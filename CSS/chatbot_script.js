/**
 * Chatbot JavaScript
 * Handles user interactions and AJAX requests
 */

document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const userInput = document.getElementById('userInput');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');
    const sendButton = document.getElementById('sendButton');
    
    /**
     * Add message to chat
     * @param {string} text - Message text
     * @param {string} type - 'user' or 'bot'
     * @param {string} timestamp - Optional timestamp
     */
    function addMessage(text, type, timestamp = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        
        const time = timestamp || getCurrentTime();
        
        if (type === 'user') {
            messageDiv.innerHTML = `
                <div class="message-content">
                    <div class="message-avatar">👤</div>
                    <div class="message-text">${escapeHtml(text)}</div>
                </div>
                <div class="message-time">${time}</div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="message-content">
                    <div class="message-avatar">🤖</div>
                    <div class="message-text">${escapeHtml(text)}</div>
                </div>
                <div class="message-time">${time}</div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }
    
    /**
     * Show typing indicator
     */
    function showTypingIndicator() {
        typingIndicator.style.display = 'block';
        scrollToBottom();
    }
    
    /**
     * Hide typing indicator
     */
    function hideTypingIndicator() {
        typingIndicator.style.display = 'none';
    }
    
    /**
     * Scroll chat to bottom
     */
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    /**
     * Get current time formatted
     * @returns {string}
     */
    function getCurrentTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }
    
    /**
     * Escape HTML to prevent XSS
     * @param {string} text
     * @returns {string}
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    /**
     * Calculate typing delay based on response length
     * Simulates realistic typing speed
     * @param {string} text - Response text
     * @returns {number} - Delay in milliseconds
     */
    function calculateTypingDelay(text) {
        // Minimum delay: 1.5 seconds
        const minDelay = 1500;
        // Maximum delay: 5 seconds
        const maxDelay = 3000;
        // Average typing speed: ~200 characters per minute = ~3.3 chars per second
        // So ~300ms per character, but we'll use a more realistic approach
        const charsPerSecond = 3;
        const calculatedDelay = (text.length / charsPerSecond) * 1000;
        
        // Ensure delay is between min and max
        return Math.max(minDelay, Math.min(maxDelay, calculatedDelay));
    }
    
    /**
     * Wait for specified milliseconds
     * @param {number} ms - Milliseconds to wait
     * @returns {Promise}
     */
    function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    
    /**
     * Send message to chatbot API
     * @param {string} message
     */
    async function sendMessage(message) {
        // Disable input and button
        userInput.disabled = true;
        sendButton.disabled = true;
        
        // Show typing indicator immediately
        showTypingIndicator();
        
        try {
            // Create FormData
            const formData = new FormData();
            formData.append('message', message);
            
            // Send AJAX request
            const response = await fetch('chatbot_api.php', {
                method: 'POST',
                body: formData
            });
            
            // Parse response
            const data = await response.json();
            
            if (data.success) {
                // Calculate typing delay based on response length
                const typingDelay = calculateTypingDelay(data.response);
                
                // Wait for the typing delay (keep typing indicator visible)
                await delay(typingDelay);
                
                // Hide typing indicator
                hideTypingIndicator();
                
                // Add bot response after delay
                addMessage(data.response, 'bot', data.timestamp || null);
            } else {
                // Hide typing indicator
                hideTypingIndicator();
                
                // Show error message
                addMessage('Sorry, there was an error processing your request. Please try again.', 'bot');
            }
        } catch (error) {
            // Hide typing indicator
            hideTypingIndicator();
            
            // Show error message
            addMessage('Sorry, there was an error connecting to the server. Please check your connection and try again.', 'bot');
            console.error('Error:', error);
        } finally {
            // Re-enable input and button
            userInput.disabled = false;
            sendButton.disabled = false;
            userInput.focus();
        }
    }
    
    /**
     * Handle form submission
     */
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = userInput.value.trim();
        
        if (message === '') {
            return;
        }
        
        // Add user message to chat
        addMessage(message, 'user');
        
        // Clear input
        userInput.value = '';
        
        // Send message to API
        sendMessage(message);
    });
    
    // Focus input on load
    userInput.focus();
    
    // Allow Enter key to send (Shift+Enter for new line)
    userInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });
});

