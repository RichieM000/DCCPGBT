<?php
require_once 'connections.php';




function getUserRequest($connections) {
    $query = "SELECT * FROM tbl_request"; 
    $result = mysqli_query($connections, $query);
  
    $userTasks = array();
    while($row = mysqli_fetch_assoc($result)) {
      $userTasks[] = $row;
    }
    mysqli_close($connections);
    return $userTasks;
}
function countRequest($connections){
  // Query to get the count of registered users
  $sql = "SELECT COUNT(*) AS total_request FROM tbl_request";
  $result = mysqli_query($connections, $sql);

  // Fetch the count
  $row = mysqli_fetch_assoc($result);
  $totalrequest = $row['total_request'];

  // Close the database connection
  return $totalrequest;
}


function getPurok($connections){
  $query = "SELECT * FROM tbl_purok";
  $result = mysqli_query($connections, $query);

  $puroklist = array();
  while($row = mysqli_fetch_assoc($result)) {
    $puroklist[] = $row;
  }
  return $puroklist;
}
function countPurok($connections){
  // Query to get the count of registered users
  $sql = "SELECT COUNT(*) AS total_purok FROM tbl_purok";
  $result = mysqli_query($connections, $sql);

  // Fetch the count
  $row = mysqli_fetch_assoc($result);
  $totalpurok = $row['total_purok'];

  // Close the database connection
  return $totalpurok;
}

function countAlbum($connections){
  $sql = "SELECT COUNT(*) AS total_album FROM tbl_album";
  $result = mysqli_query($connections, $sql);

  $row = mysqli_fetch_assoc($result);
  $totalAlbum = $row['total_album'];

  return $totalAlbum;
}




function getAlbum($connections){
  $query = "SELECT * FROM tbl_album";
  $result = mysqli_query($connections, $query);

  $albums = [];

  while($row = mysqli_fetch_assoc($result)){
    $album_image = $row['album_img'];
    $image_path = 'assets/uploads/';
    $default_image = 'no_image.jpg';

    $image_src = !empty($album_image) && file_exists($image_path . $album_image)
    ? $image_path . $album_image
    : $image_path . $default_image;

    $albums[] = [
      'album_data' => $row,
      'image_src' => $image_src,
    ];
    
  }
  return $albums;
}


function getTools($connections){
  $query = "SELECT * FROM tbl_tools";
  $result = mysqli_query($connections, $query);

  $tools = [];
  while ($row = mysqli_fetch_assoc($result)) {
      $profile_image = $row['image'];
      $image_path = 'assets/uploads/';
      $default_image = 'no_image.jpg';

      $image_src = !empty($profile_image) && file_exists($image_path . $profile_image)
          ? $image_path . $profile_image
          : $image_path . $default_image;

      $tools[] = [
          'tool_data' => $row,
          'image_src' => $image_src,
      ];
  }

  return $tools;
}
function countTools($connections){
  // Query to get the count of registered users
  $sql = "SELECT COUNT(*) AS total_tools FROM tbl_tools";
  $result = mysqli_query($connections, $sql);

  // Fetch the count
  $row = mysqli_fetch_assoc($result);
  $totaltools = $row['total_tools'];

  // Close the database connection
  return $totaltools;
}


function getImages($connections, $albumId) {
  // Prepare the SQL query to fetch images for the specific album
  $query = "SELECT * FROM tbl_images WHERE album_id = ?";
  
  // Initialize an empty array to store the images
  $images = [];

  // Prepare and execute the query safely using prepared statements
  if ($stmt = $connections->prepare($query)) {
      // Bind the album ID to the query
      $stmt->bind_param("i", $albumId);
      $stmt->execute();
      $result = $stmt->get_result();

      // Fetch and process the results
      while ($row = mysqli_fetch_assoc($result)) {
          $profile_image = $row['image'];
          $image_path = 'assets/uploads/';
          $default_image = 'no_image.jpg';

          // Determine the correct image source
          $image_src = !empty($profile_image) && file_exists($image_path . $profile_image)
              ? $image_path . $profile_image
              : $image_path . $default_image;

          // Add the image data to the images array
          $images[] = [
              'album_data' => $row,
              'image_src' => $image_src,
          ];
      }

      // Close the statement
      $stmt->close();
  } else {
      // Handle error
      echo "Error: " . $connections->error;
  }

  return $images;
}
function getAlbumImageCount($albumId, $connections) {
  $sql = "SELECT COUNT(*) as image_count FROM tbl_images WHERE album_id = ?";
  $stmt = $connections->prepare($sql);
  $stmt->bind_param("i", $albumId);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stmt->close();
  return $row['image_count'];
}

function cleanedPurok($connections){
  $sql = "SELECT * FROM tbl_waste";
  
  $stmt = $connections->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  $cleaned = array();
  while($row = $result->fetch_assoc()){
    $cleaned[] = $row;
  }

  $stmt->close();

  return $cleaned;
}
function countCleaned($connections){
    // Query to get the count of registered users
    $sql = "SELECT COUNT(*) AS total_cleaned FROM tbl_waste";
    $result = mysqli_query($connections, $sql);
  
    // Fetch the count
    $row = mysqli_fetch_assoc($result);
    $totalcleaned = $row['total_cleaned'];
  
    // Close the database connection
    return $totalcleaned;
}













