
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
    include 'functions.php';
    $events = getEvent($connections);

  
   
?>
 
  
  




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
        <div class="flex justify-end m-4">
        <a class="bg-blue-500 text-white font-bold p-1.5 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out" href="calendar.php">Add New</a>
        </div>

        <div class="data_table">
		<table id="example" class="table table-striped hover font-semibold text-lg">
    <thead>
        <tr class="">
        <th class="font-bold" style="display: none;">#</th>
            <th class="font-bold" >Title</th>
            <th class="font-bold">Location</th>
            <th class="font-bold">Tools & Quantity</th>
            
            <th class="font-bold">Assigned Staff</th>
            <th class="font-bold">Start Date</th>
            <th class="font-bold">End Date</th>
           
            <th class="font-bold">Action</th>
        </tr>
    </thead>
    <tbody>
      
    <?php foreach($events as $event){
        
          
        ?>
            <tr>
            <td class="event_id" style="display: none;"><?php echo $event['id'];?></td>
                <td class="capitalize"><?php echo $event['title'] ?></td>
                <td class="capitalize"><?php echo $event['location'] ?></td>

                
                <td class="capitalize"><?php echo $event['tools'] ?></td>
                
                <td class=""><?php echo $event['staff']?></td>
                
                <td class="capitalize"><?php echo $event['start_date'] ?></td>
                <td class="capitalize"><?php echo $event['end_date'] ?></td>
              
                

                <td class="text-2xl">
                <a href="#" class="text-blue-500 edit_data"><i class="ri-edit-fill"></i></a>
               <button class="text-red-500 hover:text-red-700 delete_data" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></button>
                </td>
               
            </tr>
          <?php }?>
           
        
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Clean Up Event</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="code.php" method="POST">

      <input type="hidden" name="id" id="event_id" value="">
					<div class="mb-4">
                        <label for="title" class="block font-medium">Even Title</label>
                        <input type="text" name="title" id="title" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="location" class="block font-medium">Location</label>
                        <input type="text" name="location" id="location" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>

                    <div class="mb-4">
            <label for="tools" class="block font-medium">Tools</label>
            <div id="tagsContainer" class="flex items-center flex-wrap p-1 border border-gray-300 rounded-md">
                <input type="text" id="tagInput" name="tools[]" class="flex-grow p-2 text-black text-xl capitalize border-none outline-none" placeholder="Add tools" autocomplete="off">
            </div>
                    </div>
					<!-- <div class="mb-4">
                        <label for="tools" class="block font-medium">Tools</label>
                        <input type="text" data-role="tagsinput" name="tools" id="tools" class="tools mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full">
                    </div> -->
                    <div class="mb-4">
            <label for="astaff" class="block font-medium">Assign Staff</label>
            <div id="staffContainer" class="flex items-center flex-wrap p-1 border border-gray-300 rounded-md">
                <input type="text" id="astaff" name="astaff[]" class="flex-grow p-2 text-black text-xl capitalize border-none outline-none" placeholder="Assign Staff" autocomplete="off">
            </div>
                    </div>
					<!-- <div class="mb-4">
                        <label for="astaff" class="block font-medium">Assign Staff</label>
                        <input type="text" name="astaff" id="astaff" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div> -->

                    <div class="grid grid-cols-2 gap-4 mb-4">

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-input block w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-input block w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                        </div>

                        </div>
                        <input type="hidden" name="updateevent" value="1">
					<div class="flex justify-center">
					<button type="submit" name="updateevent" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Save</button>
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

<?php include"footer.php" ?>

        <script>
// edit
    $(document).ready(function (){
        $('.edit_data').click(function (e) {
            e.preventDefault();

            var event_id = $(this).closest('tr').find('.event_id').text();
            

            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'event_edit_btn': true,
                    'event_id':event_id,
                },
                success: function (response){

                    $.each(response, function(Key, value){
                        $('#event_id').val(value['id']);
                        
                        $('#title').val(value['title']);
                        $('#location').val(value['location']);
                        $('#tagInput').val(value['tools']);
                        $('#astaff').val(value['fname'] + ' ' + value['lname']);
                        $('#start_date').val(value['start_date']);
                        $('#end_date').val(value['end_date']);  
                        
                       
                    });
                  
                    // console.log(response);
                    // $('.view_user_data').html(response);
                    $('#staticBackdrop').modal('show');
                }
            });

        });
    });

// delete

       $(document).ready(function (){
        $('.delete_data').click(function(e){
            e.preventDefault();
            // console.log('hello');
         var event_id = $(this).closest('tr').find('.event_id').text();

         $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'event_delete_btn': true,
                'id':event_id
            },
            success: function(response){
                window.location.reload();
            }
         });

        });
       });

     
    
</script>  


<script>
$('#staticBackdrop').on('shown.bs.modal', function () {
    // Example list of autocomplete suggestions
    var availableTags = [
        "Hammer",
        "Saw",
        "Drill",
        "Wrench",
        "Screwdriver",
        "Pliers",
        "Tape Measure",
        "Level",
        "Utility Knife",
        "Flashlight"
    ];

    $("#tagInput").autocomplete({
        source: availableTags,
        select: function(event, ui) {
            event.preventDefault();
            let tagText = ui.item.value.trim();
            if (tagText) {
                $('#tagsContainer').prepend('<span class="tag">' + tagText + '<span class="remove">x</span><input type="hidden" name="tools[]" value="' + tagText + '"></span>');
                $(this).val('');
            }
        },
        focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
        },
        minLength: 0 // Allow showing suggestions even if no characters are typed
    }).focus(function() {
        // Trigger search event to show all suggestions on focus
        $(this).autocomplete("search", "");
    });

    $('#tagInput').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            let tagText = $(this).val().trim();
            if (tagText) {
                $('#tagsContainer').prepend('<span class="tag">' + tagText + '<span class="remove">x</span><input type="hidden" name="tools[]" value="' + tagText + '"></span>');
                $(this).val('');
            }
        }
    });

    $(document).on('click', '.tag .remove', function() {
        $(this).parent().remove();
    });
});
</script>


<script>
    $('#staticBackdrop').on('shown.bs.modal', function () {

    $(document).ready(function() {
        // Fetch staff names from the server
        $.ajax({
            url: 'fetched.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var availableTags = data;

                $("#astaff").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        event.preventDefault();
                        let tagText = ui.item.value.trim();
                        let staffId = ui.item.id; // Get staff ID from autocomplete suggestion
                        if (tagText) {
                            $('#staffContainer').prepend('<span class="tag">' + tagText + '<span class="remove">x</span><input type="hidden" name="astaff[]" value="' + staffId + '"></span>');
                            $(this).val('');
                        }
                    },
                    focus: function(event, ui) {
                        event.preventDefault();
                        $(this).val(ui.item.value);
                    },
                    minLength: 0 // Allow showing suggestions even if no characters are typed
                }).focus(function() {
                    // Trigger search event to show all suggestions on focus
                    $(this).autocomplete("search", "");
                });

                $('#astaff').on('keypress', function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        let tagText = $(this).val().trim();
                        if (tagText) {
                            $('#staffContainer').prepend('<span class="tag">' + tagText + '<span class="remove">x</span><input type="hidden" name="astaff[]" value="' + tagText + '"></span>');
                            $(this).val('');
                        }
                    }
                });

                $(document).on('click', '.tag .remove', function() {
                    $(this).parent().remove();
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    });
});
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