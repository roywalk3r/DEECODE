// seed.js
const { PrismaClient } = require("@prisma/client");
const prisma = new PrismaClient();

async function main() {
    await prisma.prompt.createMany({
        data: [
            { text: "Explain how AI works", category: "AI" },
            { text: "What is JavaScript?", category: "Programming" },
            { text: "How does web development work?", category: "Web Development" },
            { text: "Explain how machine learning works", category: "AI" },
            // Add more prompts as needed
        ],
    });
}

main()
    .catch(e => console.error(e))
    .finally(async () => {
        await prisma.$disconnect();
    });
