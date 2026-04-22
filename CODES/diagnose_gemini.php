<?php
/**
 * Comprehensive Gemini API Diagnostic Tool
 * Tests multiple authentication methods and endpoints
 */

require_once 'config.php';

if (!function_exists('curl_init')) {
    die("ERROR: cURL extension is not available.");
}

echo "<h2>Gemini API Comprehensive Diagnostic</h2>";
echo "<pre>";

$apiKey = GEMINI_API_KEY;
echo "API Key: " . substr($apiKey, 0, 15) . "...\n";
echo "Key Length: " . strlen($apiKey) . " characters\n\n";

// Test 1: List Models with query parameter
echo str_repeat("=", 70) . "\n";
echo "TEST 1: List Models (v1beta) - Query Parameter Auth\n";
echo str_repeat("=", 70) . "\n";

$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . urlencode($apiKey);
echo "URL: " . str_replace($apiKey, 'HIDDEN', $url) . "\n";

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
        echo "✅ SUCCESS! Found " . count($data['models']) . " models\n\n";
        
        $workingModels = [];
        foreach ($data['models'] as $model) {
            $name = $model['name'] ?? 'Unknown';
            $displayName = $model['displayName'] ?? 'N/A';
            $methods = $model['supportedGenerationMethods'] ?? [];
            
            if (in_array('generateContent', $methods)) {
                $shortName = basename($name);
                echo "✅ {$displayName} ({$shortName}) - Supports generateContent\n";
                $workingModels[] = [
                    'name' => $shortName,
                    'fullName' => $name,
                    'displayName' => $displayName
                ];
            }
        }
        
        if (count($workingModels) > 0) {
            echo "\n" . str_repeat("-", 70) . "\n";
            echo "TESTING FIRST WORKING MODEL: {$workingModels[0]['name']}\n";
            echo str_repeat("-", 70) . "\n";
            
            $testUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$workingModels[0]['name']}:generateContent?key=" . urlencode($apiKey);
            
            $testData = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => 'Say hello in one sentence.'
                            ]
                        ]
                    ]
                ]
            ];
            
            $ch = curl_init($testUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            
            $testResponse = curl_exec($ch);
            $testHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($testHttpCode === 200) {
                $testData = json_decode($testResponse, true);
                if (isset($testData['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = trim($testData['candidates'][0]['content']['parts'][0]['text']);
                    echo "✅ GENERATE CONTENT TEST SUCCESSFUL!\n";
                    echo "Response: {$text}\n\n";
                    
                    echo str_repeat("=", 70) . "\n";
                    echo "💡 SOLUTION - Update config.php:\n";
                    echo str_repeat("=", 70) . "\n";
                    echo "define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/{$workingModels[0]['name']}:generateContent');\n";
                } else {
                    echo "⚠️ Got 200 but unexpected response structure\n";
                    echo "Response: " . substr($testResponse, 0, 500) . "\n";
                }
            } else {
                $errorData = json_decode($testResponse, true);
                $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown';
                echo "❌ GenerateContent test failed (HTTP {$testHttpCode})\n";
                echo "Error: {$errorMsg}\n";
            }
        } else {
            echo "⚠️ No models found that support generateContent\n";
        }
    } else {
        echo "⚠️ Unexpected response structure\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }
} else {
    $errorData = json_decode($response, true);
    $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown error';
    echo "❌ FAILED (HTTP {$httpCode})\n";
    echo "Error: {$errorMsg}\n";
    
    if ($httpCode === 403) {
        echo "\n⚠️ HTTP 403 Forbidden - Possible issues:\n";
        echo "1. API key doesn't have access to Generative Language API\n";
        echo "2. Generative Language API not enabled in Google Cloud Console\n";
        echo "3. API key restrictions might be blocking the request\n";
    } elseif ($httpCode === 401) {
        echo "\n⚠️ HTTP 401 Unauthorized - API key is invalid or expired\n";
    }
}

if ($curlError) {
    echo "cURL Error: {$curlError}\n";
}

// Test 2: Try v1 API
echo "\n\n" . str_repeat("=", 70) . "\n";
echo "TEST 2: List Models (v1) - Query Parameter Auth\n";
echo str_repeat("=", 70) . "\n";

$url = "https://generativelanguage.googleapis.com/v1/models?key=" . urlencode($apiKey);
echo "URL: " . str_replace($apiKey, 'HIDDEN', $url) . "\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['models']) && is_array($data['models'])) {
        echo "✅ SUCCESS! Found " . count($data['models']) . " models\n";
        foreach ($data['models'] as $model) {
            $name = basename($model['name'] ?? 'Unknown');
            $displayName = $model['displayName'] ?? 'N/A';
            $methods = $model['supportedGenerationMethods'] ?? [];
            if (in_array('generateContent', $methods)) {
                echo "  - {$displayName} ({$name})\n";
            }
        }
    }
} else {
    $errorData = json_decode($response, true);
    $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown';
    echo "❌ FAILED (HTTP {$httpCode}): {$errorMsg}\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "DIAGNOSTIC COMPLETE\n";
echo str_repeat("=", 70) . "\n";

echo "</pre>";
?>



