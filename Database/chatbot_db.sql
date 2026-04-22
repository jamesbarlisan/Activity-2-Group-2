-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2026 at 01:20 PM
-- Server version: 8.4.4
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbot_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$hPTaCx8NxLykMsnD1u9BCOcIBHPs56KeL84QLUcOwW5txPjESKRVW', '2026-01-28 01:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_qa`
--

CREATE TABLE `chatbot_qa` (
  `id` int NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `keywords` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chatbot_qa`
--

INSERT INTO `chatbot_qa` (`id`, `question`, `answer`, `keywords`, `created_at`, `updated_at`) VALUES
(1, 'How do I restart my computer?', 'To restart your computer, click on the Start menu, select the Power button, and choose Restart. Alternatively, you can press Ctrl+Alt+Del and select Restart from the options.', 'restart, reboot, computer, shutdown', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(2, 'My computer is running slow', 'If your computer is running slow, try these steps: 1) Close unnecessary programs, 2) Restart your computer, 3) Check for malware, 4) Free up disk space, 5) Update your software. If the problem persists, contact IT support.', 'slow, performance, lag, freeze, speed', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(3, 'How do I update my software?', 'To update your software: 1) Open Settings (Windows) or System Preferences (Mac), 2) Look for Update or Software Update, 3) Click Check for Updates, 4) Install any available updates. Make sure your computer is connected to the internet.', 'update, software, upgrade, patch, version', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(4, 'I forgot my password', 'If you forgot your password, you can reset it by: 1) Clicking \"Forgot Password\" on the login screen, 2) Following the password reset link sent to your email, 3) Creating a new password. If you need further assistance, contact your system administrator.', 'password, forgot, reset, login, access', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(5, 'How do I connect to WiFi?', 'To connect to WiFi: 1) Click the network icon in your system tray, 2) Select your WiFi network from the list, 3) Enter the password if required, 4) Click Connect. Make sure WiFi is enabled on your device.', 'wifi, wireless, network, internet, connection', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(6, 'My screen is black', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 'black screen, monitor, display, no signal, blank', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(7, 'How do I install software?', 'To install software: 1) Download the installation file from a trusted source, 2) Double-click the installer file, 3) Follow the installation wizard instructions, 4) Restart your computer if prompted. Always download from official websites.', 'install, software, program, application, setup', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(8, 'My keyboard is not working', 'If your keyboard is not working: 1) Check if it\'s properly connected (USB or wireless), 2) Try a different USB port, 3) Restart your computer, 4) Check if the keyboard works on another computer. If it\'s a wireless keyboard, check the batteries.', 'keyboard, not working, keys, input, typing', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(9, 'How do I backup my files?', 'To backup your files: 1) Use built-in backup tools (Windows Backup or Time Machine on Mac), 2) Copy files to an external hard drive or USB drive, 3) Use cloud storage services (OneDrive, Google Drive, Dropbox), 4) Set up automatic backups for regular protection.', 'backup, files, save, copy, protect, data', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(10, 'I have a virus', 'If you suspect a virus: 1) Disconnect from the internet immediately, 2) Run a full antivirus scan, 3) Quarantine or delete any threats found, 4) Update your antivirus software, 5) Change all passwords. If the problem is severe, contact IT support immediately.', 'virus, malware, infected, security, threat, antivirus', '2026-01-28 01:25:45', '2026-01-28 01:25:45'),
(11, 'My computer is not turning on. What should I do?', 'Check if the power cable is properly connected. If you are using a laptop, make sure the battery is charged. Try plugging the device into a different power outlet. If it still does not turn on, the power supply or battery may be faulty.', 'not turning on', '2026-01-28 01:32:17', '2026-01-28 01:32:17'),
(12, 'My laptop overheats quickly. What should I do?', 'Make sure the air vents are not blocked. Clean dust from the fan area and avoid using the laptop on soft surfaces like beds. Using a cooling pad can also help.', 'overheat', '2026-01-28 01:33:08', '2026-01-28 01:33:08'),
(13, 'My Wi-Fi is connected but there is no internet. How do I fix this?', 'Restart your modem and router. If the problem continues, check if other devices can access the internet. If none can connect, contact your internet service provider.', 'no internet, Wi-Fi', '2026-01-28 01:33:50', '2026-01-28 01:33:50'),
(14, 'The internet connection is very slow. What can I do?', 'Try restarting your router and closing apps that use a lot of bandwidth. Move closer to the router and disconnect unused devices from the network.', 'internet connection slow', '2026-01-28 01:35:02', '2026-01-28 01:35:02'),
(15, 'My computer cannot detect any Wi-Fi networks. Why?', 'Make sure Wi-Fi is turned on in your device settings. Check if airplane mode is enabled and update or reinstall your network driver if necessary.', 'Wi-Fi not detected', '2026-01-28 01:35:33', '2026-01-28 01:35:33'),
(16, 'The Wi-Fi keeps disconnecting. What is the cause?', 'This may be caused by weak signal strength, outdated drivers, or router issues. Try placing the router closer and updating your network drivers.', 'Wi-Fi disconnecting', '2026-01-28 01:36:02', '2026-01-28 01:36:02'),
(17, 'What should I do if my computer is infected with malware?', 'Disconnect from the internet, run a full antivirus scan, and remove detected threats. Restart the computer after cleaning.', '', '2026-01-28 01:36:35', '2026-01-28 01:36:35'),
(18, 'Is Windows Defender enough to protect my computer?', 'Windows Defender provides basic protection, but using additional trusted antivirus software can offer better security.', 'Windows Defender', '2026-01-28 01:36:54', '2026-01-28 01:36:54'),
(19, 'How can I prevent viruses in the future?', 'Avoid downloading files from unknown sources, do not click suspicious links, keep your system updated, and use antivirus software.', 'prevent viruses', '2026-01-28 01:37:16', '2026-01-28 01:37:16'),
(20, 'My printer is not printing. What should I check?', 'Make sure the printer is powered on, connected to the computer, and has paper and ink. Also check if it is set as the default printer.', 'printer, not printing', '2026-01-28 01:37:37', '2026-01-28 01:37:37'),
(21, 'The printer is showing “Paper Jam” but there is none. What should I do?', 'Turn off the printer, open the paper tray, and carefully check for small torn pieces of paper. Restart the printer afterward.', 'paper jam', '2026-01-28 01:37:56', '2026-01-28 01:37:56'),
(22, 'Why is my printer printing blank pages?', 'The ink or toner may be empty or clogged. Try cleaning the print head or replacing the ink cartridge.', 'printing black pages', '2026-01-28 01:38:19', '2026-01-28 01:38:19'),
(23, 'A program is not responding. What should I do?', 'Wait a few seconds, then close the program using Task Manager. Restart the computer if the problem continues.', 'program, not responding', '2026-01-28 01:38:40', '2026-01-28 01:38:40'),
(24, 'I installed new software and now my computer has errors. Why?', 'The software may be incompatible with your system. Try uninstalling it or updating your operating system.', 'installed new software', '2026-01-28 01:39:08', '2026-01-28 01:39:08'),
(25, 'My USB device is not recognized. What can I do?', 'Try plugging the USB device into a different port. Restart your computer and check if the drivers are installed correctly.', 'USB not recognized', '2026-01-28 01:39:23', '2026-01-28 01:39:23'),
(26, 'Hello', 'Hey! 👋 How can I help you today?', 'Hello', '2026-01-28 01:40:15', '2026-01-28 01:41:15'),
(27, 'How are you?', 'I’m doing great—thanks for asking! 😊 What’s up?', '', '2026-01-28 01:41:48', '2026-01-28 01:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

CREATE TABLE `chat_logs` (
  `id` int NOT NULL,
  `user_message` text NOT NULL,
  `bot_response` text NOT NULL,
  `matched_question_id` int DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`id`, `user_message`, `bot_response`, `matched_question_id`, `timestamp`) VALUES
(1, 'How do I restart my computer?', 'To restart your computer, click on the Start menu, select the Power button, and choose Restart. Alternatively, you can press Ctrl+Alt+Del and select Restart from the options.', 1, '2026-01-28 01:26:22'),
(2, 'Forgot password', 'If you forgot your password, you can reset it by: 1) Clicking \"Forgot Password\" on the login screen, 2) Following the password reset link sent to your email, 3) Creating a new password. If you need further assistance, contact your system administrator.', 4, '2026-01-28 01:26:38'),
(3, 'screen black', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-01-28 01:28:28'),
(4, 'Black screen', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-01-28 01:29:21'),
(5, 'Black screen', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-01-28 01:29:31'),
(6, 'I have a virus', 'If you suspect a virus: 1) Disconnect from the internet immediately, 2) Run a full antivirus scan, 3) Quarantine or delete any threats found, 4) Update your antivirus software, 5) Change all passwords. If the problem is severe, contact IT support immediately.', 10, '2026-01-28 01:29:58'),
(7, 'Phone not working', 'If your keyboard is not working: 1) Check if it\'s properly connected (USB or wireless), 2) Try a different USB port, 3) Restart your computer, 4) Check if the keyboard works on another computer. If it\'s a wireless keyboard, check the batteries.', 8, '2026-01-28 01:30:14'),
(8, 'Phone', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-01-28 01:30:30'),
(9, 'Turning on', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-01-28 01:31:51'),
(10, 'not turning on', 'Check if the power cable is properly connected. If you are using a laptop, make sure the battery is charged. Try plugging the device into a different power outlet. If it still does not turn on, the power supply or battery may be faulty.', 11, '2026-01-28 01:32:23'),
(11, 'Hello', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-01-28 01:39:41'),
(12, 'Hello', 'Hey! 👋\\r\\nHow can I help you today?', 26, '2026-01-28 01:40:19'),
(13, 'Hello', 'Hey! 👋 How can I help you today?', 26, '2026-01-28 01:41:21'),
(14, 'Hello', 'Hey! 👋 How can I help you today?', 26, '2026-01-28 01:45:13'),
(15, 'Windows Defender', 'Windows Defender provides basic protection, but using additional trusted antivirus software can offer better security.', 18, '2026-01-28 01:45:25'),
(16, 'My computer cannot detect any Wi-Fi networks. Why?', 'Make sure Wi-Fi is turned on in your device settings. Check if airplane mode is enabled and update or reinstall your network driver if necessary.', 15, '2026-01-28 01:46:13'),
(17, 'Paper jam', 'Turn off the printer, open the paper tray, and carefully check for small torn pieces of paper. Restart the printer afterward.', 21, '2026-01-28 02:06:17'),
(18, 'Israel', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-01-28 02:06:31'),
(19, 'Keyboard not working', 'If your keyboard is not working: 1) Check if it\'s properly connected (USB or wireless), 2) Try a different USB port, 3) Restart your computer, 4) Check if the keyboard works on another computer. If it\'s a wireless keyboard, check the batteries.', 8, '2026-01-28 02:06:51'),
(20, 'black', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-01-28 02:09:37'),
(21, 'A program is not responding', 'Wait a few seconds, then close the program using Task Manager. Restart the computer if the problem continues.', 23, '2026-01-28 02:29:08'),
(22, 'Chatgpt', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 00:49:03'),
(23, 'Give me AI customer support services', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 00:49:42'),
(24, 'What is the best antivirus software?', 'To update your software: 1) Open Settings (Windows) or System Preferences (Mac), 2) Look for Update or Software Update, 3) Click Check for Updates, 4) Install any available updates. Make sure your computer is connected to the internet.', 3, '2026-02-04 00:51:29'),
(25, 'AI Customer Support Chatbot', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 00:51:45'),
(26, 'ChatGPT', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 00:55:26'),
(27, 'Chatgpt', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 01:02:43'),
(28, 'ChatGPT', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 01:07:18'),
(29, 'Chatgpt', 'You mentioned \'Chatgpt.\' While I specialize in computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support, I\'m not equipped for general discussions.\n\nIf you have a specific technical problem or need IT assistance, please describe it, and I\'ll be happy to help!', NULL, '2026-02-04 01:10:20'),
(30, 'How do I upgrade my RAM?', 'To update your software: 1) Open Settings (Windows) or System Preferences (Mac), 2) Look for Update or Software Update, 3) Click Check for Updates, 4) Install any available updates. Make sure your computer is connected to the internet.', 3, '2026-02-04 01:10:44'),
(31, 'AI Customer Support Chatbot lists', 'That\'s an interesting topic! While I am an AI-powered customer support assistant, I don\'t maintain a list of other AI customer support chatbots myself.\n\nHowever, I can tell you that AI chatbots are widely used across various industries for customer support. Here are some of the popular categories and providers you might find on such a list:\n\n*   **Dedicated AI Chatbot Platforms:** Companies like Intercom, Zendesk, Ada, Drift, and LiveChat often integrate or offer their own AI-driven chatbot solutions.\n*   **Cloud Providers with AI Services:** Amazon (Lex), Google (Dialogflow), and Microsoft (Azure Bot Service) provide powerful AI tools that businesses use to build their own custom customer support chatbots.\n*   **Specialized AI Solutions:** Many niche companies focus solely on developing advanced AI for specific customer service functions, such as automating FAQs, qualifying leads, or handling routine requests.\n\nIf you\'re looking for something specific, like providers for a certain industry or a comparison of features, feel free to ask, and I\'ll do my best to provide general information related to their capabilities!', NULL, '2026-02-04 01:11:09'),
(32, 'How much is iPhone 17 pro max?', 'To install software: 1) Download the installation file from a trusted source, 2) Double-click the installer file, 3) Follow the installation wizard instructions, 4) Restart your computer if prompted. Always download from official websites.', 7, '2026-02-04 01:12:40'),
(33, 'iphone 17', 'The iPhone 17 has not been announced or released by Apple yet. Apple typically releases new iPhone models in the fall (September-October) each year, and the current model is the iPhone 15 series.\n\nIf you have questions about current iPhone models, general iOS features, or are experiencing an issue with your existing iPhone, please let me know and I\'ll be happy to help!', NULL, '2026-02-04 01:13:43'),
(34, 'What is Python?', 'Python is a popular, high-level, general-purpose programming language. It\'s widely used for a variety of tasks due to its simplicity, readability, and extensive libraries.\n\nHere are some key characteristics and common applications:\n\n*   **Readability:** Python\'s syntax is designed to be clear and concise, making it relatively easy to learn and understand.\n*   **Versatility:** It\'s used for a broad range of applications, from simple scripting to complex web applications and data analysis.\n*   **Extensive Libraries:** Python boasts a vast ecosystem of pre-built modules and frameworks (like Django for web development, NumPy and Pandas for data science, or TensorFlow for machine learning) that greatly enhance its capabilities.\n*   **Cross-platform:** Python code can run on various operating systems (Windows, macOS, Linux) with minimal modifications.\n\nCommon uses for Python include:\n\n*   **Web Development:** Building web applications (backend development).\n*   **Data Science and Machine Learning:** Analyzing data, creating predictive models, and developing AI solutions.\n*   **Automation and Scripting:** Automating repetitive tasks and system administration.\n*   **Scientific Computing:** Research and computational tasks.\n*   **Desktop Applications:** Developing graphical user interface (GUI) applications.', NULL, '2026-02-04 01:17:05'),
(35, 'Java', '\"Java is a widely-used programming language and computing platform. Are you looking for information about:\n\n*   **What Java is or what it\'s used for?**\n*   **How to install or update Java?**\n*   **Troubleshooting a specific Java-related issue?**\n*   **Developing with Java?**\n\nPlease tell me more about what you\'d like to know or what problem you\'re experiencing, and I\'ll do my best to help!\"', NULL, '2026-02-04 01:17:32'),
(36, 'iPhone 17', 'The iPhone 17 has not been announced or released by Apple yet. The latest models are currently the iPhone 15 series.\n\nIf you have questions about current iPhone models, general iPhone features, troubleshooting an existing iPhone, or anything else I can help with regarding Apple products, please let me know!', NULL, '2026-02-04 01:19:39'),
(37, 'How much is iPhone 17 pro max', 'The iPhone 17 Pro Max has not been announced or released yet, so there is no official pricing information available.\n\nApple typically introduces new iPhone models in the fall (September/October). Pricing for future models is usually revealed closer to their official launch.\n\nIs there anything else I can help you with regarding current iPhone models or other computer-related inquiries?', NULL, '2026-02-04 01:19:55'),
(38, 'How much is Acer laptop?', 'Acer laptops come in a wide range of models, each with different specifications, features, and price points. For example, a basic Acer Chromebook might start around $200-$300, while a high-end Acer Predator gaming laptop could cost upwards of $1500-$3000+.\n\nTo give you a more accurate idea, could you please tell me:\n\n1.  **What kind of Acer laptop are you interested in?** (e.g., for gaming, schoolwork, business, everyday use)\n2.  **What\'s your approximate budget?**\n3.  **Are there any specific features you\'re looking for?** (e.g., screen size, processor type, amount of RAM/storage)\n\nWith more details, I can help you find pricing for a specific model!', NULL, '2026-02-04 01:20:13'),
(39, 'What is Naruto?', 'That\'s an interesting question! However, my expertise is in computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support.\n\nIf you have any computer or tech questions, I\'d be happy to help!', NULL, '2026-02-04 01:20:47'),
(40, 'Encantadia', 'It seems like \"Encantadia\" refers to a fantasy TV series, which isn\'t directly related to computer hardware, software, or IT support.\n\nAs a helpful customer support assistant specializing in computer-related issues, I\'m here to assist with:\n*   Hardware problems\n*   Software troubleshooting\n*   System errors\n*   General IT support\n\nIf you have a computer-related question, please feel free to ask!', NULL, '2026-02-04 01:21:26'),
(41, 'System unit', 'The \"system unit\" (also commonly known as the computer case, chassis, or tower) is the enclosure that contains most of the core components of a computer, such as the motherboard, CPU, RAM, and storage drives.\n\nIt\'s a very general term, and to help you best, I need a little more information. Could you please tell me what specifically you\'d like to know or what issue you\'re experiencing related to your system unit?\n\nFor example, are you:\n*   Troubleshooting a problem with your computer\'s hardware?\n*   Looking to identify a specific part inside the system unit?\n*   Asking about upgrading components within it?\n*   Looking for advice on maintaining it (like cleaning)?', NULL, '2026-02-04 01:26:18'),
(42, 'What is Love?', 'I\'m an AI assistant specializing in computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support. While that\'s a profound question, it\'s outside my area of expertise.\n\nIf you have any questions about computers, software, or technology, I\'d be happy to help!', NULL, '2026-02-04 01:58:57'),
(43, 'Connecting laptop to TV', 'Hello! I can definitely help you with connecting your laptop to your TV. It\'s a common request and usually quite straightforward.\n\nHere are the general steps:\n\n1.  **Check Available Ports:**\n    *   **On your laptop:** Look for ports like HDMI, USB-C (which might support display output), or occasionally DisplayPort, VGA, or DVI. HDMI is the most common.\n    *   **On your TV:** Look for HDMI ports (usually labeled HDMI 1, HDMI 2, etc.). Modern TVs primarily use HDMI.\n\n2.  **Get the Right Cable:**\n    *   **HDMI Cable:** If both your laptop and TV have HDMI ports, an HDMI cable is your best bet for both video and audio.\n    *   **Adapters:** If your laptop has, for example, a USB-C port, a DisplayPort, or a Mini DisplayPort, you\'ll need an adapter (e.g., USB-C to HDMI adapter, DisplayPort to HDMI cable).\n    *   **VGA/DVI:** If you\'re using older equipment, you might need a VGA or DVI cable, but these usually require a separate audio cable.\n\n3.  **Connect the Cable:**\n    *   Plug one end of the cable into your laptop and the other end into an available port on your TV. Note which HDMI input number you\'re using on the TV (e.g., HDMI 1).\n\n4.  **Select Input on TV:**\n    *   Using your TV\'s remote control, press the \"Input,\" \"Source,\" or \"TV/Video\" button.\n    *   Navigate through the options and select the HDMI input corresponding to where you plugged in your laptop (e.g., HDMI 1, HDMI 2).\n\n5.  **Configure Laptop Display Settings:**\n    *   **Windows:** Press the **Windows key + P** simultaneously. A sidebar will appear with display options:\n        *   **PC screen only:** Uses only the laptop screen.\n        *   **Duplicate:** Shows the same content on both screens.\n        *   **Extend:** Expands your desktop across both screens, giving you more workspace.\n        *   **Second screen only:** Shows content only on the TV screen.\n    *   **macOS:** Go to **System Settings/Preferences > Displays**. You can then arrange screens, choose mirroring, or extend your desktop.\n    *   **Troubleshooting Tip:** If you don\'t see anything, try changing the resolution on your laptop to a common TV resolution like 1920x1080 (1080p).\n\n**For Audio:**\n*   If you\'re using an HDMI cable, audio should automatically transmit through the TV.\n*   If you\'re using VGA or DVI, you\'ll likely need a separate 3.5mm audio cable from your laptop\'s headphone jack to the TV\'s audio input.\n*   Sometimes you might need to manually set the audio output on your laptop:\n    *   **Windows:** Right-click the speaker icon in the taskbar > **Sound Settings** > Choose your TV (or \"HDMI Output\") as the output device.\n    *   **macOS:** Go to **System Settings/Preferences > Sound > Output** > Select your TV (or \"HDMI\").\n\nIf you run into any specific issues or have a particular port setup, feel free to provide more details about your laptop and TV models, and I can give more tailored advice!', NULL, '2026-02-04 01:59:39'),
(44, 'Super saiyan', 'That\'s an interesting term! However, I specialize in computer-related issues like hardware problems, software troubleshooting, and system errors.\n\nIf you have a question about your computer, feel free to ask, and I\'ll do my best to help!', NULL, '2026-02-04 02:09:03'),
(45, 'Who is super saiyan', 'That\'s an interesting question! However, I specialize in computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support. If you have any tech questions, feel free to ask!', NULL, '2026-02-04 02:09:17'),
(46, 'API', 'An API, or **Application Programming Interface**, is a set of rules and protocols that allows different software applications to communicate and interact with each other.\n\nThink of it like a menu in a restaurant:\n\n*   You (the client application) tell the waiter (the API) what you want to order (a specific function or data).\n*   The waiter takes your order to the kitchen (the server or another application).\n*   The kitchen prepares the food (processes your request).\n*   The waiter brings you back your food (the data or the result of the function).\n\n**In the context of IT support, APIs are crucial because they:**\n\n*   **Enable integration:** Allow different software systems (e.g., a CRM and an email marketing tool, or a payment gateway and an e-commerce site) to share data and functionality.\n*   **Facilitate cloud services:** Many cloud-based applications expose APIs for developers to build custom integrations or access their services.\n*   **Support mobile apps:** Mobile apps frequently use APIs to communicate with backend servers to retrieve and send data.\n*   **Are fundamental to modern web development:** How most websites and web services interact with each other.\n\nIf you have a specific question or a problem related to an API you\'re working with, feel free to elaborate, and I\'ll do my best to assist you!', NULL, '2026-02-04 02:45:14'),
(47, 'Mobile', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:45:39'),
(48, 'What is mobile', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:45:51'),
(49, 'What is Gemini?', 'That\'s an interesting question! While I can help with computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support, information about \"Gemini\" falls outside my area of expertise.\n\nIf you have any IT-related questions or need assistance with your computer, please let me know, and I\'ll be happy to help!', NULL, '2026-02-04 02:46:11'),
(50, 'where can we shop?', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:47:16'),
(51, 'iphone', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:47:54'),
(52, 'What is iphone', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:48:11'),
(53, 'What is Java', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:48:42'),
(54, 'Python', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:49:43'),
(55, 'What is Python?', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:50:02'),
(56, 'Python', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:51:29'),
(57, 'Python', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:53:38'),
(58, 'USB not recognized', 'If your keyboard is not working: 1) Check if it\'s properly connected (USB or wireless), 2) Try a different USB port, 3) Restart your computer, 4) Check if the keyboard works on another computer. If it\'s a wireless keyboard, check the batteries.', 8, '2026-02-04 02:53:54'),
(59, 'Python', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-04 02:57:01'),
(60, 'Python', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-05 03:00:58'),
(61, 'USB not recognized', 'If your keyboard is not working: 1) Check if it\'s properly connected (USB or wireless), 2) Try a different USB port, 3) Restart your computer, 4) Check if the keyboard works on another computer. If it\'s a wireless keyboard, check the batteries.', 8, '2026-02-05 03:04:47'),
(62, 'printing black pages', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-02-05 03:05:17'),
(63, 'USB', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-05 03:06:34'),
(64, 'black printing', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-05 03:11:57'),
(65, 'black', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-05 03:12:58'),
(66, 'black screen', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-02-05 03:16:36'),
(67, 'black printing', 'Sorry, I don\'t have an answer for that yet. Please contact support or try rephrasing your question.', NULL, '2026-02-05 03:18:43'),
(68, 'printing black pages', 'If your screen is black: 1) Check if the monitor is powered on, 2) Verify all cables are connected properly, 3) Try pressing any key or moving the mouse to wake the computer, 4) Restart your computer. If the issue persists, it may be a hardware problem.', 6, '2026-02-05 03:20:17'),
(69, 'install', 'To install software: 1) Download the installation file from a trusted source, 2) Double-click the installer file, 3) Follow the installation wizard instructions, 4) Restart your computer if prompted. Always download from official websites.', 7, '2026-02-05 03:25:06'),
(70, 'python', 'Python is a powerful and versatile programming language widely used in various IT fields, including web development, data analysis, artificial intelligence, automation, and system administration.\n\nTo help you best, could you please tell me what you\'d like to know or what issue you\'re experiencing with Python? For example, are you looking for:\n\n*   Information on how to install Python?\n*   Help troubleshooting a Python script or error?\n*   Guidance on using Python for a specific task?\n*   Understanding what Python is or its capabilities?\n\nPlease provide more details so I can assist you effectively!', NULL, '2026-02-11 02:30:36'),
(71, 'Kamusta?', 'Hello there! I\'m here to help with any computer-related issues, hardware problems, software troubleshooting, system errors, or general IT support you might have.\n\nHow can I assist you today with your tech needs?', NULL, '2026-03-10 12:05:21'),
(72, 'Python', 'Python is a powerful and versatile programming language! To help me understand how I can assist you, could you please tell me what you\'re trying to do or what specific issue you\'re encountering with it?\n\nFor example, are you:\n*   Trying to install Python or set up a development environment?\n*   Troubleshooting a Python script, an error message, or a specific program written in Python?\n*   Having issues with Python dependencies, virtual environments, or package management (like pip)?\n*   Looking for resources or guidance on using Python for a specific computer task (e.g., scripting, data processing, web development)?\n\nPlease provide more details so I can give you the most helpful support!', NULL, '2026-03-10 12:05:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `chatbot_qa`
--
ALTER TABLE `chatbot_qa`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `chatbot_qa` ADD FULLTEXT KEY `question` (`question`);
ALTER TABLE `chatbot_qa` ADD FULLTEXT KEY `keywords` (`keywords`);

--
-- Indexes for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matched_question_id` (`matched_question_id`),
  ADD KEY `timestamp` (`timestamp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbot_qa`
--
ALTER TABLE `chatbot_qa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `chat_logs`
--
ALTER TABLE `chat_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD CONSTRAINT `chat_logs_ibfk_1` FOREIGN KEY (`matched_question_id`) REFERENCES `chatbot_qa` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
