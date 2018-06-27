<?php 
	ini_set("display_errors", 0);
	$error = '';
	$info = '';
	include('components/color.php');
	include('components/palette.php'); 
?>
<!doctype html>
<html>
<head>
	<title>PHP Palette Maker</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>
<body class="container">

	<p><a href="/">Clear params</a></p>

	<h1 class="mt-3">PHP Palette Maker</h1>

	<?php if ($info) { ?>
	<div class="mt-3 alert alert-success rounded-0"><?=$info?></div>
	<?php } ?>

	<?php if ($error) { ?>
	<div class="mt-3 alert alert-danger rounded-0"><?=$error?></div> 
	<?php } ?>

	<?php echo colorForm(); ?>

	<?php echo paletteForm(); ?>

	<div class="row mt-5">

		<!-- List of palettes -->

		<div class="col-sm-12 col-md-6">

			<h4>Palettes</h4>

			<div class="accordian" id="palettes">


<?php foreach (getPalettes() as $palette) { ?>

			<div class="card rounded-0">
				<div class="card-header" id="palette<?php echo $palette[id]; ?>" style="margin: 0 !important; padding: 0 !important;">
					<h5 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $palette[id]; ?>"><?php echo $palette[name]; ?></button>
					</h5>
				</div>
				<div id="collapse<?php echo $palette[id]; ?>" class="collapse" data-parent="#palettes">
					<div class="card-body">

<?php 

	foreach (getPaletteColors($palette['id']) as $color) { 
		echo displayColor($color['id'], $color['name'], $color['hex'], false, true); 
	} 

	echo getAddColorLinks($palette['id']);
?>


	        		</div>
	        	</div>
	    	</div>

<?php } ?>

			</div>

		</div>

		<!-- List of colors -->

		<div class="col-sm-12 col-md-6 mt-sm-3 mt-md-0">

			<h4>Colors</h4>

<?php foreach (getColors() as $color) { echo displayColor($color['id'], $color['name'], $color['hex'], true, false); } ?>

		</div>

	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


</body>
</html>