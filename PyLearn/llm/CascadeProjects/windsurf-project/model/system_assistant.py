import os
import shutil
from pathlib import Path
from transformers import AutoTokenizer, AutoModelForCausalLM
import torch
from typing import List, Dict, Any, Optional, Union, Generator
import json
import logging
import gc
import psutil
import time
from concurrent.futures import ThreadPoolExecutor
from threading import Lock

class SystemAssistant:
    def __init__(self, model_name: str = "TinyLlama/TinyLlama-1.1B-Chat-v1.0"):
        self.setup_logging()
        self.logger.info("Initializing SystemAssistant...")
        
        # Available models and their sizes
        self.available_models = {
            "tiny": "TinyLlama/TinyLlama-1.1B-Chat-v1.0",  # ~1.1GB
            "small": "facebook/opt-125m",                   # ~125MB
            "mini": "microsoft/phi-1_5",                    # ~1.3GB
        }
        
        # Memory management
        self.memory_threshold = 0.9  # 90% memory usage threshold
        self._model_lock = Lock()
        self.conversation_history = []
        self.max_history = 10
        
        # Initialize the model and tokenizer
        self.device = "cuda" if torch.cuda.is_available() else "cpu"
        self._load_model(model_name)
        
    def _load_model(self, model_name: str) -> None:
        """Load model with memory management"""
        try:
            # Check memory before loading
            if self._check_memory_usage():
                self._free_memory()
            
            with self._model_lock:
                self.tokenizer = AutoTokenizer.from_pretrained(model_name)
                self.model = AutoModelForCausalLM.from_pretrained(
                    model_name,
                    torch_dtype=torch.float16 if self.device == "cuda" else torch.float32,
                    low_cpu_mem_usage=True,
                ).to(self.device)
            
            self.logger.info(f"Model loaded successfully on {self.device}")
        except Exception as e:
            self.logger.error(f"Error loading model: {str(e)}")
            raise

    def _check_memory_usage(self) -> bool:
        """Check if memory usage is above threshold"""
        memory = psutil.virtual_memory()
        return memory.percent > (self.memory_threshold * 100)

    def _free_memory(self) -> None:
        """Free up memory"""
        if hasattr(self, 'model'):
            with self._model_lock:
                del self.model
                if torch.cuda.is_available():
                    torch.cuda.empty_cache()
                gc.collect()
        self.logger.info("Memory cleared")

    def setup_logging(self):
        """Set up logging configuration"""
        self.logger = logging.getLogger('SystemAssistant')
        self.logger.setLevel(logging.INFO)
        
        if not self.logger.handlers:
            handler = logging.FileHandler('system_assistant.log')
            formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
            handler.setFormatter(formatter)
            self.logger.addHandler(handler)

    def change_model(self, model_size: str = "tiny") -> bool:
        """Change the current model to a different size"""
        try:
            if model_size not in self.available_models:
                raise ValueError(f"Invalid model size. Choose from: {list(self.available_models.keys())}")
            
            model_name = self.available_models[model_size]
            self._load_model(model_name)
            return True
        except Exception as e:
            self.logger.error(f"Error changing model: {str(e)}")
            return False

    def generate_response(self, prompt: str, max_length: int = 100, 
                         temperature: float = 0.7) -> str:
        """Generate a response using the model with context"""
        try:
            # Add prompt to history
            self.conversation_history.append({"role": "user", "content": prompt})
            if len(self.conversation_history) > self.max_history:
                self.conversation_history.pop(0)

            # Create context from history
            context = " ".join([f"{msg['role']}: {msg['content']}" 
                              for msg in self.conversation_history[-3:]])

            with self._model_lock:
                inputs = self.tokenizer(context, return_tensors="pt").to(self.device)
                outputs = self.model.generate(
                    **inputs,
                    max_length=max_length,
                    num_return_sequences=1,
                    do_sample=True,
                    temperature=temperature,
                    top_p=0.9,
                    pad_token_id=self.tokenizer.eos_token_id
                )
                response = self.tokenizer.decode(outputs[0], skip_special_tokens=True)

            # Add response to history
            self.conversation_history.append({"role": "assistant", "content": response})
            return response
        except Exception as e:
            self.logger.error(f"Error generating response: {str(e)}")
            return f"Error generating response: {str(e)}"

    def process_file_async(self, operation: str, *args, **kwargs) -> Any:
        """Process file operations asynchronously"""
        with ThreadPoolExecutor() as executor:
            future = executor.submit(getattr(self, operation), *args, **kwargs)
            return future.result()

    def create_file(self, filepath: str, content: str = "") -> bool:
        """Create a new file with optional content"""
        try:
            Path(filepath).parent.mkdir(parents=True, exist_ok=True)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            self.logger.info(f"Successfully created file: {filepath}")
            return True
        except Exception as e:
            self.logger.error(f"Error creating file {filepath}: {str(e)}")
            return False

    def read_file(self, filepath: str, chunk_size: int = None) -> Union[str, Generator]:
        """Read content from a file with optional chunking"""
        try:
            if chunk_size:
                def chunk_reader():
                    with open(filepath, 'r', encoding='utf-8') as f:
                        while chunk := f.read(chunk_size):
                            yield chunk
                return chunk_reader()
            else:
                with open(filepath, 'r', encoding='utf-8') as f:
                    return f.read()
        except Exception as e:
            self.logger.error(f"Error reading file {filepath}: {str(e)}")
            return ""

    def list_directory(self, directory: str, pattern: str = None) -> List[Dict[str, Any]]:
        """List contents of a directory with detailed information"""
        try:
            path = Path(directory)
            files = []
            for item in path.glob(pattern or '*'):
                file_info = {
                    'name': item.name,
                    'path': str(item),
                    'is_file': item.is_file(),
                    'is_dir': item.is_dir(),
                    'size': item.stat().st_size if item.is_file() else None,
                    'modified': time.ctime(item.stat().st_mtime)
                }
                files.append(file_info)
            return files
        except Exception as e:
            self.logger.error(f"Error listing directory {directory}: {str(e)}")
            return []

    def search_files(self, directory: str, pattern: str) -> List[str]:
        """Search for files matching a pattern"""
        try:
            matches = []
            for root, _, files in os.walk(directory):
                for filename in files:
                    if pattern in filename:
                        matches.append(os.path.join(root, filename))
            return matches
        except Exception as e:
            self.logger.error(f"Error searching files: {str(e)}")
            return []

    def execute_command(self, command: str) -> Optional[str]:
        """Execute a system command safely"""
        try:
            import subprocess
            result = subprocess.run(command, shell=True, capture_output=True, text=True)
            return result.stdout if result.returncode == 0 else f"Error: {result.stderr}"
        except Exception as e:
            self.logger.error(f"Error executing command: {str(e)}")
            return None

    def cleanup(self):
        """Cleanup resources"""
        self._free_memory()
        self.logger.info("System Assistant cleaned up successfully")
