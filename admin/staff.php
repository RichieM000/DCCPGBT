
<?php session_start() ?>
<?php require_once 'connections.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>



<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include "sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
		
		</div>
		
		<hr />
        <div class="flex justify-end m-4">
        <a class="bg-blue-500 text-white font-bold p-1.5 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out" href="addstaff.php">Create New</a>
        </div>

        <div class="data_table">
		<table id="example" class="table table-striped hover font-semibold text-lg">
    <thead>
        <tr class="">
        <th class="font-bold" style="display: none;">#</th>
            <th class="font-bold" style="text-align: left;">Profile Image</th>
            <th class="font-bold">Firstname</th>
            <th class="font-bold">Lastname</th>
            <th class="font-bold">Address</th>
            <th class="font-bold">Contact #</th>
            <th class="font-bold" style="text-align: left;">Age</th>
            <th class="font-bold">Gender</th>
            <th class="font-bold">Job Position</th>
            <th class="font-bold">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Assume $conn is your database connection
        $query = "SELECT * FROM tbl_staff WHERE usertype != 'admin' ";
        $result = mysqli_query($connections, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $profile_image = $row['file_img'];
             // assume this is the column name for the profile image
            $image_path = 'assets/uploads/'; // assume this is the directory where profile images are stored
            $default_image = 'noimage.png'; // default image to display if no profile image is found
    
            if (!empty($profile_image) && file_exists($image_path . $profile_image)) {
                $image_src = $image_path . $profile_image;
            } else {
                $image_src = $image_path . $default_image;
            }
            ?>
            <tr class="">
                <td class="user_id" style="display: none;"><?php echo $row['id'];?></td>
                <td class="capitalize"><img src="<?php echo $image_src; ?>" alt="Profile Image" class="w-20 h-20 rounded-full"></td>
                <td class="capitalize"><?php echo $row['fname']; ?></td>
                <td class="capitalize"><?php echo $row['lname']; ?></td>
                <td class="capitalize"><?php echo $row['address']; ?></td>
                <td class="capitalize"><?php echo $row['phone']; ?></td>
                <td class="capitalize" style="text-align: left;"><?php echo $row['age']; ?></td>
                <td class="capitalize"><?php echo $row['gender']; ?></td>
                <td class="capitalize"><?php echo $row['job_position']; ?></td>

                <td class="text-2xl">
                
                <a href="" class="text-blue-500 edit_data"><i class="ri-edit-fill"></i></a>
                <a href="code.php?idstaff=<?php echo $row['id'];?>" class="text-red-500 hover:text-red-700 delete_data" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
                </td>
            </tr>
            
            <?php
        }
        ?>
        
    </tbody>
</table>


<!-- <div id="adminModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-10 hidden">
    <div class="bg-white shadow-md rounded-lg p-6 mx-auto relative">
        <form id="adminForm" action="update_admin.php" method="POST">
            <input type="hidden" id="adminId" name="adminId">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <button type="submit">Save</button>
            <button type="button" onclick="closeAdminModal()">Close</button>
        </form>
    </div>
</div>


<script>
function openAdminModal(adminId) {
    // Fetch existing data for the admin
    fetch('code.php?id=' + adminId)
        .then(response => response.json())
        .then(data => {
            // Populate the form fields with the existing data
            document.getElementById('adminId').value = data.id;
            document.getElementById('name').value = data.fname;
            document.getElementById('email').value = data.email;
            
            // Show the modal
            document.getElementById('adminModal').classList.remove('hidden');
        })
        .catch(error => console.error('Error fetching admin data:', error));
}

function closeAdminModal() {
    // Clear the form fields
    document.getElementById('adminForm').reset();
    
    // Hide the modal
    document.getElementById('adminModal').classList.add('hidden');
}
</script> -->














