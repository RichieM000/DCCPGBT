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
    }

    $requestStatus = $notExpired ? 'in progress' : $task['status'];

    if ($requestStatus === 'in progress' && $task['status'] !== 'in progress') {
        $sql = "UPDATE tbl_request SET status = ? WHERE id = ?";
        $stmt = $connections->prepare($sql);
        $stmt->bind_param("si", $requestStatus, $task['id']);
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
    <div>
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
                <!-- <th class="font-bold">Actions</th> -->
               
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
                <td><?php echo $task['firstname'] ?></td>
                <td><?php echo $task['lastname'] ?></td>
                <td><?php echo $task['address'] ?></td>
                <td><?php echo $task['phone'] ?></td>
                <td><?php echo $task['email'] ?></td>
                <td><?php echo $task['gender'] ?></td>
                <td><?php echo $task['reason'] ?></td>
                <td><?php echo $task['comments'] ?></td>
                <td class="whitespace-nowrap capitalize" style="color: <?php 
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

      

        


                <!-- <td class="py-4 px-6 text-2xl whitespace-nowrap flex justify-center gap-2">

                <?php  if($task['status'] == 'pending'){ ?>

                    <form action="code.php" method="POST" id="myForm">
                        <input type="hidden" name="action" value="in progress">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <button type="submit" value="submit" name="confirmrequest" onclick="return confirm('Add this to event schedule?')" class="text-blue-500 hover:text-blue-700"><i class="ri-add-box-fill"></i></button>
                </form>
                    
                <?php }?>


                  
                <?php if($task['status'] == 'in progress') {?>
                    <form action="code.php" method="POST" id="myForm">
                        <input type="hidden" name="action" value="complete">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <button type="submit" name="completerequest" class="text-blue-500 hover:text-blue-700" onclick="return confirm('Confirm Request?')"><i class="ri-checkbox-circle-fill"></i></button>
                </form>
                <?php }?>

               <a href="code.php?id=<?php echo $task['id'];?>" class="text-red-500 hover:text-red-700 delete_data" onclick="return confirm('Are you sure you want to delete this data?')"><i class="ri-delete-bin-fill"></i></a>
                </td> -->
               
            </tr>
          <?php }?>
        </tbody>
    </table>
    </div>


   
  
    </div>

		
	
		
		<?php include"footer.php" ?>
		
        </div>
        <!-- <script>
         new DataTable('#example');
        </script> -->
</body>
</html>