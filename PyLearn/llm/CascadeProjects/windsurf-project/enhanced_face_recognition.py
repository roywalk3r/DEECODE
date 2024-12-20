import cv2
import numpy as np
import face_recognition
import mediapipe as mp
import os
from datetime import datetime
import imutils
from PIL import Image
from deepface import DeepFace
import time
import speech_recognition as sr
import pyttsx3
import threading
from queue import Queue
import random
import json
import logging
from pathlib import Path
import pandas as pd
import matplotlib.pyplot as plt
from collections import defaultdict
import torch
from ultralytics import YOLO

class EnhancedFaceRecognition:
    def __init__(self, known_faces_dir="known_faces"):
        # Set up logging
        logging.basicConfig(
            level=logging.INFO,
            format='%(asctime)s - %(levelname)s - %(message)s',
            handlers=[
                logging.FileHandler('face_recognition.log'),
                logging.StreamHandler()
            ]
        )
        self.logger = logging.getLogger(__name__)
        
        # Initialize directories
        self.known_faces_dir = known_faces_dir
        self.data_dir = "face_data"
        self.analytics_dir = "analytics"
        for directory in [self.known_faces_dir, self.data_dir, self.analytics_dir]:
            Path(directory).mkdir(exist_ok=True)
        
        self.known_face_encodings = []
        self.known_face_names = []
        self.face_data = defaultdict(lambda: {
            'appearances': 0,
            'emotions': defaultdict(int),
            'last_seen': None,
            'total_time': 0
        })
        
        # Initialize MediaPipe Face Mesh with enhanced settings
        self.mp_face_mesh = mp.solutions.face_mesh
        self.face_mesh = self.mp_face_mesh.FaceMesh(
            max_num_faces=10,
            min_detection_confidence=0.6,
            min_tracking_confidence=0.6,
            refine_landmarks=True
        )
        self.mp_drawing = mp.solutions.drawing_utils
        self.drawing_spec = self.mp_drawing.DrawingSpec(thickness=1, circle_radius=1)
        
        # Initialize face detection
        self.face_detector = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
        
        # Initialize speech recognition and text-to-speech with enhanced settings
        self.recognizer = sr.Recognizer()
        self.recognizer.dynamic_energy_threshold = True
        self.recognizer.energy_threshold = 4000
        
        self.engine = pyttsx3.init()
        self.engine.setProperty('rate', 150)
        voices = self.engine.getProperty('voices')
        if voices:  # Set a more natural voice if available
            self.engine.setProperty('voice', voices[0].id)
        
        # Enhanced voice commands
        self.speech_queue = Queue()
        self.voice_commands = {
            'toggle mesh': 'toggle_mesh',
            'capture face': 'capture_face',
            'start recording': 'start_recording',
            'stop recording': 'stop_recording',
            'show analytics': 'show_analytics',
            'save report': 'save_report',
            'toggle tracking': 'toggle_tracking',
            'quit': 'quit',
            'stop': 'quit'
        }
        
        # Voice feedback control
        self.last_spoken_time = time.time()
        self.speak_interval = 3.0
        self.previously_spoken = set()
        
        # Recording and tracking
        self.is_recording = False
        self.video_writer = None
        self.tracking_enabled = True
        self.face_trackers = {}
        
        # Analytics data
        self.emotion_history = defaultdict(list)
        self.attendance_log = defaultdict(list)
        
        # Emotion colors with enhanced visibility
        self.emotion_colors = {
            'angry': (0, 0, 255),     # Red
            'disgust': (0, 140, 255), # Orange
            'fear': (0, 255, 255),    # Yellow
            'happy': (0, 255, 0),     # Green
            'sad': (255, 0, 0),       # Blue
            'surprise': (255, 0, 255), # Purple
            'neutral': (255, 255, 255) # White
        }
        
        # Initialize YOLO model for object detection
        self.yolo_model = YOLO('yolov8n.pt')
        
        # Object-emotion mapping for contextual analysis
        self.object_emotions = {
            'dog': ['happy', 'excited'],
            'cat': ['content', 'neutral'],
            'food': ['happy', 'satisfied'],
            'phone': ['neutral', 'focused'],
            'laptop': ['focused', 'serious'],
            'book': ['focused', 'neutral'],
            'tv': ['neutral', 'relaxed']
        }
        
        # Enhanced emotion detection parameters
        self.emotion_threshold = 0.6
        self.emotion_context = defaultdict(list)
        self.emotion_memory = 5  # Remember last 5 emotions for smoothing
        
        self.load_known_faces()
        self.load_face_data()
        
        # Start voice command listener
        self.voice_thread = threading.Thread(target=self.listen_for_commands, daemon=True)
        self.voice_thread.start()
        
        self.logger.info("Enhanced recognition system initialized with object detection")

    def load_face_data(self):
        """Load saved face data from JSON"""
        try:
            data_file = Path(self.data_dir) / "face_data.json"
            if data_file.exists():
                with open(data_file, 'r') as f:
                    data = json.load(f)
                    for name, info in data.items():
                        self.face_data[name].update(info)
                self.logger.info(f"Loaded face data for {len(data)} people")
        except Exception as e:
            self.logger.error(f"Error loading face data: {str(e)}")

    def save_face_data(self):
        """Save face data to JSON"""
        try:
            data_file = Path(self.data_dir) / "face_data.json"
            with open(data_file, 'w') as f:
                json.dump(self.face_data, f, indent=4, default=str)
            self.logger.info("Face data saved successfully")
        except Exception as e:
            self.logger.error(f"Error saving face data: {str(e)}")

    def generate_analytics(self):
        """Generate analytics visualizations"""
        try:
            # Create emotion distribution plot
            plt.figure(figsize=(12, 6))
            for name, data in self.face_data.items():
                emotions = data['emotions']
                if emotions:
                    emotions_df = pd.DataFrame.from_dict(emotions, orient='index')
                    emotions_df.plot(kind='bar', title=f'Emotion Distribution for {name}')
                    plt.tight_layout()
                    plt.savefig(f"{self.analytics_dir}/{name}_emotions.png")
                    plt.close()
            
            # Generate attendance report
            report = "Face Recognition Analytics Report\n"
            report += "=" * 50 + "\n\n"
            
            for name, data in self.face_data.items():
                report += f"Name: {name}\n"
                report += f"Total Appearances: {data['appearances']}\n"
                report += f"Last Seen: {data['last_seen']}\n"
                report += f"Total Time Present: {data['total_time']:.2f} seconds\n"
                report += "Emotion Distribution:\n"
                for emotion, count in data['emotions'].items():
                    report += f"  - {emotion}: {count}\n"
                report += "\n"
            
            with open(f"{self.analytics_dir}/analytics_report.txt", 'w') as f:
                f.write(report)
            
            self.logger.info("Analytics generated successfully")
            return True
        except Exception as e:
            self.logger.error(f"Error generating analytics: {str(e)}")
            return False

    def start_recording(self, output_path="output_video.avi"):
        """Start recording the video feed"""
        try:
            fourcc = cv2.VideoWriter_fourcc(*'XVID')
            self.video_writer = cv2.VideoWriter(output_path, fourcc, 20.0, (1280, 720))
            self.is_recording = True
            self.speak("Started recording video")
            self.logger.info("Started video recording")
        except Exception as e:
            self.logger.error(f"Error starting recording: {str(e)}")
            self.speak("Failed to start recording")

    def stop_recording(self):
        """Stop recording the video feed"""
        if self.is_recording and self.video_writer:
            self.video_writer.release()
            self.is_recording = False
            self.video_writer = None
            self.speak("Stopped recording video")
            self.logger.info("Stopped video recording")

    def update_face_data(self, name, emotion):
        """Update tracking data for a face"""
        if not emotion or not isinstance(emotion, str):
            return
            
        current_time = datetime.now()
        self.face_data[name]['appearances'] += 1
        
        # Ensure we only track valid emotions that are in our emotion_colors dictionary
        if emotion.lower() in self.emotion_colors:
            self.face_data[name]['emotions'][emotion.lower()] += 1
            
            # Update emotion history for real-time analytics
            self.emotion_history[name].append({
                'emotion': emotion.lower(),
                'timestamp': current_time
            })
        
        self.face_data[name]['last_seen'] = current_time

    def recognize_faces(self, video_source=0, show_mesh=True, show_fps=True):
        """Enhanced face recognition with advanced features"""
        if not self.known_face_encodings:
            msg = "No known faces found. Please add images to the known faces directory."
            self.logger.warning(msg)
            self.speak(msg)
            return

        cap = cv2.VideoCapture(video_source)
        cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1280)
        cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 720)
        
        fps_start_time = datetime.now()
        fps = 0
        frames_count = 0
        last_emotion_time = time.time()
        emotion_update_interval = 0.5
        current_emotions = {}

        self.speak("Advanced face recognition system is ready. Use voice commands for control.")

        while True:
            ret, frame = cap.read()
            if not ret:
                break

            # Process voice commands
            try:
                while not self.speech_queue.empty():
                    command = self.speech_queue.get_nowait()
                    if command == 'toggle_mesh':
                        show_mesh = not show_mesh
                        self.speak("Toggled face mesh display")
                    elif command == 'capture_face':
                        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
                        cv2.imwrite(f"{self.known_faces_dir}/captured_face_{timestamp}.jpg", frame)
                        self.speak("Face captured for training")
                    elif command == 'start_recording':
                        self.start_recording()
                    elif command == 'stop_recording':
                        self.stop_recording()
                    elif command == 'show_analytics':
                        if self.generate_analytics():
                            self.speak("Analytics generated and saved")
                    elif command == 'save_report':
                        self.save_face_data()
                        self.speak("Face data report saved")
                    elif command == 'toggle_tracking':
                        self.tracking_enabled = not self.tracking_enabled
                        self.speak("Face tracking toggled")
                    elif command == 'quit':
                        self.speak("Shutting down face recognition system")
                        self.save_face_data()
                        self.stop_recording()
                        cap.release()
                        cv2.destroyAllWindows()
                        return
            except Exception as e:
                self.logger.error(f"Error processing command: {str(e)}")

            # Main processing pipeline
            frame = imutils.resize(frame, width=1280)
            rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
            
            if show_mesh:
                mesh_results = self.face_mesh.process(rgb_frame)
                if mesh_results.multi_face_landmarks:
                    self.draw_face_mesh(frame, mesh_results)
            
            gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
            faces = self.face_detector.detectMultiScale(gray, 1.1, 5, minSize=(30, 30))
            
            face_locations = []
            for (x, y, w, h) in faces:
                pad = int(w * 0.1)
                face_locations.append((
                    max(0, y - pad),
                    min(frame.shape[1], x + w + pad),
                    min(frame.shape[0], y + h + pad),
                    max(0, x - pad)
                ))
            
            # Analyze scene for objects and context
            scene_context = self.analyze_scene(frame, face_locations)
            
            face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)
            
            # Update emotions with context
            current_time = time.time()
            if current_time - last_emotion_time >= emotion_update_interval:
                current_emotions.clear()
                for face_location in face_locations:
                    emotion = self.analyze_emotion_with_context(frame, face_location, scene_context)
                    if emotion:
                        current_emotions[face_location] = emotion
                last_emotion_time = current_time
            
            face_names = []
            for face_encoding in face_encodings:
                matches = face_recognition.compare_faces(
                    self.known_face_encodings, face_encoding, tolerance=0.6
                )
                name = "Unknown"

                if True in matches:
                    first_match_index = matches.index(True)
                    name = self.known_face_names[first_match_index]

                face_names.append(name)

            # Draw information for faces and objects
            for (top, right, bottom, left), name in zip(face_locations, face_names):
                emotion = current_emotions.get((top, right, bottom, left), 'neutral')
                color = self.emotion_colors.get(emotion, (255, 255, 255))
                
                # Find related objects
                related_objects = [
                    ctx['object'] for ctx in scene_context 
                    if ctx['face_location'] == (top, right, bottom, left)
                ]
                
                if name != "Unknown":
                    self.update_face_data(name, emotion)
                    
                    # Generate contextual feedback
                    if related_objects:
                        feedback = f"{name} is {emotion} while interacting with {', '.join(related_objects)}"
                    else:
                        feedback = self.generate_feedback(name, emotion)
                    
                    self.speak(feedback)
                
                # Enhanced visualization
                cv2.rectangle(frame, (left, top), (right, bottom), color, 2)
                
                # Draw labels with background for better visibility
                label_y = top - 10 if top - 10 > 10 else bottom + 25
                
                # Draw name and emotion
                cv2.putText(frame, f"{name}", (left, label_y),
                          cv2.FONT_HERSHEY_DUPLEX, 0.7, color, 2)
                cv2.putText(frame, f"Emotion: {emotion}", (left, label_y + 25),
                          cv2.FONT_HERSHEY_DUPLEX, 0.7, color, 2)
                
                # Draw related objects
                if related_objects:
                    obj_text = f"Objects: {', '.join(related_objects)}"
                    cv2.putText(frame, obj_text, (left, label_y + 50),
                              cv2.FONT_HERSHEY_DUPLEX, 0.7, color, 2)
            
            # Record video if enabled
            if self.is_recording and self.video_writer:
                self.video_writer.write(frame)
            
            # Display FPS and status
            if show_fps:
                frames_count += 1
                if (datetime.now() - fps_start_time).seconds >= 1:
                    fps = frames_count
                    frames_count = 0
                    fps_start_time = datetime.now()
                cv2.putText(frame, f"FPS: {fps}", (10, 30),
                          cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)

            # Status indicators
            status_y = frame.shape[0] - 10
            cv2.putText(frame, "Voice Commands: 'toggle mesh', 'capture face', 'show analytics', 'quit'",
                      (10, status_y), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (255, 255, 255), 2)
            
            if self.is_recording:
                cv2.circle(frame, (30, 30), 10, (0, 0, 255), -1)  # Red recording indicator

            cv2.imshow('Advanced Face Recognition', frame)

            key = cv2.waitKey(1) & 0xFF
            if key == ord('q'):
                break
            elif key == ord('s'):
                show_mesh = not show_mesh

        self.save_face_data()
        self.stop_recording()
        cap.release()
        cv2.destroyAllWindows()

    def load_known_faces(self):
        """Load and encode all known faces from the known_faces directory"""
        if not os.path.exists(self.known_faces_dir):
            os.makedirs(self.known_faces_dir)
            print(f"Created {self.known_faces_dir} directory. Please add face images.")
            return

        print("Loading known faces...")
        for filename in os.listdir(self.known_faces_dir):
            if filename.endswith((".jpg", ".jpeg", ".png")):
                image_path = os.path.join(self.known_faces_dir, filename)
                try:
                    image = face_recognition.load_image_file(image_path)
                    face_encodings = face_recognition.face_encodings(image)
                    
                    if face_encodings:
                        self.known_face_encodings.append(face_encodings[0])
                        self.known_face_names.append(os.path.splitext(filename)[0])
                        print(f"Loaded face: {os.path.splitext(filename)[0]}")
                except Exception as e:
                    print(f"Error loading {filename}: {str(e)}")

    def draw_face_mesh(self, image, face_landmarks):
        """Draw facial mesh landmarks on the image"""
        for facial_landmarks in face_landmarks.multi_face_landmarks:
            self.mp_drawing.draw_landmarks(
                image=image,
                landmark_list=facial_landmarks,
                connections=self.mp_face_mesh.FACEMESH_TESSELATION,
                landmark_drawing_spec=self.drawing_spec,
                connection_drawing_spec=self.drawing_spec
            )

    def add_face(self, image_path, name):
        """Add a new face to the known faces"""
        try:
            image = face_recognition.load_image_file(image_path)
            face_encodings = face_recognition.face_encodings(image)
            
            if face_encodings:
                self.known_face_encodings.append(face_encodings[0])
                self.known_face_names.append(name)
                
                # Save the image to known_faces directory
                new_path = os.path.join(self.known_faces_dir, f"{name}.jpg")
                Image.fromarray(image).save(new_path)
                print(f"Successfully added {name} to known faces")
                return True
            else:
                print("No face found in the image")
                return False
        except Exception as e:
            print(f"Error adding face: {str(e)}")
            return False

    def analyze_scene(self, frame, face_locations):
        """Analyze the scene for objects and their relationship to emotions"""
        scene_context = []
        
        # Run YOLO detection
        results = self.yolo_model(frame)
        
        # Process detected objects
        for result in results:
            boxes = result.boxes
            for box in boxes:
                # Get box coordinates
                x1, y1, x2, y2 = box.xyxy[0].cpu().numpy()
                x1, y1, x2, y2 = int(x1), int(y1), int(x2), int(y2)
                
                # Get class name and confidence
                class_id = int(box.cls[0])
                conf = float(box.conf[0])
                class_name = result.names[class_id]
                
                if conf > 0.5:  # Confidence threshold
                    # Draw box around object
                    cv2.rectangle(frame, (x1, y1), (x2, y2), (0, 255, 0), 2)
                    cv2.putText(frame, f"{class_name} {conf:.2f}",
                              (x1, y1 - 10), cv2.FONT_HERSHEY_SIMPLEX,
                              0.5, (0, 255, 0), 2)
                    
                    # Check if object is near any face
                    for face_loc in face_locations:
                        top, right, bottom, left = face_loc
                        # Calculate distance between object and face
                        face_center = ((left + right) // 2, (top + bottom) // 2)
                        obj_center = ((x1 + x2) // 2, (y1 + y2) // 2)
                        
                        distance = np.sqrt(
                            (face_center[0] - obj_center[0])**2 +
                            (face_center[1] - obj_center[1])**2
                        )
                        
                        # If object is close to face, add to context
                        if distance < frame.shape[1] * 0.3:  # Within 30% of frame width
                            scene_context.append({
                                'object': class_name,
                                'face_location': face_loc,
                                'distance': distance,
                                'confidence': conf
                            })
        
        return scene_context

    def analyze_emotion_with_context(self, frame, face_location, scene_context):
        """Enhanced emotion analysis using scene context"""
        try:
            top, right, bottom, left = face_location
            face_image = frame[top:bottom, left:right]
            
            if face_image.size == 0:
                return None
            
            # Get base emotion from DeepFace
            result = DeepFace.analyze(
                face_image,
                actions=['emotion'],
                enforce_detection=False,
                silent=True
            )
            
            if not result or not isinstance(result, list):
                return None
            
            base_emotion = result[0]['dominant_emotion'].lower()
            emotion_scores = {k.lower(): v for k, v in result[0]['emotion'].items()}
            
            # Only keep emotions that are in our emotion_colors dictionary
            emotion_scores = {k: v for k, v in emotion_scores.items() if k in self.emotion_colors}
            
            if not emotion_scores:
                return None
            
            # Adjust emotion based on scene context
            for ctx in scene_context:
                if ctx['face_location'] == face_location:
                    object_name = ctx['object']
                    if object_name in self.object_emotions:
                        # Boost emotions associated with the object
                        for emotion in self.object_emotions[object_name]:
                            emotion = emotion.lower()
                            if emotion in emotion_scores:
                                emotion_scores[emotion] *= 1.2  # 20% boost
            
            # Get the emotion with highest adjusted score
            adjusted_emotion = max(emotion_scores.items(), key=lambda x: x[1])[0]
            
            # Add to emotion memory for smoothing
            self.emotion_context[face_location].append(adjusted_emotion)
            if len(self.emotion_context[face_location]) > self.emotion_memory:
                self.emotion_context[face_location].pop(0)
            
            # Return most common emotion in memory
            from collections import Counter
            smoothed_emotion = Counter(self.emotion_context[face_location]).most_common(1)[0][0]
            
            return smoothed_emotion
            
        except Exception as e:
            self.logger.error(f"Error in emotion analysis: {str(e)}")
            return None

    def speak(self, text):
        """Speak the given text if enough time has passed since last speech"""
        current_time = time.time()
        if current_time - self.last_spoken_time >= self.speak_interval:
            # Clear old spoken phrases after some time
            self.previously_spoken.clear()
            
            if text not in self.previously_spoken:
                self.previously_spoken.add(text)
                self.last_spoken_time = current_time
                self.engine.say(text)
                self.engine.runAndWait()

    def listen_for_commands(self):
        """Continuously listen for voice commands"""
        while True:
            try:
                with sr.Microphone() as source:
                    print("Listening for commands...")
                    self.recognizer.adjust_for_ambient_noise(source, duration=0.5)
                    audio = self.recognizer.listen(source, timeout=1, phrase_time_limit=3)
                    
                try:
                    command = self.recognizer.recognize_google(audio).lower()
                    print(f"Command recognized: {command}")
                    
                    # Check for known commands
                    for key_phrase, action in self.voice_commands.items():
                        if key_phrase in command:
                            self.speech_queue.put(action)
                            break
                            
                except sr.UnknownValueError:
                    pass  # Speech was not understood
                except sr.RequestError:
                    print("Could not request results from speech recognition service")
                    
            except Exception as e:
                print(f"Error in voice command listener: {str(e)}")
                time.sleep(1)  # Prevent rapid retries on error

    def generate_feedback(self, name, emotion):
        """Generate varied feedback messages"""
        greetings = [
            f"I see {name} is feeling {emotion}",
            f"Hello {name}! You seem {emotion}",
            f"Nice to see you {name}, looking {emotion} today",
        ]
        return random.choice(greetings)

if __name__ == "__main__":
    face_system = EnhancedFaceRecognition()
    face_system.recognize_faces(show_mesh=True, show_fps=True)
