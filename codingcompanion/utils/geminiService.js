const { GoogleGenerativeAI } = require("@google/generative-ai");
require("dotenv").config();

const genAI = new GoogleGenerativeAI(process.env.GOOGLE_API_KEY);
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
const sessionHistory = {};

async function generateContentWithHistory(sessionId, prompt) {
    const previousResponses = sessionHistory[sessionId] || [];
    const response = await generateContentFromGemini(`${previousResponses.join(" ")} ${prompt}`);
    sessionHistory[sessionId] = [...previousResponses, response];
    return response;
}

async function generateContentFromGemini(prompt, model = "gemini-1.5-flash") {    try {
    const modelToUse = genAI.getGenerativeModel({ model });
    const result = await modelToUse.generateContent(prompt);
    return result.response.text();
    } catch (error) {
        console.error("Error in generateContentFromGemini:", error);
        throw error;
    }
}

module.exports = { generateContentWithHistory, generateContentFromGemini };
