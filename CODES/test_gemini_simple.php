<?php
/**
 * Simple Gemini API Test
 * Quick test to see if API is working
 */

require_once 'config.php';

echo "<h2>Simple Gemini API Test</h2>";
echo "<pre>";

// Test message
$testMessage = "Say hello in one sentence.";

echo "API Key: " . substr(GEMINI_API_KEY, 0, 15) . "...\n";
echo "API URL: " . GEMINI_API_URL . "\n";
echo "Test Message: {$testMessage}\n\n";

// Prepare prompt
$prompt = "You are a helpful assistant. Answer briefly: " . $testMessage;

// Prepare data
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

// Build URL
$url = GEMINI_API_URL . '?key=' . urlencode(GEMINI_API_KEY);

echo "Request URL: " . str_replace(GEMINI_API_KEY, 'HIDDEN', $url) . "\n\n";

// Make request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
$curlErrno = curl_errno($ch);
curl_close($ch);

echo "=== RESULTS ===\n";
echo "HTTP Code: {$httpCode}\n";
echo "cURL Error: " . ($curlError ? $curlError : 'None') . "\n";
echo "cURL Error No: {$curlErrno}\n\n";

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        $text = trim($data['candidates'][0]['content']['parts'][0]['text']);
        echo "✅ SUCCESS!\n";
        echo "Response: {$text}\n";
    } else {
        echo "⚠️ Got 200 but unexpected structure\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }
} else {
    echo "❌ FAILED\n";
    echo "Response: " . substr($response, 0, 500) . "\n";
    
    $errorData = json_decode($response, true);
    if (isset($errorData['error']['message'])) {
        echo "\nError Message: " . $errorData['error']['message'] . "\n";
    }
}

echo "</pre>";
?>


