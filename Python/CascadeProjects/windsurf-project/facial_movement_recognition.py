import cv2
import mediapipe as mp
import face_recognition
import numpy as np

class FacialMovementRecognition:
    def __init__(self):
        # Face recognition setup
        self.known_face_encodings = []
        self.known_face_names = []

        # Mediapipe setup for body landmarks
        self.mp_pose = mp.solutions.pose
        self.mp_drawing = mp.solutions.drawing_utils
        self.pose = self.mp_pose.Pose(
            min_detection_confidence=0.5, 
            min_tracking_confidence=0.5
        )

        # OpenCV video capture
        self.cap = cv2.VideoCapture(0)

    def register_face(self, image_path, name):
        """
        Register a new face for recognition
        :param image_path: Path to the face image
        :param name: Name associated with the face
        """
        face_image = face_recognition.load_image_file(image_path)
        face_encoding = face_recognition.face_encodings(face_image)[0]
        
        self.known_face_encodings.append(face_encoding)
        self.known_face_names.append(name)

    def detect_faces_and_movements(self):
        """
        Real-time facial and movement recognition
        """
        while True:
            # Capture frame-by-frame
            ret, frame = self.cap.read()
            if not ret:
                break

            # Convert the image from BGR color to RGB
            rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

            # Face Recognition
            face_locations = face_recognition.face_locations(rgb_frame)
            face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

            face_names = []
            for face_encoding in face_encodings:
                # Compare faces
                matches = face_recognition.compare_faces(
                    self.known_face_encodings, 
                    face_encoding
                )
                name = "Unknown"

                if True in matches:
                    first_match_index = matches.index(True)
                    name = self.known_face_names[first_match_index]
                
                face_names.append(name)

            # Body Movement Detection
            results = self.pose.process(rgb_frame)
            
            # Draw face rectangles
            for (top, right, bottom, left), name in zip(face_locations, face_names):
                cv2.rectangle(frame, (left, top), (right, bottom), (0, 0, 255), 2)
                cv2.rectangle(frame, (left, bottom - 35), (right, bottom), (0, 0, 255), cv2.FILLED)
                font = cv2.FONT_HERSHEY_DUPLEX
                cv2.putText(frame, name, (left + 6, bottom - 6), font, 1.0, (255, 255, 255), 1)

            # Draw body landmarks if detected
            if results.pose_landmarks:
                self.mp_drawing.draw_landmarks(
                    frame, 
                    results.pose_landmarks, 
                    self.mp_pose.POSE_CONNECTIONS
                )

            # Display the resulting frame
            cv2.imshow('Facial and Movement Recognition', frame)

            # Break loop on 'q' key press
            if cv2.waitKey(1) & 0xFF == ord('q'):
                break

        # Release resources
        self.cap.release()
        cv2.destroyAllWindows()

def main():
    # Create an instance of the recognition system
    recognition_system = FacialMovementRecognition()
    
    # Optional: Register known faces
    # recognition_system.register_face('path/to/known/face.jpg', 'Person Name')
    
    # Start real-time recognition
    recognition_system.detect_faces_and_movements()

if __name__ == "__main__":
    main()
