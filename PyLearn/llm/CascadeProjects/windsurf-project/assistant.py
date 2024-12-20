from model.system_assistant import SystemAssistant
import time
import os
from typing import List, Dict
import psutil

def print_help():
    """Print available commands"""
    print("\nAvailable Commands:")
    print("!help     - Show this help message")
    print("!clear    - Clear the screen")
    print("!files    - List files in current directory")
    print("!read     - Read a file (!read filename)")
    print("!write    - Write to a file (!write filename content)")
    print("!search   - Search for files (!search pattern)")
    print("!cmd      - Execute a system command (!cmd command)")
    print("!exit     - Exit the chat")
    print("!memory   - Show memory usage")
    print()

def clear_screen():
    """Clear the terminal screen"""
    os.system('cls' if os.name == 'nt' else 'clear')

def handle_command(command: str, assistant: SystemAssistant) -> bool:
    """Handle special commands
    Returns: True if should continue, False if should exit
    """
    parts = command.split(maxsplit=1)
    cmd = parts[0].lower()
    args = parts[1] if len(parts) > 1 else ""

    if cmd == "!help":
        print_help()
    elif cmd == "!clear":
        clear_screen()
    elif cmd == "!files":
        files = assistant.list_directory(".")
        for file_info in files:
            if file_info['is_file']:
                print(f" {file_info['name']} ({file_info['size']} bytes)")
            else:
                print(f" {file_info['name']}")
    elif cmd == "!read":
        if not args:
            print("Please specify a filename: !read filename")
            return True
        content = assistant.read_file(args)
        print(f"\nContent of {args}:")
        print("-------------------")
        print(content)
        print("-------------------")
    elif cmd == "!write":
        try:
            filename, content = args.split(maxsplit=1)
            success = assistant.create_file(filename, content)
            print(f"File {'created successfully' if success else 'creation failed'}")
        except ValueError:
            print("Usage: !write filename content")
    elif cmd == "!search":
        if not args:
            print("Please specify a search pattern: !search pattern")
            return True
        files = assistant.search_files(".", args)
        print(f"\nFound {len(files)} matching files:")
        for file in files:
            print(f"- {file}")
    elif cmd == "!cmd":
        if not args:
            print("Please specify a command: !cmd command")
            return True
        result = assistant.execute_command(args)
        print(result if result else "Command failed")
    elif cmd == "!memory":
        memory = psutil.virtual_memory()
        print(f"\nMemory Usage:")
        print(f"Total: {memory.total / (1024**3):.1f} GB")
        print(f"Available: {memory.available / (1024**3):.1f} GB")
        print(f"Used: {memory.percent}%")
    elif cmd == "!exit":
        return False
    else:
        print(f"Unknown command: {cmd}")
        print("Type !help for available commands")
    
    return True

def chat_loop(assistant: SystemAssistant):
    """Main chat loop"""
    clear_screen()
    print("Welcome to the AI Assistant Chat!")
    print("Type your message or use commands (type !help for available commands)")
    print("Type !exit to quit")
    print("\nInitializing chat...\n")

    try:
        while True:
            try:
                user_input = input("\n You: ").strip()
                
                # Handle empty input
                if not user_input:
                    continue
                
                # Handle commands
                if user_input.startswith("!"):
                    if not handle_command(user_input, assistant):
                        break
                    continue

                # Generate response
                print("\n Assistant: ", end="", flush=True)
                response = assistant.generate_response(user_input)
                print(response)

            except KeyboardInterrupt:
                print("\nUse !exit to quit properly")
            except Exception as e:
                print(f"\nError: {str(e)}")
                print("Please try again")

    finally:
        print("\nCleaning up...")
        assistant.cleanup()
        print("Goodbye! ")

def main():
    # Initialize the assistant with the smallest model
    print("Initializing AI Assistant...")
    assistant = SystemAssistant()
    assistant.change_model("small")
    
    # Start chat loop
    chat_loop(assistant)

if __name__ == "__main__":
    main()