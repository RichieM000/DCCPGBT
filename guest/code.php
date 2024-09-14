<?php
ob_start();
session_start();
require_once 'connections.php';

// $id = $_GET['id'];
// $sql = "SELECT * FROM tbl_staff WHERE id = $id";
// $result = $connections->query($sql);

// if ($result->num_rows > 0) {
//     $admin = $result->fetch_assoc();
//     echo json_encode($admin);
// } else {
//     echo json_encode(['error' => 'No data found']);
// }

// $connections->close();



// residents request submit
if(isset($_POST['submitrequest'])){
    $firstname = ($_POST['firstname']);
    $lastname = ($_POST['lastname']);
    $address = ($_POST['address']);
    $phone = ($_POST['phone']);
    $email = ($_POST['email']);
    $gender = ($_POST['gender']);
    $reason = ($_POST['reason']);
    $comments = ($_POST['comments']);
    $status = "pending";


    $sql = "INSERT INTO tbl_request (firstname, lastname, address, phone, email, gender, reason, comments, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connections->prepare($sql);

    $stmt->bind_param("sssssssss", $firstname, $lastname, $address, $phone, $email, $gender, $reason, $comments, $status);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Request Submitted Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: ../index.php');
        
    } else {
        echo "Error executing statement: " . $stmt->error;
        
    }
}


// submit cleanup schedule
if (isset($_POST['submitevent'])) {
    // Sanitize and retrieve form data
    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
    $staff_ids = $_POST['astaff'];
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $request_id = isset($_POST['requestid']);
    
    $request_id = "";
    $event_id = null; // Initialize event_id

    // Start a transaction
    $connections->begin_transaction();

    try {
        // Insert event data
        $sql = "INSERT INTO tbl_eventsched (request_id, title, location, tools, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)";
        $default_tools = '';
        $stmt = $connections->prepare($sql);
        $stmt->bind_param("isssss", $request_id, $title, $location, $default_tools, $start_date, $end_date);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting event: " . $stmt->error);
        }

        $event_id = $stmt->insert_id;

        // Insert tools data
        if (!empty($tools) && !empty($quantities) && count($tools) == count($quantities)) {
            $sql_tools = "INSERT INTO tbl_event_tools (event_id, tool_id, quantity) VALUES (?, ?, ?)";
            $stmt_tools = $connections->prepare($sql_tools);

            foreach ($tools as $index => $tool_id) {
                $quantity = $quantities[$index];
                if (is_numeric($tool_id) && is_numeric($quantity)) {
                    $tool_id = (int) $tool_id;
                    $quantity = (int) $quantity;
                    $stmt_tools->bind_param("iii", $event_id, $tool_id, $quantity);
                    
                    if (!$stmt_tools->execute()) {
                        throw new Exception("Error inserting tool: " . $stmt_tools->error);
                    }
                     // Update tool quantity in tbl_tools
                     $sql_update_tool = "UPDATE tbl_tools SET quantity = quantity - ? WHERE id = ?";
                     $stmt_update_tool = $connections->prepare($sql_update_tool);
                     $stmt_update_tool->bind_param("ii", $quantity, $tool_id);
 
                     if (!$stmt_update_tool->execute()) {
                         throw new Exception("Error updating tool quantity: " . $stmt_update_tool->error);
                     }
                }
            }
        } else {
            throw new Exception("Tools or quantities data is invalid.");
        }

        // Insert staff-event association
        if (isset($_POST['astaff']) && is_array($_POST['astaff']) && !empty($_POST['astaff'])) {
            // Insert staff-event association
        $sql_staff = "INSERT INTO tbl_event_staff (event_id, staff_id) VALUES (?, ?)";
        $stmt_staff = $connections->prepare($sql_staff);

        foreach ($staff_ids as $staff_id) {
           if (is_numeric($staff_id)) {
               $staff_id = (int) $staff_id; // Cast to integer
               $stmt_staff->bind_param("ii", $event_id, $staff_id);
               if (!$stmt_staff->execute()) {
                   throw new Exception("Error inserting staff: " . $stmt_staff->error);
               }
           } else {
               // Handle the case of invalid staff IDs, e.g., log an error
               // You might also want to display a user-friendly error message
               // to the user.
               echo "Invalid staff ID: " . $staff_id; 
           }
       }

       } else {
            throw new Exception("Please select staff members.");
        }

        // Commit the transaction
        $connections->commit();

        // Success message
        $_SESSION['status'] = "Request Submitted Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: calendar.php');
        
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        $connections->rollback();
        echo "Error: " . $e->getMessage();
    }
}





// edit event

if(isset($_POST['event_edit_btn'])){
    $id = $_POST['event_id'];
    $arrayresult = [];

    $fetch_query = "SELECT e.id, e.title, e.location, e.start_date, e.end_date,
    t.id AS tool_id, t.name AS tool_name, et.quantity,
    s.id AS staff_id, s.fname, s.lname
        FROM tbl_eventsched e 
        LEFT JOIN tbl_event_tools et ON e.id = et.event_id
        LEFT JOIN tbl_tools t ON et.tool_id = t.id
        LEFT JOIN tbl_event_staff es ON e.id = es.event_id 
        LEFT JOIN tbl_staff s ON es.staff_id = s.id
        WHERE e.id='$id'";
    
    $fetch_query_run = mysqli_query($connections, $fetch_query);

    if(mysqli_num_rows($fetch_query_run) > 0){
        while ($row = mysqli_fetch_array($fetch_query_run)){
            array_push($arrayresult, $row);
        }
        
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
        echo '<h4>No record found!</h4>';
    }
}

