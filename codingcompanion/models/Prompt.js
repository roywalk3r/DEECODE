// models/Prompt.js
const { PrismaClient } = require("@prisma/client");
const prisma = new PrismaClient();

async function createPrompt(text, category) {
    return await prisma.prompt.create({
        data: { text, category }
    });
}

async function getPromptsByCategory(category) {
    return await prisma.prompt.findMany({
        where: { category }
    });
}

// Export the functions
module.exports = { createPrompt, getPromptsByCategory };