<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" id="edit-form" method="POST" class="grid grid-cols-2 gap-4 m-3" enctype="multipart/form-data">
			
			<div class="">
            <input type="hidden" name="id" id="user_id">
				<div class="mb-4">
                        <label for="fname" class="block font-medium">Firstname</label>
                        <input type="text" name="fname" id="fname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="lname" class="block font-medium">Lastname</label>
                        <input type="text" name="lname" id="lname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="address" class="block font-medium">Address</label>
                        <input type="text" name="address" id="address" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block font-medium">Contact #</label>
                        <input type="text" name="phone" id="phone" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" maxlength="11" required>
                    </div>
					<div class="mb-4">
                        <label for="age" class="block font-medium">Age</label>
                        <input type="text" name="age" id="age" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
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
                            <option value="SK">SK</option>
                            <option value="Clerk">Clerk</option>
                            <option value="BHW">Barangay Health Workers</option>
                        </select>
                    </div>

				</div>
			<div class="">

			<div class="">
    <label for="" class="text-xl">Profile Image:</label>
    <input type="file" name="img" id="img" accept="image/*" onchange="loadFile(event)">
    <div class="m-auto overflow-hidden rounded-full bg-gray-200 w-32 h-32">
       <span id="old_img_span"> <img src="<?php echo isset($avatar)? 'assets/uploads/'.$avatar :'assets/uploads/no_image.jpg'?>" id="cimg" class="w-full h-full bg-contain rounded-full"></span>
      
       
    </div>
    <input type="hidden" name="old_img" id="old_img" value="<?php echo isset($avatar)? $avatar :''?>">
    
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
                        <input type="text" name="email" id="email" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="password" class="block font-medium">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full">
                        <input type="hidden" name="old_password" id="oldpass">  
                    </div>
					<div class="mb-4">
                        <label for="cpassword" class="block font-medium">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="mt-1 p-2 text-black text-xl border border-gray-300 rounded-md w-full">
                       
                    </div>

</div>
<input type="hidden" name="update-btn" value="1">

        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <div class="col-span-2 m-auto">
        <button type="submit" id="update-btn" class="btn btn-primary">Save</button>
        </div>
      
			
		</form>
      </div>
     
    </div>
  </div>
</div>

<!-- <div id="editModal" >

<p>qiowdhqoidqhdioqwhdoiqwho</p>

</div> -->


</div>
		
		

        <script>
// edit
    $(document).ready(function (){
        $('.edit_data').click(function (e) {
            e.preventDefault();

            var user_id = $(this).closest('tr').find('.user_id').text();
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_edit_btn': true,
                    'user_id':user_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#user_id').val(value['id']);
                        $('#old_img_span img').attr('src', 'assets/uploads/' + value['file_img']);
                        $('#oldpass').val(value['password']);
                        $('#oldimg').val(value['file_img']);
                        $('#fname').val(value['fname']);
                        $('#lname').val(value['lname']); 
                        $('#address').val(value['address']);
                        $('#phone').val(value['phone']);  
                        $('#age').val(value['age']); 
                        $('#gender').val(value['gender']); 
                        $('#position').val(value['job_position']); 
                        $('#email').val(value['email']);
                    });
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#staticBackdrop').modal('show');
                }
            });

        });
    });

// delete

       
     
    
</script>  

<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        
<script type="text/javascript">
        new DataTable('#example', {
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    }
});
     </script> -->
 



<?php include"footer.php" ?>

        <!-- <script>
        function openAdminModal(admin) {
            document.getElementById('adminEditId-' + admin.id).value = admin.id;
        
            // Set the values of the form fields to the old values or the current values of the admin
            document.getElementById('name-' + admin.id).value = admin.name;
            document.getElementById('email-' + admin.id).value = admin.email;
        
            // Show the modal
            document.getElementById('adminModal-' + admin.id).classList.remove('hidden');
        }
        
        function closeAdminModal(adminId) {
            // Clear the values of the form fields
            document.getElementById('name-' + adminId).value = '';
            document.getElementById('email-' + adminId).value = '';
        
            // Hide the modal
            document.getElementById('adminModal-' + adminId).classList.add('hidden');
        }
        </script> -->
        <!-- <script>
            $(document).ready(function(){
                var table = $('#example').DataTable({
                    buttons:['copy', 'csv', 'excel', 'pdf', 'print']
                });
            });
        </script>
     -->

    
</body>
</html>