// update event

if (isset($_POST['updateevent'])) {
    // Sanitize and retrieve form data
    $id = trim($_POST['id']);
    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
    $staff_ids = isset($_POST['astaff']) ? $_POST['astaff'] : [];
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);

    // Start a transaction
    $connections->begin_transaction();

    try {
        // Update event data
        $sql = "UPDATE tbl_eventsched SET title = ?, location = ?, start_date = ?, end_date = ? WHERE id = ?";
        $stmt = $connections->prepare($sql);
        $stmt->bind_param("ssssi", $title, $location, $start_date, $end_date, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error updating event: " . $stmt->error);
        }
        $existing_tools = [];

    

        $sql_delete_staffs = "DELETE FROM tbl_event_staff WHERE event_id = ?";
        $stmt_delete_staffs = $connections->prepare($sql_delete_staffs);
        $stmt_delete_staffs->bind_param("i", $id);

        if (!$stmt_delete_staffs->execute()) {
            throw new Exception("Error deleting staffs: " . $stmt_delete_staffs->error);
        }

    // Update existing tool records for this event
if (!empty($tools) && !empty($quantities) && count($tools) == count($quantities)) {
    $sql_tools = "SELECT * FROM tbl_event_tools WHERE event_id = ?";
    $stmt_tools = $connections->prepare($sql_tools);
    $stmt_tools->bind_param("i", $id);
    $stmt_tools->execute();
    $result_tools = $stmt_tools->get_result();

    $existing_tools = array();
    while ($row = $result_tools->fetch_assoc()) {
        $existing_tools[$row['tool_id']] = $row['quantity'];
    }

    foreach ($tools as $index => $tool_id) {
        $quantity = $quantities[$index];
        if (is_numeric($tool_id) && is_numeric($quantity)) {
            $tool_id = (int)$tool_id;
            $quantity = (int)$quantity;
    
            if (isset($existing_tools[$tool_id])) {
                // Check if the quantity has changed
                if ($existing_tools[$tool_id]!= $quantity) {
                    // Update existing record
                    $sql_update_tool = "UPDATE tbl_event_tools SET quantity =? WHERE event_id =? AND tool_id =?";
                    $stmt_update_tool = $connections->prepare($sql_update_tool);
                    $stmt_update_tool->bind_param("iii", $quantity, $id, $tool_id);
    
                    if (!$stmt_update_tool->execute()) {
                        throw new Exception("Error updating tool: ". $stmt_update_tool->error);
                    }
    
                    // Update tool quantity in tbl_tools
                    $sql_update_tool_quantity = "UPDATE tbl_tools SET quantity = quantity -? +? WHERE id =?";
                    $stmt_update_tool_quantity = $connections->prepare($sql_update_tool_quantity);
                    $stmt_update_tool_quantity->bind_param("iii", $quantity - $existing_tools[$tool_id], $existing_tools[$tool_id], $tool_id);
    
                    if (!$stmt_update_tool_quantity->execute()) {
                        throw new Exception("Error updating tool quantity: ". $stmt_update_tool_quantity->error);
                    }
                }
            } else {
                // Insert new record
                $sql_insert_tool = "INSERT INTO tbl_event_tools (event_id, tool_id, quantity) VALUES (?,?,?)";
                $stmt_insert_tool = $connections->prepare($sql_insert_tool);
                $stmt_insert_tool->bind_param("iii", $id, $tool_id, $quantity);
    
                if (!$stmt_insert_tool->execute()) {
                    throw new Exception("Error inserting tool: ". $stmt_insert_tool->error);
                }
    
                // Update tool quantity in tbl_tools
                $sql_update_tool_quantity = "UPDATE tbl_tools SET quantity = quantity -? WHERE id =?";
                $stmt_update_tool_quantity = $connections->prepare($sql_update_tool_quantity);
                $stmt_update_tool_quantity->bind_param("ii", $quantity, $tool_id);
    
                if (!$stmt_update_tool_quantity->execute()) {
                    throw new Exception("Error updating tool quantity: ". $stmt_update_tool_quantity->error);
                }
            }
        }
    }

    // Remove any tools that were removed from the form
    foreach ($existing_tools as $tool_id => $quantity) {
        if (!in_array($tool_id, $tools)) {
            $sql_delete_tool = "DELETE FROM tbl_event_tools WHERE event_id = ? AND tool_id = ?";
            $stmt_delete_tool = $connections->prepare($sql_delete_tool);
            $stmt_delete_tool->bind_param("ii", $id, $tool_id);

            if (!$stmt_delete_tool->execute()) {
                throw new Exception("Error deleting tool: " . $stmt_delete_tool->error);
            }
            // Add back the quantity to tbl_tools
        $sql_update_tool_quantity = "UPDATE tbl_tools SET quantity = quantity + ? WHERE id = ?";
        $stmt_update_tool_quantity = $connections->prepare($sql_update_tool_quantity);
        $stmt_update_tool_quantity->bind_param("ii", $quantity, $tool_id);

        if (!$stmt_update_tool_quantity->execute()) {
            throw new Exception("Error updating tool quantity: " . $stmt_update_tool_quantity->error);
            }
        }
    }
} elseif (empty($tools) && empty($quantities)) {
    // Remove all tools for this event
    $sql_delete_tools = "DELETE FROM tbl_event_tools WHERE event_id = ?";
    $stmt_delete_tools = $connections->prepare($sql_delete_tools);
    $stmt_delete_tools->bind_param("i", $id);

    if (!$stmt_delete_tools->execute()) {
        throw new Exception("Error deleting tools: " . $stmt_delete_tools->error);
    }
} else {
    throw new Exception("Tools or quantities data is invalid.");
}
       
        

        // Insert new staff records for this event
        if (!empty($staff_ids)) {
            $sql_staff = "INSERT INTO tbl_event_staff (staff_id, event_id) VALUES (?, ?)";
            $stmt_staff = $connections->prepare($sql_staff);

            foreach ($staff_ids as $staff_id) {
                if (is_numeric($staff_id)) {
                    $staff_id = (int)$staff_id;
                    $stmt_staff->bind_param("ii", $staff_id, $id);
                    if (!$stmt_staff->execute()) {
                        throw new Exception("Error inserting staff: " . $stmt_staff->error);
                    }
                } else {
                    throw new Exception("Invalid staff ID: " . $staff_id);
                }
            }
        }

        // Commit the transaction
        $connections->commit();

        // Success message
        $_SESSION['status'] = "Updated Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: activities.php');
        exit;
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        $connections->rollback();
        echo "Error: " . $e->getMessage();
    }
}










