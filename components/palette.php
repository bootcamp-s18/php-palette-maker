<?php

	require_once('utility.php');

	if (isset($_GET['paletteName'])) {
		$safeName = htmlentities($_GET['paletteName'], ENT_QUOTES);
		addPalette($safeName);
	}

	function paletteForm() {

		return '<div><form class="form-inline mt-3" method="get" action="">
	<label class="sr-only" for="paletteName">Palette Name</label>
	<input type="text" class="rounded-0 form-control mb-2 mr-sm-2 mb-sm-0" id="paletteName" name="paletteName" placeholder="The most beautiful...">
	<button type="submit" class="btn btn-secondary rounded-0">Add Palette</button>
</form></div>';

	}

	function getPalettes() {
		$db = getDb();
		$request = pg_query($db, "select id, name from palette order by name");
		return $results = pg_fetch_all($request);
	}

	function getPaletteColors($palette_id) {
		$db = getDb();
		$sql = 'SELECT color.id, color.name, color.hex FROM color 
JOIN color_palette ON color_palette.color_id = color.id
WHERE color_palette.palette_id = ' . $palette_id . '
ORDER BY color.name;';
		$request = pg_query($db, $sql);
		return $results = pg_fetch_all($request);
	}

	function addPalette($name) {

		global $error;
		global $info;

		$sql = "INSERT INTO palette (name) VALUES ('" . $name . "');";

		$db = getDb(); // So we can check pg_last_error later

		$request = pg_query($db, $sql);

		if ($request) {
			$_SESSION['info'] = "<strong>" . $name . "</strong> was added to the palette list.";
			$newUrl = removeParams(assembleCurrentUrl(), [ 'paletteName' ]);
			header('Location: '.$newUrl);
			exit();
		}
		else {
			$_SESSION['error'] = cleanUpErrorMessage(pg_last_error($db));
		}

	}

	function getAddColorLinks($palette_id) {

		$output = '
			<div class="card rounded-0">
							<div class="card-header row" id="color' . $id . '" style="margin: 0 !important; padding: 0 !important; background-color: #FFFFFF;">

			<div class="col m-auto">
			<div class="dropright">
			  <a class="btn dropdown-toggle rounded-0" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Add a Color
			  </a>

			  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

		foreach (getUnlinkedColors($palette_id) as $unlinked) {

    		$output .= '<a class="dropdown-item" href="#">' . $unlinked['name'] . '</a>';

    	}


		$output .= '
		  </div>
		</div>
		</div>

						</div>
					</div>';

		return $output;

	}

	function getUnlinkedColors($palette_id) {

		$sql = 'SELECT id, name, hex FROM color
WHERE color.id NOT IN (SELECT color_id FROM color_palette WHERE palette_id = ' . $palette_id . ')
ORDER BY name;';

		$request = pg_query(getDb(), $sql);

		$results = pg_fetch_all($request);

		return $results;

	}



	function addColorToPalette($color_id) {


	}

	function deletePalette($palette_id) {


	}

?>