import subprocess
import sys
import os

def install_requirements():
    print("Setting up the AI Face Recognition System...")
    
    # First install setuptools and wheel
    print("\nStep 1: Installing basic build requirements...")
    basic_setup = [
        "setuptools",
        "wheel"
    ]
    
    for req in basic_setup:
        try:
            subprocess.check_call([sys.executable, "-m", "pip", "install", "--upgrade", req])
        except subprocess.CalledProcessError as e:
            print(f"Error installing {req}: {str(e)}")
            return False
    
    # Install cmake and basic requirements
    basic_requirements = [
        "cmake>=3.25.0",
        "urllib3==2.0.7",
        "numpy==1.24.3",
        "matplotlib==3.7.1",
        "Pillow==10.0.1",
        "imutils==0.5.4"
    ]
    
    print("\nStep 2: Installing basic requirements...")
    for req in basic_requirements:
        try:
            subprocess.check_call([sys.executable, "-m", "pip", "install", req])
        except subprocess.CalledProcessError as e:
            print(f"Error installing {req}: {str(e)}")
            return False
    
    # Install dlib separately
    print("\nStep 3: Installing dlib...")
    try:
        subprocess.check_call([sys.executable, "-m", "pip", "install", "dlib==19.24.2", "--no-cache-dir"])
    except subprocess.CalledProcessError:
        print("Error installing dlib. Please make sure you have Visual Studio Build Tools installed.")
        print("You can download it from: https://visualstudio.microsoft.com/visual-cpp-build-tools/")
        return False
    
    # Install face recognition packages
    print("\nStep 4: Installing face recognition packages...")
    face_reqs = [
        "face-recognition-models==0.3.0",
        "face-recognition==1.3.0"
    ]
    for req in face_reqs:
        try:
            subprocess.check_call([sys.executable, "-m", "pip", "install", req])
        except subprocess.CalledProcessError as e:
            print(f"Error installing {req}: {str(e)}")
            return False
    
    # Install AI and ML packages
    print("\nStep 5: Installing AI and ML packages...")
    ai_reqs = [
        "tensorflow==2.13.0",
        "keras==2.13.1",
        "deepface==0.0.79",
        "scikit-learn==1.3.0",
        "pandas==2.0.3",
        "mediapipe==0.10.8"
    ]
    for req in ai_reqs:
        try:
            subprocess.check_call([sys.executable, "-m", "pip", "install", "--no-cache-dir", req])
        except subprocess.CalledProcessError as e:
            print(f"Error installing {req}: {str(e)}")
            return False
    
    # Install voice interaction packages
    print("\nStep 6: Installing voice interaction packages...")
    voice_reqs = [
        "pyttsx3==2.90",
        "SpeechRecognition==3.10.0"
    ]
    for req in voice_reqs:
        try:
            subprocess.check_call([sys.executable, "-m", "pip", "install", req])
        except subprocess.CalledProcessError as e:
            print(f"Error installing {req}: {str(e)}")
            return False
    
    print("\nAll requirements installed successfully!")
    return True

if __name__ == "__main__":
    if install_requirements():
        print("\nSetup completed successfully! You can now run the AI Face Recognition System.")
        print("Run 'python ai_face_system.py' to start the system.")
    else:
        print("\nSetup failed. Please check the error messages above.")