// if(isset($_POST['updateevent'])){
//      // Check the form data

//     // Sanitize and retrieve form data
//     $id = ($_POST['id']);
//     $title = ($_POST['title']);
//     $location = ($_POST['location']);
//     $tools = implode(', ', $_POST['tools']);
//     // $staff_ids = $_POST['astaff'];
//     $start_date = ($_POST['start_date']);
//     $end_date = ($_POST['end_date']);

//     $sql = "UPDATE tbl_eventsched SET title =?, location =?, tools =?, start_date =?, end_date =? WHERE id =?";
//     $stmt = $connections->prepare($sql);
//     $stmt->bind_param("sssssi", $title, $location, $tools, $start_date, $end_date, $id);

//     $stmt->execute();

//     $_SESSION['status'] = "Event Updated Successfully!";
//     $_SESSION['status_code'] = "success";
//     header('Location: activities.php');
//     exit;

// }

// delete event
if (isset($_GET['idevent'])) {
    $id = $_GET['idevent'];

    // Start a transaction
    $connections->begin_transaction();

    try {
        // Retrieve the quantities and tools associated with the event
        $fetch_tools_query = "SELECT tool_id, quantity FROM tbl_event_tools WHERE event_id = ?";
        $stmt_fetch_tools = $connections->prepare($fetch_tools_query);
        $stmt_fetch_tools->bind_param("i", $id);
        $stmt_fetch_tools->execute();
        $result_tools = $stmt_fetch_tools->get_result();

        $tools_to_update = [];
        while ($row = $result_tools->fetch_assoc()) {
            $tools_to_update[] = $row;
        }

        // Delete the event data from tbl_event_tools
        $delete_tools_query = "DELETE FROM tbl_event_tools WHERE event_id = ?";
        $stmt_delete_tools = $connections->prepare($delete_tools_query);
        $stmt_delete_tools->bind_param("i", $id);
        if (!$stmt_delete_tools->execute()) {
            throw new Exception("Error deleting from tbl_event_tools: " . $stmt_delete_tools->error);
        }

        // Update tool quantities in tbl_tools
        foreach ($tools_to_update as $tool) {
            $update_tool_query = "UPDATE tbl_tools SET quantity = quantity + ? WHERE id = ?";
            $stmt_update_tool = $connections->prepare($update_tool_query);
            $stmt_update_tool->bind_param("ii", $tool['quantity'], $tool['tool_id']);
            if (!$stmt_update_tool->execute()) {
                throw new Exception("Error updating tool quantity: " . $stmt_update_tool->error);
            }
        }

        // Delete the event data from tbl_event_staff
        $delete_staff_query = "DELETE FROM tbl_event_staff WHERE event_id = ?";
        $stmt_delete_staff = $connections->prepare($delete_staff_query);
        $stmt_delete_staff->bind_param("i", $id);
        if (!$stmt_delete_staff->execute()) {
            throw new Exception("Error deleting from tbl_event_staff: " . $stmt_delete_staff->error);
        }

        // Delete the event data from tbl_eventsched
        $delete_event_query = "DELETE FROM tbl_eventsched WHERE id = ?";
        $stmt_delete_event = $connections->prepare($delete_event_query);
        $stmt_delete_event->bind_param("i", $id);
        if (!$stmt_delete_event->execute()) {
            throw new Exception("Error deleting from tbl_eventsched: " . $stmt_delete_event->error);
        }

        // Commit the transaction
        $connections->commit();

        $_SESSION['status'] = "Deleted successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: activities.php');
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        $connections->rollback();
        $_SESSION['status'] = "Delete Failed: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }
}




// add staff
if (isset($_POST['submit'])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $position = $_POST["position"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
 
    // Check if passwords match
    if ($password != $cpassword) {
        $_SESSION['status'] = "Password does not match!";
        $_SESSION['status_code'] = "error";
        header('Location: addstaff.php');
        exit;
    }
 
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
    // Upload profile image
    $avatar = NULL; // default value
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $target_dir = "assets/uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
 
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
 
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
 
        // Check file size
        if ($_FILES["img"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
 
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }
 
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $avatar = basename($_FILES["img"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Image upload failed";
    }
 
 
    // Insert data into tbl_staff
    $sql = "INSERT INTO tbl_staff (fname, lname, address, phone, age, gender, job_position, email, password, file_img, usertype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connections->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $connections->errno . ") " . $connections->error;
        exit;
    }
 
    $stmt->bind_param("ssssissssss", $fname, $lname, $address, $phone, $age, $gender, $position, $email, $hashed_password, $avatar, $usertype);
    $usertype = "user";
 
    if ($stmt->execute()) {
        $_SESSION['status'] = "Added successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: staff.php');
        
    } else {
        echo "Error executing statement: " . $stmt->error;
        
    }
 }



// edit view
if(isset($_POST['click_edit_btn'])){

    $id = $_POST['user_id'];
    $arrayresult = [];

   $fetch_query = "SELECT * FROM tbl_staff WHERE id='$id'";
   $fetch_query_run = mysqli_query($connections, $fetch_query);

   if(mysqli_num_rows($fetch_query_run) > 0){

    while ($row = mysqli_fetch_array($fetch_query_run)){
        

      array_push($arrayresult, $row);
      header('content-type: application/json');
      echo json_encode($arrayresult);
    }

   }else{
      echo '<h4>No record found!</h4>';
   }
}

// 






// edit save
if (isset($_POST['update-btn'])) {
   $id = $_POST['id']; // assuming you have a hidden input field with the id
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $address = $_POST['address'];
   $phone = $_POST["phone"];
   $age = $_POST['age'];
   $gender = $_POST['gender'];
   $position = $_POST['position'];
   $email = $_POST['email'];

//    if (isset($_POST['old_img'])) {
//       $old_img = $_POST['old_img'];
//   } else {
//       $old_img = '';
//   }



  if (isset($_POST['old_password'])) {
      $old_password = $_POST['old_password'];
  } else {
      $old_password = '';
  }

    // Default to an empty string if 'old_img' is not set
    $old_img = isset($_POST['old_img']) ? $_POST['old_img'] : '';
    
    $avatar = $old_img; // Default to old image if no new image is uploaded

   // Update profile image if uploaded
   if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $target_dir = "assets/uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["img"]["size"] > 500000) { // 500 KB
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        // Generate a unique file name to avoid conflicts
        $uniqueFileName = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueFileName;

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $avatar = $uniqueFileName;
            // Optionally, delete the old image file if a new one is uploaded
            if ($old_img && file_exists($target_dir . $old_img)) {
                unlink($target_dir . $old_img);
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
} else {
    $avatar = $old_img;
}
  
   // Update password if changed
   if (!empty($_POST['password'])) {
       $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   } else {
       $password = $_POST['old_password']; // assuming you have a hidden input field with the old password
   }

    if($avatar != ''){
        $stmt = $connections->prepare("UPDATE tbl_staff SET 
        fname = ?, 
        lname = ?, 
        address = ?,
        phone = ?, 
        age = ?, 
        gender = ?, 
        job_position = ?, 
        email = ?, 
        file_img = ?, 
        usertype = ?, 
        password = ? 
        WHERE id = ?");
$stmt->bind_param("ssssissssssi", $fname, $lname, $address, $phone, $age, $gender, $position, $email, $avatar, $usertype, $password, $id);
    }else{
        $stmt = $connections->prepare("UPDATE tbl_staff SET 
        fname = ?, 
        lname = ?, 
        address = ?,
        phone = ?, 
        age = ?, 
        gender = ?, 
        job_position = ?, 
        email = ?,  
        usertype = ?, 
        password = ? 
        WHERE id = ?");
$stmt->bind_param("ssssisssssi", $fname, $lname, $address, $phone, $age, $gender, $position, $email, $usertype, $password, $id);
    }
   // Prepare and bind
   
   $usertype = "user";
   try {
       $stmt->execute();
       if ($stmt->affected_rows > 0) {
         $_SESSION['status'] = "Updated successfully!";
         $_SESSION['status_code'] = "success";
         header('Location: staff.php');
       } else {
         $_SESSION['status'] = "Update Failed";
         $_SESSION['status_code'] = "error";
         header('Location: staff.php');
       }
   } catch (Exception $e) {
       echo 'Error updating staff data: ' . $e->getMessage();
   }

   $stmt->close();
}



// delete data
if(isset($_GET['idstaff'])){
   $id = $_GET['idstaff'];

   $delete_query = "DELETE FROM tbl_staff WHERE id='$id'";
   $delete_query_run = mysqli_query($connections, $delete_query);

   if($delete_query_run){
      $_SESSION['status'] = "Deleted successfully!";
      $_SESSION['status_code'] = "success";
      header('Location: staff.php');
   }else{
      $_SESSION['status'] = "Delete Failed";
      $_SESSION['status_code'] = "error";
    //   header('Location: staff.php');
     
   }

}

// confirm request
if(isset($_POST['confirmrequest'])){
    $action = $_POST["action"];
    $id = $_POST["id"];

    // Update the status column in the tbl_request table
    $sql = "UPDATE tbl_request SET status = '$action' WHERE id = '$id'"; // Add your WHERE clause here

    if (mysqli_query($connections, $sql)) {
        // Get the updated request ID
         // Get the updated request ID
         $request_id = $id;

         // Store the request ID in a session variable
         $_SESSION['request_id'] = $request_id;

        $_SESSION['status'] = "Request Confirmed! Add this request to the Clean Up Schedule!";
        $_SESSION['status_code'] = "success";
        header('Location: calendar.php');
    } else {
        echo "Error updating status: " . mysqli_error($connections);
    }
}

// complete request
if(isset($_POST['completerequest'])) {
    $action = $_POST['action'];
    $id = $_POST['id'];

    // Start a transaction
    mysqli_begin_transaction($connections);

    // Update the status column in the tbl_request table
    $sql1 = "UPDATE tbl_request SET status = '$action' WHERE id = '$id'";

    // Update the status column in the tbl_eventsched table
    $sql2 = "UPDATE tbl_eventsched SET status = '$action' WHERE request_id = '$id'"; // Assuming the foreign key in tbl_eventsched is request_id

    if (mysqli_query($connections, $sql1) && mysqli_query($connections, $sql2)) {
        // Commit the transaction
        mysqli_commit($connections);
        $_SESSION['status'] = "Request Completed";
        $_SESSION['status_code'] = "success";
        header('Location: request.php');
    } else {
        // Rollback the transaction
        mysqli_rollback($connections);
        echo "Error updating status: " . mysqli_error($connections);
    }
}



// delete request

if(isset($_GET['id'])){
    
    $id = $_GET["id"];

    // Update the status column in the tbl_request table
    $sql = "DELETE FROM tbl_request WHERE id = '$id'"; // Add your WHERE clause here

    if (mysqli_query($connections, $sql)) {
        $_SESSION['status'] = "Delete Success!";
        $_SESSION['status_code'] = "success";
        header('Location: request.php');
    } else {
        echo "Error updating status: " . mysqli_error($connections);
    }
}


// add purok
if(isset($_POST['addpurok'])){

    $purokname = $_POST['prkname'];
    $population = $_POST['population'];

    $sql = "INSERT INTO tbl_purok (purok, population) VALUES (?, ?)";
    $stmt = $connections->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $connections->errno . ") " . $connections->error;
        exit;
    }

    $stmt->bind_param("ss", $purokname, $population);

    if($stmt->execute()){
        $_SESSION['status'] = "Added successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: purok.php');
        
    } else {
        echo "Error executing statement: " . $stmt->error;
        
    }

}
// edit purok

if(isset($_POST['purok_edit_btn'])){
    $id = $_POST['purok_id'];
    $arrayresult = [];

    $fetch_query = "SELECT * FROM tbl_purok WHERE id='$id'";
    $fetch_query_run = mysqli_query($connections, $fetch_query);
 
    if(mysqli_num_rows($fetch_query_run) > 0){
 
     while ($row = mysqli_fetch_array($fetch_query_run)){
         
 
       array_push($arrayresult, $row);
       header('content-type: application/json');
       echo json_encode($arrayresult);
     }
 
    }else{
       echo '<h4>No record found!</h4>';
    }
}
// update purok

if(isset($_POST['updatepurok'])){
    $id = $_POST['id'];
    $purokname = $_POST['prkname'];
    $population = $_POST['population'];

    $stmt = $connections->prepare("UPDATE tbl_purok SET purok=?, population=? WHERE id=?");
    $stmt->bind_param("ssi", $purokname, $population, $id);

    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Updated successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: purok.php');
        } else {
            $_SESSION['status'] = "Update Failed";
            $_SESSION['status_code'] = "error";
            header('Location: purok.php');
        }
    } catch (Exception $e) {
        echo 'Error updating staff data: '. $e->getMessage();
    }

    $stmt->close();
}



// add tools

// Check if the form has been submitted
if (isset($_POST['submittools'])) {

    $toolname = $_POST['toolname'];
    $quantity = $_POST['quantity'];

  // Get the uploaded image
  $avatar = NULL; // default value
   if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
       $target_dir = "assets/uploads/";
       $target_file = $target_dir . basename($_FILES["img"]["name"]);
       $uploadOk = 1;
       $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

       // Check if image file is a actual image or fake image
       $check = getimagesize($_FILES["img"]["tmp_name"]);
       if ($check !== false) {
           $uploadOk = 1;
       } else {
           echo "File is not an image.";
           $uploadOk = 0;
       }

       // Check if file already exists
       if (file_exists($target_file)) {
           echo "Sorry, file already exists.";
           $uploadOk = 0;
       }

       // Check file size
       if ($_FILES["img"]["size"] > 500000) {
           echo "Sorry, your file is too large.";
           $uploadOk = 0;
       }

       // Allow certain file formats
       if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['status'] = "Jpg, PNG, and Jpeg is only allowed to upload";
        $_SESSION['status_code'] = "error";
        header('Location: tools.php');
           $uploadOk = 0;
       }

       // Check if $uploadOk is set to 0 by an error
       if ($uploadOk == 0) {
           echo "Sorry, your file was not uploaded.";
       } else {
           if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
               $avatar = basename($_FILES["img"]["name"]);
           } else {
               echo "Sorry, there was an error uploading your file.";
           }
       }
   } else {
       echo "Image upload failed";
   }


  // Get the other form data
  

  // Insert the data into the database (assuming you have a database connection established)
  
  // Insert data into tbl_tools
  $sql = "INSERT INTO tbl_tools (image, name, quantity) VALUES (?, ?, ?)";
  $stmt = $connections->prepare($sql);
  if (!$stmt) {
      echo "Prepare failed: (" . $connections->errno . ") " . $connections->error;
      exit;
  }

  $stmt->bind_param("ssi", $avatar, $toolname, $quantity);
  

  if ($stmt->execute()) {
      $_SESSION['status'] = "Added successfully!";
      $_SESSION['status_code'] = "success";
      header('Location: tools.php');
      
  } else {
      echo "Error executing statement: " . $stmt->error;
      
  }
}

