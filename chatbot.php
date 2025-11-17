<?php
session_start();
header('Content-Type: application/json');

// Get JSON from frontend
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = trim($data['message'] ?? '');

if (!$userMessage) {
    echo json_encode(['reply' => 'No message received.']);
    exit;
}

// Initialize chat history in session if not exists
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [
        ["role" => "system", "content" => "You are a helpful assistant. Respond politely and clearly."]
    ];
}

// Append user message to chat history
$_SESSION['chat_history'][] = ["role" => "user", "content" => $userMessage];

// LM Studio API endpoint
$lm_url = "http://127.0.0.1:1234/v1/chat/completions";

// Prepare POST data
$postData = [
    "model" => "meta-llama-3.1-8b-instruct",
    "messages" => $_SESSION['chat_history'],
    "max_tokens" => 300,
    "temperature" => 0.7
];

// cURL request
$ch = curl_init($lm_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_TIMEOUT, 120);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(['reply' => "Error contacting LM Studio: $error"]);
    exit;
}

// Decode LM Studio response
$respData = json_decode($response, true);
$assistantReply = $respData['choices'][0]['message']['content'] ?? "LM Studio did not return a response.";

// Clean reply
$assistantReply = trim($assistantReply);
$assistantReply = preg_replace('/[\r\n]+/', ' ', $assistantReply);
$assistantReply = preg_replace('/[^[:print:]]/', '', $assistantReply);

// Append assistant reply to chat history
$_SESSION['chat_history'][] = ["role" => "assistant", "content" => $assistantReply];

// Send JSON response to frontend
echo json_encode(['reply' => $assistantReply]);
?>
