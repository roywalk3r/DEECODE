const express = require("express");
const { generateGeminiResponse } = require("../controllers/geminiController");
const router = express.Router();

// Define a route to handle prompts for Gemini
router.post("/generate", generateGeminiResponse);
router.post("/prompts", (req, res) => {
    const prompts = [
        "What is the capital of France?",
        "Explain the theory of relativity.",
        "What are the benefits of using Node.js?"
    ];
    res.json(prompts); // Return the predefined prompts
});
module.exports = router;
