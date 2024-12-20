import * as vscode from "vscode";
import * as path from "path";
import * as fs from "fs/promises";
import { GoogleGenerativeAI } from "@google/generative-ai";

// Initialize Google Generative AI client
const API_KEY = "AIzaSyD2aV3EVGCjS3EzytSD1OhU03ga6hATXGU"; // Replace with your actual API key
const genAI = new GoogleGenerativeAI(API_KEY);
const model = genAI.getGenerativeModel({ model: "gemini-1.5-pro" });

interface CodeStructure {
  [key: string]: string;
}
interface ChatMessage {
  role: "user" | "ai";
  content: string;
}
let chatHistory: ChatMessage[] = [];
let chatViewProvider: ChatViewProvider;
class ChatViewProvider implements vscode.WebviewViewProvider {
  private _view?: vscode.WebviewView;

  constructor(private readonly _extensionUri: vscode.Uri) {}

  public resolveWebviewView(
    webviewView: vscode.WebviewView,
    context: vscode.WebviewViewResolveContext,
    _token: vscode.CancellationToken
  ) {
    this._view = webviewView;

    webviewView.webview.options = {
      enableScripts: true,
      localResourceRoots: [this._extensionUri],
    };

    webviewView.webview.html = this._getHtmlForWebview(webviewView.webview);

    webviewView.webview.onDidReceiveMessage(async (data) => {
      switch (data.type) {
        case "sendMessage":
          await this.handleUserMessage(data.value);
          break;
      }
    });
  }

  private async handleUserMessage(message: string) {
    if (!this._view) return;

    chatHistory.push({ role: "user", content: message });
    this._view.webview.postMessage({
      type: "addMessage",
      value: { role: "user", content: message },
    });

    if (message.startsWith("@")) {
      await this.handleFileMention(message);
    } else if (message.startsWith("/")) {
      await this.handleCommand(message);
    } else {
      await this.getAIResponse(message);
    }
  }

  private async handleFileMention(message: string) {
    const fileName = message.slice(1).trim();
    const workspaceFolders = vscode.workspace.workspaceFolders;
    if (!workspaceFolders) {
      this.sendAIMessage("No workspace folder is open.");
      return;
    }

    const rootPath = workspaceFolders[0].uri.fsPath;
    const filePath = path.join(rootPath, fileName);

    try {
      const fileContent = await fs.readFile(filePath, "utf-8");
      await this.getAIResponse(
        `File content of ${fileName}:\n\n${fileContent}`
      );
    } catch (error: any) {
      this.sendAIMessage(`Error reading file ${fileName}: ${error.message}`);
    }
  }

  private async handleCommand(message: string) {
    const command = message.slice(1).trim();
    switch (command) {
      case "generate":
        await generateCodeFromPrompt();
        break;
      case "edit":
        await editActiveFile();
        break;
      case "explain":
        await explainCode();
        break;
      case "history":
        await viewChatHistory();
        break;
      default:
        this.sendAIMessage(`Unknown command: ${command}`);
    }
  }

  private async getAIResponse(message: string) {
    try {
      const result = await model.generateContent(message);
      const response = result.response.text();
      chatHistory.push({ role: "ai", content: response });
      this.sendAIMessage(response);
    } catch (error: any) {
      this.sendAIMessage(`Error: ${error.message}`);
    }
  }

  private sendAIMessage(message: string) {
    if (this._view) {
      this._view.webview.postMessage({
        type: "addMessage",
        value: { role: "ai", content: message },
      });
    }
  }

  private _getHtmlForWebview(webview: vscode.Webview) {
    const scriptUri = webview.asWebviewUri(
      vscode.Uri.joinPath(this._extensionUri, "media", "main.ts")
    );
    const styleUri = webview.asWebviewUri(
      vscode.Uri.joinPath(this._extensionUri, "media", "style.css")
    );

    return `<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="${styleUri}" rel="stylesheet">
        <title>AI Chat</title>
    </head>
    <body>
        <div id="chat-container"></div>
        <div id="input-container">
            <input type="text" id="user-input" placeholder="Type a message...">
            <button id="send-button">Send</button>
        </div>
        <script src="${scriptUri}"></script>
    </body>
    </html>`;
  }
}

