<?php
// Include the functions file
require 'functions.php';

// Database connection
require 'connections.php';

// Call the function to get users
$staffList = getUsers($connections);
$toolList = getTools($connections);

// Close the database connection
$connections->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($staffList);
?>