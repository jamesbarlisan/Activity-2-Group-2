<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechAssist</title>
    <link rel="stylesheet" href="chatbot_styles.css">
</head>
<body>
    <nav class="main-tabs">
        <a href="index.php" class="tab-btn active">💬 Chatbot</a>
        <a href="viewer.html" class="tab-btn">📦 3D OBJ Viewer</a>
    </nav>
    <div class="chatbot-container">
        <div class="chatbot-header">
            <h1>💬 Customer Support Chatbot</h1>
            <p>Ask me anything about computer issues, hardware, software, or IT support!</p>
        </div>
        
        <div class="chatbot-messages" id="chatMessages">
            <div class="message bot-message">
                <div class="message-content">
                    <div class="message-avatar">🤖</div>
                    <div class="message-text">
                        Hello! I'm your customer support assistant. How can I help you today?
                    </div>
                </div>
                <div class="message-time">Just now</div>
            </div>
        </div>
        
        <div class="typing-indicator" id="typingIndicator" style="display: none;">
            <div class="message bot-message">
                <div class="message-content">
                    <div class="message-avatar">🤖</div>
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="chatbot-input-container">
            <form id="chatForm" class="chatbot-form">
                <input 
                    type="text" 
                    id="userInput" 
                    placeholder="Type your question here..." 
                    autocomplete="off"
                    required
                >
                <button type="submit" id="sendButton" class="send-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
        
        <div class="chatbot-footer">
            <small>Powered by PHP Chatbot System | <a href="admin_login.php" target="_blank">Admin Login</a></small>
        </div>
    </div>
    
    <script src="chatbot_script.js"></script>
</body>
</html>






