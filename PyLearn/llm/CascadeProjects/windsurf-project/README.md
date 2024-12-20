# Face Recognition System

## Setup
1. Create a virtual environment:
```bash
python -m venv venv
source venv/bin/activate  # On Windows, use `venv\Scripts\activate`
```

2. Install dependencies:
```bash
pip install -r requirements.txt
```

## Project Structure
- `face_detection.py`: Detect faces in images and video
- `face_recognition.py`: Recognize known faces
- `train_faces.py`: Train the system with known faces

## Usage
1. Add known face images to the `known_faces` directory
2. Run `train_faces.py` to train the recognition system
3. Use `face_recognition.py` to recognize faces in images or video
