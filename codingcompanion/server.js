const express = require("express");
const geminiRoutes = require("./routes/geminiRoutes");
const { PrismaClient } = require("@prisma/client"); // Import PrismaClient
const prisma = new PrismaClient(); // Create an instance of PrismaClient
const cors = require("cors");
const app = express();

// Allow CORS for requests from http://localhost:3001 (your Next.js frontend)
app.use(cors({
    origin: "http://localhost:3001",
    methods: ["GET", "POST"],
    credentials: true
}));
app.use(express.json());
app.use("/api/gemini", geminiRoutes);

// Gracefully disconnect from the database on application exit
process.on('SIGINT', async () => {
    await prisma.$disconnect(); // Disconnect Prisma client
    process.exit(0);
});

// Start the server and listen on port 3000
app.listen(3000, () => {
    console.log("Server is running on port 3000");
});
