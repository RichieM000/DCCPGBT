<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
require_once 'functions.php';

// Assuming you have a function to get the ID from the database
// Example: Fetching the ID from the database
$userTasks = getUserRequest($connections);
$events = getEvent($connections);

// Convert events to an associative array for quick lookup by request ID
$eventsByRequestId = [];
foreach ($events as $event) {
    $eventsByRequestId[$event['request_id']] = $event['end_date'];
}

$currentDate = new DateTime(); // Current date

// Check and update status for each task
foreach ($userTasks as $task) {
    $endDate = isset($eventsByRequestId[$task['id']]) ? new DateTime($eventsByRequestId[$task['id']]) : null;
    
    // Check if the current date is greater than the end date
    $isExpired = $endDate && $currentDate > $endDate;
    $notExpired = $endDate && $currentDate < $endDate;
    
    $requestStatus = $isExpired ? 'Missed the Deadline' : $task['status'];
    
    // Update the status in the database if needed
    if ($requestStatus === 'Missed the Deadline' && $task['status'] !== 'Missed the Deadline') {
        $sql = "UPDATE tbl_request SET status = ? WHERE id = ?";
        $stmt = $connections->prepare($sql);
        $stmt->bind_param("si", $requestStatus, $task['id']);
        $stmt->execute();
        $stmt->close();
    }elseif ($notExpired && $task['status'] === 'missed the deadline') {
        // Update the status back to its original text
        $originalStatus = 'in progress'; // assume you have this value stored somewhere
        $sql = "UPDATE tbl_request SET status = ? WHERE id = ?";
        $stmt = $connections->prepare($sql);
        $stmt->bind_param("si", $originalStatus, $task['id']);
        $stmt->execute();
        $stmt->close();
    }

 
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
            <h1 class="font-bold text-2xl text-center">Resident's Request</h1>
		
		</div>
		
		<hr />
    
<div class="data_table">
    <table id="example" class="table hover table-striped font-semibold text-lg">
        <thead>
            <tr>
                <th style="display: none;">#</th>
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
            <?php foreach($userTasks as $task){
                
                // Get the end_date for the current task
            $endDate = isset($eventsByRequestId[$task['id']]) ? new DateTime($eventsByRequestId[$task['id']]) : null;
            
            // Check if the current date is greater than the end date
            $isExpired = $endDate && $currentDate > $endDate;
        
            
            $requestStatus = $isExpired ? 'missed the deadline' : $task['status'];
          
                
                
                ?>
            <tr>
                <td style="display: none;"><?php echo $task['id'] ?></td>
                <td class="capitalize"><?php echo $task['firstname'] ?></td>
                <td class="capitalize"><?php echo $task['lastname'] ?></td>
                <td class="capitalize"><?php echo $task['address'] ?></td>
                <td><?php echo $task['phone'] ?></td>
                <td><?php echo $task['email'] ?></td>
                <td><?php echo $task['gender'] ?></td>
                <td><?php echo $task['reason'] ?></td>
                <td><?php echo $task['comments'] ?></td>
                <td class="whitespace-nowrap capitalize" id="status" style="color: <?php 
    switch ($requestStatus) {
        case 'pending':
            echo 'gray';
            break;
        case 'in progress':
            echo 'blue';
            break;
        case 'complete':
            echo 'green';
            break;
        default:
            echo 'red';
            break;
    }
?>">
    <?php echo $requestStatus ?>
</td>

      

        


<td class="text-2xl">
    <div class="flex gap-2">
        <?php  if($task['status'] == 'pending'){ ?>

        <form action="code.php" method="POST" id="myForm">
            <input type="hidden" name="action" value="in progress">
            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
            <input type="hidden" name="location" value="<?php echo $task['address']; ?>">
            
        <button type="submit" value="submit" name="confirmrequest" onclick="return confirm('Add this to event schedule?')" class="text-blue-500 hover:text-blue-700"><i class="ri-add-box-fill"></i></button>
        </form>

        <?php }?>

        <?php if($task['status'] == 'in progress') {?>
                    <form action="code.php" method="POST" id="myForm">
                        <input type="hidden" name="action" value="complete">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <button type="submit" name="completerequest" class="text-blue-500 hover:text-blue-700" onclick="return confirm('Complete Request?')"><i class="ri-checkbox-circle-fill"></i></button>
                </form>
                <?php }?>

       


            <?php if($task['status'] == 'missed the deadline'){ ?>

            
        <?php } ?>
        <a href="code.php?id=<?php echo htmlspecialchars($task['id']); ?>" class="text-red-500 hover:text-red-700 delete_data" onclick="return confirm('Are you sure you want to delete this data?')">
            <i class="ri-delete-bin-fill"></i>
            </a>
            </div>
        </td>
               
            </tr>
          <?php }?>
        </tbody>
    </table>
    </div>


   
  
    

		<script>
            // Get all elements with the id "status"
const statusElements = document.querySelectorAll('#status');

// Loop through each element
statusElements.forEach((element) => {
  // Get the text content of the element
  const text = element.textContent.trim();

  // Get the delete button
  const confirmButton = element.parentNode.parentNode.querySelector('.confirm_data');
  const completeButton = element.parentNode.parentNode.querySelector('.complete_data');
  const deleteButton = element.parentNode.parentNode.querySelector('.delete_data');

  // Check if the text is "missed the deadline"
 


});
        </script>
	
		
		<?php include"footer.php" ?>
		
        </div>
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>
</html>