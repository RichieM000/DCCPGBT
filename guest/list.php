<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
require_once 'functions.php';

// Assuming you have a function to get the ID from the database
// Example: Fetching the ID from the database
$events = getEvent($connections);
$volunteers = getVolunteer($connections);

?>



<body class="page-body  page-left-in font-sans" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
            <h1 class="font-bold text-2xl text-center">List of Volunteers</h1>
		
		</div>
		
		<hr />
  
		<div>
	<div class="flex justify-end m-4">
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addvolunteer">
  Add Volunteer
</button>
        </div>
<div class="data_table">
    <table id="example" class="table hover table-striped font-semibold text-lg" style="width:100%">
        <thead>
            <tr>
            <th class="font-bold" style="display: none;">#</th>
				<th class="font-bold">Firstname</th>
                <th class="font-bold">Lastname</th>
                <th class="font-bold">Gender</th>
				<th class="font-bold">Contact #</th>
				<th class="font-bold">Address</th>
				<th class="font-bold">Cleanup Joined</th>
                <!-- <th class="font-bold">Actions</th> -->
                
               
            </tr>
        </thead>
        <tbody>
        <?php foreach($volunteers as $volunteer){ ?>
          <tr>
			
                <td class="list_id" style="display: none;"><?php echo $volunteer['id'] ?></td>
				<td><?php echo $volunteer['firstname']; ?></td>
				<td><?php echo $volunteer['lastname']; ?></td>
				<td><?php echo $volunteer['gender']; ?></td>
				<td><?php echo $volunteer['contact']; ?></td>
				<td><?php echo $volunteer['address']; ?></td>
				<td><?php echo $volunteer['title']; ?></td>
       
              
    <!-- <td class="text-2xl">
                <a href="#" class="text-blue-500 edit_list"><i class="ri-edit-fill"></i></a>
                <a href="code.php?idlist=<?php echo $volunteer['id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
                </td> -->

			
          </tr>
          <?php } ?>	
        </tbody>
    </table>
    </div>


   
  
    </div>
<!-- Add Modal -->
<div class="modal fade" id="addvolunteer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addvolunteerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addvolunteerLabel">Add Volunteer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

      
	
					<div class="mb-4">
                        <label for="firstname" class="block font-medium">Firstname</label>
                        <input type="text" name="firstname" id="firstname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="lastname" class="block font-medium">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
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
                        <label for="contact" class="block font-medium">Contact #</label>
                        <input type="text" name="contact" id="contact" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" maxlength="11" required>
                    </div>
					<div class="mb-4">
                        <label for="address" class="block font-medium">Address</label>
                        <input type="text" name="address" id="address" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

					<div class="mb-4">
                        <label for="cleanup" class="block font-medium">Cleanup Joined</label>
                        <select name="cleanup" id="cleanup" class="mt-1 p-2 text-black border border-gray-300 rounded-md w-full" required>
							<?php foreach($events as $event){ ?>
                            <option value="<?php echo $event['id'] ?>"><?php echo $event['title'] ?></option>
                            
							<?php } ?>
                        </select>
                    </div>

                 
                        <input type="hidden" name="addvolunteer" value="1">
					<div class="flex justify-center">
					<button type="submit" name="addvolunteer" class="bg-blue-500 rounded-md py-1.5 px-6 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>





<!-- Edit Modal -->
<div class="modal fade" id="editlist" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editlistLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editlistLabel">Edit Tools</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" id="edit-form" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="id" id="list_id">

      <div class="mb-4">
                        <label for="firstname" class="block font-medium">Firstname</label>
                        <input type="text" name="firstname" id="firstname1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="lastname" class="block font-medium">Lastname</label>
                        <input type="text" name="lastname" id="lastname1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="gender" class="block font-medium">Gender</label>
                        <select name="gender" id="gender1" class="mt-1 p-2 text-black border border-gray-300 rounded-md w-full" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
					</div>
					<div class="mb-4">
                        <label for="contact" class="block font-medium">Contact #</label>
                        <input type="text" name="contact" id="contact1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" maxlength="11" required>
                    </div>
					<div class="mb-4">
                        <label for="address" class="block font-medium">Address</label>
                        <input type="text" name="address" id="address1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

					<div class="mb-4">
                        <label for="cleanup" class="block font-medium">Cleanup Joined</label>
                        <select name="cleanup" id="cleanup1" class="mt-1 p-2 text-black border border-gray-300 rounded-md w-full" required>
							<?php foreach($events as $event){ ?>
                            <option value="<?php echo $event['id'] ?>"><?php echo $event['title'] ?></option>
                            
							<?php } ?>
                        </select>
                    </div>
                 
                        <input type="hidden" name="updatevolunteer" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updatevolunteer" class="bg-blue-500 rounded-md py-1.5 px-6 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>

<script>
  $(document).ready(function (){
        $('.edit_list').click(function (e) {
            e.preventDefault();

            var list_id = $(this).closest('tr').find('.list_id').text();
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'list_edit_btn': true,
                    'list_id':list_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#list_id').val(value['id']);
                   
                        $('#firstname1').val(value['firstname']);
                        $('#lastname1').val(value['lastname']);
                        $('#gender1').val(value['gender']);
                        $('#contact1').val(value['contact']);
                        $('#address1').val(value['address']);
                        $('#cleanup1').val(value['eventsched_id']);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#editlist').modal('show');
                }
            });

        });
    });
</script>

		
	
		
		<?php include"footer.php" ?>
		
        </div>
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>
</html>