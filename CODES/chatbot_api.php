<?php
/**
 * Chatbot API Endpoint
 * Handles user messages and returns bot responses
 */

header('Content-Type: application/json');
require_once 'db.php';
require_once 'config.php';

// Get user message from POST request
$userMessage = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($userMessage)) {
    echo json_encode([
        'success' => false,
        'response' => 'Please enter a message.',
        'matched' => false
    ]);
    exit;
}

// Sanitize user input
$userMessage = htmlspecialchars($userMessage, ENT_QUOTES, 'UTF-8');
$userMessageClean = $db->escape($userMessage);

// Initialize response
$response = '';
$matched = false;
$matchedQuestionId = null;

/**
 * Check if user message matches any keywords from database
 * @param mysqli $conn - Database connection
 * @param string $userMessage - User's question
 * @param Database $db - Database object
 * @return bool - True if keywords match, false otherwise
 */
function checkKeywordMatch($conn, $userMessage, $db) {
    $userMessageLower = strtolower($userMessage);
    $userMessageLowerClean = $db->escape($userMessageLower);
    
    // Get all keywords from database
    $query = "SELECT keywords FROM chatbot_qa WHERE keywords IS NOT NULL AND keywords != ''";
    $result = $conn->query($query);
    
    if ($result->num_rows === 0) {
        return false; // No keywords in database
    }
    
    // Extract all keywords from database
    $dbKeywords = [];
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['keywords'])) {
            $keywords = explode(',', strtolower($row['keywords']));
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                if (!empty($keyword) && strlen($keyword) > 2) {
                    $dbKeywords[] = $keyword;
                }
            }
        }
    }
    
    // Remove duplicates
    $dbKeywords = array_unique($dbKeywords);
    
    if (empty($dbKeywords)) {
        return false; // No valid keywords found
    }
    
    // Check if any database keyword appears in user message
    foreach ($dbKeywords as $dbKeyword) {
        if (strpos($userMessageLower, $dbKeyword) !== false) {
            return true; // Keyword found in user message
        }
    }
    
    return false; // No keyword match
}

/**
 * Find best matching answer from database
 * Uses keyword matching - if no keywords match, returns null to trigger Gemini
 */
function findAnswer($conn, $userMessage, $db) {
    $userMessageLower = strtolower($userMessage);
    $userMessageClean = $db->escape($userMessage);
    $userMessageLowerClean = $db->escape($userMessageLower);
    
    // Strategy 1: Exact match (case-insensitive) - Always check this first
    $query = "SELECT id, question, answer FROM chatbot_qa WHERE LOWER(question) = LOWER(?) LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userMessageClean);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return [
            'answer' => $row['answer'],
            'matched' => true,
            'id' => $row['id']
        ];
    }
    $stmt->close();
    
    // Strategy 2: Check if user message keywords match database keywords
    // If NO keywords match, return null to trigger Gemini
    if (!checkKeywordMatch($conn, $userMessage, $db)) {
        // No keyword match found - use Gemini
        return [
            'answer' => null,
            'matched' => false,
            'id' => null
        ];
    }
    
    // Keywords match found - search database for best answer
    // Split user message into keywords
    $keywords = explode(' ', $userMessageLower);
    $keywords = array_filter($keywords, function($word) {
        // Remove common stop words
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'is', 'are', 'was', 'were', 'be', 'been', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'can', 'this', 'that', 'these', 'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they', 'my', 'your', 'his', 'her', 'its', 'our', 'their', 'how', 'what', 'when', 'where', 'why', 'who'];
        return strlen($word) > 2 && !in_array($word, $stopWords);
    });
    
    if (!empty($keywords)) {
        $keywordConditions = [];
        $params = [];
        $types = '';
        
        foreach ($keywords as $keyword) {
            $keywordConditions[] = "(LOWER(question) LIKE ? OR LOWER(keywords) LIKE ?)";
            $keywordPattern = "%" . $db->escape($keyword) . "%";
            $params[] = $keywordPattern;
            $params[] = $keywordPattern;
            $types .= "ss";
        }
        
        $query = "SELECT id, question, answer, keywords FROM chatbot_qa WHERE " . 
                 implode(" OR ", $keywordConditions) . 
                 " ORDER BY (CASE WHEN LOWER(question) LIKE ? THEN 1 ELSE 2 END) LIMIT 5";
        
        $userMessagePattern = "%" . $userMessageLowerClean . "%";
        $params[] = $userMessagePattern;
        $types .= "s";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Get the best match (first result)
            $row = $result->fetch_assoc();
            $stmt->close();
            return [
                'answer' => $row['answer'],
                'matched' => true,
                'id' => $row['id']
            ];
        }
        $stmt->close();
    }
    
    // If keywords matched but no answer found, still use Gemini
    return [
        'answer' => null,
        'matched' => false,
        'id' => null
    ];
}

