<?php 
session_start();
?>

<div class="sidebar-menu font-sans"> 

		<div class="sidebar-menu-inner font-sans">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="index.html">
						<img src="assets/images/logo.png" width="90" alt=""/>
					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>

								
				

			</header>
			
						<div class="sidebar-user-info">

				<div class="sui-normal">
					<a href="#" class="user-link">
						<img src="assets/images/thumb-1@2x.png" width="55" alt="" class="img-circle" />

						<span>Welcome,</span>
						<strong><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; ?></strong>
					</a>
				</div>

				<div class="sui-hover inline-links animate-in">

					<span class="close-sui-popup">&times;</span>			</div>
			</div>
			
									
			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li class="opened active has-sub">
					<a href="dashboard.php">
						<i class="entypo-gauge"></i>
						<span class="title">Dashboard</span>
					</a>
					
						</li>


						<li class="has-sub">
					<a href="monitoring_report.php">
					<i class="ri-survey-fill"></i>
						<span class="title">Resident's Request</span>
					</a>
					<ul>
						<li>
							<a href="request.php">
								<i class=""></i>
								<span class="title">Requests</span>
							</a>
							</ul>
						</li>





						
				<li class="has-sub">
					<a href="scheduling.php">
						<i class="entypo-newspaper"></i>
						<span class="title">Schedule of Activities</span>
					</a>
					<ul>
						<!-- <li>
							<a href="calendar.php">
								<span class="title">Calendar</span>
							</a>
						</li> -->

						<li>
							<a href="activities.php">
								<span class="title">List of Activities</span>
							</a>
						</li>
						
					</ul>
				</li>

			


			




				<li class="has-sub">
					<a href="attendance.php">
						<i class="entypo-mail"></i>
						<span class="title">Attendance Record</span>
						
					</a>
					<ul>
						<li>
							<a href="list.php">
								<i class="entypo-inbox"></i>
								<span class="title">List of Volunteers</span>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="has-sub">
					<a href="cleanliness_record.php">
						<i class="entypo-doc-text"></i>
						<span class="title">Purok Cleanliness Record</span>
					</a>
					<ul>
						<li>
							<a href="cleaned.php">
								<span class="title">Cleaned Purok</span>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="has-sub">
					<a href="purok_profile.php">
						<i class="entypo-window"></i>
						<span class="title">Purok Profile</span>
					</a>
					<ul>
						<li>
							<a href="purok.php">
								<span class="title">Purok List</span>
							</a>
						</li>
						
					</ul>
				</li>
				
				
				<li class="has-sub">
					<a href="monitoring_report.php">
						<i class="entypo-flow-tree"></i>
						<span class="title">Monitoring Report</span>
					</a>
					<ul>
						<li>
							<a href="doc.php">
								<i class="entypo-flow-line"></i>
								<span class="title">Documentation/Report</span>
							</a>
							</ul>
					</li>
						</li>

						<li class="opened">
					<a href="logout.php">
					<i class="entypo-logout"></i>
						<span class="title">Logout</span>
					</a>
					
						</li>

					


</ul>

					</ul>

			
		</div>
		

	</div>