function getEvent($connections) {
  $sql = "  SELECT e.id, e.title, e.location, e.start_date, e.end_date, e.status, 
  GROUP_CONCAT(DISTINCT CONCAT(t.name, ' (', et.quantity, ')') ORDER BY t.name SEPARATOR ', ') AS tools,
  GROUP_CONCAT(DISTINCT CONCAT(s.fname, ' ', s.lname) ORDER BY s.fname SEPARATOR ', ') AS staff
FROM tbl_eventsched e
LEFT JOIN tbl_event_tools et ON e.id = et.event_id
LEFT JOIN tbl_tools t ON et.tool_id = t.id
LEFT JOIN tbl_event_staff es ON e.id = es.event_id
LEFT JOIN tbl_staff s ON es.staff_id = s.id
GROUP BY e.id, e.title, e.location, e.start_date, e.end_date";
  
$stmt = $connections->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$events = array();
while ($row = $result->fetch_assoc()) {
$events[] = $row;
}

$stmt->close();

return $events;
}
function countEvent($connections){
  // Query to get the count of registered users
  $sql = "SELECT COUNT(*) AS total_event FROM tbl_eventsched";
  $result = mysqli_query($connections, $sql);

  // Fetch the count
  $row = mysqli_fetch_assoc($result);
  $totalevent = $row['total_event'];

  // Close the database connection
  return $totalevent;
}

function getEventsByStaffId($connections, $staffId) {
  $query = "SELECT e.id, e.title, e.location, e.start_date, e.end_date, e.status, 
  GROUP_CONCAT(DISTINCT CONCAT(t.name, ' (', et.quantity, ')') ORDER BY t.name SEPARATOR ', ') AS tools,
  GROUP_CONCAT(DISTINCT CONCAT(s.fname, ' ', s.lname) ORDER BY s.fname SEPARATOR ', ') AS staff
FROM tbl_eventsched e
LEFT JOIN tbl_event_tools et ON e.id = et.event_id
LEFT JOIN tbl_tools t ON et.tool_id = t.id
LEFT JOIN tbl_event_staff es ON e.id = es.event_id
LEFT JOIN tbl_staff s ON es.staff_id = s.id
WHERE es.staff_id = ?
GROUP BY e.id, e.title, e.location, e.start_date, e.end_date";

  // Prepare and execute the query
  if ($stmt = $connections->prepare($query)) {
      $stmt->bind_param("i", $staffId);  // Bind the staff ID as an integer parameter
      $stmt->execute();
      $result = $stmt->get_result();
      
      // Fetch all events and store them in an array
      $staffevents = [];
      while ($row = $result->fetch_assoc()) {
          $staffevents[] = $row;
      }
      
      // Close the statement
      $stmt->close();

      return $staffevents;  // Return the array of events
  } else {
      echo "Error: " . $connections->error;
      exit;
  }
}

function countStaffEvent($connections,  $staffId){
  $query = "SELECT COUNT(e.id) AS event_count
FROM tbl_eventsched e
LEFT JOIN tbl_event_staff es ON e.id = es.event_id
WHERE es.staff_id = ?";

  // Prepare and execute the query
  if ($stmt = $connections->prepare($query)) {
      $stmt->bind_param("i", $staffId);  // Bind the staff ID as an integer parameter
      $stmt->execute();
      $result = $stmt->get_result();
      
      // Fetch the event count
      $row = $result->fetch_assoc();
      $eventCount = $row['event_count'];
      
      // Close the statement
      $stmt->close();

      return $eventCount;  // Return the event count
  } else {
      echo "Error: " . $connections->error;
      exit;
  }
}






function getVolunteer($connections){
  $sql = "SELECT e.id, e.firstname, e.lastname, e.gender, e.contact, e.address, 
          es.title FROM tbl_volunteers e LEFT JOIN tbl_eventsched es ON e.eventsched_id = es.id";

  $stmt = $connections->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  $volunteers = array();
  while ($row = $result->fetch_assoc()){
    $volunteers[] = $row;
  }

  $stmt->close();
  return $volunteers;


}



function getStaffs($connections){

  $query = "SELECT * FROM tbl_staff WHERE usertype != 'admin'"; 
  $result = mysqli_query($connections, $query);

  $staffs = array();
  while($row = mysqli_fetch_assoc($result)) {
    $staffs[] = $row;
  }

  return $staffs;

}

function countStaff($connections){
    // Query to get the count of registered users
    $sql = "SELECT COUNT(*) AS total_users FROM tbl_staff WHERE usertype != 'admin'";
    $result = mysqli_query($connections, $sql);

    // Fetch the count
    $row = mysqli_fetch_assoc($result);
    $totalUsers = $row['total_users'];

    // Close the database connection
    return $totalUsers;
}



// Other functions here...

// $userTasks = getUserRequest($connections);

// $connections->close();

function getUsers($connections) {
  
  $sql = "SELECT id, CONCAT(fname, ' ', lname) AS fullname FROM tbl_staff WHERE usertype != 'admin'";
  $result = $connections->query($sql);

  $staffList = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $staffList[] = array(
              'id' => $row['id'],
              'value' => $row['fullname']
          );
      }
  }
  
  return $staffList;
}



?>