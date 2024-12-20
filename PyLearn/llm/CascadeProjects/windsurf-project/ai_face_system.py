import cv2
import numpy as np
import face_recognition
import mediapipe as mp
from deepface import DeepFace
import os
from datetime import datetime
import imutils
import pyttsx3
import speech_recognition as sr
import threading
import pandas as pd
from time import sleep
import json

class AIFaceSystem:
    def __init__(self, known_faces_dir="known_faces"):
        self.known_faces_dir = known_faces_dir
        self.known_face_encodings = []
        self.known_face_names = []
        self.person_data = {}  # Store additional info about known people
        
        # Initialize speech engine
        self.engine = pyttsx3.init()
        self.engine.setProperty('rate', 150)
        
        # Initialize speech recognition
        self.recognizer = sr.Recognizer()
        self.listening = False
        
        # Initialize MediaPipe Face Mesh
        self.mp_face_mesh = mp.solutions.face_mesh
        self.face_mesh = self.mp_face_mesh.FaceMesh(
            max_num_faces=10,
            min_detection_confidence=0.5,
            min_tracking_confidence=0.5
        )
        
        # Load known faces and their data
        self.load_known_faces()
        
        # Initialize interaction history
        self.interaction_history = []
        
    def speak(self, text):
        """Text to speech output"""
        print(f"AI: {text}")
        self.engine.say(text)
        self.engine.runAndWait()
        
    def listen(self):
        """Speech to text input"""
        with sr.Microphone() as source:
            print("Listening...")
            self.recognizer.adjust_for_ambient_noise(source)
            audio = self.recognizer.listen(source)
            
            try:
                text = self.recognizer.recognize_google(audio)
                print(f"User: {text}")
                return text.lower()
            except:
                return ""

    def load_known_faces(self):
        """Load known faces and their associated data"""
        if not os.path.exists(self.known_faces_dir):
            os.makedirs(self.known_faces_dir)
            os.makedirs(os.path.join(self.known_faces_dir, "data"))
            print(f"Created {self.known_faces_dir} directory. Please add face images.")
            return

        print("Loading known faces...")
        data_dir = os.path.join(self.known_faces_dir, "data")
        if not os.path.exists(data_dir):
            os.makedirs(data_dir)

        # Load face images and encodings
        for filename in os.listdir(self.known_faces_dir):
            if filename.endswith((".jpg", ".jpeg", ".png")):
                image_path = os.path.join(self.known_faces_dir, filename)
                name = os.path.splitext(filename)[0]
                
                try:
                    # Load face encoding
                    image = face_recognition.load_image_file(image_path)
                    face_encodings = face_recognition.face_encodings(image)
                    
                    if face_encodings:
                        self.known_face_encodings.append(face_encodings[0])
                        self.known_face_names.append(name)
                        
                        # Load or analyze person data
                        data_file = os.path.join(data_dir, f"{name}.json")
                        if os.path.exists(data_file):
                            with open(data_file, 'r') as f:
                                self.person_data[name] = json.load(f)
                        else:
                            # Analyze face for demographic info
                            try:
                                analysis = DeepFace.analyze(image_path, actions=['age', 'gender', 'race', 'emotion'])
                                self.person_data[name] = {
                                    'age': analysis[0]['age'],
                                    'gender': analysis[0]['gender'],
                                    'race': analysis[0]['race'],
                                    'last_emotion': analysis[0]['emotion'],
                                    'interaction_count': 0
                                }
                                # Save person data
                                with open(data_file, 'w') as f:
                                    json.dump(self.person_data[name], f)
                            except:
                                print(f"Could not analyze demographics for {name}")
                        
                        print(f"Loaded face: {name}")
                except Exception as e:
                    print(f"Error loading {filename}: {str(e)}")

    def process_command(self, command, name=None):
        """Process voice commands"""
        if "hello" in command or "hi" in command:
            if name:
                self.speak(f"Hello {name}! How are you today?")
            else:
                self.speak("Hello! I don't recognize you yet. Would you like to introduce yourself?")
        
        elif "who am i" in command and name:
            data = self.person_data.get(name, {})
            self.speak(f"You are {name}. Based on my analysis, you appear to be "
                      f"approximately {data.get('age', 'unknown')} years old and "
                      f"{data.get('gender', 'unknown')}. We have interacted "
                      f"{data.get('interaction_count', 0)} times before.")
        
        elif "how are you" in command:
            self.speak("I'm functioning well, thank you for asking!")
        
        elif "goodbye" in command or "bye" in command:
            self.speak("Goodbye! Have a great day!")
            return False
        
        return True

    def add_new_person(self, frame, face_encoding):
        """Add a new person through interaction"""
        self.speak("I don't recognize you. What's your name?")
        name = self.listen()
        
        if name:
            # Save face image
            img_path = os.path.join(self.known_faces_dir, f"{name}.jpg")
            cv2.imwrite(img_path, frame)
            
            # Add to known faces
            self.known_face_encodings.append(face_encoding)
            self.known_face_names.append(name)
            
            # Analyze and save person data
            try:
                analysis = DeepFace.analyze(img_path, actions=['age', 'gender', 'race', 'emotion'])
                self.person_data[name] = {
                    'age': analysis[0]['age'],
                    'gender': analysis[0]['gender'],
                    'race': analysis[0]['race'],
                    'last_emotion': analysis[0]['emotion'],
                    'interaction_count': 1
                }
                
                # Save person data
                data_file = os.path.join(self.known_faces_dir, "data", f"{name}.json")
                with open(data_file, 'w') as f:
                    json.dump(self.person_data[name], f)
                
                self.speak(f"Nice to meet you, {name}! I've added you to my database.")
            except Exception as e:
                print(f"Error adding new person: {str(e)}")
                self.speak("I'm sorry, there was an error adding your information.")

    def run_ai_system(self, video_source=0):
        """Run the AI face recognition system"""
        cap = cv2.VideoCapture(video_source)
        process_this_frame = True
        
        self.speak("AI Face System activated. Press 'q' to quit, 'v' to activate voice command.")
        
        while True:
            ret, frame = cap.read()
            if not ret:
                break

            frame = imutils.resize(frame, width=800)
            
            if process_this_frame:
                # Convert to RGB for face_recognition
                rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
                
                # Detect faces
                face_locations = face_recognition.face_locations(rgb_frame)
                face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)
                
                # Process each face
                for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
                    matches = face_recognition.compare_faces(self.known_face_encodings, face_encoding)
                    name = "Unknown"
                    
                    if True in matches:
                        first_match_index = matches.index(True)
                        name = self.known_face_names[first_match_index]
                        
                        # Update interaction count
                        if name in self.person_data:
                            self.person_data[name]['interaction_count'] += 1
                    
                    # Draw rectangle and name
                    cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
                    cv2.rectangle(frame, (left, bottom - 35), (right, bottom), (0, 255, 0), cv2.FILLED)
                    font = cv2.FONT_HERSHEY_DUPLEX
                    cv2.putText(frame, name, (left + 6, bottom - 6), font, 0.6, (255, 255, 255), 1)
                    
                    # Analyze emotion in real-time
                    try:
                        face_img = frame[top:bottom, left:right]
                        analysis = DeepFace.analyze(face_img, actions=['emotion'], enforce_detection=False)
                        emotion = max(analysis[0]['emotion'].items(), key=lambda x: x[1])[0]
                        cv2.putText(frame, emotion, (left + 6, top - 10), font, 0.6, (255, 255, 255), 1)
                    except:
                        pass

            process_this_frame = not process_this_frame
            
            cv2.imshow('AI Face Recognition System', frame)
            
            key = cv2.waitKey(1) & 0xFF
            if key == ord('q'):
                break
            elif key == ord('v'):
                # Activate voice command mode
                command = self.listen()
                if command:
                    if not self.process_command(command, name if name != "Unknown" else None):
                        break

        cap.release()
        cv2.destroyAllWindows()
        
        # Save updated person data
        for name, data in self.person_data.items():
            data_file = os.path.join(self.known_faces_dir, "data", f"{name}.json")
            with open(data_file, 'w') as f:
                json.dump(data, f)

if __name__ == "__main__":
    ai_system = AIFaceSystem()
    ai_system.run_ai_system()
