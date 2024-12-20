import subprocess
import sys
import os
import platform
import urllib.request
import ssl

def download_file(url, filename):
    """Download a file from a URL"""
    try:
        # Create an SSL context that doesn't verify certificates
        ctx = ssl.create_default_context()
        ctx.check_hostname = False
        ctx.verify_mode = ssl.CERT_NONE
        
        with urllib.request.urlopen(url, context=ctx) as response, open(filename, 'wb') as out_file:
            out_file.write(response.read())
        return True
    except Exception as e:
        print(f"Error downloading {filename}: {str(e)}")
        return False

def install_pyaudio():
    """Install PyAudio using wheel file for Windows"""
    system = platform.system()
    if system == "Windows":
        python_version = f"{sys.version_info.major}{sys.version_info.minor}"
        architecture = "win_amd64" if platform.machine().endswith('64') else "win32"
        
        # URL for PyAudio wheel
        wheel_url = f"https://download.lfd.uci.edu/pythonlibs/archived/PyAudio-0.2.11-cp{python_version}-cp{python_version}-{architecture}.whl"
        wheel_file = f"PyAudio-0.2.11-cp{python_version}-cp{python_version}-{architecture}.whl"
        
        print("Downloading PyAudio wheel...")
        if download_file(wheel_url, wheel_file):
            print("Installing PyAudio from wheel...")
            try:
                subprocess.check_call([sys.executable, "-m", "pip", "install", wheel_file])
                os.remove(wheel_file)
                return True
            except subprocess.CalledProcessError:
                print("Failed to install PyAudio wheel")
                if os.path.exists(wheel_file):
                    os.remove(wheel_file)
                return False
    return False

def install_requirements():
    """Install all required packages"""
    print("Setting up AI Assistant environment...")
    
    # Upgrade pip, setuptools, and wheel
    print("\nUpgrading pip, setuptools, and wheel...")
    subprocess.check_call([sys.executable, "-m", "pip", "install", "--upgrade", "pip", "setuptools", "wheel"])
    
    # Install numpy first as it's a common dependency
    print("\nInstalling numpy...")
    try:
        subprocess.check_call([sys.executable, "-m", "pip", "install", "numpy>=1.21.0"])
    except subprocess.CalledProcessError:
        print("Failed to install numpy. Please try a different Python version (3.9-3.11)")
        return False
    
    # Install PyAudio separately
    print("\nInstalling PyAudio...")
    if not install_pyaudio():
        print("PyAudio installation failed. You may need to install it manually.")
        print("Download the appropriate wheel from: https://www.lfd.uci.edu/~gohlke/pythonlibs/#pyaudio")
    
    # Install other requirements
    print("\nInstalling other requirements...")
    try:
        subprocess.check_call([sys.executable, "-m", "pip", "install", "-r", "requirements.txt"])
    except subprocess.CalledProcessError as e:
        print(f"Error installing requirements: {str(e)}")
        return False
    
    # Download NLTK data
    print("\nDownloading NLTK data...")
    try:
        import nltk
        nltk.download('punkt')
        nltk.download('stopwords')
    except Exception as e:
        print(f"Error downloading NLTK data: {str(e)}")
    
    print("\nInstallation completed!")
    print("\nNotes:")
    print("1. If you plan to use OpenAI features, create a .env file with your API key:")
    print("   OPENAI_API_KEY=your_api_key_here")
    print("\n2. If you had any issues with PyAudio, try installing it manually:")
    print("   - Download from: https://www.lfd.uci.edu/~gohlke/pythonlibs/#pyaudio")
    print("   - Install with: pip install PyAudio_wheel_file.whl")
    
    return True

if __name__ == "__main__":
    install_requirements()
