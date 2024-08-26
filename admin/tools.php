<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
require_once 'functions.php';

$tools = getTools($connections);

?>




<body class="page-body  page-left-in font-sans" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
            <h1 class="font-bold text-2xl text-center">Tools</h1>
		
		</div>
		
		<hr />

    
    <div>
	<div class="flex justify-end m-4">
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Add Tools
</button>
        </div>

<div class="data_table">
    <table id="example" class="table hover table-striped font-semibold text-lg" style="width:100%">
        <thead>
            <tr>
            <th class="font-bold" style="display: none;">#</th>
				<th class="font-bold">Image</th>
                <th class="font-bold">Name</th>
                <th class="font-bold">Quantity</th>
                <th class="font-bold">Actions</th>
                
               
            </tr>
        </thead>
        <tbody>
          <?php foreach($tools as $tool){ ?>
          <tr>
            
          <td class="tool_id" style="display: none;"><?php echo $tool['tool_data']['id'];?></td>
          <td><img src="<?php echo $tool['image_src']; ?>" alt="Profile Image" width="50" height="50" class="rounded-full"></td>
          <td class="capitalize"><?php echo $tool['tool_data']['name']; ?></td>
          <td><?php echo $tool['tool_data']['quantity']; ?></td>
              
    <td class="text-2xl">
                <a href="#" class="text-blue-500 edit_tool"><i class="ri-edit-fill"></i></a>
                <a href="code.php?idtool=<?php echo $tool['tool_data']['id'];?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Tools</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

      
	  <div class="">
    <label for="" class="text-xl">Tool Image:</label>
    <input type="file" name="img" id="img" accept="image/*" onchange="loadAddFile(event)">
    <div class="m-auto overflow-hidden rounded-full bg-gray-200 w-32 h-32">
       <span id="old_img_span"> <img src="<?php echo isset($avatar)? 'assets/uploads/'.$avatar :'assets/uploads/no_image.jpg'?>" id="cimg" class="w-full h-full bg-contain rounded-full"></span>
      
       
    </div>
    
    
    <script>
function loadAddFile(event) {
    var image = document.getElementById('cimg');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.onload = function() {
        URL.revokeObjectURL(image.src); // free memory
    }
}
</script>
</div>
					<div class="mb-4">
                        <label for="toolname" class="block font-medium">Tool Name</label>
                        <input type="text" name="toolname" id="toolname" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="quantity" class="block font-medium">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

                 
                        <input type="hidden" name="submittools" value="1">
					<div class="flex justify-center">
					<button type="submit" name="submittools" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>





<!-- Edit Modal -->
<div class="modal fade" id="edittool" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edittoolLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="edittoolLabel">Edit Tools</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" id="edit-form" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="id" id="tool_id">

	  <div class="">
    
    <label for="" class="text-xl">Tool Image:</label>
    <input type="file" name="img" id="img" accept="image/*" onchange="loadFile(event)">
    <div class="m-auto overflow-hidden rounded-full bg-gray-200 w-32 h-32">
       <span id="old_img_span"> <img src="<?php echo isset($avatar)? 'assets/uploads/'.$avatar :'assets/uploads/no_image.jpg'?>" id="editimg" class="w-full h-full bg-contain rounded-full"></span>
      
    </div>
    <input type="hidden" name="old_img" id="old_img" value="<?php echo isset($avatar)? $avatar :''?>">
    
    <script>
function loadFile(event) {
    var image = document.getElementById('editimg');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.onload = function() {
        URL.revokeObjectURL(image.src); // free memory
    }
}
</script>
</div>
					<div class="mb-4">
                        <label for="toolname" class="block font-medium">Tool Name</label>
                        <input type="text" name="toolname" id="toolname1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="quantity" class="block font-medium">Quantity</label>
                        <input type="number" name="quantity" id="quantity1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

                 
                        <input type="hidden" name="updatetools" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updatetools" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>

<script>
  $(document).ready(function (){
        $('.edit_tool').click(function (e) {
            e.preventDefault();

            var tool_id = $(this).closest('tr').find('.tool_id').text();
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'tool_edit_btn': true,
                    'tool_id':tool_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#tool_id').val(value['id']);
                          
                        $('#old_img_span img').attr('src', 'assets/uploads/' + value['image']); 
                        $('#oldimg').val(value['image']);
                        $('#toolname1').val(value['name']);
                        $('#quantity1').val(value['quantity']);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#edittool').modal('show');
                }
            });

        });
    });
</script>





		
<?php include "footer.php" ?>
		
		
		
        
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>


</html>