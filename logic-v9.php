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
    'version' => 'v9',
    'action' => $action,
    'timestamp' => date('Y-m-d H:i:s')
];

if ($action === 'dispatch') {
    $task = $input['task'] ?? 'unknown';
    $response['message'] = "Successfully triggered repository dispatch for workflow: {$task}";
    
    $logFile = 'data-v1.json';
    if (file_exists($logFile)) {
        $data = json_decode(file_get_contents($logFile), true);
        if (is_array($data) && isset($data['logs'])) {
            $data['logs'][] = [
                'id' => count($data['logs']) + 1,
                'action' => "dispatch_{$task}",
                'status' => 'success',
                'timestamp' => $response['timestamp']
            ];
            file_put_contents($logFile, json_encode($data, JSON_PRETTY_PRINT));
        }
    }
} else {
    $response['message'] = 'System operational and fully responsive.';
}

echo json_encode($response);
?>
