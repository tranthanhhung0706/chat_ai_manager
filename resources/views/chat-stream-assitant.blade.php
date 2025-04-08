<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-lg border rounded-lg shadow-lg bg-white flex flex-col">
        <div class="p-4 border-b bg-blue-600 text-white font-semibold text-lg">AI Assistant Stream</div>

        <div id="chat-box" class="p-4 space-y-3 h-96 overflow-y-auto"></div>

        <div class="border-t p-4 flex">
            <input id="message" type="text" class="flex-1 p-2 border rounded-lg" placeholder="Ask me anything...">
            <button id="sendBtn" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Send</button>
        </div>
    </div>
    <script>
        document.getElementById("sendBtn").addEventListener("click", function () {
            let message = document.getElementById("message").value.trim();
            if (!message) return;
    
            let chatBox = document.getElementById("chat-box");
    
            // Hiển thị tin nhắn của người dùng
            chatBox.innerHTML += `<div class="flex justify-end"><div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-xs">${message}</div></div>`;
    
            document.getElementById("message").value = "";
    
            // Tạo hiệu ứng "typing..."
            let typingIndicator = document.createElement("div");
            typingIndicator.className = "flex justify-start";
            typingIndicator.innerHTML = `<div class="bg-gray-300 text-gray-900 px-4 py-2 rounded-lg max-w-xs">Typing...</div>`;
            chatBox.appendChild(typingIndicator);
    
            let eventSource = new EventSource(`http://127.0.0.1:8000/streamassitant-chat?message=${encodeURIComponent(message)}`);
    
            let responseElement = document.createElement("div");
            responseElement.className = "flex justify-start";
            responseElement.innerHTML = `<div class="bg-gray-300 text-gray-900 px-4 py-2 rounded-lg max-w-xs"></div>`;
            chatBox.appendChild(responseElement);
    
            eventSource.onmessage = function (event) {
                typingIndicator.remove(); 
                
                let text = event.data.replace(/^"|"$/g, ""); 
                responseElement.querySelector("div").innerHTML += text;
                chatBox.scrollTop = chatBox.scrollHeight;
            };
    
            eventSource.onerror = function () {
                eventSource.close();
            };
        });
    </script>
    
</body>
</html>