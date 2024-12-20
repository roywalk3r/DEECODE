import subprocess
import sys
import os
import time

def run_command(command):
    """Run a command and return its output"""
    try:
        result = subprocess.run(command, shell=True, check=True, capture_output=True, text=True)
        return True, result.stdout
    except subprocess.CalledProcessError as e:
        return False, e.stderr

def install_package(package):
    """Install a single package using pip"""
    print(f"\nInstalling {package}...")
    success, output = run_command(f"{sys.executable} -m pip install {package}")
    if success:
        print(f"Successfully installed {package}")
    else:
        print(f"Failed to install {package}")
        print(f"Error: {output}")
    return success

def main():
    print("Starting installation of requirements...")
    
    # First, upgrade pip
    print("\nUpgrading pip...")
    run_command(f"{sys.executable} -m pip install --upgrade pip")
    
    # Basic requirements first
    basic_packages = [
        "numpy",
        "opencv-python",
        "mediapipe"
    ]
    
    # AI and ML packages
    ai_packages = [
        "tensorflow",
        "torch",
        "transformers",
        "scikit-learn",
        "deepface"
    ]
    
    # Voice and audio packages
    voice_packages = [
        "pyttsx3",
        "SpeechRecognition",
        "PyAudio"
    ]
    
    # Utility packages
    util_packages = [
        "python-dotenv",
        "openai",
        "nltk"
    ]
    
    # Install basic packages
    print("\nInstalling basic packages...")
    for package in basic_packages:
        if not install_package(package):
            print(f"Failed to install {package}. Stopping installation.")
            return
    
    # Install AI and ML packages
    print("\nInstalling AI and ML packages...")
    for package in ai_packages:
        if not install_package(package):
            print(f"Failed to install {package}. Continuing with other packages...")
            continue
    
    # Install voice packages
    print("\nInstalling voice and audio packages...")
    for package in voice_packages:
        if not install_package(package):
            print(f"Failed to install {package}. Continuing with other packages...")
            continue
    
    # Install utility packages
    print("\nInstalling utility packages...")
    for package in util_packages:
        if not install_package(package):
            print(f"Failed to install {package}. Continuing with other packages...")
            continue
    
    print("\nInstallation completed!")
    print("\nNote: If you encounter any issues with PyAudio installation:")
    print("1. For Windows: Try installing the wheel file manually from:")
    print("   https://www.lfd.uci.edu/~gohlke/pythonlibs/#pyaudio")
    print("2. For Linux: Install portaudio development package first:")
    print("   sudo apt-get install python3-pyaudio")

if __name__ == "__main__":
    main()
