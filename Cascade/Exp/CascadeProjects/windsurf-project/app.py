import os
from flask import Flask, render_template, request, jsonify
from flask_cors import CORS
from transformers import AutoModelForCausalLM, AutoTokenizer
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

# Initialize Flask app
app = Flask(__name__)
CORS(app)

# Load Qwen model with auth token
model_name = "Qwen/Qwen2.5-Coder-32B-Instruct"
auth_token = os.getenv("HUGGINGFACE_HUB_API_TOKEN")
tokenizer = AutoTokenizer.from_pretrained(model_name, token=auth_token)
model = AutoModelForCausalLM.from_pretrained(model_name, token=auth_token)

def generate_response(prompt):
    """Generate AI response using Qwen model"""
    try:
        # Prepare input
        inputs = tokenizer.encode(prompt, return_tensors="pt")
        
        # Generate response
        outputs = model.generate(
            inputs, 
            max_length=int(os.getenv("MAX_TOKENS", 200)), 
            num_return_sequences=1,
            no_repeat_ngram_size=2,
            temperature=0.7
        )
        
        # Decode and return response
        response = tokenizer.decode(outputs[0], skip_special_tokens=True)
        return response
    except Exception as e:
        return f"Error generating response: {str(e)}"

@app.route('/')
def index():
    """Render the main page"""
    return render_template('index.html')

@app.route('/chat', methods=['POST'])
def chat():
    """Handle chat interactions"""
    data = request.json
    user_message = data.get('message', '')
    
    if not user_message:
        return jsonify({"error": "No message provided"}), 400
    
    ai_response = generate_response(user_message)
    return jsonify({"response": ai_response})

if __name__ == '__main__':
    app.run(debug=True, host='127.0.0.1', port=8080)
