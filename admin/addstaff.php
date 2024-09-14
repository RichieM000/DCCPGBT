
<?php include "code.php"; ?>
<?php
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $input_values = $_SESSION['oldvalue'];
    unset($_SESSION['errors']); // unset the session variable
    unset($_SESSION['oldvalue']);
} else {
    $errors = array();
    $input_values = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header.php"?>




<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>

		</div>

    <hr />


        
		
	
<div class="bg-gray-600 m-auto h-auto p-12 border-xl">
	<h1 class="relative font-bold text-xl mb-8 text-white">Add Staff</h1>
	

		<form action="code.php" method="POST" class="grid grid-cols-2 gap-4 m-3 text-white" enctype="multipart/form-data">
			
			<div class="">
            <input type="hidden" name="addstaff" value="true">
            
				<div class="mb-4">
                        <label for="fname" class="block font-medium">Firstname</label>
                        <input type="text" name="fname" id="fname" value="<?php echo isset($input_values['fname']) ? $input_values['fname'] : ''; ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                        <?php if(isset($errors['fname'])) { echo "<span class='text-red-400'>".$errors['fname']."</span>"; }?>
                    </div>
					<div class="mb-4">
                        <label for="lname" class="block font-medium">Lastname</label>
                        <input type="text" name="lname" id="lname" value="<?php echo isset($input_values['lname']) ? $input_values['lname'] : ''; ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                        <?php if(isset($errors['lname'])) { echo "<span class='text-red-400'>".$errors['lname']."</span>"; }?>
                    </div>
					<div class="mb-4">
                        <label for="address" class="block font-medium">Address</label>
                        <input type="text" name="address" id="address" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" value="<?php echo isset($input_values['address']) ? $input_values['address'] : ''; ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block font-medium">Contact #</label>
                        <input type="text" name="phone" id="phone" value="<?php echo isset($input_values['phone']) ? $input_values['phone'] : ''; ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" maxlength="11" required>
                        <?php if(isset($errors['phone'])) { echo "<span class='text-red-400'>".$errors['phone']."</span>"; }?>
                    </div>
					<div class="mb-4">
                        <label for="age" class="block font-medium">Age</label>
                        <input type="text" name="age" id="age" value="<?php echo isset($input_values['age']) ? $input_values['age'] : ''; ?>" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                        <?php if(isset($errors['age'])) { echo "<span class='text-red-400'>".$errors['age']."</span>"; }?>
                    </div>
					<div class="mb-4">
                        <label for="gender" class="block font-medium">Gender</label>
                        <select name="gender" id="gender" class="mt-1 p-2 text-black border border-gray-300 rounded-md w-full" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
					</div>
					<div class="mb-4">
                        <label for="position" class="block font-medium">Job Position</label>
                        <select name="position" id="position" class="mt-1 p-2 text-black border border-gray-300 rounded-md w-full" required>
						<option>--Select Position--</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="Kagawad">Kagawad</option>
                            <option value="Tanod">Tanod</option>
                            <option value="SKchairman">SK Chairman</option>
                            <!-- <option value="SK">SK</option>
                            <option value="Clerk">Clerk</option>
                            <option value="BHW">Barangay Health Workers</option> -->
                        </select>
                    </div>
             

				</div>
			<div class="">

			<div class="mb-4">
			<label for="" class="text-xl">Profile Image:</label>
			<input type="file" name="img" id="profileImage" accept="image/*" onchange="loadFile(event)">
			<div class="m-auto overflow-hidden rounded-full bg-white w-32 h-32">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar :'assets/uploads/no-images.jpg' ?>" alt="Avatar" id="cimg" class="w-full h-full bg-cover rounded-full">
           
						</div>

            <script>
function loadFile(event) {
    var image = document.getElementById('cimg');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.onload = function() {
        URL.revokeObjectURL(image.src); // free memory
    }
}
</script>
						</div>

						<div class="mb-4">
                        <label for="email" class="block font-medium">Email</label>
                        <input type="text" name="email" id="email" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" value="<?php echo isset($input_values['email']) ? $input_values['email'] : ''; ?>" required>
                    </div>
					<div class="mb-4">
                        <label for="password" class="block font-medium">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="cpassword" class="block font-medium">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                        <?php if(isset($errors['cpassword'])) { echo "<span class='text-red-400'>".$errors['cpassword']."</span>"; }?>
                    </div>

</div>
					<div class="col-span-2 m-auto mt-12">
					<button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-lg px-4 py-2 rounded-md">Save</button>
					</div>
			
		</form>

    


</div>

	


		<?php include"footer.php" ?>
		

</body>
</html>