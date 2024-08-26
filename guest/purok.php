<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
require_once 'functions.php';

$puroklist = getPurok($connections);

?>




<body class="page-body  page-left-in font-sans" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
            <h1 class="font-bold text-2xl text-center">Purok List</h1>
		
		</div>
		
		<hr />

  <style>
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button{
        -webkit-appearance: none;
      }
  </style>


    <div>
	<div class="flex justify-end m-4">
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Add Purok
</button>
        </div>
<div class="data_table">
    <table id="example" class="table hover table-striped font-semibold text-lg" style="width:100%">
        <thead>
            <tr>
            <th class="font-bold" style="display: none;">#</th>
				<th class="font-bold">Purok</th>
        <th class="font-bold">Population</th>
                
                <th class="font-bold">Actions</th>
                
               
            </tr>
        </thead>
        <tbody>
			<?php foreach($puroklist as $purok){ ?>
         <tr>
		 <td class="purok_id" style="display: none;"><?php echo $purok['purok'];?></td>
			<td class="capitalize"><?php echo $purok['purok'] ?></td>
      <td class="capitalize"><?php echo $purok['population'] ?></td>
			<td class="text-2xl">
                <a href="#" data-purok-id="<?php echo $purok['id']; ?>" class="text-blue-500 edit_purok"><i class="ri-edit-fill"></i></a>
                <a href="code.php?idtool=<?php echo $purok['id'];?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
                </td>
		 </tr>
		 <?php }?>
        </tbody>
    </table>
    </div>


   
  
    </div>
<!-- Add Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Purok</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

      

					<div class="mb-4">
                        <label for="prkname" class="block font-medium">Purok Name</label>
                        <input type="text" name="prkname" id="prkname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="population" class="block font-medium">Population</label>
                        <input type="text" name="population" id="population" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					

                 
                        <input type="hidden" name="addpurok" value="1">
					<div class="flex justify-center">
					<button type="submit" name="addpurok" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>
<script>
document.getElementById('population').addEventListener('input', function(e) {
    let value = e.target.value.replace(/,/g, '');

    // Ensure only numbers are allowed
    if (/^\d*$/.test(value)) {
        // Format the number with commas
        e.target.value = parseInt(value, 10).toLocaleString();
    } else {
        e.target.value = value.replace(/\D/g, '');
    }
});
</script>




<!-- Edit Modal -->
<div class="modal fade" id="editpurok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editpurokLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editpurokLabel">Edit Purok</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" id="purok_id">

					<div class="mb-4">
                        <label for="prkname" class="block font-medium">Purok Name</label>
                        <input type="text" name="prkname" id="prkname1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="population" class="block font-medium">Population</label>
                        <input type="text" name="population" id="population1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
                    

                 
                        <input type="hidden" name="updatepurok" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updatepurok" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>

<script>
  $(document).ready(function (){
        $('.edit_purok').click(function (e) {
            e.preventDefault();

            var purok_id = $(this).data('purok-id');
            
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'purok_edit_btn': true,
                    'purok_id':purok_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#purok_id').val(value['id']);
                      
                        $('#prkname1').val(value['purok']);
                        $('#population1').val(value['population']);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#editpurok').modal('show');
                }
            });

        });
    });



</script>

<script>
document.getElementById('population1').addEventListener('input', function(e) {
    let value = e.target.value.replace(/,/g, '');

    // Ensure only numbers are allowed
    if (/^\d*$/.test(value)) {
        // Format the number with commas
        e.target.value = parseInt(value, 10).toLocaleString();
    } else {
        e.target.value = value.replace(/\D/g, '');
    }
});
</script>



		
<?php include "footer.php" ?>
		
		
		
        
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>


</html>