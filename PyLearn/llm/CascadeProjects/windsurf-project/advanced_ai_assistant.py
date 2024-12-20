import cv2
import numpy as np
import mediapipe as mp
from deepface import DeepFace
import os
import pyttsx3
import speech_recognition as sr
from datetime import datetime
import torch
from transformers import AutoTokenizer, AutoModelForSequenceClassification
import json
import pickle
from sklearn.preprocessing import LabelEncoder
from sklearn.svm import SVC
from sklearn.model_selection import train_test_split
import threading
import queue
import time
from dotenv import load_dotenv
import openai
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords

class AdvancedAIAssistant:
    def __init__(self):
        # Load environment variables
        load_dotenv()
        
        # Initialize OpenAI (if API key is available)
        self.openai_available = False
        if os.getenv("OPENAI_API_KEY"):
            openai.api_key = os.getenv("OPENAI_API_KEY")
            self.openai_available = True

        # Initialize face detection and mesh
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

        # Initialize voice components
        self.engine = pyttsx3.init()
        self.engine.setProperty('rate', 150)
        self.recognizer = sr.Recognizer()
        
        # Initialize NLTK
        try:
            nltk.data.find('tokenizers/punkt')
        except LookupError:
            nltk.download('punkt')
            nltk.download('stopwords')
        
        # Initialize face recognition model
        self.face_recognizer = None
        self.label_encoder = LabelEncoder()
        self.load_face_recognition_model()
        
        # Create necessary directories
        self.base_dir = "ai_assistant_data"
        self.known_faces_dir = os.path.join(self.base_dir, "known_faces")
        self.model_dir = os.path.join(self.base_dir, "models")
        self.training_data_dir = os.path.join(self.base_dir, "training_data")
        
        for directory in [self.base_dir, self.known_faces_dir, self.model_dir, self.training_data_dir]:
            if not os.path.exists(directory):
                os.makedirs(directory)
        
        # Initialize command queue and processing thread
        self.command_queue = queue.Queue()
        self.processing_thread = threading.Thread(target=self.process_commands_thread, daemon=True)
        self.processing_thread.start()

    def speak(self, text):
        """Text to speech output"""
        print(f"AI: {text}")
        self.engine.say(text)
        self.engine.runAndWait()

    def listen(self):
        """Enhanced speech recognition"""
        with sr.Microphone() as source:
            print("Listening...")
            self.recognizer.adjust_for_ambient_noise(source)
            try:
                audio = self.recognizer.listen(source, timeout=5)
                text = self.recognizer.recognize_google(audio)
                print(f"User: {text}")
                return text.lower()
            except Exception as e:
                print(f"Error in speech recognition: {str(e)}")
                return ""

    def extract_face_features(self, face_image):
        """Extract features from face image using DeepFace"""
        try:
            embedding = DeepFace.represent(face_image, model_name="Facenet")
            return np.array(embedding)
        except Exception as e:
            print(f"Error extracting face features: {str(e)}")
            return None

    def train_face_recognition(self):
        """Train face recognition model with collected data"""
        self.speak("Starting face recognition training...")
        
        features = []
        labels = []
        
        # Collect training data from known_faces directory
        for person_name in os.listdir(self.known_faces_dir):
            person_dir = os.path.join(self.known_faces_dir, person_name)
            if os.path.isdir(person_dir):
                for image_file in os.listdir(person_dir):
                    if image_file.endswith(('.jpg', '.jpeg', '.png')):
                        image_path = os.path.join(person_dir, image_file)
                        image = cv2.imread(image_path)
                        face_features = self.extract_face_features(image)
                        
                        if face_features is not None:
                            features.append(face_features)
                            labels.append(person_name)
        
        if not features:
            self.speak("No training data available")
            return False
        
        # Convert lists to numpy arrays
        X = np.array(features)
        y = self.label_encoder.fit_transform(labels)
        
        # Train SVM classifier
        self.face_recognizer = SVC(kernel='linear', probability=True)
        self.face_recognizer.fit(X, y)
        
        # Save the model
        model_path = os.path.join(self.model_dir, "face_recognition_model.pkl")
        with open(model_path, 'wb') as f:
            pickle.dump((self.face_recognizer, self.label_encoder), f)
        
        self.speak("Face recognition training completed")
        return True

    def load_face_recognition_model(self):
        """Load trained face recognition model"""
        model_path = os.path.join(self.model_dir, "face_recognition_model.pkl")
        if os.path.exists(model_path):
            try:
                with open(model_path, 'rb') as f:
                    self.face_recognizer, self.label_encoder = pickle.load(f)
                return True
            except Exception as e:
                print(f"Error loading face recognition model: {str(e)}")
        return False

    def add_face_to_training(self, name):
        """Add new face to training data"""
        person_dir = os.path.join(self.known_faces_dir, name)
        if not os.path.exists(person_dir):
            os.makedirs(person_dir)
        
        self.speak(f"I'll take 5 pictures of {name}. Please look at the camera and move slightly between shots.")
        
        cap = cv2.VideoCapture(0)
        images_taken = 0
        
        while images_taken < 5:
            ret, frame = cap.read()
            if not ret:
                continue
            
            cv2.imshow('Adding Face', frame)
            key = cv2.waitKey(1)
            
            if key == ord('c'):  # Capture image when 'c' is pressed
                image_path = os.path.join(person_dir, f"{name}_{images_taken}.jpg")
                cv2.imwrite(image_path, frame)
                images_taken += 1
                self.speak(f"Picture {images_taken} taken")
            
            elif key == ord('q'):
                break
        
        cap.release()
        cv2.destroyAllWindows()
        
        if images_taken > 0:
            self.speak("Training face recognition model with new data")
            self.train_face_recognition()
        
        return images_taken > 0

    async def get_ai_response(self, text):
        """Get AI response using OpenAI API"""
        if not self.openai_available:
            return "I apologize, but I don't have access to the OpenAI API. Please set up your API key."
        
        try:
            response = await openai.ChatCompletion.acreate(
                model="gpt-3.5-turbo",
                messages=[
                    {"role": "system", "content": "You are a helpful AI assistant."},
                    {"role": "user", "content": text}
                ]
            )
            return response.choices[0].message.content
        except Exception as e:
            print(f"Error getting AI response: {str(e)}")
            return "I apologize, but I encountered an error processing your request."

    def process_commands_thread(self):
        """Background thread for processing commands"""
        while True:
            try:
                command = self.command_queue.get()
                if command.startswith("train"):
                    self.train_face_recognition()
                elif command.startswith("add face"):
                    name = command.split("add face")[-1].strip()
                    self.add_face_to_training(name)
                # Add more command processing as needed
                self.command_queue.task_done()
            except Exception as e:
                print(f"Error processing command: {str(e)}")

    def process_command(self, command):
        """Process voice commands"""
        if not command:
            return True

        # Basic commands
        if "hello" in command or "hi" in command:
            self.speak("Hello! I'm your AI assistant. How can I help you today?")
        
        elif "train" in command and "face" in command:
            self.command_queue.put("train")
            self.speak("Starting face recognition training")
        
        elif "add face" in command:
            name = command.split("add face")[-1].strip()
            if name:
                self.command_queue.put(f"add face {name}")
            else:
                self.speak("Please specify a name for the face")
        
        elif "recognize" in command:
            return "recognize"
        
        elif "emotion" in command:
            return "emotion"
        
        elif "mesh" in command:
            return "mesh"
        
        elif "exit" in command or "quit" in command or "bye" in command:
            self.speak("Goodbye! Have a great day!")
            return "quit"
        
        # AI conversation
        else:
            response = asyncio.run(self.get_ai_response(command))
            self.speak(response)
        
        return True

    def run_assistant(self):
        """Main function to run the AI assistant"""
        cap = cv2.VideoCapture(0)
        mode = "recognize"  # default mode
        
        self.speak("AI Assistant activated. Press 'q' to quit, 'v' for voice commands, 't' to train faces.")
        
        while cap.isOpened():
            success, image = cap.read()
            if not success:
                continue

            image_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
            
            if mode == "recognize":
                # Perform face recognition
                results = self.face_detection.process(image_rgb)
                if results.detections and self.face_recognizer is not None:
                    for detection in results.detections:
                        bbox = detection.location_data.relative_bounding_box
                        h, w, _ = image.shape
                        x, y, width, height = int(bbox.xmin * w), int(bbox.ymin * h), \
                                            int(bbox.width * w), int(bbox.height * h)
                        
                        face_image = image[y:y+height, x:x+width]
                        features = self.extract_face_features(face_image)
                        
                        if features is not None:
                            prediction = self.face_recognizer.predict([features])[0]
                            name = self.label_encoder.inverse_transform([prediction])[0]
                            
                            cv2.rectangle(image, (x, y), (x+width, y+height), (0, 255, 0), 2)
                            cv2.putText(image, name, (x, y-10), cv2.FONT_HERSHEY_SIMPLEX, 
                                      0.9, (0, 255, 0), 2)
            
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

            cv2.putText(image, f"Mode: {mode}", (10, 30),
                       cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)

            cv2.imshow('AI Assistant', image)

            key = cv2.waitKey(1) & 0xFF
            if key == ord('q'):
                break
            elif key == ord('v'):
                command = self.listen()
                result = self.process_command(command)
                if result == "quit":
                    break
                elif result in ["recognize", "emotion", "mesh"]:
                    mode = result
            elif key == ord('t'):
                self.train_face_recognition()

        cap.release()
        cv2.destroyAllWindows()

if __name__ == "__main__":
    assistant = AdvancedAIAssistant()
    assistant.run_assistant()
