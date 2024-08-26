<?php 

include("connections.php");

$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required!";
    } else {
        $email = $_POST["email"];
    }
    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required!";
		
    } else {
        $password = $_POST["password"];
    }
    
    if ($email && $password) {
        include("connections.php");
        $check_email = mysqli_query($connections, "SELECT * FROM tbl_staff WHERE email='$email'");
        $check_email_row = mysqli_num_rows($check_email);
        
        if ($check_email_row > 0) {
            while ($row = mysqli_fetch_assoc($check_email)) {

                $id = $row["id"];
                $db_password = $row["password"];
                $account_type = $row["usertype"];
				$first_name = $row["fname"]; 

				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                if (password_verify($password, $db_password)) {

                    session_start();

                    $_SESSION["id"] = $id;
					$_SESSION["name"] = $first_name;
                    
                    if ($account_type == "admin") {
                        echo "<script>window.location.href='dashboard.php';</script>";
                       
                    } else if($account_type == "user") {
						// echo "<script>window.location.href='../guest/home.php';</script>";
						$useralert = "This Account is belong to the staff, please go to the <a href='../guest/index.php' style='text-decoration:underline;'>staff login</a>";
					}else{
						echo 'There is an error';
					}
                } else {
                    $passwordErr = "Password is incorrect!";
					
                }
            }
        } else {
            $emailErr = "Email is not registered!";

			
        }
		
    }
}
	?>

<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="assets/logo.png">

	<title>DCCPGBT | Login</title>
 

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">


<script type="text/javascript">
var baseurl = '';
</script>




<div class="login-container">
	
	<div class="login-header login-caret">
		
		<div class="login-content">
			
			<a href="../index.php" class="logo">
				<img src="assets/images/logo.png" width="200" alt="" />
			</a>
			
			<p class="description">Digitizing Community Cleanup for a Greener Barangay Taloc</p>
			<h1 style="color: gray;">Admin Login</h1>
			
			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>43%</h3>
				<span>logging in...</span>
			</div>
		</div>
		
	</div>
	
	<div class="login-progressbar">
		<div></div>
	</div>
	
	<div class="login-form">
		
		<div class="login-content">
			
			<div class="form-login-error">
				<h3>Invalid login</h3>
			</div>
			
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form">
				
				<div class="form-group">
				<?php if(isset($useralert)) { echo "<span style='color:red'>".$useralert."</span>"; }?>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
						
						<input type="email" class="form-control" name="email" id="username" placeholder="Username" autocomplete="off" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required />
					</div>
					<?php if(isset($emailErr)) { echo "<span style='color:red'>".$emailErr."</span>"; }?>
					
				</div>
				
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" required />
					</div>
					<?php if(isset($passwordErr)) { echo "<span style='color:red'>".$passwordErr."</span>"; }?>
				
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btn-login">
						<i class="entypo-login"></i>
						Login
					</button>
				</div>
				
				
			</form>
			
		</div>
		
	</div>
	
</div>


	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-login.js"></script>

</body>
</html>