
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
    include 'functions.php';
    $staffId = $_SESSION['id'];
    $staffs = getStaffs($connections);
    $events = getEvent($connections);
    $tools = getTools($connections);
      // Example: Fetching from session
    $staffevents = getEventsByStaffId($connections, $staffId);
   
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



        <div class="bg-white rounded-lg w-6/12 shadow-lg  p-4 mb-4">
                <h1>Clean Up Schedule Calendar</h1>
                    <div class="" id='calendar'></div>
                </div>
				

                <hr />


       
        <div class="flex justify-end m-4">
        <a class="bg-blue-500 text-white font-bold p-1.5 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out" href="calendar.php">Add New</a>
        </div>
        <h1 class="font-bold mb-4 text-xl">Cleanup Events Assigned To You</h1>
        <div class="data_table">
		<table id="example" class="table table-striped hover font-semibold text-lg">
    <thead>
        <tr class="">
        <th class="font-bold" style="display: none;">#</th>
            <th class="font-bold" >Title</th>
            <th class="font-bold">Location</th>
            <th class="font-bold">Tools & Quantity</th>
            
            <th class="font-bold">Assigned Staff</th>
            <th class="font-bold">Status</th>
            <th class="font-bold">Start Date</th>
            <th class="font-bold">End Date</th>
           
            <!-- <th class="font-bold">Action</th> -->
        </tr>
    </thead>
    <tbody>
      
    <?php foreach($staffevents as $staffevent){
        
          
        ?>
            <tr>
            <td class="event_id" style="display: none;"><?php echo $staffevent['id'];?></td>
                <td class="capitalize"><?php echo $staffevent['title'] ?></td>
                <td class="capitalize"><?php echo $staffevent['location'] ?></td>

                
                <td class="capitalize"><?php echo $staffevent['tools'] ?></td>
                
                <td class="capitalize"><?php echo $staffevent['staff']?></td>
                <td class="capitalize"><?php echo $staffevent['status']?></td>
                
                <td class="capitalize"><?php echo $staffevent['start_date'] ?></td>
                <td class="capitalize"><?php echo $staffevent['end_date'] ?></td>
              
                

                <!-- <td class="text-2xl">
                <a href="#" class="text-blue-500 edit1" ><i class="ri-edit-fill"></i></a>
                <a href="code.php?idevent=<?php echo $event['id'];?>" class="text-red-500 hover:text-red-700 delete_data" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
                </td> -->
               
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

                    <div class="tools-container mb-4">
  <label for="tools" class="font-semibold" for="tools">Tools:</label>
  <select class="border border-gray-300 rounded-md" id="tools" name="tools">
    <option value="">-----</option>
  <?php
            if (!empty($tools)) {
                foreach ($tools as $tool) {
                    echo '<option value="' .  $tool['tool_data']['id'] . '">' . $tool["tool_data"]['name'] . '</option>';
                }
            } else {
                echo '<option value="">No data available</option>';
            }
            ?>
          
        </select>
        <label for="quantity">Quantity:</label>
    <input class="border border-gray-300 rounded-md" style="width: 50px;" type="number" name="quantity" id="quantity">

  <button type="button" class="border font-medium px-1.5 rounded-md bg-gray-200" id="add-tool">Add Tool</button>
  <div id="selected-tools" class="mt-4">
    <!-- Selected tools will be displayed here -->
  </div>
</div>




<div class="staffs-container mb-4">
  <label class="font-semibold" for="astaff">Assign Staff:</label>
  <select class="border border-gray-300 rounded-md" id="astaff" name="astaff">
  <option value="">-----</option>
            <?php
            if (!empty($staffs)) {
                foreach ($staffs as $staff) {
                    echo '<option value="' .  $staff['id'] . '">' . $staff['fname'] .' '. $staff['lname'] . '</option>';
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








<!-- <script>
      $('#staticBackdrop').on('shown.bs.modal', function () {
        // JavaScript code that interacts with elements inside the modal
        // Make sure this code runs after the modal is fully shown
        document.getElementById('add-tool').addEventListener('click', function() {
            const select = document.getElementById('dataSelect');
            const quantityInput = document.getElementById('quantity');
            const selectedToolsDiv = document.getElementById('selected-tools');

            const selectedTool = select.options[select.selectedIndex].text;
            const selectedToolId = select.value;
            const quantity = quantityInput.value;

            if (selectedToolId && quantity) {
                // Create a container div for the selected tool
                const toolContainer = document.createElement('div');
                toolContainer.className = 'selected-tool';
                toolContainer.innerHTML = `
                    <span class="font-medium">Tool: ${selectedTool}, Quantity: ${quantity}</span>
                    <input type="hidden" name="tools[]" value="${selectedToolId}">
                    <input type="hidden" name="quantities[]" value="${quantity}">
                    <span class="remove-tool bg-red-200 p-1 rounded-md cursor-pointer">Remove</span>
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
    });
       
    </script> -->

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



<!-- Button trigger modal -->


<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

<?php include"footer.php" ?>


<script>

$(document).ready(function () {
    $('.edit1').click(function (e) {
        e.preventDefault();

        var event_id = $(this).closest('tr').find('.event_id').text();

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'event_edit_btn': true,
                'event_id': event_id,
            },
            success: function (response) {
                if (response.length > 0 && response[0].id) {
                    $('#event_id').val(response[0]['id']);
                    $('#title').val(response[0]['title']);
                    $('#location').val(response[0]['location']);
                    $('#start_date').val(response[0]['start_date']);
                    $('#end_date').val(response[0]['end_date']);
                    
                    // Clear existing selected tools
                    $('#selected-tools').empty();
                    $('#selected-staffs').empty();

                    // Populate tools
                    response.forEach(function(item) {
    if (item['tool_id']) {
        // Check if the tool already exists in the container
        let existingTool = $('#selected-tools').find(`div[data-tool-id="${item['tool_id']}"]`);

        // If the tool doesn't exist, create and append it
        if (existingTool.length === 0) {
            const toolInfo = document.createElement('div');
            toolInfo.classList.add('tool-info');
            toolInfo.setAttribute('data-tool-id', item['tool_id']);
            toolInfo.setAttribute('data-quantity', item['quantity']);
            
            const toolText = document.createElement('div');
            toolText.className = 'selected-tool';
            toolText.innerHTML = `<span>Tool: ${item['tool_name']}, Quantity: ${item['quantity']}</span>
            <input type="hidden" name="tools[]" value="${item['tool_id']}">
            <input type="hidden" name="quantities[]" value="${item['quantity']}">
            `;

            const removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.classList.add('remove-tool');
            removeButton.addEventListener('click', function() {
                toolInfo.remove();
            });

            toolInfo.appendChild(toolText);
            toolInfo.appendChild(removeButton);
            $('#selected-tools').append(toolInfo);
        }
    }
});

                    // Populate staffs
                    const uniqueStaffs = [];
                    response.forEach(function(item) {
                        if (item['staff_id'] && !uniqueStaffs.includes(item['staff_id'])) {
                            uniqueStaffs.push(item['staff_id']);
                            const staffInfo = document.createElement('div');
                            staffInfo.classList.add('staff-info');
                            staffInfo.setAttribute('data-staff-id', item['staff_id']);
                            
                            const staffText = document.createElement('div');
                            staffText.className = 'selected-staff';
                            staffText.innerHTML = `<span>Staff: ${item['fname']} ${item['lname']}</span>
                            <input type="hidden" name="astaff[]" value="${item['staff_id']}">
                            `;
                            
                            const removeButton = document.createElement('button');
                            removeButton.textContent = 'Remove';
                            removeButton.classList.add('remove-staff');
                            removeButton.addEventListener('click', function() {
                                staffInfo.remove();
                            });
                            
                            staffInfo.appendChild(staffText);
                            staffInfo.appendChild(removeButton);
                            $('#selected-staffs').append(staffInfo);
                        }
                    });

                    $('#staticBackdrop').modal('show');
                } else {
                    alert('No record found!');
                }
            }
        });
    });

    document.getElementById('add-tool').addEventListener('click', function() {
        const select = document.getElementById('tools');
        const quantityInput = document.getElementById('quantity');
        const selectedToolsDiv = document.getElementById('selected-tools');

        const selectedTool = select.options[select.selectedIndex].text;
        const selectedToolId = select.value;
        const quantity = quantityInput.value;

        if (selectedToolId && quantity) {
            // Create a container div for the selected tool
            const toolContainer = document.createElement('div');
            toolContainer.className = 'selected-tool';
            toolContainer.innerHTML = `
                <span class="font-medium">Tool: ${selectedTool}, Quantity: ${quantity}</span>
                <input type="hidden" name="tools[]" value="${selectedToolId}">
                <input type="hidden" name="quantities[]" value="${quantity}">
                <span class="remove-tool">Remove</span>
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
        const select = document.getElementById('astaff');
        const selectedStaffsDiv = document.getElementById('selected-staffs');

        const selectedStaff = select.options[select.selectedIndex].text;
        const selectedStaffId = select.value;
        

        if (selectedStaffId) {
            // Create a container div for the selected staff
            const staffContainer = document.createElement('div');
            staffContainer.className = 'selected-staff';
            staffContainer.innerHTML = `
                <span class="font-medium mt-2">Assigned Staff: ${selectedStaff}</span>
                <input type="hidden" name="astaff[]" value="${selectedStaffId}">
                <span class="remove-staff">Remove</span>
            `;
            selectedStaffsDiv.appendChild(staffContainer);

            // Add event listener to the remove button
            staffContainer.querySelector('.remove-staff').addEventListener('click', function() {
                selectedStaffsDiv.removeChild(staffContainer);
            });

            // Clear the selection and input
            select.selectedIndex = '';
        } else {
            alert('Please select a staff.');
        }
    });
});
</script>







<style>
    .remove-tool {
    background-color: #ff4d4d; /* Red background */
    color: white; /* White text */
    border: none; /* No border */
    padding: 5px 10px; /* Padding */
    margin-left: 10px; /* Space between text and button */
    cursor: pointer; /* Pointer cursor on hover */
    border-radius: 5px; /* Rounded corners */
}

.remove-tool:hover {
    background-color: #ff1a1a; /* Darker red on hover */
}
.remove-staff {
    background-color: #ff4d4d; /* Red background */
    color: white; /* White text */
    border: none; /* No border */
    padding: 5px 10px; /* Padding */
    margin-left: 10px; /* Space between text and button */
    cursor: pointer; /* Pointer cursor on hover */
    border-radius: 5px; /* Rounded corners */
}

.remove-staff:hover {
    background-color: #ff1a1a; /* Darker red on hover */
}
  </style>












        <script>
// edit
// $(document).ready(function () {
//     $('.edit_data').click(function (e) {
//         e.preventDefault();

//         var event_id = $(this).closest('tr').find('.event_id').text();

//         $.ajax({
//             method: "POST",
//             url: "code.php",
//             data: {
//                 'event_edit_btn': true,
//                 'event_id': event_id,
//             },
//             success: function (response) {
//                 if (response.length > 0 && response[0].id) {
//                     $('#event_id').val(response[0]['id']);
//                     $('#title').val(response[0]['title']);
//                     $('#location').val(response[0]['location']);
//                     $('#start_date').val(response[0]['start_date']);
//                     $('#end_date').val(response[0]['end_date']);
                    
//                     // Clear existing selected tools
//                     $('#selected-tools').empty();

//                     response.forEach(function(item) {
//                         if (item['tool_id']) {
//                             const toolInfo = document.createElement('div');
//                             toolInfo.classList.add('tool-info');
//                             toolInfo.setAttribute('data-tool-id', item['tool_id']);
//                             toolInfo.setAttribute('data-quantity', item['quantity']);
                            
//                             const toolText = document.createElement('span');
//                             toolText.textContent = `Tool: ${item['tool_name']}, Quantity: ${item['quantity']}`;
                            
//                             const removeButton = document.createElement('button');
//                             removeButton.textContent = 'Remove';
//                             removeButton.classList.add('remove-tool');
//                             removeButton.addEventListener('click', function() {
//                                 toolInfo.remove();
//                             });
                            
//                             toolInfo.appendChild(toolText);
//                             toolInfo.appendChild(removeButton);
//                             $('#selected-tools').append(toolInfo);
//                         }
//                     });

//                     // Populate staff
//                     if (response[0]['fname'] && response[0]['lname']) {
//                         const staffFullName = response[0]['fname'] + ' ' + response[0]['lname'];
//                         $('#astaff').val(staffFullName);
//                     }

//                     $('#staticBackdrop').modal('show');
//                 } else {
//                     alert('No record found!');
//                 }
//             }
//         });
//     });

    // $('#add-tool').click(function() {
    //     const select = $('#tools');
    //     const quantityInput = $('#quantity');
    //     const selectedToolsDiv = $('#selected-tools');

    //     const selectedTool = select.find('option:selected').text();
    //     const selectedToolId = select.val();
    //     const quantity = quantityInput.val();

    //     if (selectedToolId && quantity) {
    //         const toolInfo = document.createElement('div');
    //         toolInfo.textContent = `Tool: ${selectedTool}, Quantity: ${quantity}`;
    //         toolInfo.setAttribute('data-tool-id', selectedToolId);
    //         toolInfo.setAttribute('data-quantity', quantity);
    //         selectedToolsDiv.append(toolInfo);

    //         // Optionally clear the selection and input
    //         select.prop('selectedIndex', 0);
    //         quantityInput.val('');
    //     } else {
    //         alert('Please select a tool and enter a quantity.');
    //     }
    // });
// });


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

     <!-- <script>
    function initializeModalFunction() {
        document.getElementById('add-tool').addEventListener('click', function() {
            const select = document.getElementById('tools');
            const quantityInput = document.getElementById('quantity');
            const selectedToolsDiv = document.getElementById('selected-tools');

            const selectedTool = select.options[select.selectedIndex].text;
            const selectedToolId = select.value;
            const quantity = quantityInput.value;

            if (selectedToolId && quantity) {
                // Create a container div for the selected tool
                const toolContainer = document.createElement('div');
                toolContainer.className = 'selected-tool';
                toolContainer.innerHTML = `
                    <span class="font-medium">Tool: ${selectedTool}, Quantity: ${quantity}</span>
                    <input type="hidden" name="tools[]" value="${selectedToolId}">
                    <input type="hidden" name="quantities[]" value="${quantity}">
                    <span class="remove-tool bg-red-200 p-1 rounded-md cursor-pointer">Remove</span>
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
    }

    $('#staticBackdrop').on('shown.bs.modal', function () {
        initializeModalFunction();
    });
</script> -->
</body>
</html>