import cv2
import numpy as np
import face_recognition

def detect_faces(image_path=None, video_source=0):
    """
    Detect faces in images or video stream
    Args:
        image_path: Path to image file (if None, uses video)
        video_source: Camera index or video file path
    """
    if image_path:
        # Image mode
        frame = cv2.imread(image_path)
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        face_locations = face_recognition.face_locations(rgb_frame)
        
        # Draw rectangles around faces
        for (top, right, bottom, left) in face_locations:
            cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
        
        cv2.imshow('Face Detection', frame)
        cv2.waitKey(0)
        cv2.destroyAllWindows()
        
    else:
        # Video mode
        cap = cv2.VideoCapture(video_source)
        
        while True:
            ret, frame = cap.read()
            if not ret:
                break
                
            # Resize frame for faster processing
            small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)
            rgb_small_frame = cv2.cvtColor(small_frame, cv2.COLOR_BGR2RGB)
            
            face_locations = face_recognition.face_locations(rgb_small_frame)
            
            # Draw rectangles around faces
            for (top, right, bottom, left) in face_locations:
                # Scale back up face locations
                top *= 4
                right *= 4
                bottom *= 4
                left *= 4
                
                cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
            
            cv2.imshow('Face Detection', frame)
            
            if cv2.waitKey(1) & 0xFF == ord('q'):
                break
        
        cap.release()
        cv2.destroyAllWindows()

if __name__ == "__main__":
    # Example usage
    # For image: detect_faces("path/to/image.jpg")
    # For video/webcam: detect_faces()
    detect_faces()
