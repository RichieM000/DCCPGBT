<?php

// $connections = mysqli_connect ("localhost","root", "", "barangay_taloc"
// 	);
// 	if (mysqli_connect_errno()) {
// 		echo "Failed to connect to MySQL!" . mysqli_connect_error();
		
// 	}

	$connections = mysqli_connect("localhost", "root", "", "barangay_taloc");
if (!$connections) {
    die("Connection failed: " . mysqli_connect_error());
}
return $connections;

	
?>
 