// edit tools
if(isset($_POST['tool_edit_btn'])){
    $id = $_POST['tool_id'];
    $arrayresult = [];

    $fetch_query = "SELECT * FROM tbl_tools WHERE id='$id'";
    $fetch_query_run = mysqli_query($connections, $fetch_query);
 
    if(mysqli_num_rows($fetch_query_run) > 0){
 
     while ($row = mysqli_fetch_array($fetch_query_run)){
         
 
       array_push($arrayresult, $row);
       header('content-type: application/json');
       echo json_encode($arrayresult);
     }
 
    }else{
       echo '<h4>No record found!</h4>';
    }
}

// update tools
if(isset($_POST['updatetools'])){
    $id = $_POST['id'];
    $toolname = $_POST['toolname'];
    $quantity = $_POST['quantity'];

    $old_img = isset($_POST['old_img'])? $_POST['old_img'] : '';

    // Only update the image column if a new image is uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        // Upload and process the new image
        $target_dir = "assets/uploads/";
        $target_file = $target_dir. basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check!== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["img"]["size"] > 500000) { // 500 KB
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType!= "jpg" && $imageFileType!= "png" && $imageFileType!= "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
        } else {
            // Generate a unique file name to avoid conflicts
            $uniqueFileName = uniqid(). '.'. $imageFileType;
            $target_file = $target_dir. $uniqueFileName;

            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $avatar = $uniqueFileName;
                // Optionally, delete the old image file if a new one is uploaded
                if ($old_img && file_exists($target_dir. $old_img)) {
                    unlink($target_dir. $old_img);
                }
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    } else {
        $avatar = $old_img; // Use the old image if no new image is uploaded
    }

    // Update the database
    if ($avatar != '') {
        $stmt = $connections->prepare("UPDATE tbl_tools SET 
                                        name =?, 
                                        quantity =?, 
                                        image =?                                       
                                        WHERE id =?");

        $stmt->bind_param("sisi", $toolname, $quantity, $avatar, $id);
    } else {
        $stmt = $connections->prepare("UPDATE tbl_tools SET 
                                        name =?, 
                                        quantity =?                                       
                                        WHERE id =?");

        $stmt->bind_param("ssi", $toolname, $quantity, $id);
    }

    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Updated successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: tools.php');
        } else {
            $_SESSION['status'] = "Update Failed";
            $_SESSION['status_code'] = "error";
            header('Location: tools.php');
        }
    } catch (Exception $e) {
        echo 'Error updating staff data: '. $e->getMessage();
    }

    $stmt->close();
}
// delete tools

