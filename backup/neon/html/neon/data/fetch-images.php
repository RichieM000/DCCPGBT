<?php

header('Content-Type: application/json');

$uploadDir = '../uploads/';
$response = ['files' => []];

// Fetch all image files from the upload directory
if (is_dir($uploadDir)) {
    $files = scandir($uploadDir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $uploadDir . $file;
            if (is_file($filePath)) {
                $response['files'][] = [
                    'name' => $file,
                    'size' => filesize($filePath),
                    'type' => mime_content_type($filePath)
                ];
            }
        }
    }
}

echo json_encode($response);
?>
