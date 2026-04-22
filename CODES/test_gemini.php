<?php
/**
 * Gemini API Test Script
 * Use this file to test if Gemini API is working correctly
 * Access: http://localhost/chatbot/test_gemini.php
 */

require_once 'config.php';

// Check if cURL is available
if (!function_exists('curl_init')) {
    die("ERROR: cURL extension is not available. Please enable it in php.ini");
}

echo "<h2>Gemini API Test</h2>";
echo "<pre>";

// Test message
$testMessage = "How do I restart my computer?";

echo "Testing Gemini API connection...\n";
echo "API Key: " . substr(GEMINI_API_KEY, 0, 10) . "...\n";
echo "API URL: " . GEMINI_API_URL . "\n";
echo "Test Message: " . $testMessage . "\n\n";

// Also test alternative endpoints
echo "=== Alternative Endpoints to Try ===\n";
echo "1. v1beta/gemini-pro (current)\n";
echo "2. v1/gemini-1.5-flash\n";
echo "3. v1/gemini-1.5-pro\n";
echo "4. v1beta/gemini-1.5-pro-latest\n\n";

// Prepare the prompt
$prompt = "You are a helpful customer support assistant specializing in computer-related issues, hardware problems, software troubleshooting, system errors, and general IT support. Provide clear, concise, and helpful answers.\n\nUser Question: " . $testMessage . "\n\nProvide a helpful response:";

// Prepare request data
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

// Build API URL
$url = GEMINI_API_URL . '?key=' . urlencode(GEMINI_API_KEY);

echo "Request URL: " . str_replace(GEMINI_API_KEY, 'HIDDEN', $url) . "\n\n";
echo "Request Data:\n";
echo json_encode($data, JSON_PRETTY_PRINT) . "\n\n";

// Initialize cURL
$ch = curl_init($url);

if ($ch === false) {
    die("ERROR: Failed to initialize cURL");
}

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

// Execute request
echo "Sending request...\n";
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
$curlErrno = curl_errno($ch);
curl_close($ch);

echo "\n=== Results ===\n";
echo "HTTP Code: " . $httpCode . "\n";
echo "cURL Error Code: " . $curlErrno . "\n";

if ($curlError) {
    echo "cURL Error: " . $curlError . "\n";
}

echo "\n=== Response ===\n";
if ($response) {
    echo "Response Length: " . strlen($response) . " bytes\n";
    echo "Raw Response (first 1000 chars):\n";
    echo substr($response, 0, 1000) . "\n\n";
    
    // Try to parse JSON
    $responseData = json_decode($response, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "JSON Parsed Successfully!\n";
        echo "Response Structure:\n";
        echo json_encode($responseData, JSON_PRETTY_PRINT) . "\n\n";
        
        // Try to extract text
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $responseData['candidates'][0]['content']['parts'][0]['text'];
            echo "=== Extracted Text ===\n";
            echo $text . "\n";
            echo "\n✅ SUCCESS! Gemini API is working!\n";
        } elseif (isset($responseData['candidates'][0]['text'])) {
            $text = $responseData['candidates'][0]['text'];
            echo "=== Extracted Text (alternative structure) ===\n";
            echo $text . "\n";
            echo "\n✅ SUCCESS! Gemini API is working!\n";
        } else {
            echo "⚠️ WARNING: Response received but text not found in expected location\n";
            echo "Check the response structure above\n";
        }
    } else {
        echo "❌ JSON Parse Error: " . json_last_error_msg() . "\n";
    }
} else {
    echo "❌ No response received\n";
}

// Check for common errors
if ($httpCode === 400) {
    echo "\n⚠️ HTTP 400: Bad Request - Check your API key and request format\n";
} elseif ($httpCode === 401) {
    echo "\n⚠️ HTTP 401: Unauthorized - Invalid API key\n";
} elseif ($httpCode === 403) {
    echo "\n⚠️ HTTP 403: Forbidden - API key may not have proper permissions\n";
} elseif ($httpCode === 404) {
    echo "\n⚠️ HTTP 404: Not Found - Check the API endpoint URL\n";
} elseif ($httpCode === 429) {
    echo "\n⚠️ HTTP 429: Too Many Requests - API quota exceeded\n";
} elseif ($httpCode !== 200) {
    echo "\n⚠️ HTTP Error: " . $httpCode . "\n";
}

echo "</pre>";
?>

