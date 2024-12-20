# Facial and Movement Recognition System

## Overview
This Python project implements real-time facial recognition and body movement tracking using advanced computer vision techniques.

## Features
- Real-time face detection
- Face recognition with name identification
- Body landmark and movement tracking
- Webcam-based interaction

## Prerequisites
- Python 3.8+
- Webcam

## Installation
1. Clone the repository
2. Create a virtual environment
```bash
python -m venv venv
source venv/bin/activate  # On Windows use `venv\Scripts\activate`
```

3. Install dependencies
```bash
pip install -r requirements.txt
```

## Usage
```bash
python facial_movement_recognition.py
```

### Registering Faces
Uncomment and modify the `register_face()` method in the script to add known faces.

## Libraries Used
- OpenCV: Image processing
- MediaPipe: Body landmark detection
- face_recognition: Facial recognition
- NumPy: Numerical computing

## Troubleshooting
- Ensure webcam is connected
- Check Python and library versions
- Verify camera permissions

## Contributing
Pull requests are welcome. For major changes, please open an issue first.
