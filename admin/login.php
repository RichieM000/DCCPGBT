
    // if ($email && $password) {
	// 	include("connections.php");
	// 	$check_email = mysqli_query($connections, "SELECT * FROM tbl_staff WHERE email='$email'");
	// 	$check_email_row = mysqli_num_rows($check_email);
		
	// 	if ($check_email_row > 0) {
	// 		while ($row = mysqli_fetch_assoc($check_email)) {
	
	// 			$staff_id = $row["id"];
	// 			$db_password = $row["password"];
				
	// 			if ($password == $db_password) {
	
	// 				session_start();
	
	// 				$_SESSION["id"] = $staff_id;
					
	// 				echo "<script>window.location.href='dashboard.php';</script>";
					
	// 			} else {
	// 				$passwordErr = "Password is incorrect!";
	// 			}
	// 		}
	// 	} else {
	// 		$emailErr = "Email is not registered!";
	// 	}
	// }


<style>
   .error {
       color: red;
}
</style>

