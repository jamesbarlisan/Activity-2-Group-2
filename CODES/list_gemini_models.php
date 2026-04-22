<?php
/**
 * List Available Gemini Models
 * This script calls the ListModels API to see what models are available
 */

require_once 'config.php';

if (!function_exists('curl_init')) {
    die("ERROR: cURL extension is not available.");
}

echo "<h2>Listing Available Gemini Models</h2>";
echo "<pre>";

// Try both v1beta and v1 API versions
$apiVersions = [
    'v1beta' => 'https://generativelanguage.googleapis.com/v1beta/models',
    'v1' => 'https://generativelanguage.googleapis.com/v1/models'
];

$availableModels = [];

foreach ($apiVersions as $version => $baseUrl) {
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "Checking {$version} API...\n";
    echo "URL: {$baseUrl}\n\n";
    
    $url = $baseUrl . '?key=' . urlencode(GEMINI_API_KEY);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        
        if (isset($data['models']) && is_array($data['models'])) {
            echo "✅ Found " . count($data['models']) . " models:\n\n";
            
            foreach ($data['models'] as $model) {
                $modelName = $model['name'] ?? 'Unknown';
                $displayName = $model['displayName'] ?? 'N/A';
                $supportedMethods = isset($model['supportedGenerationMethods']) ? implode(', ', $model['supportedGenerationMethods']) : 'N/A';
                
                echo "Model Name: {$modelName}\n";
                echo "Display Name: {$displayName}\n";
                echo "Supported Methods: {$supportedMethods}\n";
                
                // Check if generateContent is supported
                if (isset($model['supportedGenerationMethods']) && in_array('generateContent', $model['supportedGenerationMethods'])) {
                    echo "✅ Supports generateContent!\n";
                    
                    // Extract short model name
                    $shortName = basename($modelName);
                    $availableModels[] = [
                        'version' => $version,
                        'fullName' => $modelName,
                        'shortName' => $shortName,
                        'displayName' => $displayName,
                        'url' => "https://generativelanguage.googleapis.com/{$version}/models/{$shortName}:generateContent"
                    ];
                }
                echo "\n";
            }
        } else {
            echo "⚠️ Unexpected response structure\n";
            echo "Response: " . substr($response, 0, 500) . "\n";
        }
    } else {
        $errorData = json_decode($response, true);
        $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown error';
        echo "❌ Failed (HTTP {$httpCode})\n";
        echo "Error: {$errorMsg}\n";
    }
    
    if ($curlError) {
        echo "cURL Error: {$curlError}\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "\n=== AVAILABLE MODELS FOR generateContent ===\n\n";

if (count($availableModels) > 0) {
    foreach ($availableModels as $model) {
        echo "✅ {$model['displayName']} ({$model['shortName']})\n";
        echo "   API Version: {$model['version']}\n";
        echo "   URL: {$model['url']}\n\n";
    }
    
    // Test the first available model
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "Testing first available model: {$availableModels[0]['shortName']}\n";
    echo "URL: {$availableModels[0]['url']}\n\n";
    
    $testMessage = "How do I restart my computer?";
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
    
    $testUrl = $availableModels[0]['url'] . '?key=' . urlencode(GEMINI_API_KEY);
    
    $ch = curl_init($testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $responseData = json_decode($response, true);
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $text = trim($responseData['candidates'][0]['content']['parts'][0]['text']);
            echo "✅ TEST SUCCESSFUL!\n";
            echo "Response: " . substr($text, 0, 200) . "\n\n";
            
            echo "💡 UPDATE YOUR config.php:\n";
            echo "define('GEMINI_API_URL', '{$availableModels[0]['url']}');\n";
        } else {
            echo "⚠️ Got 200 but unexpected response structure\n";
        }
    } else {
        $errorData = json_decode($response, true);
        $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown error';
        echo "❌ Test failed (HTTP {$httpCode})\n";
        echo "Error: {$errorMsg}\n";
    }
} else {
    echo "❌ No models found that support generateContent\n";
    echo "\nPossible issues:\n";
    echo "1. API key might not have access to Generative Language API\n";
    echo "2. API key might need to be enabled in Google Cloud Console\n";
    echo "3. Check API key permissions and quotas\n";
    echo "4. Verify the API key is correct\n";
}

echo "</pre>";
?>



