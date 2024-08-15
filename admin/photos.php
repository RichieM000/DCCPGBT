<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
// Include your database connection file
include('connections.php');
require_once 'functions.php';

// Initialize the album ID
$albumId = null;

// Check if 'id' query parameter is set
if (isset($_GET['id'])) {
    $albumId = $_GET['id'];

    // Fetch album details from the database
    $query = "SELECT * FROM tbl_album WHERE id = ?";
    if ($stmt = $connections->prepare($query)) {
        $stmt->bind_param("i", $albumId);
        $stmt->execute();
        $result = $stmt->get_result();
        $album = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo "Error: " . $connections->error;
        exit;
    }

    // Fetch images related to the specified album
    $images = getImages($connections, $albumId);
} else {
    echo "No album ID provided.";
    exit;
}
?>




<body class="page-body  page-left-in font-sans" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
            <div>
            <a href="doc.php" class="font-semibold text-white text-lg px-4 py-1.5 bg-blue-500 rounded-md">Back</a>
            </div>
            <h1 class="font-bold text-2xl text-center">Documentation/Report</h1>
		
		</div>
		
		<hr />

		
    <div>

        <div class="mb-8">
        <h1 class="text-xl font-bold mt-2"><?php echo $album['album_title']; ?></h1>
        <p class="text-gray-600 font-semibold mt-1"><?php echo $album['album_descrip']; ?></p>
        <?php
        // Convert the date and time format
        $originalDateTime = $album['created_at'];
        $dateTime = new DateTime($originalDateTime);
        $formattedDateTime = $dateTime->format('F j, Y g:i A');
        ?>
        <p class="text-gray-600 text-sm mt-1"><?php echo $formattedDateTime; ?></p>
        </div>

        <form action="code.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="album_id" value="<?php echo $_GET['id']; ?>"> <!-- Hidden field for album ID -->

    <div class="">
        <label for="img" class="text-lg">Insert New Image:</label>
        <input type="file" name="img" id="img" accept="image/*" onchange="loadAddFile(event)">
        <div class="overflow-hidden rounded-full bg-gray-200 w-32 h-32">
            <span id="old_img_span">
            <img src="<?php echo isset($avatar1) ? 'assets/uploads/' . $avatar1 : 'assets/uploads/no_image.jpg'?>" id="cimg_insert" class="w-full h-full bg-contain rounded-full">
            </span>
        </div>
    </div>

    <button type="submit" name="submit_image" id="submitimg" class="bg-blue-500 text-white px-2 py-1.5 rounded mt-2 hover:cursor-not-allowed" disabled>Upload Image</button>
</form>



<!-- edit -->
<div class="modal fade" id="editphoto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editphotoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editphotoLabel">Edit Album</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

	  <input type="hidden" name="id" id="image_id">
      <input type="hidden" name="album_id" value="<?php echo $_GET['id']; ?>">

      
	  <div class="">
    <label for="" class="text-xl">Photo:</label>
    <input type="file" name="img" id="img" accept="image/*" onchange="loadFileEdit(event)">
    <div class="m-auto overflow-hidden rounded-full bg-gray-200 w-32 h-32">
       <span id="img_span"> <img src="<?php echo isset($avatar)? 'assets/uploads/'.$avatar :'assets/uploads/no_image.jpg'?>" id="cimg_edit" class="w-full h-full bg-contain rounded-full"></span>
      
       
    </div>
    <input type="hidden" name="old_img" id="img_old" value="<?php echo isset($avatar)? $avatar :''?>">
    
    <script>
function loadFileEdit(event) {
    var image = document.getElementById('cimg_edit');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.onload = function() {
        URL.revokeObjectURL(image.src); // free memory
    }
}
</script>
</div>
			
                 
                        <input type="hidden" name="updatephoto" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updatephoto" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>





<script>
function loadAddFile(event) {
    var image = document.getElementById('cimg_insert');
    var submitButton = document.getElementById('submitimg');
    var fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        image.src = URL.createObjectURL(fileInput.files[0]);
        image.onload = function() {
            URL.revokeObjectURL(image.src); // free memory
        }
        submitButton.disabled = false; // Enable button
        submitButton.style.cursor = 'pointer'; // Set cursor to pointer
    } else {
        image.src = 'assets/uploads/no_image.jpg';
        submitButton.disabled = true; // Disable button if no file is selected
        submitButton.style.cursor = 'not-allowed'; // Set cursor to not-allowed
    }
}

// Ensure the button is disabled if the file input is cleared
document.getElementById('img').addEventListener('change', function(event) {
    var submitButton = document.getElementById('submitimg');
    if (!event.target.files.length) {
        submitButton.disabled = true;
        submitButton.style.cursor = 'not-allowed'; // Set cursor to not-allowed
    } else {
        submitButton.disabled = false;
        submitButton.style.cursor = 'pointer'; // Set cursor to pointer
    }
});
</script>

    </div>
    <div class="mt-8 mb-28">
        <h1 class="font-bold text-lg text-center">IMAGES</h1>

        <div class="p-28 m-4 shadow-lg rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3">
        <?php foreach($images as $image){ ?>
            <div class="flex flex-col items-center">
        <img src="<?php echo $image['image_src']; ?>" alt="Album Cover" class="w-48 h-48 shadow-xl cursor-pointer rounded-lg hover:scale-110 transition duration-300 ease-in-out">
        <div class="text-2xl mt-3">
            <a href="" class="edit_image text-blue-500" data-image-id="<?php echo $image['album_data']['id']; ?>"><i class="ri-pencil-fill"></i></a>   
            <a href="code.php?idimage=<?php echo $image['album_data']['id']; ?>&albumid=<?php echo $albumId; ?>" onclick="return confirm('Are you sure you want to delete this image?')" class="text-red-500"><i class="ri-delete-bin-2-fill"></i></a>
        </div> 
    </div>
        <?php }?>
    </div>
        </div>

    </div>

    <script>
   $(document).ready(function (){
        $('.edit_image').click(function (e) {
            e.preventDefault();

            var image_id = $(this).data('image-id');
            
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'image_edit_btn': true,
                    'image_id':image_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#image_id').val(value['id']);
                      
                        $('#img_span img').attr('src', 'assets/uploads/' + value['image']); 
                        $('#imgold').val(value['image']);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#editphoto').modal('show');
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