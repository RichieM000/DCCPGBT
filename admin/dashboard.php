<?php session_start();  ?>
<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<?php
include("connections.php");
require_once 'functions.php';
	$totalUsers = countStaff($connections);
	$totalrequest = countRequest($connections);
	$totalpurok = countPurok($connections);
	$totaltools = countTools($connections);
	$totalevent = countEvent($connections);
	$totalcleaned = countCleaned($connections);
	$totalAlbum = countAlbum($connections);
	$totalvolunteer = countVolunteer($connections);


	
?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Purok/Year', 'Paper', 'Glass', 'Organic','Plastic'],
      
     <?php 
     	$query = "SELECT purok, date, paper, glass, organic, plastic FROM tbl_waste";
     	$stmt = mysqli_prepare($connections, $query);
     	mysqli_stmt_execute($stmt);
     	$result = mysqli_stmt_get_result($stmt);
		while($data = mysqli_fetch_array($result)){
			
			$date = $data['date'];
			$year = date('Y-m-d', strtotime($date));
			$purok = $data['purok'];
			$paper = $data['paper'];
			$glass = $data['glass'];
			$organic = $data['organic'];
			$plastic = $data['plastic'];
     ?> 
     ['<?php echo $purok; ?> - <?php echo $year ?>', <?php echo $paper; ?>, <?php echo $glass; ?>, <?php echo $organic; ?>, <?php echo $plastic; ?>],

     <?php } ?>
    ]);

    var options = {
      chart: {
        title: 'Waste Collected',
        subtitle: 'Waste Segregation Chart',
      },
      bars: 'horizontal' // Required for Material Bar Charts.
    };

    var chart = new google.charts.Bar(document.getElementById('barchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>

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
		
	
		
		<div class="row">
			<div class="col-sm-12">
				<div class="well">
				<h1><?php echo date('F d, Y'); ?></h1>
					<h3>Welcome to the site <strong><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; ?></strong></h3>
				</div>
			</div>
		</div>
		
		<!-- <div class="bg-blue-500 text-white p-4 rounded-md">
  <div class="flex justify-between items-center">
    <div class="text-4xl font-bold">150</div>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
      <path d="M3 1a1 1 0 000 2h14a1 1 0 000-2H3zM3 5a1 1 0 000 2h14a1 1 0 000-2H3zM3 9a1 1 0 000 2h14a1 1 0 000-2H3z" />
    </svg>
  </div>
  <div class="text-sm mt-2">New Orders</div>
  <a href="#" class="text-white font-bold hover:underline mt-2">More info →</a>
</div> -->














<div class="grid grid-cols-4">

	<div class="bg-blue-500 shadown-md rounded-md text-white pt-4 px-4 m-2">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalUsers ?></h2>
			<h1 class="mt-1.5 text-base">Users Registered</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-user-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
        <a href="staff.php" class="text-white font-bold hover:underline">More info →</a>
        </div>
		
		</div>

<div class="bg-orange-500 shadown-md rounded-md text-white pt-4 px-4 m-2 <?= ($totalrequest > 0) ? 'relative' : ''; ?>">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalrequest ?></h2>
			<h1 class="mt-1.5 text-base">Residents Request</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-todo-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="request.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

		<?php if ($totalrequest > 0) { ?>
        <span class="absolute top-0 right-0 h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
            <span class="absolute top-0 right-0 inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
        </span>
    <?php } ?>

</div>

<div class="bg-green-500 shadown-md rounded-md text-white pt-4 px-4 m-2">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalpurok ?></h2>
			<h1 class="mt-1.5 text-base">Total Puroks</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-home-7-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="purok.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

</div>

<div class="bg-cyan-500 shadown-md rounded-md text-white pt-4 px-4 m-2">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totaltools ?></h2>
			<h1 class="mt-1.5 text-base">Cleanup Tools</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-tools-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="tools.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

</div>

<div class="bg-yellow-500 shadown-md rounded-md text-white pt-4 px-4 m-2 <?= ($totalevent > 0) ? 'relative' : ''; ?>">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalevent ?></h2>
			<h1 class="mt-1.5 text-base">Total Events</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-file-list-3-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="activities.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

		<?php if ($totalevent > 0) { ?>
        <span class="absolute top-0 right-0 h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
            <span class="absolute top-0 right-0 inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
        </span>
    <?php } ?>

</div>

<div class="bg-emerald-500 shadown-md rounded-md text-white pt-4 px-4 m-2 <?= ($totalcleaned > 0) ? 'relative' : ''; ?>">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalcleaned ?></h2>
			<h1 class="mt-1.5 text-base">Cleaned Purok</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-sparkling-2-line"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="cleaned.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

		<?php if ($totalcleaned > 0) { ?>
        <span class="absolute top-0 right-0 h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
            <span class="absolute top-0 right-0 inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
        </span>
    <?php } ?>

</div>

<div class="bg-indigo-500 shadown-md rounded-md text-white pt-4 px-4 m-2">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalAlbum ?></h2>
			<h1 class="mt-1.5 text-base">Documentations</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-gallery-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="doc.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

</div>

<div class="bg-red-400 shadown-md rounded-md text-white pt-4 px-4 m-2">

		<div class="flex justify-between items-center">

		<div class="flex flex-col">
			<h2 class="text-4xl font-bold"><?php echo $totalvolunteer ?></h2>
			<h1 class="mt-1.5 text-base">Volunteers</h1>
		</div>

		<span class="text-6xl opacity-25 text-black"><i class="ri-team-fill"></i></span>

		</div>

		<div class="flex items-end justify-center mt-3">
		<a href="list.php" class="text-white font-bold hover:underline">More info →</a>
		</div>

</div>


		</div>


		<div id="barchart_material" style="width: 900px; height: 500px; margin-top:2rem;"></div>
		
		
		<?php include"footer.php" ?>
		

</body>
</html>