if(isset($_GET['idtool'])){
    $id = $_GET['idtool'];

    // Get the old image file name from the database
    $stmt = $connections->prepare("SELECT image FROM tbl_tools WHERE id =?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_img = $row['image'];

    // Delete the file from the directory
    $target_dir = "assets/uploads/";
    $target_file = $target_dir. $old_img;
    if (file_exists($target_file)) {
        unlink($target_file);
    }

    // Delete the record from the database
    $stmt = $connections->prepare("DELETE FROM tbl_tools WHERE id =?");
    $stmt->bind_param("i", $id);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Deleted successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: tools.php');
        } else {
            $_SESSION['status'] = "Delete Failed";
            $_SESSION['status_code'] = "error";
            header('Location: tools.php');
        }
    } catch (Exception $e) {
        echo 'Error deleting staff data: '. $e->getMessage();
    }

    $stmt->close();
}




// add album
if(isset($_POST['submitalbum'])){

    $albumtitle = $_POST['albumtitle'];
    $albumdescrip = $_POST['albumdescription'];

  // Get the uploaded image
  $avatar = NULL; // default value
   if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
       $target_dir = "assets/uploads/";
       $target_file = $target_dir . basename($_FILES["img"]["name"]);
       $uploadOk = 1;
       $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

       // Check if image file is a actual image or fake image
       $check = getimagesize($_FILES["img"]["tmp_name"]);
       if ($check !== false) {
           $uploadOk = 1;
       } else {
           echo "File is not an image.";
           $uploadOk = 0;
       }

       // Check if file already exists
       if (file_exists($target_file)) {
           echo "Sorry, file already exists.";
           $uploadOk = 0;
       }

       // Check file size
       if ($_FILES["img"]["size"] > 20000000) { 
        $_SESSION['status'] = "File size is too big";
        $_SESSION['status_code'] = "error";
        $uploadOk = 0;
    }

       // Allow certain file formats
       if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['status'] = "Jpg, PNG, and Jpeg is only allowed to upload";
        $_SESSION['status_code'] = "error";
        header('Location: doc.php');
           $uploadOk = 0;
       }

       // Check if $uploadOk is set to 0 by an error
       if ($uploadOk == 0) {
           echo "Sorry, your file was not uploaded.";
       } else {
           if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
               $avatar = basename($_FILES["img"]["name"]);
           } else {
               echo "Sorry, there was an error uploading your file.";
           }
       }
   } else {
       echo "Image upload failed";
   }


  // Get the other form data
  

  // Insert the data into the database (assuming you have a database connection established)
  
  // Insert data into tbl_tools
  $sql = "INSERT INTO tbl_album (album_img, album_title, album_descrip) VALUES (?, ?, ?)";
  $stmt = $connections->prepare($sql);
  if (!$stmt) {
      echo "Prepare failed: (" . $connections->errno . ") " . $connections->error;
      exit;
  }

  $stmt->bind_param("sss", $avatar, $albumtitle, $albumdescrip);
  

  if ($stmt->execute()) {
      $_SESSION['status'] = "Added successfully!";
      $_SESSION['status_code'] = "success";
      header('Location: doc.php');
      
  } else {
      echo "Error executing statement: " . $stmt->error;
      
  }

}

