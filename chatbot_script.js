/**
 * Chatbot UI Styles
 * Modern and responsive design
 */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #070707 0%, #070707 100%);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

/* Main tab navigation */
.main-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
    width: 100%;
    max-width: 800px;
}

.main-tabs .tab-btn {
    flex: 1;
    padding: 12px 20px;
    text-align: center;
    text-decoration: none;
    color: #666;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s;
}

.main-tabs .tab-btn:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    border-color: rgba(255, 255, 255, 0.3);
}

.main-tabs .tab-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

.chatbot-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 800px;
    height: 90vh;
    max-height: 700px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chatbot-header {
    background: linear-gradient(135deg, #25252b 0%, #212022 100%);
    color: white;
    padding: 20px 30px;
    text-align: center;
}

.chatbot-header h1 {
    font-size: 24px;
    margin-bottom: 5px;
}

.chatbot-header p {
    font-size: 14px;
    opacity: 0.9;
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px 30px;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Custom Scrollbar */
.chatbot-messages::-webkit-scrollbar {
    width: 6px;
}

.chatbot-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.chatbot-messages::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.chatbot-messages::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.message {
    display: flex;
    flex-direction: column;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message-content {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    max-width: 80%;
}

.user-message .message-content {
    margin-left: auto;
    flex-direction: row-reverse;
}

.message-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.bot-message .message-avatar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.user-message .message-avatar {
    background: #6c757d;
    color: white;
    font-size: 16px;
    font-weight: bold;
}

.message-text {
    padding: 12px 16px;
    border-radius: 18px;
    word-wrap: break-word;
    line-height: 1.5;
}

.bot-message .message-text {
    background: white;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-message .message-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.message-time {
    font-size: 11px;
    color: #999;
    margin-top: 5px;
    padding: 0 50px;
}

.user-message .message-time {
    text-align: right;
}

/* Typing Indicator */
.typing-indicator {
    padding: 0 30px 10px;
}

.typing-dots {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: white;
    border-radius: 18px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.typing-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #667eea;
    animation: typing 1.4s infinite;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.7;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

.chatbot-input-container {
    padding: 20px 30px;
    background: white;
    border-top: 1px solid #e0e0e0;
}

.chatbot-form {
    display: flex;
    gap: 10px;
    align-items: center;
}

#userInput {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
}

#userInput:focus {
    border-color: #667eea;
}

.send-button {
    width: 45px;
    height: 45px;
    border: none;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s, box-shadow 0.2s;
    flex-shrink: 0;
}

.send-button:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.send-button:active {
    transform: scale(0.95);
}

.send-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.chatbot-footer {
    padding: 10px 30px;
    background: #f8f9fa;
    text-align: center;
    border-top: 1px solid #e0e0e0;
}

.chatbot-footer small {
    color: #666;
    font-size: 12px;
}

.chatbot-footer a {
    color: #667eea;
    text-decoration: none;
}

.chatbot-footer a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chatbot-container {
        height: 100vh;
        max-height: 100vh;
        border-radius: 0;
    }
    
    .message-content {
        max-width: 85%;
    }
    
    .chatbot-header h1 {
        font-size: 20px;
    }
    
    .chatbot-header p {
        font-size: 12px;
    }
}






