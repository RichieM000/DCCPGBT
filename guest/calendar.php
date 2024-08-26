

<!DOCTYPE html>
<html lang="en">


<?php
    include 'functions.php';
    $staffs = getStaffs($connections);
    $staffList = getUsers($connections);
    $events = getEvent($connections);
    $tools = getTools($connections); // assuming $connections is your database connection
$availableTags = array_column(array_map(function($tool) {
    return $tool['tool_data'];
}, $tools), 'name');
?>

<?php include "header.php"?>

<body class="page-body" data-url="http://neon.dev">
<style>
      .tag {
    display: inline-flex;
    align-items: center;
    background-color: #60a5fa;
    color: white;
    border-radius: 5px;
    padding: 0 8px;
    margin: 2px;
}

.tag .remove {
    margin-left: 4px;
    cursor: pointer;
}
    </style>
     <style>
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button{
        -webkit-appearance: none;
      }
  </style>

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default-->
	
<?php include"sidebar.php"?>

		<div class="sidebar-menu-inner">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="index.php">
						
					</a>
				</div>
<div class="main-content">
               
		



    
    

			</header>
			<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            <?php foreach($events as $event): ?>
            {
                title: "<?php echo $event['title']; ?>",
                start: "<?php echo $event['start_date']; ?>",
                end: "<?php echo $event['end_date']; ?>",
                url: "activities.php"
            },
            <?php endforeach; ?>
        ]
    });
    calendar.render();
});
</script>

			<div class="w-full flex gap-4 p-4">

				<div class="w-6/12 bg-white shadow-lg p-4 rounded-lg overflow-auto" style="max-height: 700px;">
					<h1 class="mb-4 text-xl font-bold">Add Event</h1>
					<form action="code.php" method="POST">
                    

                <input type="hidden" name="requestid" value="">

					<div class="mb-4">
                        <label for="title" class="block font-medium">Even Title</label>
                        <input type="text" name="title" id="title" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
					<div class="mb-4">
                        <label for="location" class="block font-medium">Location</label>
                        <input type="text" name="location" id="location" class="mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full" required>
                    </div>
    <div class="tools-container mb-4">
    <label class="font-semibold" for="tools">Tools:</label>
<select class="border border-gray-300 rounded-md" id="dataSelect" name="dataSelect" onchange="updateQuantity()">
    <?php
    if (!empty($tools)) {
        foreach ($tools as $tool) {
            echo '<option value="' .  $tool['tool_data']['id'] . '" data-quantity="' . $tool['tool_data']['quantity'] . '">' . $tool["tool_data"]['name'] . '</option>';
        }
    } else {
        echo '<option value="">No data available</option>';
    }
    ?>
</select>

<label for="quantity">Quantity:</label>
<input class="border border-gray-300 rounded-md" style="width: 50px;" type="number" name="quantity" id="quantity" value="">


<script>
function updateQuantity() {
    var selectElement = document.getElementById("dataSelect");
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var quantity = selectedOption.getAttribute("data-quantity");

    // Update the quantity input field with the selected tool's default quantity
    var quantityInput = document.getElementById("quantity");
    quantityInput.value = quantity;
    quantityInput.max = quantity;  // Set the maximum value for the input field
}

// Initialize the quantity input field with the quantity of the first tool in the dropdown
window.onload = function() {
    updateQuantity();
};
</script>




  <button type="button" class="border font-medium px-1.5 rounded-md bg-gray-200" id="add-tool">Add Tool</button>
  <div id="selected-tools" class="mt-4">
    <!-- Selected tools will be displayed here -->
  </div>
</div>

<div class="staffs-container mb-4">
  <label class="font-semibold" for="staff">Assign Staff:</label>
  <select class="border border-gray-300 rounded-md" id="staff" name="astaff">
            <?php
            if (!empty($staffs)) {
                foreach ($staffs as $staff) {
                    echo '<option value="' .  $staff['id'] . '">' . $staff['fname'] . '</option>';
                }
            } else {
                echo '<option value="">No data available</option>';
            }
            ?>
        </select>
     

  <button type="button" class="border font-medium px-1.5 rounded-md bg-gray-200" id="add-staff">Add Staff</button>
  <div id="selected-staffs" class="mt-4">
    <!-- Selected tools will be displayed here -->
  </div>
</div>