// edit album
if(isset($_POST['album_edit_btn'])){
    $id = $_POST['album_id'];
    $arrayresult = [];

    $fetch_query = "SELECT * FROM tbl_album WHERE id='$id'";
    $fetch_query_run = mysqli_query($connections, $fetch_query);
 
    if(mysqli_num_rows($fetch_query_run) > 0){
 
     while ($row = mysqli_fetch_array($fetch_query_run)){
         
 
       array_push($arrayresult, $row);
       header('content-type: application/json');
       echo json_encode($arrayresult);
     }
 
    }else{
       echo '<h4>No record found!</h4>';
    }
}
// update album
if(isset($_POST['updatealbum'])){
    $id = $_POST['id'];
    $albumtitle = $_POST['albumtitle'];
    $albumdescrip = $_POST['albumdescription'];

    $old_img = isset($_POST['old_img'])? $_POST['old_img'] : '';

    // Only update the image column if a new image is uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        // Upload and process the new image
        $target_dir = "assets/uploads/";
        $target_file = $target_dir. basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check!== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["img"]["size"] > 20000000) { // 500 KB
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType!= "jpg" && $imageFileType!= "png" && $imageFileType!= "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
        } else {
            // Generate a unique file name to avoid conflicts
            $uniqueFileName = uniqid(). '.'. $imageFileType;
            $target_file = $target_dir. $uniqueFileName;

            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $avatar = $uniqueFileName;
                // Optionally, delete the old image file if a new one is uploaded
                if ($old_img && file_exists($target_dir. $old_img)) {
                    unlink($target_dir. $old_img);
                }
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    } else {
        $avatar = $old_img; // Use the old image if no new image is uploaded
    }

    // Update the database
    if ($avatar != '') {
        $stmt = $connections->prepare("UPDATE tbl_album SET 
                                        album_title =?, 
                                        album_descrip =?, 
                                        album_img =?                                       
                                        WHERE id =?");

        $stmt->bind_param("sssi", $albumtitle, $albumdescrip, $avatar, $id);
    } else {
        $stmt = $connections->prepare("UPDATE tbl_album SET 
                                        album_title =?, 
                                        album_descrip =?                                       
                                        WHERE id =?");

        $stmt->bind_param("ssi", $albumtitle, $albumdescrip, $id);
    }

    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Updated successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: doc.php');
        } else {
            $_SESSION['status'] = "Update Failed";
            $_SESSION['status_code'] = "error";
            header('Location: doc.php');
        }
    } catch (Exception $e) {
        echo 'Error updating staff data: '. $e->getMessage();
    }

    $stmt->close();
}