/**
 * Get response from Google Gemini API
 * @param string $userMessage - User's question
 * @param string $modelUrl - Optional: override API URL (for fallback models)
 * @return string|false - Gemini response or false on error
 */
function getGeminiResponse($userMessage, $modelUrl = null) {
    if (!GEMINI_ENABLED) {
        return false;
    }
    
    // Check if cURL is available
    if (!function_exists('curl_init')) {
        error_log("Gemini API Error: cURL extension is not available");
        return false;
    }
    
    // Prepare the prompt for Gemini
    $prompt = "You are a helpful customer support assistant specializing in computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support. Provide clear, concise, and helpful answers. If the question is not related to IT support, politely redirect the conversation.\n\nUser Question: " . $userMessage . "\n\nProvide a helpful response:";
    
    // Prepare request data according to Gemini API format
    $data = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => $prompt
                    ]
                ]
            ]
        ]
    ];
    
    // Use provided model URL or default
    $apiUrl = $modelUrl ? $modelUrl : GEMINI_API_URL;
    
    // Build API URL with API key as query parameter
    $url = $apiUrl . '?key=' . urlencode(GEMINI_API_KEY);
    
    // Initialize cURL
    $ch = curl_init($url);
    
    if ($ch === false) {
        error_log("Gemini API Error: Failed to initialize cURL");
        return false;
    }
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30 second timeout
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    
    // Execute request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    $curlErrno = curl_errno($ch);
    curl_close($ch);
    
    // Check for cURL errors
    if ($curlErrno !== 0 || $curlError) {
        $errorMsg = "Gemini API cURL Error #{$curlErrno}: " . $curlError;
        error_log($errorMsg);
        if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
            error_log("Gemini API Debug: URL was " . str_replace(GEMINI_API_KEY, 'HIDDEN', $url));
        }
        return false;
    }
    
    // Check if response is empty
    if (empty($response)) {
        $errorMsg = "Gemini API Error: Empty response received. HTTP Code: {$httpCode}";
        error_log($errorMsg);
        if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
            error_log("Gemini API Debug: URL was " . str_replace(GEMINI_API_KEY, 'HIDDEN', $url));
        }
        return false;
    }
    
    // Check HTTP status code
    if ($httpCode !== 200) {
        $errorMsg = "Gemini API HTTP Error {$httpCode}: " . substr($response, 0, 500);
        error_log($errorMsg);
        
        // Try to parse error message
        $errorData = json_decode($response, true);
        
        // Handle quota exceeded (429) - try with retry delay
        if ($httpCode === 429 && isset($errorData['error']['details'])) {
            foreach ($errorData['error']['details'] as $detail) {
                if (isset($detail['@type']) && $detail['@type'] === 'type.googleapis.com/google.rpc.RetryInfo') {
                    $retryDelay = isset($detail['retryDelay']) ? (int)str_replace('s', '', $detail['retryDelay']) : 20;
                    error_log("Gemini API: Quota exceeded. Retry after {$retryDelay} seconds.");
                    
                    // Wait and retry once
                    sleep(min($retryDelay, 30)); // Max 30 seconds wait
                    
                    // Retry the request
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                    
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    // If retry succeeded, continue processing
                    if ($httpCode === 200) {
                        // Continue to parse response below
                        break;
                    } else {
                        // Retry also failed
                        if (isset($errorData['error']['message'])) {
                            $quotaMsg = $errorData['error']['message'];
                            error_log("Gemini API Quota Error: " . $quotaMsg);
                        }
                        return false;
                    }
                }
            }
            
            // If still not 200 after retry, return false
            if ($httpCode !== 200) {
                if (isset($errorData['error']['message'])) {
                    $detailedError = "Gemini API Error Message: " . $errorData['error']['message'];
                    error_log($detailedError);
                }
                return false;
            }
        } else {
            // Other HTTP errors
            if (isset($errorData['error']['message'])) {
                $detailedError = "Gemini API Error Message: " . $errorData['error']['message'];
                error_log($detailedError);
            }
            
            if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
                error_log("Gemini API Debug: Full response: " . substr($response, 0, 1000));
                error_log("Gemini API Debug: URL was " . str_replace(GEMINI_API_KEY, 'HIDDEN', $url));
            }
            
            return false;
        }
    }
    
    // Parse JSON response
    $responseData = json_decode($response, true);
    
    // Check if response is valid JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Gemini API JSON Error: " . json_last_error_msg());
        error_log("Gemini API Raw Response: " . substr($response, 0, 500));
        return false;
    }
    
    // Extract text from response - try multiple possible response structures
    $geminiText = false;
    
    // Standard response structure
    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        $geminiText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);
    }
    // Alternative structure
    elseif (isset($responseData['candidates'][0]['text'])) {
        $geminiText = trim($responseData['candidates'][0]['text']);
    }
    // Another possible structure
    elseif (isset($responseData['text'])) {
        $geminiText = trim($responseData['text']);
    }
    
    if ($geminiText !== false && !empty($geminiText)) {
        // Clean up the response (remove any unwanted prefixes)
        $geminiText = preg_replace('/^(Response:|Answer:)\s*/i', '', $geminiText);
        return $geminiText;
    }
    
    // If no text found, log the response structure for debugging
    error_log("Gemini API: Unexpected response structure. Full response: " . json_encode($responseData));
    return false;
}

