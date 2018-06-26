<!doctype html>
<html>
<head>
	<title>PHP Palette Maker</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body class="container">
	<h1 class="mt-3">PHP Palette Maker</h1>

<div class="mt-5"></div>

<!-- New color form -->
<form class="form-inline" method="get" action="">
	<label class="sr-only" for="colorName">Color Name</label>
	<input type="text" class="rounded-0 form-control mb-2 mr-sm-2 mb-sm-0" id="colorName" name="colorName" placeholder="The deep dark void...">

	<label class="sr-only" for="hexCode">Hex Code</label>
	<div class="input-group mb-2 mr-sm-2 mb-sm-0">
		<div class="input-group-prepend">
			<div class="rounded-0 input-group-text">#</div>
		</div>
		<input type="text" class="rounded-0form-control" id="hexCode" placeholder="a1b2c3" maxlength="6" size="6">
	</div>

	<button type="submit" class="btn btn-secondary rounded-0">Add Color</button>
</form>


<div class="mt-3"></div>


<!-- New palette form -->
<form class="form-inline" method="get" action="">
	<label class="sr-only" for="paletteName">Palette Name</label>
	<input type="text" class="rounded-0 form-control mb-2 mr-sm-2 mb-sm-0" id="paletteName" name="paletteName" placeholder="The most beautiful...">

	<button type="submit" class="btn btn-secondary rounded-0">Add Palette</button>
</form>



<div class="mb-5"></div>



<div class="row">

<!-- List of palettes -->

<div class="col-sm-12 col-md-6">

	<h4>Palettes</h4>

	<div class="accordian" id="palettes">


<?php

	$db = pg_connect("host=localhost port=5432 dbname=palettemaker user=palettemakeruser password=palettepalettepalette");

	$request = pg_query($db, "select id, name from palette");

	$results = pg_fetch_all($request);

	// $palettes = [ 'Rainbow', 'Greyscale', 'Arbor Day', 'Christmas'];

	foreach ($results as $palette) {

?>

		<div class="card rounded-0">
			<div class="card-header" id="palette<?php echo $palette[id]; ?>" style="margin: 0 !important; padding: 0 !important;">
				<h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $palette[id]; ?>"><?php echo $palette[name]; ?></button>
				</h5>
			</div>
			<div id="collapse<?php echo $palette[id]; ?>" class="collapse" data-parent="#palettes">
				<div class="card-body">
					Your shields were failing, sir. The Enterprise computer system is controlled by three primary main processor cores, cross-linked with a redundant melacortz ramistat, fourteen kiloquad interface modules. What? We're not at all alike! The Federation's gone; the Borg is everywhere!
        		</div>
        	</div>
    	</div>

<?php

	}

?>

	</div>

</div>

<!-- List of colors -->

<div class="col-sm-12 col-md-6">

	<h4>Colors</h4>


</div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


</body>
</html>