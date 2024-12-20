interface VSCode {
  postMessage(message: any): void;
}

interface Message {
  type: string;
  value: {
    role: "user" | "ai";
    content: string;
  };
}

declare function acquireVsCodeApi(): VSCode;

(function () {
  const vscode = acquireVsCodeApi();
  const chatContainer = document.getElementById(
    "chat-container"
  ) as HTMLDivElement;
  const userInput = document.getElementById("user-input") as HTMLInputElement;
  const sendButton = document.getElementById(
    "send-button"
  ) as HTMLButtonElement;

  function addMessage(message: { role: "user" | "ai"; content: string }) {
    const messageElement = document.createElement("div");
    messageElement.className = `message ${message.role}`;
    messageElement.textContent = message.content;
    chatContainer.appendChild(messageElement);
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }

  sendButton.addEventListener("click", () => {
    const message = userInput.value.trim();
    if (message) {
      vscode.postMessage({ type: "sendMessage", value: message });
      userInput.value = "";
    }
  });

  userInput.addEventListener("keypress", (e: KeyboardEvent) => {
    if (e.key === "Enter") {
      sendButton.click();
    }
  });

  window.addEventListener("message", (event: MessageEvent<Message>) => {
    const message = event.data;
    switch (message.type) {
      case "addMessage":
        addMessage(message.value);
        break;
    }
  });
})();
