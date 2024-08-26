<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
include('connections.php');
require_once 'functions.php';

$albums = getAlbum($connections);


?>




<body class="page-body  page-left-in font-sans" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
	<?php include"sidebar.php"?>

	<div class="main-content">
				
		<div class="row">
		
			 
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
	
		
		
			</div>
            <h1 class="font-bold text-2xl text-center">Documentation/Report</h1>
		
		</div>
		
		<hr />

		
  

        <div class="p-4 w-full">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold">Gallery</h1>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-bs-toggle="modal" data-bs-target="#newalbum">
                    Add New
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
			<?php foreach($albums as $album){
                
                   // Fetch the album ID for the current album in the loop
                    $albumId = $album['album_data']['id'];

                    // Fetch the count of images for this album
                    $imageCount = getAlbumImageCount($albumId, $connections);
                ?>
                <div class="bg-white rounded-lg shadow-md p-4">

                <?php
        // Convert the date and time format
        $originalDateTime = $album['album_data']['created_at'];
        $dateTime = new DateTime($originalDateTime);
        $formattedDateTime = $dateTime->format('F j, Y g:i A');
        ?>
					
                    <a href="photos.php?id=<?php echo $album['album_data']['id']; ?>"><img src="<?php echo $album['image_src']; ?>" alt="Album Cover" class="w-full cursor-pointer rounded-lg hover:scale-105 transition duration-300 ease-in-out"></a>
                    <h2 class="text-xl font-bold mt-2"><?php echo $album['album_data']['album_title']; ?></h2>
                    <p class="text-gray-600 font-semibold mt-1"><?php echo $album['album_data']['album_descrip'] ?></p>
                    <p class="text-gray-600 text-xs mt-1"><?php echo $formattedDateTime; ?></p>
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center">
						<i class="ri-gallery-fill"></i>
                            <span class="ml-2 text-gray-600"><?php echo $imageCount; ?></span>
                        </div>
                        <div class="flex items-center">
						<a href="" class="settings-icon" data-album-id="<?php echo $album['album_data']['id']; ?>"><i class="ri-settings-3-fill"> </i></a>
                        <a href="code.php?idalbum=<?php echo $album['album_data']['id'];?>" class="ml-1" onclick="return confirm('Are you sure you want to delete this album?')"><i class="ri-delete-bin-2-fill"></i></a>
                        </div>
                    </div>
                </div>
				<?php } ?>
              
    </div>











	
<!-- add modal -->
	<div class="modal fade" id="newalbum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newalbumLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="newalbumLabel">Edit Album</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

      
	  <div class="">
    <label for="" class="text-xl"> Album Cover:</label>
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
                        <label for="albumtitle" class="block font-medium">Album Title</label>
                        <input type="text" name="albumtitle" id="albumtitle" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="albumdescription" class="block font-bold">Album Description:</label>
                        <textarea name="albumdescription" id="albumdescription" rows="3" class="form-textarea block w-full mt-1 p-2 border border-gray-300 rounded-md" oninput="updateCharacterCount('albumdescription', 100)"></textarea>
                        <p class="text-sm text-gray-600"><span id="albumdescriptionCount">0</span>/200 characters</p>
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
                 
                        <input type="hidden" name="submitalbum" value="1">
					<div class="flex justify-center">
					<button type="submit" name="submitalbum" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>


<!-- edit album -->
	<div class="modal fade" id="editalbum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editalbumLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editalbumLabel">Edit Album</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST" enctype="multipart/form-data">

	  <input type="hidden" name="id" id="album_id">

      
	  <div class="">
    <label for="" class="text-xl">Album Cover:</label>
    <input type="file" name="img" id="img" accept="image/*" onchange="loadFile(event)">
    <div class="m-auto overflow-hidden rounded-full bg-gray-200 w-32 h-32">
       <span id="old_img_span"> <img src="<?php echo isset($avatar)? 'assets/uploads/'.$avatar :'assets/uploads/no_image.jpg'?>" id="albumimg" class="w-full h-full bg-contain rounded-full"></span>
      
       
    </div>
    <input type="hidden" name="old_img" id="old_img" value="<?php echo isset($avatar)? $avatar :''?>">
    
    <script>
function loadFile(event) {
    var image = document.getElementById('albumimg');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.onload = function() {
        URL.revokeObjectURL(image.src); // free memory
    }
}
</script>
</div>
					<div class="mb-4">
                        <label for="albumtitle" class="block font-medium">Album Title</label>
                        <input type="text" name="albumtitle" id="albumtitle1" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="albumdescription" class="block font-bold">Album Description:</label>
                        <textarea name="albumdescription" id="albumdescription1" rows="3" class="form-textarea block w-full mt-1 p-2 border border-gray-300 rounded-md" oninput="updateCharacterCount('albumdescription', 100)"></textarea>
                        <p class="text-sm text-gray-600"><span id="albumdescriptionCount">0</span>/200 characters</p>
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
                 
                        <input type="hidden" name="updatealbum" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updatealbum" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
                    </div>
					</form>

      </div>
     
    </div>
  </div>
</div>





	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



	<script>
		$(document).ready(function (){
        $('.settings-icon').click(function (e) {
            e.preventDefault();

            var album_id = $(this).data('album-id');
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'album_edit_btn': true,
                    'album_id':album_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#album_id').val(value['id']);
                        $('#old_img_span img').attr('src', 'assets/uploads/' + value['album_img']); 
                        $('#oldimg').val(value['album_img']);
                        $('#albumtitle1').val(value['album_title']);
                        $('#albumdescription1').val(value['album_descrip']);
                      
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#editalbum').modal('show');
                }
            });

        });
    });
	</script>


	<!-- <script>
        $(document).ready(function(){
            $('#settings-icon').click(function(e){
                e.preventDefault();
                $('#edit-popup').removeClass('hidden');
            });

            $('#cancel-button').click(function(){
                $('#edit-popup').addClass('hidden');
            });
        });
    </script> -->
<!-- <script>
$(document).ready(function() {
  // Open modal when clicking on an image
  $('.gallery-item').click(function() {
    var modalId = $(this).data('modal-id');
    var imgSrc = $(this).find('img').attr('src');

    $('#modal-img').attr('src', imgSrc);
    $('#myModal').fadeIn();
  });

  // Close modal when clicking on the close button
  $('.close').click(function() {
    $('#myModal').fadeOut();
  });
});
</script> -->

<!-- <script>
$(document).ready(function() {
    // Open modal when clicking on a gallery item
    $('.gallery-item').click(function() {
        var imgSrc = $(this).find('img').attr('src');
        $('#modal-img').attr('src', imgSrc);
        $('#myModal').fadeIn();
    });

    // Close modal when clicking on the close button
    $('.close').click(function() {
        $('#myModal').fadeOut();
    });

    // Close modal when clicking outside of the modal content
    $(window).click(function(event) {
        if ($(event.target).is('#myModal')) {
            $('#myModal').fadeOut();
        }
    });
});
</script> -->


<?php include "footer.php" ?>
		
		
		
        
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>


</html>