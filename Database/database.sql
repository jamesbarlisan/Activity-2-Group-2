-- Customer Support Chatbot Database Schema
-- Run this SQL file in phpMyAdmin or MySQL command line

-- Create database (uncomment if needed)
-- CREATE DATABASE IF NOT EXISTS chatbot_db;
-- USE chatbot_db;

-- Table: admins
-- Stores admin login credentials
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin (username: admin, password: admin123)
-- Password is hashed using password_hash() - default password is 'admin123'
INSERT INTO `admins` (`username`, `password`) VALUES
('admin', '$2y$10$hPTaCx8NxLykMsnD1u9BCOcIBHPs56KeL84QLUcOwW5txPjESKRVW');

-- Table: chatbot_qa
-- Stores questions, answers, and keywords for the chatbot
CREATE TABLE IF NOT EXISTS `chatbot_qa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `keywords` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `question` (`question`),
  FULLTEXT KEY `keywords` (`keywords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample Q&A pairs for testing
INSERT INTO `chatbot_qa` (`question`, `answer`, `keywords`) VALUES
('How do I restart my computer?', 'To restart your computer, click on the Start menu, select the Power button, and choose Restart. Alternatively, you can press Ctrl+Alt+Del and select Restart from the options.', 'restart, reboot, computer, shutdown'),
('My computer is running slow', 'If your computer is running slow, try these steps: 1) Close unnecessary programs, 2) Restart your computer, 3) Check for malware, 4) Free up disk space, 5) Update your software. If the problem persists, contact IT support.', 'slow, performance, lag, freeze, speed'),
('How do I update my software?', 'To update your software: 1) Open Settings (Windows) or System Preferences (Mac), 2) Look for Update or Software Update, 3) Click Check for Updates, 4) Install any available updates. Make sure your computer is connected to the internet.', 'update, software, upgrade, patch, version'),
('I forgot my password', 'If you forgot your password, you can reset it by: 1) Clicking "Forgot Password" on the login screen, 2) Following the password reset link sent to your email, 3) Creating a new password. If you need further assistance, contact your system administrator.', 'password, forgot, reset, login, access'),
('How do I connect to WiFi?', 'To connect to WiFi: 1) Click the network icon in your system tray, 2) Select your WiFi network from the list, 3) Enter the password if required, 4) Click Connect. Make sure WiFi is enabled on your device.', 'wifi, wireless, network, internet, connection'),
('My screen is black', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 'black screen, monitor, display, no signal, blank'),
('How do I install software?', 'To install software: 1) Download the installation file from a trusted source, 2) Double-click the installer file, 3) Follow the installation wizard instructions, 4) Restart your computer if prompted. Always download from official websites.', 'install, software, program, application, setup'),
('My keyboard is not working', 'If your keyboard is not working: 1) Check if it\'s properly connected (USB or wireless), 2) Try a different USB port, 3) Restart your computer, 4) Check if the keyboard works on another computer. If it\'s a wireless keyboard, check the batteries.', 'keyboard, not working, keys, input, typing'),
('How do I backup my files?', 'To backup your files: 1) Use built-in backup tools (Windows Backup or Time Machine on Mac), 2) Copy files to an external hard drive or USB drive, 3) Use cloud storage services (OneDrive, Google Drive, Dropbox), 4) Set up automatic backups for regular protection.', 'backup, files, save, copy, protect, data'),
('I have a virus', 'If you suspect a virus: 1) Disconnect from the internet immediately, 2) Run a full antivirus scan, 3) Quarantine or delete any threats found, 4) Update your antivirus software, 5) Change all passwords. If the problem is severe, contact IT support immediately.', 'virus, malware, infected, security, threat, antivirus');

-- Table: chat_logs
-- Stores all chat conversations for analytics
CREATE TABLE IF NOT EXISTS `chat_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_message` text NOT NULL,
  `bot_response` text NOT NULL,
  `matched_question_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `matched_question_id` (`matched_question_id`),
  KEY `timestamp` (`timestamp`),
  CONSTRAINT `chat_logs_ibfk_1` FOREIGN KEY (`matched_question_id`) REFERENCES `chatbot_qa` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