<!-- 
                    <div class="mb-4">
            <label for="tools" class="block font-medium">Tools</label>
            <div id="tagsContainer" class="flex items-center flex-wrap p-1 border border-gray-300 rounded-md">
                <input type="text" id="tagInput" name="tools[]" class="flex-grow p-2 text-black text-xl capitalize border-none outline-none" placeholder="Add tools" autocomplete="off">
            </div>
                    </div> -->
					<!-- <div class="mb-4">
                        <label for="tools" class="block font-medium">Tools</label>
                        <input type="text" data-role="tagsinput" name="tools" id="tools" class="tools mt-1 p-2 text-black text-xl capitalize border border-gray-300 rounded-md w-full">
                    </div> -->







                    <!-- <div class="mb-4">
            <label for="astaff" class="block font-medium">Assign Staff</label>
            <div id="staffContainer" class="flex items-center flex-wrap p-1 border border-gray-300 rounded-md">
                <input type="text" id="astaff" name="astaff[]" class="flex-grow p-2 text-black text-xl capitalize border-none outline-none" placeholder="Assign Staff" autocomplete="off">
            </div>
                    </div> -->
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
                

</body>


	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
	
  
	
	<!-- Imported styles on this page -->
	<!-- <link rel="stylesheet" href="assets/css/bootstrap-tagsinput.css"> -->
	
	
	

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<!-- <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script> -->
	
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/fullcalendar-2/fullcalendar.min.js"></script>
	<script src="assets/js/neon-calendar-2.js"></script>
	<script src="assets/js/neon-chat.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<?php
	if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
		?>

		<script>

		swal({
		title: "<?php echo $_SESSION['status']; ?>",
		
		icon: "<?php echo $_SESSION['status_code']; ?>",
		button: "Okay!",
		});
			</script>

		<?php
		unset($_SESSION['status']);
	}

	?>
	
	


	<!-- JavaScripts initializations and stuff -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
	<script src="assets/js/neon-custom.js"></script>

	<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
	<script src="assets/js/bootstrap-tagsinput.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

	<!-- <script type="text/javascript">
					$("#tools").tagsinput({
						autocomplete:{
							source: ['red', 'blue', 'green'],
							delay:100
						},
						showAutocompleteOnFocus: true
					});
				</script> -->

                <script>
       document.getElementById('add-tool').addEventListener('click', function() {
    const select = document.getElementById('dataSelect');
    const quantityInput = document.getElementById('quantity');
    const selectedToolsDiv = document.getElementById('selected-tools');

    const selectedTool = select.options[select.selectedIndex].text;
    const selectedToolId = select.value;
    const quantity = quantityInput.value;
    const maxQuantity = select.options[select.selectedIndex].getAttribute('data-quantity');

    if (selectedToolId && quantity) {
        if (quantity > maxQuantity) {
            alert(`Quantity exceeds the maximum limit of ${maxQuantity}.`);
            return;
        }

        // Create a container div for the selected tool
        const toolContainer = document.createElement('div');
        toolContainer.className = 'selected-tool';
        toolContainer.innerHTML = `
            <span class="font-medium mb-8">Tool: ${selectedTool}, Quantity: ${quantity}</span>
            <input type="hidden" name="tools[]" value="${selectedToolId}">
            <input type="hidden" name="quantities[]" value="${quantity}">
            <span class="remove-tool"><i class="ri-close-fill"></i></span>
        `;
        selectedToolsDiv.appendChild(toolContainer);

        // Add event listener to the remove button
        toolContainer.querySelector('.remove-tool').addEventListener('click', function() {
            selectedToolsDiv.removeChild(toolContainer);
        });

        // Clear the selection and input
        select.selectedIndex = '';
        quantityInput.value = '';
    } else {
        alert('Please select a tool and enter a quantity.');
    }
});

        document.getElementById('add-staff').addEventListener('click', function() {
            const select = document.getElementById('staff');
            // const quantityInput = document.getElementById('quantity');
            const selectedStaffsDiv = document.getElementById('selected-staffs');

            const selectedStaff = select.options[select.selectedIndex].text;
            const selectedStaffId = select.value;
            

            if (selectedStaffId) {
                // Create a container div for the selected tool
                const toolContainer = document.createElement('div');
                toolContainer.className = 'selected-staffs';
                toolContainer.innerHTML = `
                    <span class="font-medium mt-2">Assigned Staff: ${selectedStaff}</span>
                    <input type="hidden" name="astaff[]" value="${selectedStaffId}">
                    
                    <span class="remove-tool"><i class="ri-close-fill"></i></span>
                `;
                selectedStaffsDiv.appendChild(toolContainer);

                // Add event listener to the remove button
                toolContainer.querySelector('.remove-tool').addEventListener('click', function() {
                    selectedStaffsDiv.removeChild(toolContainer);
                });

                // Clear the selection and input
                select.selectedIndex = '';
                // quantityInput.value = '';
            } else {
                alert('Please select a tool and enter a quantity.');
            }
        });
    </script>

