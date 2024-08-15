
<?php session_start() ?>
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
 

	<link rel="stylesheet" href="admin/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="admin/assets/css/font-icons/entypo/css/entypo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="admin/assets/css/bootstrap.css"> -->
	<link rel="stylesheet" href="admin/assets/css/neon-core.css">
	<link rel="stylesheet" href="admin/assets/css/neon-theme.css">
	<link rel="stylesheet" href="admin/assets/css/neon-forms.css">
	<link rel="stylesheet" href="admin/assets/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

	<script src="admin/assets/js/jquery-1.11.3.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script> 
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">


<script type="text/javascript">
var baseurl = '';
</script>




<div class="login-container">
	
	<div class="login-header login-caret">
		
		<div class="flex flex-col justify-center items-center">
			
			<a href="" class="">
				<img src="admin/assets/images/logo.png" width="200" alt="" />
			</a>
			
			<p class="text-gray-400 text-sm mt-4">Digitizing Community Cleanup for a Greener Barangay Taloc</p>
			
			<!-- progress bar indicator
			<div class="">
				<h3>43%</h3>
				<span>logging in...</span>
			</div> -->
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
            <!-- <div class="p-6 text-white rounded-md mb-4 hover:scale-105 transition duration-300 ease-in-out" style="background-color: #373e4a;">
                    <a href=""><i class="ri-admin-fill"></i> Admin Login</a>
                </div> -->
			
            <div>
               
                   <a href="admin/index.php">
                    <div class="p-2 text-lg text-gray-400 rounded-md mb-3 hover:text-gray-300 hover:scale-105 transition duration-300 ease-in-out" style="background-color: #373e4a;"><i class="ri-admin-fill"></i> Admin Login</div>
                   </a>
                   <a href="guest/index.php">
                    <div class="p-2 text-lg text-gray-400 rounded-md mb-3 hover:text-gray-300 hover:scale-105 transition duration-300 ease-in-out" style="background-color: #373e4a;"><i class="ri-user-2-fill"></i> Staff Login</div>
                   </a>   
                   <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <div class="p-2 text-lg text-gray-400 rounded-md mb-3 hover:text-gray-300 hover:scale-105 transition duration-300 ease-in-out" style="background-color: #373e4a;"><i class="ri-team-fill"></i> Resident's CleanUp Request</div>
                   </a>        

            </div>
       
            <!-- <div id='calendar'></div> -->
		</div>
        
	</div>
	
</div>

<!-- <script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth'
  });
  calendar.render();
});

</script> -->

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Resident CleanUp Request</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="profileForm" method="POST" action="admin/code.php" class="grid grid-cols-2 gap-4">
         
            <div class="mb-3">
                        <label for="firstname" class="block font-bold">Firstname</label>
                        <input type="text" name="firstname" id="firstname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-3">
                        <label for="lastname" class="block font-bold">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-3">
                        <label for="address" class="block font-bold">Address/Purok</label>
                        <input type="text" name="address" id="address" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="block font-bold">Contact #</label>
                        <input type="text" name="phone" id="phone" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-3">
                        <label for="email" class="block font-bold">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="block font-bold">Gender</label>
                        <select name="gender" id="gender" class="mt-1 p-2 text-black border border-gray-300 rounded-md w-full" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
					</div>
                    <div class="mb-3">
                        <label for="reason" class="block font-bold">Reason For Request</label>
                        <textarea name="reason" id="reason" rows="3" class="form-textarea block w-full mt-1 p-2 border border-gray-300 rounded-md" required oninput="updateCharacterCount('reason', 500)"></textarea>
                        <p class="text-sm text-gray-600"><span id="reasonCount">0</span>/500 characters</p>
                    </div>
                    <div class="mb-3">
                        <label for="comments" class="block font-bold">Additional Notes/Comments:</label>
                        <textarea name="comments" id="comments" rows="3" class="form-textarea block w-full mt-1 p-2 border border-gray-300 rounded-md" oninput="updateCharacterCount('comments', 200)"></textarea>
                        <p class="text-sm text-gray-600"><span id="commentsCount">0</span>/200 characters</p>
                    </div>

                    <div class="col-span-2 m-auto">
        <button type="button" class="" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submitrequest" class="bg-blue-500 text-white p-2 rounded-md">Submit</button>
      </div>
                    
        </form>
       
       
      </div>

      
    </div>
  </div>
</div>
<script>
        function updateCharacterCount(id, maxLength) {
            const textArea = document.getElementById(id);
            const countDisplay = document.getElementById(id + 'Count');
            const currentLength = textArea.value.length;
            countDisplay.textContent = currentLength;
            if (currentLength > maxLength) {
                countDisplay.classList.add('text-red-500');
            } else {
                countDisplay.classList.remove('text-red-500');
            }
        }
    </script>

	<!-- Bottom scripts (common) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="admin/assets/js/gsap/TweenMax.min.js"></script>
	<script src="admin/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="admin/assets/js/bootstrap.js"></script>
	<script src="admin/assets/js/joinable.js"></script>
	<script src="admin/assets/js/resizeable.js"></script>
	<script src="admin/assets/js/neon-api.js"></script>
	<script src="admin/assets/js/jquery.validate.min.js"></script>
	<script src="admin/assets/js/neon-login.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
    ?>

    <script>

    swal({
    title: "<?php echo $_SESSION['status']; ?>",
    text: "The barangay staff's will send a notif through text or email if your request has been approved.",
    icon: "<?php echo $_SESSION['status_code']; ?>",
    button: "Okay!",
    });
        </script>

    <?php
    unset($_SESSION['status']);
}

?>
</body>
</html>