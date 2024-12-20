const FtpSrv = require("ftp-srv");
const { networkInterfaces } = require('os');
const path = require('path');
const fs = require('fs');

// Get local network interfaces
const nets = networkInterfaces();

// Function to get the local IP address
const getLocalIP = () => {
    for (const name of Object.keys(nets)) {
        for (const net of nets[name]) {
            if (net.family === 'IPv4' && !net.internal) {
                return net.address; // Return the first non-internal IPv4 address
            }
        }
    }
    return "127.0.0.1"; // Fallback to localhost if no address found
};

// Define FTP server options
const host = "192.168.100.24"; // Predefined IP address
const port = 2221; // Use default FTP port for optimal routing
const ftpRoot = path.join(require('os').homedir(),'Desktop', 'uploads'); // Set the root directory for FTP

// Ensure the FTP directory exists
if (!fs.existsSync(ftpRoot)) {
    fs.mkdirSync(ftpRoot, { recursive: true });
    console.log(`Created directory: ${ftpRoot}`);
}

// Define user credentials
const USERNAME = "ftp";
const PASSWORD = "1111chopbox";

const ftpServer = new FtpSrv({
    url: `ftp://${host}:${port}`,
    anonymous: false, // Disable anonymous access
    greeting: ["Welcome to the high-speed FTP server!"], // Add a greeting
    maxConnections: 20, // Allow up to 20 simultaneous connections
    pasv_url: host, // Use specific host for passive mode
    pasv_min: 1024, // Define a range for passive mode ports
    pasv_max: 1050,
});

// Log when a client connects
ftpServer.on("client-connected", (connection) => {
    console.log(`Client connected: ${connection.id}`);
});

// Handle file upload and download logging
ftpServer.on("login", ({ connection, username, password }, resolve, reject) => {
    connection.on("RETR", (error, filePath) => {
        if (error) console.log(`File download error: ${error}`);
        else console.log(`File downloaded: ${filePath}`);
    });

    connection.on("STOR", (error, filePath) => {
        if (error) console.log(`File upload error: ${error}`);
        else console.log(`File uploaded: ${filePath}`);
    });

    // Check the provided username and password
    if (username === USERNAME && password === PASSWORD) {
        return resolve({ root: ftpRoot });
    } else {
        console.log("Invalid username or password");
        return reject(new Error("Invalid username or password"));
    }
});

// Handle client errors
ftpServer.on("client-error", ({ connection, context, error }) => {
    console.log(`Client error at ${context}: ${error}`);
});

// Start the FTP server
ftpServer.listen().then(() => {
    console.log(`High-speed FTP server started at ftp://${host}:${port}...`);
    console.log(`Files can be accessed at: ftp://${USERNAME}:${PASSWORD}@${host}:${port}/`);
});
