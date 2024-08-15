	Footer
 
<footer class="main">
			
			&copy; 2024 <strong>DCCPGBT</strong> 
		
		</footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
	<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
	
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- <script src="assets/js/copy/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- <script src="assets/js/copy/jquery-3.6.0.min.js"></script> -->
<script src="assets/js/copy/datatables.min.js"></script>
<script src="assets/js/copy/pdfmake.min.js"></script>
<script src="assets/js/copy/vfs_fonts.js"></script>
<script src="assets/js/copy/custom.js"></script>
<script src="assets/js/bootstrap-tagsinput.js"></script>



	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>

		
	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/js/jquery.sparkline.min.js"></script>
	<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<?php
	if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
		?>

		<script>

		swal({
		title: "<?php echo $_SESSION['status']; ?>",
		
		icon: "<?php echo $_SESSION['status_code']; ?>",
		button: "Okay!",
		timer: 6000,
		});
			</script>

		<?php
		unset($_SESSION['status']);
	}

	?>
		



	