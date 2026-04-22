<?php
/**
 * Test All Available Gemini Models
 * This script tests multiple model endpoints to find which one works
 */

require_once 'config.php';

if (!function_exists('curl_init')) {
    die("ERROR: cURL extension is not available.");
}

$testMessage = "How do I restart my computer?";

// List of endpoints to test
$endpoints = [
    'v1beta/gemini-pro' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent',
    'v1/gemini-pro' => 'https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent',
    'v1beta/gemini-1.5-pro' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent',
    'v1/gemini-1.5-pro' => 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-pro:generateContent',
    'v1beta/gemini-1.5-flash' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
    'v1/gemini-1.5-flash' => 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent',
];

$prompt = "You are a helpful customer support assistant. Answer briefly: " . $testMessage;

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

echo "<h2>Testing All Gemini API Endpoints</h2>";
echo "<pre>";

$workingEndpoints = [];

foreach ($endpoints as $name => $url) {
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "Testing: {$name}\n";
    echo "URL: {$url}\n";
    
    $fullUrl = $url . '?key=' . urlencode(GEMINI_API_KEY);
    
    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $responseData = json_decode($response, true);
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $responseData['candidates'][0]['content']['parts'][0]['text'];
            echo "✅ SUCCESS!\n";
            echo "Response: " . substr(trim($text), 0, 100) . "...\n";
            $workingEndpoints[] = [
                'name' => $name,
                'url' => $url,
                'response' => substr(trim($text), 0, 200)
            ];
        } else {
            echo "⚠️ HTTP 200 but unexpected response structure\n";
        }
    } else {
        $errorData = json_decode($response, true);
        $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown error';
        echo "❌ FAILED (HTTP {$httpCode})\n";
        echo "Error: " . substr($errorMsg, 0, 100) . "\n";
    }
    
    if ($curlError) {
        echo "cURL Error: {$curlError}\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "\n=== SUMMARY ===\n";

if (count($workingEndpoints) > 0) {
    echo "\n✅ Working Endpoints:\n\n";
    foreach ($workingEndpoints as $endpoint) {
        echo "Name: {$endpoint['name']}\n";
        echo "URL: {$endpoint['url']}\n";
        echo "Sample Response: {$endpoint['response']}\n";
        echo "\n";
    }
    
    echo "\n💡 RECOMMENDATION:\n";
    echo "Update config.php with:\n";
    echo "define('GEMINI_API_URL', '{$workingEndpoints[0]['url']}');\n";
} else {
    echo "\n❌ No working endpoints found.\n";
    echo "\nPossible issues:\n";
    echo "1. API key might be invalid or expired\n";
    echo "2. API key might not have access to Generative Language API\n";
    echo "3. Check Google Cloud Console to enable the API\n";
    echo "4. Verify API key permissions and quotas\n";
}

echo "</pre>";
?>



