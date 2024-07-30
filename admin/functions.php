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

function getEvent($connections) {
  $sql = "  SELECT e.id, e.title, e.location, e.start_date, e.end_date, 
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


// function getStaffs($connections){

//   $query = "SELECT * FROM tbl_staff"; 
//   $result = mysqli_query($connections, $query);

//   $staffs = array();
//   while($row = mysqli_fetch_assoc($result)) {
//     $staffs[] = $row;
//   }

//   return $staffs;

// }
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