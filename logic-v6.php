<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? $_GET['action'] ?? 'status';

$response = [
    'status' => 'success',
    'version' => 'v6',
    'action' => $action,
    'timestamp' => time()
];

if ($action === 'dispatch') {
    $task = $input['task'] ?? 'unknown';
    $response['message'] = "Successfully triggered repository dispatch for workflow: {$task}";
} else {
    $response['message'] = 'System operational and fully responsive.';
}

echo json_encode($response);
?>