// Find answer from database
$result = findAnswer($conn, $userMessage, $db);
$response = $result['answer'];
$matched = $result['matched'];
$matchedQuestionId = $result['id'];
$isGeminiResponse = false;

// If no database match found, try Gemini API
if (!$matched && $response === null && GEMINI_ENABLED) {
    if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
        error_log("Gemini API: Attempting to get response for: " . substr($userMessage, 0, 100));
    }
    
    $geminiResponse = getGeminiResponse($userMessage);
    
    // If first attempt fails with quota error, try alternative model
    if ($geminiResponse === false) {
        // Try gemini-pro as fallback (might have different quota)
        $fallbackUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';
        if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
            error_log("Gemini API: Trying fallback model (gemini-pro)");
        }
        $geminiResponse = getGeminiResponse($userMessage, $fallbackUrl);
    }
    
    if ($geminiResponse !== false && !empty($geminiResponse)) {
        $response = $geminiResponse;
        $isGeminiResponse = true;
        
        if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
            error_log("Gemini API: Successfully received response");
        }
    } else {
        // Fallback message if Gemini also fails
        if (defined('GEMINI_DEBUG') && GEMINI_DEBUG) {
            error_log("Gemini API: Failed to get response, using fallback message");
            error_log("Gemini API: Check PHP error logs for details");
            error_log("Gemini API: Possible reasons - Quota exceeded (20 requests/day free tier), API key issue, or network problem");
        }
        $response = "Sorry, I don't have an answer for that yet. Please contact support or try rephrasing your question.";
    }
}

// Log the conversation
$logQuery = "INSERT INTO chat_logs (user_message, bot_response, matched_question_id) VALUES (?, ?, ?)";
$logStmt = $conn->prepare($logQuery);
$logStmt->bind_param("ssi", $userMessageClean, $response, $matchedQuestionId);
$logStmt->execute();
$logStmt->close();

// Return JSON response
echo json_encode([
    'success' => true,
    'response' => $response,
    'matched' => $matched,
    'gemini' => $isGeminiResponse, // Indicate if response came from Gemini
    'timestamp' => date('Y-m-d H:i:s')
]);




