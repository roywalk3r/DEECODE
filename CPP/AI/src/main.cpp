#include <iostream>
#include <fstream>
#include <string>
#include <unordered_map>
#include <sstream>

class Chatbot {
private:
    std::unordered_map<std::string, std::string> memory;

public:
    void loadDataset(const std::string& filename) {
        std::ifstream file(filename);
        if (!file.is_open()) {
            std::cerr << "Error: Unable to open file: " << filename << "\n";
            return;
        }

        std::string line;
        while (std::getline(file, line)) {
            std::istringstream stream(line);
            std::string input, response;

            // Split line into input and response using tab delimiter
            if (std::getline(stream, input, '\t') && std::getline(stream, response)) {
                memory[input] = response;
            }
        }
        file.close();
        std::cout << "Dataset loaded successfully.\n";
    }

    void respond(const std::string& input) {
        if (memory.find(input) != memory.end()) {
            std::cout << memory[input] << "\n";
        } else {
            std::cout << "I don't know how to respond to that.\n";
        }
    }
};

int main() {
    Chatbot myAI;
    myAI.loadDataset("dialog.txt"); // Make sure the dataset file is in the same directory

    std::string input;
    while (true) {
        std::cout << "You: ";
        std::getline(std::cin, input);

        if (input == "exit") {
            std::cout << "Goodbye!\n";
            break;
        }

        myAI.respond(input);
    }

    return 0;
}