<style>
    .remove-tool {
    background-color: #ff4d4d; /* Red background */
    text-align: center;
    color: white; /* White text */
    border: none; /* No border */
    padding: 2px 4px ;/* Padding */
    margin-left: 10px; /* Space between text and button */
    cursor: pointer; /* Pointer cursor on hover */
    border-radius: 100%; /* Rounded corners */
}

.remove-tool:hover {
    background-color: #ff1a1a; /* Darker red on hover */
}
  </style>

<!-- <script>
    $(document).ready(function() {
  // 1. Get Tool Data from Database:
  $.ajax({
    url: 'code.php', // Replace with your script URL
    type: 'POST',
    data: { action: 'get_tools' },
    success: function(response) {
      var toolsData = JSON.parse(response);
      // 2. Create Autocomplete for Tools:
      $('#tools').autocomplete({
        source: toolsData,
        select: function(event, ui) {
          // 3. Handle Tool Selection:
          addSelectedTool(ui.item.value);
          $('#tools').val(''); // Clear the input field
          return false;
        }
      });
    }
  });

  // 4. Handle "Add Tool" Button:
  $('#add-tool').click(function() {
    var toolName = $('#tools').val();
    if (toolName) {
      addSelectedTool(toolName);
      $('#tools').val(''); // Clear the input field
    }
  });

  // 5. Add Selected Tool Function:
  function addSelectedTool(toolName) {
    // Get the quantity of the tool selected
    var toolQuantity = prompt("Enter quantity for " + toolName + ":");
    if (toolQuantity) {
      // Append to Selected Tools:
      $('#selected-tools').append(`
        <div class="selected-tool">
          <span class="tool-name">${toolName}</span>
          <input type="number" class="quantity" value="${toolQuantity}" min="1">
          <button type="button" class="remove-tool">Remove</button>
        </div>
      `);
    }
  }

  // 6. Remove Tool Functionality:
  $(document).on('click', '.remove-tool', function() {
    $(this).closest('.selected-tool').remove();
  });
});
</script> -->


                
<!-- fetching tools -->
                <!-- <script>
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
</script> -->

<!-- fetching staff -->
<script>
//    $(document).ready(function() {
//     var availableTags = <?php echo json_encode($staffList);?>;

//     $("#astaff").autocomplete({
//         source: availableTags,
//         select: function(event, ui) {
//             event.preventDefault();
//             let tagText = ui.item.value.trim();
//             let staffId = ui.item.id; // Get staff ID from autocomplete suggestion
//             if (tagText) {
//                 $('#staffContainer').prepend('<span class="tag">' + tagText + '<span class="remove">x</span><input type="hidden" name="astaff[]" value="' + staffId + '"></span>');
//                 $(this).val('');
//             }
//         },
//         focus: function(event, ui) {
//             event.preventDefault();
//             $(this).val(ui.item.value);
//         },
//         minLength: 0 // Allow showing suggestions even if no characters are typed
//     }).focus(function() {
//         // Trigger search event to show all suggestions on focus
//         $(this).autocomplete("search", "");
//     });

//     $('#astaff').on('keypress', function(e) {
//         if (e.which == 13) {
//             e.preventDefault();
//             let tagText = $(this).val().trim();
//             if (tagText) {
//                 $('#staffContainer').prepend('<span class="tag">' + tagText + '<span class="remove">x</span><input type="hidden" name="astaff[]" value="' + tagText + '"></span>');
//                 $(this).val('');
//             }
//         }
//     });

//     $(document).on('click', '.tag .remove', function() {
//         $(this).parent().remove();
//     });
// });
</script>



</html>

