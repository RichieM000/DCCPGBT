<!DOCTYPE html>
<html lang="en">
<?php include"header.php"?>
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"> <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
<?php include"sidebar.php"?>


	<strong>Gallery</strong>
							
					
		<script type="text/javascript">
		jQuery(document).ready(function($)
		{
			// Handle the Change Cover
			$(".gallery-env").on("click", ".album header .album-options", function(ev)
			{
				ev.preventDefault();
				
				// Sample Modal
				$("#album-cover-options").modal('show');
				
				// Sample Crop Instance
				var image_to_crop = $("#album-cover-options .croppable-image img"),
					img_load = new Image();
				
				img_load.src = image_to_crop.attr('src');
				img_load.onload = function()
				{
					if(image_to_crop.data('loaded'))
						return false;
						
					image_to_crop.data('loaded', true);
					
					image_to_crop.Jcrop({
						boxWidth: 410,
						boxHeight: 265,
						onSelect: function(cords)
						{
							// you can use these vars to save cropping of the image coordinates
							var h = cords.h,
								w = cords.w,
								
								x1 = cords.x,
								x2 = cords.x2,
								
								y1 = cords.w,
								y2 = cords.y2;
							
						}
					}, function()
					{
						var jcrop = this;
						
						jcrop.animateTo([800, 600, 150, 50]);
					});
				}
			});
		});
		</script>
		
		<div class="gallery-env">
		
			<div class="row">
			
				<div class="col-sm-4">
					
					<article class="album">
					
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								55
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
				
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-image-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								27
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
				
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								43
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
			
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								18
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
				
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								67
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
				
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								8
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
			
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								25
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
				
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								19
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
				
				<div class="col-sm-4">
					
					<article class="album">
						
						<header>
							
							<a href="extra-gallery-single.html">
								<img src="assets/images/album-thumb-1.jpg" />
							</a>
							
							<a href="#" class="album-options">
								<i class="entypo-cog"></i>
								Change Cover
							</a>
						</header>
						
						<section class="album-info">
							<h3><a href="extra-gallery-single.html">Album Title</a></h3>
							
							<p>Can curiosity may end shameless explained. True high on said mr on come. </p>
						</section>
						
						<footer>
							
							<div class="album-images-count">
								<i class="entypo-picture"></i>
								14
							</div>
							
							<div class="album-options">
								<a href="#">
									<i class="entypo-cog"></i>
								</a>
								
								<a href="#">
									<i class="entypo-trash"></i>
								</a>
							</div>
							
						</footer>
						
					</article>
					
				</div>
			
			</div>
			
		</div>
		<!-- Footer -->

		<h3>
			Upload More Images
			<br />
			<small>The upload script will generate random response status (error or success), files are not uploaded.</small>
		</h3>
		
		<br />
			
		<form action="data/upload-file.php" class="dropzone dz-min" id="dropzone_example">
			<div class="fallback">
				<input name="file" type="file" multiple />
			</div>
		</form>
		
		<div id="dze_info" class="hidden">
			
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">Dropzone Uploaded Images Info</div>
				</div>
				
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="40%">File name</th>
							<th width="15%">Size</th>
							<th width="15%">Type</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4"></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		
		<br />
 
<footer class="main">
			
			&copy; 2024 <strong>DCCPGBT</strong> 
		
		</footer>
		
	<!-- Album Cover Settings Modal -->
<div class="modal fade custom-width" id="album-cover-options">
	<div class="modal-dialog" style="width: 65%;">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit: <strong>Album Title</strong></h4>
			</div>
			
			<div class="modal-body">
				
				<div class="row">
					<div class="col-sm-6">
										
						<div class="row">
							<div class="col-md-12">
								
								<h4 class="margin-top-none">Crop Image</h4>
								
								<div class="croppable-image">
									<img src="assets/images/sample-crop.jpg" class="img-responsive" />
								</div>
								
							</div>
						</div>
						
					</div>
					
					<div class="col-sm-6">
					
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group">
									<label for="field-1" class="control-label">Title</label>
									
									<input type="text" class="form-control" id="field-1" placeholder="Enter album title">
								</div>	
								
							</div>
						</div>
					
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group">
									<label for="field-1" class="control-label">Tags</label>
									
									<input type="text" class="form-control" id="field-3" placeholder="Tags">
								</div>	
								
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group">
									<label for="field-1" class="control-label">Description</label>
									
									<textarea class="form-control autogrow" id="field-2" placeholder="Enter album description" style="min-height: 120px;"></textarea>
								</div>	
								
							</div>
						</div>
						
					</div>
				</div>
				
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-icon">
					<i class="entypo-check"></i>
					Apply Changes
				</button>
			</div>
		</div>
	</div>
</div>


<!-- Album Image Settings Modal -->
<div class="modal fade" id="album-image-options">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="gallery-image-edit-env">
				<img src="assets/images/sample-crop-1.png" class="img-responsive" />
				
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			
			<div class="modal-body">
			
					
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group">
									<label for="field-1" class="control-label">Title</label>
									
									<input type="text" class="form-control" id="field-1" placeholder="Enter image title">
								</div>	
								
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group">
									<label for="field-1" class="control-label">Description</label>
									
									<textarea class="form-control autogrow" id="field-2" placeholder="Enter image description" style="min-height: 80px;"></textarea>
								</div>	
								
							</div>
						</div>
						
				
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-icon">
					<i class="entypo-check"></i>
					Apply Changes
				</button>
			</div>
		</div>
	</div>
</div>



	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/jcrop/jquery.Jcrop.min.css">
	<link rel="stylesheet" href="assets/js/dropzone/dropzone.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jcrop/jquery.Jcrop.min.js"></script>
	<script src="assets/js/dropzone/dropzone.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>
	



	

</body>
</html>