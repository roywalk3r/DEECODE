// routes/promptsRoutes.js
const express = require("express");
const { createPrompt, getPromptsByCategory } = require("../controllers/promptsController");
const router = express.Router();

// Route for creating a new prompt
router.post("/", async (req, res) => {
    const { text, category } = req.body;
    const prompt = await createPrompt(text, category);
    res.status(201).json(prompt);
});

// Route for fetching prompts by category
router.get("/:category", async (req, res) => {
    const prompts = await getPromptsByCategory(req.params.category);
    res.json(prompts);
});

module.exports = router;
