<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
require_once 'functions.php';

// Assuming you have a function to get the ID from the database
// Example: Fetching the ID from the database

$completes = completeEvent($connections);
$cleaned = cleanedPurok($connections);

?>



<body class="page-body  page-left-in font-sans" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
            <h1 class="font-bold text-2xl text-center">Cleaned Purok</h1>
		
		</div>
		
		<hr />



		
  
	<div class="grid grid-cols-4 gap-4">

	<?php foreach($completes as $complete){ ?>
		<div class="bg-white shadow-md pt-4 px-4 rounded-md">

		<div>
			<h1 class="font-semibold"><span class="font-bold">Title:</span> <?php echo $complete['title'] ?></h1>
			<p class="font-semibold"><span class="font-bold">Location:</span> <?php echo $complete['location'] ?></p>
			<p class="font-semibold"><span class="font-bold">Status:</span> <?php echo $complete['status'] ?></p>
			<p class="font-semibold"><span class="font-bold">Date Completed:</span> <?php echo $complete['date'] ?></p>
		</div>
		<div class="my-4 flex justify-between">
		<button class="bg-red-500 p-2 text-white font-semibold rounded-md">Cancel</button>
			<a href="" data-complete-id="<?php echo $complete['id']; ?>" class="bg-blue-500 p-2 text-white font-semibold rounded-md edit_complete">Add To the record</a>
			
		</div>

		</div>
		<?php } ?>
	</div>

<div>
	<div class="data_table">
    <table id="example" class="table hover table-striped font-semibold text-lg" style="width:100%">
        <thead>
            <tr>
            
				<th class="font-bold">Purok</th>
                <th class="font-bold">Date</th>
                <th class="font-bold">Paper</th>
                <th class="font-bold">Glass</th>
				<th class="font-bold">Organic</th>
                <th class="font-bold">Plastic</th>
				<th class="font-bold">Total Waste</th>
                <th class="font-bold">Actions</th>
                
               
            </tr>
        </thead>
			<tbody>
			<?php foreach($cleaned as $clean){ ?>
			<tr>
				<td><?php echo $clean['purok'] ?></td>
				<td><?php echo date('Y-m-d', strtotime($clean['date'])); ?></td>
				<td><?php echo $clean['paper'] ?></td>
				<td><?php echo $clean['glass'] ?></td>
				<td><?php echo $clean['organic'] ?></td>
				<td><?php echo $clean['plastic'] ?></td>
				<td><?php echo $clean['totalwaste'] ?></td>

				<td class="text-2xl">
                <a href="#" data-clean-id="<?php echo $clean['id']; ?>" class="text-blue-500 edit_clean"><i class="ri-edit-fill"></i></a>
                <a href="code.php?idclean=<?php echo $clean['id'];?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
                </td>
				
			</tr>

			</tbody>
			<?php } ?>
        
    </table>
    </div>

	</div>


<!-- add -->
	<div class="modal fade" id="addrecord" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addrecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addrecordLabel">Add To Record</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="id" id="complete_id">
	  <input type="hidden" name="action" value="done">
	
					<div class="mb-4">
                        <label for="purok" class="block font-medium">Purok</label>
                        <input type="text" name="purok" id="purok" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="date" class="block font-medium">Date</label>
                        <input type="date" name="date" id="date" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

					<div class="grid grid-cols-4 gap-4">

					<div class="mb-4">
                        <label for="paper" class="block font-medium">Paper</label>
                        <input type="text" name="paper" id="paper" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>

					<div class="mb-4">
                        <label for="glass" class="block font-medium">Glass</label>
                        <input type="text" name="glass" id="glass" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>

					<div class="mb-4">
                        <label for="organic" class="block font-medium">Organic</label>
                        <input type="text" name="organic" id="organic" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>

					<div class="mb-4">
                        <label for="plastic" class="block font-medium">Plastic</label>
                        <input type="text" name="plastic" id="plastic" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>
			
					</div>

				

                        <input type="hidden" name="submitclean" value="1">
					<div class="flex justify-center">
					<button type="submit" name="submitclean" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>



<!-- edit -->
<div class="modal fade" id="editrecord" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editrecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editrecordLabel">Add To Record</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="id" id="clean_id">
	  <input type="hidden" name="action" value="done">
	
					<div class="mb-4">
                        <label for="purok" class="block font-medium">Purok</label>
                        <input type="text" name="purok" id="purok1" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="date" class="block font-medium">Date</label>
                        <input type="date" name="date" id="date1" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

					<div class="grid grid-cols-4 gap-4">

					<div class="mb-4">
                        <label for="paper" class="block font-medium">Paper</label>
                        <input type="text" name="paper" id="paper1" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>

					<div class="mb-4">
                        <label for="glass" class="block font-medium">Glass</label>
                        <input type="text" name="glass" id="glass1" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>

					<div class="mb-4">
                        <label for="organic" class="block font-medium">Organic</label>
                        <input type="text" name="organic" id="organic1" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>

					<div class="mb-4">
                        <label for="plastic" class="block font-medium">Plastic</label>
                        <input type="text" name="plastic" id="plastic1" value="" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full waste">
                    </div>
			
					</div>

				

                        <input type="hidden" name="updateclean" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updateclean" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>










	<script>
    document.querySelectorAll('.waste').forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/,/g, '');

            // Ensure only numbers are allowed
            if (/^\d*$/.test(value)) {
                // Format the number with commas
                e.target.value = value ? parseInt(value, 10).toLocaleString() : '';  // If empty, don't add commas
            } else {
                e.target.value = value.replace(/\D/g, '');
            }

            // Calculate the total waste
            
        });
    });

  
</script>





	<script>
  $(document).ready(function (){
        $('.edit_complete').click(function (e) {
            e.preventDefault();

            var complete_id = $(this).data('complete-id');
            
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'complete_edit_btn': true,
                    'complete_id':complete_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#complete_id').val(value['request_id']);
                      
                        $('#purok').val(value['location']);
                        

						var date = value['date'].split(' ')[0]; // Get the 'YYYY-MM-DD' part
        
       					 $('#date').val(date);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#addrecord').modal('show');
                }
            });

        });
    });



</script>

<script>
  $(document).ready(function (){
        $('.edit_clean').click(function (e) {
            e.preventDefault();

            var clean_id = $(this).data('clean-id');
            
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'clean_edit_btn': true,
                    'clean_id':clean_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#clean_id').val(value['id']);
                      
                        $('#purok1').val(value['purok']);
                        $('#paper1').val(value['paper']);
                        $('#glass1').val(value['glass']);
                        $('#organic1').val(value['organic']);
                        $('#plastic1').val(value['plastic']);

						var date = value['date'].split(' ')[0]; // Get the 'YYYY-MM-DD' part
        
       					 $('#date1').val(date);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#editrecord').modal('show');
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