async function generateCodeFromPrompt() {
  const prompt = await vscode.window.showInputBox({
    prompt: "Enter your prompt for code generation with structure details",
  });
  if (!prompt) {
    console.log("No prompt entered. Exiting function.");
    return;
  }

  const workspaceFolders = vscode.workspace.workspaceFolders;
  if (!workspaceFolders) {
    console.log("No workspace folder found.");
    vscode.window.showErrorMessage("Please open a workspace folder first.");
    return;
  }

  const rootPath = workspaceFolders[0].uri.fsPath;
  console.log(`Root path: ${rootPath}`);

  try {
    vscode.window.withProgress(
      {
        location: vscode.ProgressLocation.Notification,
        title: "Generating Code",
        cancellable: true,
      },
      async (progress) => {
        progress.report({ increment: 0 });

        console.log("Generating content from prompt...");
        const generatedCode = await getGeneratedContent(prompt);
        console.log("Generated content:", generatedCode);
        progress.report({ increment: 30, message: "Code structure generated" });

        console.log("Parsing structure...");
        const structure = parseStructure(generatedCode);
        console.log("Parsed structure:", structure);
        progress.report({ increment: 20, message: "Parsing structure" });

        console.log("Creating files and directories...");
        await createFilesAndDirectories(rootPath, structure);
        progress.report({
          increment: 50,
          message: "Creating files and directories",
        });

        vscode.window.showInformationMessage(
          `Files and directories generated based on prompt.`
        );

        // Add to chat history
        chatHistory.push({ role: "user", content: prompt });
        chatHistory.push({
          role: "ai",
          content: "Code generated successfully.",
        });
      }
    );
  } catch (error: any) {
    console.error("Error in generateCodeFromPrompt:", error);
    vscode.window.showErrorMessage(`Failed to generate code: ${error.message}`);
  }
}

async function getGeneratedContent(prompt: string): Promise<string> {
  try {
    const formattedPrompt = `Generate a strict JSON object with file paths as keys and their corresponding file contents as string values. Do not use backticks, template literals, or any other formatting. The response should be a JSON object only, with no extraneous syntax. Here's the request:\n\n${prompt}`;
    console.log("Formatted prompt:", formattedPrompt);
    const result = await model.generateContent(formattedPrompt);
    // Await the `text()` method to correctly get the response content
    let response = await result.response.text();
    console.log("API response:", response);
    // Remove ```json at the start and ``` at the end
    response = response.replace(/^```json\n|```$/g, "");
    console.log("Cleaned JSON response:", response);
    return response;
  } catch (error: any) {
    console.error("Error in getGeneratedContent:", error);
    throw new Error(
      `Failed to fetch code from Google Generative AI: ${error.message}`
    );
  }
}

function parseStructure(generatedCode: string): CodeStructure {
  try {
    // Try to parse the entire response as JSON
    const structure = JSON.parse(generatedCode);
    if (typeof structure === "object" && !Array.isArray(structure)) {
      return structure;
    }
    throw new Error("Invalid structure format from API.");
  } catch (e) {
    console.error("Error parsing structure:", e);

    // If parsing fails, try to extract JSON from the response
    const jsonMatch = generatedCode.match(/\{[\s\S]*\}/);
    if (jsonMatch) {
      try {
        const extractedJson = JSON.parse(jsonMatch[0]);
        if (
          typeof extractedJson === "object" &&
          !Array.isArray(extractedJson)
        ) {
          return extractedJson;
        }
      } catch (innerError) {
        console.error("Error parsing extracted JSON:", innerError);
      }
    }

    throw new Error("Failed to parse code structure from API response.");
  }
}
async function testApiConnection() {
  try {
    const result = await model.generateContent("Hello, World!");
    vscode.window.showInformationMessage(
      `API Test Successful: ${result.response.text()}`
    );
  } catch (error: any) {
    vscode.window.showErrorMessage(`API Test Failed: ${error.message}`);
  }
}

async function createFilesAndDirectories(
  rootPath: string,
  structure: CodeStructure
) {
  for (const filePath in structure) {
    const fullPath = path.join(rootPath, filePath);
    const dirPath = path.dirname(fullPath);
    const fileContent = structure[filePath];

    await fs.mkdir(dirPath, { recursive: true });
    await fs.writeFile(fullPath, fileContent);
  }
}