if(isset($_GET['idalbum'])){
    $id = $_GET['idalbum'];

    // Get the old image file name from the database
    $stmt = $connections->prepare("SELECT album_img FROM tbl_album WHERE id =?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_img = $row['album_img'];

    // Delete the file from the directory
    $target_dir = "assets/uploads/";
    $target_file = $target_dir. $old_img;
    if (file_exists($target_file)) {
        unlink($target_file);
    }

    // Delete the record from the database
    $stmt = $connections->prepare("DELETE FROM tbl_album WHERE id =?");
    $stmt->bind_param("i", $id);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Deleted successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: doc.php');
        } else {
            $_SESSION['status'] = "Delete Failed";
            $_SESSION['status_code'] = "error";
            header('Location: doc.php');
        }
    } catch (Exception $e) {
        echo 'Error deleting staff data: '. $e->getMessage();
    }

    $stmt->close();
}


// add photo
if (isset($_POST['submit_image'])  && !empty($_POST['album_id'])) {
    // Retrieve album ID from the form
    $albumId = $_POST['album_id'];

    // Retrieve image file details
    $image = $_FILES['img']['name'];
    $uploadDir = 'assets/uploads/';
    $uploadFile = $uploadDir . basename($image);

    // Validate and move the uploaded file to the upload directory
    if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
        // Prepare the SQL query to insert the image into the new table
        $query = "INSERT INTO tbl_images (album_id, image) VALUES (?, ?)";

        // Prepare and execute the statement
        if ($stmt = $connections->prepare($query)) {
            $stmt->bind_param("is", $albumId, $image);
            if ($stmt->execute()) {
                $_SESSION['status'] = "Image uploaded and linked to album successfully!";
            $_SESSION['status_code'] = "success";
            header("Location: photos.php?id=$albumId");
                
            } 
        } else {
            echo "Error: " . $connections->error;
        }
    } else {
        echo "File upload failed.";
    }
}
// edit photo

if(isset($_POST['image_edit_btn'])){
    $id = $_POST['image_id'];
    $arrayresult = [];

    $fetch_query = "SELECT * FROM tbl_images WHERE id='$id'";
    $fetch_query_run = mysqli_query($connections, $fetch_query);
 
    if(mysqli_num_rows($fetch_query_run) > 0){
 
     while ($row = mysqli_fetch_array($fetch_query_run)){
         
 
       array_push($arrayresult, $row);
       header('content-type: application/json');
       echo json_encode($arrayresult);
     }
 
    }else{
       echo '<h4>No record found!</h4>';
    }
}


