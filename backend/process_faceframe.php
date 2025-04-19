<?php
$request = json_decode(file_get_contents('php://input'), true);

if (!isset($request['image'])) {
    echo json_encode(['error' => 'No image data received']);
    exit;
}

$imageData = $request['image'];
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);

$imagePath = '../captured_frames/captured_frame.png';

// Save the image to the server
if (!file_put_contents($imagePath, base64_decode($imageData))) {
    echo json_encode(['error' => 'Failed to save the image']);
    exit;
}

// Call the Python script
$pythonPath = 'C:\\Users\\Asus\\AppData\\Local\\Programs\\Python\\Python312\\python.exe'; // Correct Python path
$scriptPath = '../python/process_image.py';
$command = escapeshellcmd("$pythonPath $scriptPath $imagePath 2>&1"); // Escape shell arguments for security
$output = shell_exec($command); // Execute the Python script

// Log the raw output for debugging
file_put_contents('../logs/python_raw_output.log', $output, FILE_APPEND);

// Extract the JSON response from the output
$jsonStart = strpos($output, '{'); // Find the start of the JSON
$jsonEnd = strrpos($output, '}');  // Find the end of the JSON
if ($jsonStart !== false && $jsonEnd !== false) {
    $jsonString = substr($output, $jsonStart, $jsonEnd - $jsonStart + 1);
    $response = json_decode($jsonString, true);
} else {
    $response = null;
}

// Handle Python script errors
if ($response === null) {
    // Log the Python script error for debugging
    file_put_contents('../logs/python_error.log', $output, FILE_APPEND);

    echo json_encode(['error' => 'Python script error', 'details' => $output]);
    exit;
}

// Return the response from the Python script
header('Content-Type: application/json');
echo json_encode($response);
?>