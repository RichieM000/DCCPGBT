

<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>




<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>

		</div>

        


        
        <?php

require_once 'connections.php';

// Retrieve the ID from the URL parameter
$id = $_GET['id'];

// Fetch the staff data from the database
$query = "SELECT * FROM tbl_staff WHERE id = '$id'";
$result = mysqli_query($connections, $query);

if (!$result) {
    echo "Error: " . mysqli_error($connections);
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $staff_data = mysqli_fetch_assoc($result);

    // Extract the values from the result
    $fname = $staff_data['fname'];
    $lname = $staff_data['lname'];
    $address = $staff_data['address'];
    $age = $staff_data['age'];
    $gender = $staff_data['gender'];
    $job_position = $staff_data['job_position'];
    // ... and so on for each column
} else {
    echo "No staff data found with ID $id";
    exit;
}

// Close the database connection
mysqli_close($connections);
?>
	
<div class="bg-gray-600 m-auto h-auto p-32 border-xl text-white">
	<h1 class="relative font-bold text-4xl mb-8">Edit Details</h1>
	

		<form action="createstaff.php" method="POST" class="grid grid-cols-2 gap-4 m-3" enctype="multipart/form-data">
			
			<div class="">

				<div class="mb-4">
                        <label for="fname" class="block text-xl font-medium">Firstname</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $fname ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="lname" class="block text-xl font-medium">Lastname</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $lname ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="address" class="block text-xl font-medium">Address</label>
                        <input type="text" name="address" id="address" value="<?php echo $address ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="age" class="block text-xl font-medium">Age</label>
                        <input type="text" name="age" id="age" value="<?php echo $age ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="gender" class="block text-xl font-medium">Gender</label>
                        <select name="gender" id="gender" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                        <option value="male" <?= ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?= ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?= ($gender == 'other') ? 'selected' : ''; ?>>Other</option>
                           
                        </select>
					</div>
					<div class="mb-4">
                        <label for="position" class="block text-xl font-medium">Job Position</label>
                        <select name="position" id="position" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
						<option>--Select Position--</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="Kagawad">Kagawad</option>
                            <option value="Tanod">Tanod</option>
                            <option value="SKchairman">SK Chairman</option>
                            <option value="SK">SK</option>
                            <option value="Clerk">Clerk</option>
                            <option value="BHW">Barangay Health Workers</option>
                        </select>
                    </div>

				</div>
			<div class="">

			<div class="mb-4">
			<label for="" class="text-xl">Profile Image:</label>
			<input type="file" name="img">
			<div class="flex justify-center items-center p-14 rounded-full">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar :'' ?>" alt="Avatar" id="cimg" class="bg-white rounded-full p-12">
						</div>
						</div>

						<div class="mb-4">
                        <label for="email" class="block text-xl font-medium">Email</label>
                        <input type="text" name="email" id="email" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="password" class="block text-xl font-medium">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="cpassword" class="block text-xl font-medium">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                       
                    </div>

</div>
					<div class="col-span-2 m-auto mt-12">
					<button type="submit" name="submit" class="bg-green-500 hover:bg-green-700 text-white text-2xl px-4 py-2 rounded-md">Save</button>
					</div>
			
		</form>
	
</div>

	</div>
</div>
		
		<?php include"footer.php" ?>
		

</body>
</html>