// update photo
if(isset($_POST['updatephoto']) && !empty($_POST['album_id'])){
    $id = $_POST ['id'];
    $albumId = $_POST['album_id'];

    $old_img = isset($_POST['old_img'])? $_POST['old_img'] : '';

    // Only update the image column if a new image is uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        // Upload and process the new image
        $target_dir = "assets/uploads/";
        $target_file = $target_dir. basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check!== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["img"]["size"] > 20000000) { // 500 KB
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType!= "jpg" && $imageFileType!= "png" && $imageFileType!= "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
        } else {
            // Generate a unique file name to avoid conflicts
            $uniqueFileName = uniqid(). '.'. $imageFileType;
            $target_file = $target_dir. $uniqueFileName;

            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $avatar = $uniqueFileName;
                // Optionally, delete the old image file if a new one is uploaded
                if ($old_img && file_exists($target_dir. $old_img)) {
                    unlink($target_dir. $old_img);
                }
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    } else {
        $avatar = $old_img; // Use the old image if no new image is uploaded
    }

    $stmt = $connections->prepare("UPDATE tbl_images SET image=? WHERE id=?");
    $stmt->bind_param("si", $avatar, $id);

    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Updated successfully!";
            $_SESSION['status_code'] = "success";
            header("Location: photos.php?id=$albumId");
        } else {
            $_SESSION['status'] = "Update Failed";
            $_SESSION['status_code'] = "error";
            header("Location: photos.php?id=$albumId");
        }
    } catch (Exception $e) {
        echo 'Error updating staff data: '. $e->getMessage();
    }

    $stmt->close();

}
// delete photos

if(isset($_GET['idimage'])){
    $id = $_GET['idimage'];
    $albumId = $_GET['albumid'];

    // Get the old image file name from the database
    $stmt = $connections->prepare("SELECT image FROM tbl_images WHERE id =?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_img = $row['image'];

    // Delete the file from the directory
    $target_dir = "assets/uploads/";
    $target_file = $target_dir. $old_img;
    if (file_exists($target_file)) {
        unlink($target_file);
    }

    // Delete the record from the database
    $stmt = $connections->prepare("DELETE FROM tbl_images WHERE id =?");
    $stmt->bind_param("i", $id);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Deleted successfully!";
            $_SESSION['status_code'] = "success";
            header("Location: photos.php?id=$albumId");
        } else {
            $_SESSION['status'] = "Delete Failed";
            $_SESSION['status_code'] = "error";
            header("Location: photos.php?id=$albumId");
        }
    } catch (Exception $e) {
        echo 'Error deleting staff data: '. $e->getMessage();
    }

    $stmt->close();
}

// add volunteer
if(isset($_POST['addvolunteer'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $cleanup = $_POST['cleanup'];


    $errors = array();
    
    if (preg_match('/[^a-zA-Z]/', $firstname)) {
        $errors['firstname'] = "Firstname can only contain letters.";
    }
    if (preg_match('/[^a-zA-Z]/', $lastname)) {
        $errors['lastname'] = "Lastname can only contain letters.";
    }
    
    if (!preg_match('/^(09|\+639)\d{9}$/', $contact)) {
        $errors['contact'] = "Invalid PH mobile number.";
    }
    
    if (!empty($errors)) {
        echo json_encode($errors);
        exit;
    }else{

    $sql = "INSERT INTO tbl_volunteers (firstname, lastname, gender, contact, address, eventsched_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connections->prepare($sql);
    $stmt->bind_param("sssssi", $firstname, $lastname, $gender, $contact, $address, $cleanup);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Added Successfully!'));
        exit;
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Action Failed'));
        exit;
    }

    $stmt->close();
    
}
}
// edit volunteer
if(isset($_POST['list_edit_btn'])){
    $id = $_POST['list_id'];
    $arrayresult = [];

    $fetch_query = "SELECT * FROM tbl_volunteers WHERE id='$id'";
    $fetch_query_run = mysqli_query($connections, $fetch_query);
 
    if(mysqli_num_rows($fetch_query_run) > 0){
 
     while ($row = mysqli_fetch_array($fetch_query_run)){
         
 
       array_push($arrayresult, $row);
       header('content-type: application/json');
       echo json_encode($arrayresult);
     }
 
    }else{
       echo '<h4>No record found!</h4>';
    }
}

// update volunteer
if(isset($_POST['updatevolunteer'])){
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $cleanup = $_POST['cleanup'];

    $errors = array();
    
    if (preg_match('/[^a-zA-Z]/', $firstname)) {
        $errors['firstname'] = "Firstname can only contain letters.";
    }
    if (preg_match('/[^a-zA-Z]/', $lastname)) {
        $errors['lastname'] = "Lastname can only contain letters.";
    }
    
    if (!preg_match('/^(09|\+639)\d{9}$/', $contact)) {
        $errors['contact'] = "Error: Invalid Philippine mobile number.";
    }
    
    if (!empty($errors)) {
        echo json_encode($errors);
        exit;
    }else{

    $stmt = $connections->prepare("UPDATE tbl_volunteers SET firstname=?, lastname=?, gender=?, contact=?, address=?, eventsched_id=? WHERE id=?");
    $stmt->bind_param("sssssii", $firstname, $lastname, $gender, $contact, $address, $cleanup, $id);

    
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Success!'));
            exit;
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Action Failed'));
            exit;
        }
    
    

    $stmt->close();
}
}
// delete volunteer
if(isset($_GET['idlist'])){
    $id = $_GET['idlist'];


    // Delete the record from the database
    $stmt = $connections->prepare("DELETE FROM tbl_volunteers WHERE id =?");
    $stmt->bind_param("i", $id);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = "Deleted successfully!";
            $_SESSION['status_code'] = "success";
            header('Location: list.php');
        } else {
            $_SESSION['status'] = "Delete Failed";
            $_SESSION['status_code'] = "error";
            header('Location: list.php');
        }
    } catch (Exception $e) {
        echo 'Error deleting staff data: '. $e->getMessage();
    }

    $stmt->close();
}



$connections->close();
ob_end_flush();

?>