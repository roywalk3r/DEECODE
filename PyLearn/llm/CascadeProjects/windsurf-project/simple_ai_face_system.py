import cv2
import numpy as np
import mediapipe as mp
from deepface import DeepFace
import os
import pyttsx3
import speech_recognition as sr
from datetime import datetime

class SimpleFaceAI:
    def __init__(self):
        # Initialize MediaPipe Face Detection
        self.mp_face_detection = mp.solutions.face_detection
        self.mp_drawing = mp.solutions.drawing_utils
        self.face_detection = self.mp_face_detection.FaceDetection(
            model_selection=1,
            min_detection_confidence=0.5
        )

        # Initialize MediaPipe Face Mesh
        self.mp_face_mesh = mp.solutions.face_mesh
        self.face_mesh = self.mp_face_mesh.FaceMesh(
            max_num_faces=1,
            min_detection_confidence=0.5,
            min_tracking_confidence=0.5
        )

        # Initialize text-to-speech engine
        self.engine = pyttsx3.init()
        self.engine.setProperty('rate', 150)

        # Initialize speech recognition
        self.recognizer = sr.Recognizer()
        self.is_listening = False

        # Create directory for known faces if it doesn't exist
        self.known_faces_dir = "known_faces"
        if not os.path.exists(self.known_faces_dir):
            os.makedirs(self.known_faces_dir)

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
            try:
                audio = self.recognizer.listen(source, timeout=5)
                text = self.recognizer.recognize_google(audio)
                print(f"User: {text}")
                return text.lower()
            except sr.WaitTimeoutError:
                return ""
            except sr.UnknownValueError:
                return ""
            except Exception as e:
                print(f"Error in speech recognition: {str(e)}")
                return ""

    def process_command(self, command):
        """Process voice commands"""
        if not command:
            return True

        if "hello" in command or "hi" in command:
            self.speak("Hello! I'm your AI assistant. How can I help you today?")
        
        elif "analyze" in command or "detect" in command:
            self.speak("I'll analyze faces in the camera feed.")
            return "analyze"
        
        elif "emotion" in command:
            self.speak("I'll detect emotions in faces.")
            return "emotion"
        
        elif "mesh" in command:
            self.speak("I'll show the facial mesh.")
            return "mesh"
        
        elif "exit" in command or "quit" in command or "bye" in command:
            self.speak("Goodbye! Have a great day!")
            return "quit"
        
        return True

    def run_ai_system(self):
        """Main function to run the AI face system"""
        cap = cv2.VideoCapture(0)
        mode = "detect"  # default mode
        
        self.speak("AI Face System activated. Press 'q' to quit, 'v' for voice commands.")
        
        while cap.isOpened():
            success, image = cap.read()
            if not success:
                continue

            # Convert the BGR image to RGB
            image_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
            
            if mode == "detect":
                # Perform face detection
                results = self.face_detection.process(image_rgb)
                if results.detections:
                    for detection in results.detections:
                        self.mp_drawing.draw_detection(image, detection)
            
            elif mode == "emotion":
                try:
                    analysis = DeepFace.analyze(image_rgb, actions=['emotion'], enforce_detection=False)
                    if analysis:
                        emotion = analysis[0]['dominant_emotion']
                        cv2.putText(image, f"Emotion: {emotion}", (10, 30),
                                  cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)
                except:
                    pass
            
            elif mode == "mesh":
                # Perform face mesh detection
                results = self.face_mesh.process(image_rgb)
                if results.multi_face_landmarks:
                    for face_landmarks in results.multi_face_landmarks:
                        self.mp_drawing.draw_landmarks(
                            image=image,
                            landmark_list=face_landmarks,
                            connections=self.mp_face_mesh.FACEMESH_TESSELATION,
                            landmark_drawing_spec=None,
                            connection_drawing_spec=mp.solutions.drawing_styles.get_default_face_mesh_tesselation_style()
                        )

            # Display FPS
            cv2.putText(image, f"Mode: {mode}", (10, 30),
                       cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)

            cv2.imshow('AI Face System', image)

            key = cv2.waitKey(1) & 0xFF
            if key == ord('q'):
                break
            elif key == ord('v'):
                # Activate voice command
                command = self.listen()
                result = self.process_command(command)
                if result == "quit":
                    break
                elif result in ["analyze", "emotion", "mesh"]:
                    mode = result

        cap.release()
        cv2.destroyAllWindows()

if __name__ == "__main__":
    face_ai = SimpleFaceAI()
    face_ai.run_ai_system()
