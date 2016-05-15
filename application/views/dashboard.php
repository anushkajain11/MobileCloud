<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Blank page | Nifty - Responsive admin template.</title>


	<?php include_once('head.php'); ?>
		

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
	<div id="container" class="effect mainnav-lg">
		
		<!--NAVBAR-->
		<!--===================================================-->
		<header id="navbar">
			<div id="navbar-container" class="boxed">

				<!--Brand logo & name-->
				<!--================================-->
				<div class="navbar-header">
					<a href="index.html" class="navbar-brand">
						<div class="brand-title">
							<span class="brand-text">Sensor Cloud</span>
						</div>
					</a>
				</div>
				<!--================================-->
				<!--End brand logo & name-->


				<!--Navbar Dropdown-->
				<!--================================-->
				<?php include_once('navbar_dropdown.php'); ?>
				<!--================================-->
				<!--End Navbar Dropdown-->

			</div>
		</header>
		<!--===================================================-->
		<!--END NAVBAR-->

		<div class="boxed">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<!--Page Title-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div id="page-title">
					<h1 class="page-header text-overflow">Dashboard</h1>

					<!--Searchbox-->
					<div class="searchbox">
						<div class="input-group custom-search-form">
							<input type="text" class="form-control" placeholder="Search..">
							<span class="input-group-btn">
								<button class="text-muted" type="button"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</div>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End page title-->


				


		

				<!--Page content-->
				<!--===================================================-->
				<div id="page-content">
					
					<div class="panel">
						
						<div class="panel-body">
							
					
							<!-- Geocoding -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div id="demo-geocoding-map" style="height:500px"></div>
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
					
						</div>
					</div>
					
					
					
				</div>
				<!--===================================================-->
				<!--End page content-->


			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->


			
			<!--MAIN NAVIGATION-->
			<!--===================================================-->
			<? include('main_nav.php'); ?>
			
			<!--===================================================-->
			<!--END MAIN NAVIGATION-->
			
			

		</div>

		

		<!-- FOOTER -->
		<!--===================================================-->
		<?php include_once('footer.php'); ?>
		<!--===================================================-->
		<!-- END FOOTER -->


		<!-- SCROLL TOP BUTTON -->
		<!--===================================================-->
		<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
		<!--===================================================-->



	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->


	
	
	

	
	<?php include_once('body_bottom.php'); ?>

	<script>
		
		

	</script>
	<!--Gmaps [ OPTIONAL ]-->
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="nifty-v2.2/template/plugins/gmaps/gmaps.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {


		// GMAPS
		// =================================================================
		// Require gmaps
		// -----------------------------------------------------------------
		// http://hpneo.github.io/gmaps/
		// =================================================================



			



		// Geocoding
		// =================================================================
		var geomap = new GMaps({
			div: '#demo-geocoding-map',
			lat: 35.741,
			lng: -121.884,
			zoom:4
		});
		var physicalSensorsJsonString = <?php echo json_encode($physicalSensors); ?>;
		var physicalSensors = physicalSensorsJsonString;

		for(var i=0; i < physicalSensors.length; i++) {

			geomap.addMarker({
			  lat: physicalSensors[i].lat,
			  lng: physicalSensors[i].lon,
			  title: physicalSensors[i].name
			});


		}

		



	});
	</script>
	
		

</body>
</html>