<?php
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
    
    $event_id = null; // Initialize event_id

    // Start a transaction
    $connections->begin_transaction();

    try {
        // Insert event data
        $sql = "INSERT INTO tbl_eventsched (title, location, tools, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
        $default_tools = '';
        $stmt = $connections->prepare($sql);
        $stmt->bind_param("sssss", $title, $location, $default_tools, $start_date, $end_date);

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


// edit event

if(isset($_POST['event_edit_btn'])){
    $id = $_POST['event_id'];
    $arrayresult = [];

    $fetch_query = "SELECT e.*, s.fname, s.lname 
                    FROM tbl_eventsched e 
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
if(isset($_POST['updateevent'])){
     // Check the form data

    // Sanitize and retrieve form data
    $id = ($_POST['id']);
    $title = ($_POST['title']);
    $location = ($_POST['location']);
    $tools = implode(', ', $_POST['tools']);
    // $staff_ids = $_POST['astaff'];
    $start_date = ($_POST['start_date']);
    $end_date = ($_POST['end_date']);

    $sql = "UPDATE tbl_eventsched SET title =?, location =?, tools =?, start_date =?, end_date =? WHERE id =?";
    $stmt = $connections->prepare($sql);
    $stmt->bind_param("sssssi", $title, $location, $tools, $start_date, $end_date, $id);

    $stmt->execute();

    $_SESSION['status'] = "Event Updated Successfully!";
    $_SESSION['status_code'] = "success";
    header('Location: activities.php');
    exit;

}

// delete event
if(isset($_POST['event_delete_btn'])){
    $id = $_POST['id'];
 
    $delete_query = "DELETE FROM tbl_eventsched WHERE id='$id'";
    $delete_query_run = mysqli_query($connections, $delete_query);
 
    if($delete_query_run){
       $_SESSION['status'] = "Deleted successfully!";
       $_SESSION['status_code'] = "success";
     //   header('Location: staff.php');
    }else{
       $_SESSION['status'] = "Delete Failed";
       $_SESSION['status_code'] = "error";
     //   header('Location: staff.php');
      
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
        $_SESSION['status'] = "Request Confirmed! Add this request to the Event Schedule!";
        $_SESSION['status_code'] = "success";
        header('Location: request.php');
    } else {
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

    $fetch_query = "SELECT * FROM tbl_tools WHERE id =?";
$stmt = mysqli_prepare($connections, $fetch_query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            array_push($arrayresult, $row);
        }
        
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
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




if (isset($_POST['action']) && $_POST['action'] === 'get_tools') {
  $sql = "SELECT name FROM tbl_tools";
  $result = $conn->query($sql);
  $toolsData = array();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $toolsData[] = $row['name'];
    }
  }
  echo json_encode($toolsData);
} else if (isset($_POST['action']) && $_POST['action'] === 'update_tools') {
  // Update Tool Quantities in the Database
  // ... (See the next section for detailed logic)
  $selectedTools = $_POST['tools']; // Array of selected tool names
  foreach ($selectedTools as $toolName => $quantity) {
    $sql = "UPDATE tbl_tools SET quantity = quantity - $quantity WHERE name = '$toolName'";
    if ($conn->query($sql) === TRUE) {
      // Tool quantity updated successfully
    } else {
      // Error updating tool quantity
      echo "Error updating quantity: " . $conn->error;
    }
  }
}




$connections->close();


?>