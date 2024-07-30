<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>



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
		
		<script type="text/javascript">
		jQuery(document).ready(function($)
		{
			$('.pie').sparkline('html', {
				type: 'pie',
				borderWidth: 0,
				sliceColors: ['#3d4554', '#ee4749','#00b19d']
			});
		
		
			$(".chart").sparkline([1,2,3,1], {
				type: 'pie',
				barColor: '#485671',
				height: '110px',
				barWidth: 10,
				barSpacing: 2});
		
		
			var seriesData = [ [], [] ];
		
			var random = new Rickshaw.Fixtures.RandomData(50);
		
			for (var i = 0; i < 90; i++)
			{
				random.addData(seriesData);
			}
		
			var graph = new Rickshaw.Graph( {
				element: document.getElementById("rickshaw-chart-demo-2"),
				height: 217,
				renderer: 'area',
				stroke: false,
				preserve: true,
				series: [{
						color: '#359ade',
						data: seriesData[0],
						name: 'Page Views'
					}, {
						color: '#73c8ff',
						data: seriesData[1],
						name: 'Unique Users'
					}, {
						color: '#e0f2ff',
						data: seriesData[1],
						name: 'Bounce Rate'
					}
				]
			} );
		
			graph.render();
		
			var hoverDetail = new Rickshaw.Graph.HoverDetail( {
				graph: graph,
				xFormatter: function(x) {
					return new Date(x * 1000).toString();
				}
			} );
		
			var legend = new Rickshaw.Graph.Legend( {
				graph: graph,
				element: document.getElementById('rickshaw-legend')
			} );
		
			var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight( {
				graph: graph,
				legend: legend
			} );
		
			setInterval( function() {
				random.removeData(seriesData);
				random.addData(seriesData);
				graph.update();
		
			}, 500 );
		
		});
		</script>
		
		
		<div class="row">
			<div class="col-sm-12">
				<div class="well">
					<h1>November 04, 2024</h1>
					<h3>Welcome to the site <strong>Admin</strong></h3>
				</div>
			</div>
		</div>
		
		<div class="row">
		
			<div class="col-sm-9">
		
				<div class="row">
		
					<div class="col-sm-6">
		
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title">New vs Returning Visitors</div>
		
								
							</div>
							<div class="panel-body">
								<center><span class="chart"></span></center>
							</div>
						</div>
		
					</div>
		
					<div class="col-sm-6">
		
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title">Latest Users</div>
		
								
							<table class="table table-bordered table-responsive">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Position</th>
										<th>Activity</th>
									</tr>
								</thead>
		
								<tbody>
									<tr>
										<td>1</td>
										<td>Art Ramadani</td>
										<td>CEO</td>
										<td class="text-center"><span class="pie">4,3,5</span></td>
									</tr>
		
									<tr>
										<td>2</td>
										<td>Filan Fisteku</td>
										<td>Member</td>
										<td class="text-center"><span class="pie">1,3,4</span></td>
									</tr>
		
									<tr>
										<td>3</td>
										<td>Arlind Nushi</td>
										<td>Co-founder</td>
										<td class="text-center"><span class="pie">5,3,2</span></td>
									</tr>
		
								</tbody>
							</table>
						</div>
		
					</div>
		
				</div>
		
		
					</div>
		
					<div class="panel-body no-padding">
						<div id="rickshaw-chart-demo-2">
							<div id="rickshaw-legend"></div>
						</div>
					</div>

				</div>
			</div>
		
		<?php include"footer.php" ?>
		

</body>
</html>