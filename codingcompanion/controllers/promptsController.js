// controllers/promptsController.js
const { createPrompt, getPromptsByCategory } = require("../models/Prompt");

async function createNewPrompt(req, res) {
    const { text, category } = req.body;
    try {
        const prompt = await createPrompt(text, category);
        res.status(201).json(prompt);
    } catch (error) {
        res.status(500).json({ error: "Failed to create prompt" });
    }
}

async function fetchPromptsByCategory(req, res) {
    const { category } = req.params;
    try {
        const prompts = await getPromptsByCategory(category);
        res.json(prompts);
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch prompts" });
    }
}

module.exports = { createNewPrompt, fetchPromptsByCategory };
