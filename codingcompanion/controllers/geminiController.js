// controllers/geminiController.js
const { generateContentFromGemini } = require("../utils/geminiService");
const fs = require("fs");
const path = require("path");

const sessionHistory = {}; // Store session history in-memory

async function generateGeminiResponse(req, res) {
    const { prompt, sessionId } = req.body; // Expecting sessionId from the request body
    try {
        const response = await generateContentWithHistory(sessionId, prompt);
        logInteraction(prompt, response);
        res.json({ response });
    } catch (error) {
        console.error("Error generating response:", error);
        res.status(500).json({ error: "Failed to generate response" });
    }
}

function logInteraction(prompt, response) {
    const logData = `${new Date().toISOString()} - Prompt: ${prompt} - Response: ${response}\n`;
    fs.appendFileSync(path.join(__dirname, '../logs/interaction.log'), logData);
}

async function generateContentWithHistory(sessionId, prompt) {
    const previousResponses = sessionHistory[sessionId] || [];
    const response = await generateContentFromGemini(`${previousResponses.join(" ")} ${prompt}`);
    sessionHistory[sessionId] = [...previousResponses, response]; // Update session history
    return response;
}

module.exports = { generateGeminiResponse };