async function editActiveFile() {
  const editor = vscode.window.activeTextEditor;
  if (!editor) {
    vscode.window.showErrorMessage("No active editor found.");
    return;
  }

  const document = editor.document;
  const selection = editor.selection;
  const text = document.getText(selection);

  if (!text) {
    vscode.window.showErrorMessage("No text selected for editing.");
    return;
  }

  const prompt = await vscode.window.showInputBox({
    prompt: "Enter your prompt for code editing",
  });
  if (!prompt) return;

  try {
    // Fetch the edited content
    const editedCode = await getGeneratedContent(
      `Edit the following code according to the instructions:\n\nCode:\n${text}\n\nInstructions:\n${prompt}`
    );

    // Check if the edited code is defined
    if (!editedCode || typeof editedCode !== "string") {
      throw new Error("No valid edited code returned from the API.");
    }

    // Apply edits
    await editor.edit((editBuilder) => {
      editBuilder.replace(selection, editedCode);
    });

    // Update chat history
    chatHistory.push({ role: "user", content: prompt });
    chatHistory.push({ role: "ai", content: editedCode });

    vscode.window.showInformationMessage("Code edited successfully.");
  } catch (error: any) {
    vscode.window.showErrorMessage(`Failed to edit code: ${error.message}`);
    console.error("Error in editActiveFile:", error);
  }
}

async function viewChatHistory() {
  const chatContent = chatHistory
    .map((msg) => `${msg.role.toUpperCase()}: ${msg.content}`)
    .join("\n\n");
  const doc = await vscode.workspace.openTextDocument({
    content: chatContent,
    language: "markdown",
  });
  vscode.window.showTextDocument(doc);
}
async function explainCode() {
  const editor = vscode.window.activeTextEditor;
  if (!editor) {
    vscode.window.showErrorMessage("No active editor found.");
    return;
  }

  const selectedCode = editor.document.getText(editor.selection);
  if (!selectedCode) {
    vscode.window.showErrorMessage(
      "No code selected. Please select some code to explain."
    );
    return;
  }

  try {
    const explanation = await getGeneratedContent(
      `Explain the following code:\n\n${selectedCode}`
    );
    const explanationDoc = await vscode.workspace.openTextDocument({
      content: explanation,
      language: "markdown",
    });
    vscode.window.showTextDocument(explanationDoc, {
      viewColumn: vscode.ViewColumn.Beside,
    });
  } catch (error: any) {
    vscode.window.showErrorMessage(`Failed to explain code: ${error.message}`);
  }
}

async function optimizeCode() {
  const editor = vscode.window.activeTextEditor;
  if (!editor) {
    vscode.window.showErrorMessage("No active editor found.");
    return;
  }

  const selectedCode = editor.document.getText(editor.selection);
  if (!selectedCode) {
    vscode.window.showErrorMessage(
      "No code selected. Please select some code to optimize."
    );
    return;
  }

  try {
    const optimizedCode = await getGeneratedContent(
      `Optimize the following code:\n\n${selectedCode}`
    );
    editor.edit((editBuilder) => {
      editBuilder.replace(editor.selection, optimizedCode);
    });
  } catch (error: any) {
    vscode.window.showErrorMessage(`Failed to optimize code: ${error.message}`);
  }
}

async function generateTests() {
  const editor = vscode.window.activeTextEditor;
  if (!editor) {
    vscode.window.showErrorMessage("No active editor found.");
    return;
  }

  const selectedCode = editor.document.getText(editor.selection);
  if (!selectedCode) {
    vscode.window.showErrorMessage(
      "No code selected. Please select some code to generate tests for."
    );
    return;
  }

  try {
    const tests = await getGeneratedContent(
      `Generate unit tests for the following code:\n\n${selectedCode}`
    );
    const testsDoc = await vscode.workspace.openTextDocument({
      content: tests,
      language: editor.document.languageId,
    });
    vscode.window.showTextDocument(testsDoc, {
      viewColumn: vscode.ViewColumn.Beside,
    });
  } catch (error: any) {
    vscode.window.showErrorMessage(
      `Failed to generate tests: ${error.message}`
    );
  }
}

export function activate(context: vscode.ExtensionContext) {
  chatViewProvider = new ChatViewProvider(context.extensionUri);
  context.subscriptions.push(
    vscode.window.registerWebviewViewProvider(
      "aiCompanion.chatView",
      chatViewProvider
    ),
    vscode.commands.registerCommand(
      "aiCompanion.generateCode",
      generateCodeFromPrompt
    ),
    vscode.commands.registerCommand("aiCompanion.explainCode", explainCode),
    vscode.commands.registerCommand("aiCompanion.optimizeCode", optimizeCode),
    vscode.commands.registerCommand("aiCompanion.generateTests", generateTests),
    vscode.commands.registerCommand(
      "aiCompanion.editActiveFile",
      editActiveFile
    ),
    vscode.commands.registerCommand(
      "aiCompanion.viewChatHistory",
      viewChatHistory
    )
    // Add this to your activate function
  );
  context.subscriptions.push(
    vscode.commands.registerTextEditorCommand(
      "aiCompanion.quickEdit",
      editActiveFile
    )
  );
}

export function deactivate() {}
