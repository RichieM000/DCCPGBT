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

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        
    });
    calendar.render();
});
</script>
    
			<div class="w-full flex gap-4 p-4">

				<div class="w-6/12 bg-white shadow-lg p-4 rounded-lg overflow-auto" style="max-height: 700px;">
					<h1 class="mb-4 text-xl font-bold">Add Event</h1>
					<form action="code.php" method="POST">
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

					
					<button type="submit" name="submitevent" class="bg-blue-500 rounded-md py-1.5 px-2 text-white font-semibold">Add Event</button>
					</form>
				</div>

			
			<div class="bg-white rounded-lg w-6/12 shadow-lg  p-4">
                <h1>Clean Up Schedule</h1>
                    <div class="" id='calendar'></div>
                </div>
				

				</div>
                
                

                <div class="data_table">
    <table id="example" class="table hover table-striped font-semibold text-lg" style="width:100%">
        <thead>
            <tr>
                <th class="font-bold">Firstname</th>
                <th class="font-bold">Lastname</th>
                <th class="font-bold">Address</th>
                <th class="font-bold">Phone</th>
                <th class="font-bold">Email</th>
                <th class="font-bold">Gender</th>
                <th class="font-bold">Reason</th>
                <th class="font-bold">Comments</th>
                <th class="font-bold">Status</th>
                <th class="font-bold">Actions</th>
               
            </tr>
        </thead>
        <tbody>
            
            <tr>
              
              <td>asdasd</td>
              <td>asdasd</td>
              <td>asdasd</td>
              <td>adadss</td>
              <td>ssssssaa</td>
              <td>asdsad</td>
              <td></td>
               
            </tr>

        </tbody>
    </table>
    </div>
    
    <?php include "footer.php" ?>

	<!-- <script type="text/javascript">
					$("#tools").tagsinput({
						autocomplete:{
							source: ['red', 'blue', 'green'],
							delay:100
						},
						showAutocompleteOnFocus: true
					});
				</script> -->

<!-- fetching tools -->

<!-- <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
  <script src="assets/js/bootstrap-tagsinput.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script> -->

<script>
    $(document).ready(function() {
    // Example list of autocomplete suggestions
    var availableTags = <?php echo json_encode($availableTags); ?>;


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
   $(document).ready(function() {
    var availableTags = <?php echo json_encode($staffList);?>;

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
});
</script>





</div>




		

		
		
		
        
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>


</html>