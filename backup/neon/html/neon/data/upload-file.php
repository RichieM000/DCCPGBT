<?php

header('Content-Type: application/json');

$uploadDir = '../uploads/';
$errors = [];
$response = [];

// Create the upload directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!empty($_FILES['file'])) {
    $file = $_FILES['file'];
    $tmpName = $file['tmp_name'];
    $name = basename($file['name']);
    $uploadFile = $uploadDir . $name;

    // Check if the file is a valid image
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = pathinfo($name, PATHINFO_EXTENSION);
    if (!in_array(strtolower($fileExtension), $validExtensions)) {
        $errors[] = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    if (empty($errors)) {
        if (move_uploaded_file($tmpName, $uploadFile)) {
            $response['files'][] = [
                'name' => $name,
                'size' => $file['size'],
                'type' => $file['type'],
                'status' => 'Uploaded'
            ];
        } else {
            $errors[] = "Failed to move uploaded file. Check server permissions.";
        }
    }
} else {
    $errors[] = "No file uploaded.";
}

if (!empty($errors)) {
    http_response_code(400);
    $response['error'] = implode(', ', $errors);
} else {
    http_response_code(200);
}

echo json_encode($response);
?>
