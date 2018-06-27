<?php 

	require_once('utility.php');

	if (isset($_GET['colorName']) && isset($_GET['hexCode'])) {
		$safeName = htmlentities($_GET['colorName'], ENT_QUOTES);
		$safeHex = htmlentities($_GET['hexCode'], ENT_QUOTES);
		addColor($safeName, $safeHex);
	}
	elseif (isset($_POST['deleteColorId'])) {

		$safeColorId = htmlentities($_POST['deleteColorId'], ENT_QUOTES);

		if (isset($_POST['deleteFromPaletteId'])) {

			// Deleting a color in a palette (ie from color_palette table)
			$safePaletteId = htmlentities($_POST['deleteFromPaletteId'], ENT_QUOTES);
			deleteColorFromPalette($safeColorId, $safePaletteId);

		}
		else {

			// Delete a color from the color table
			deleteColor($safeColorId);

		}

	}

	function colorForm() {

		return '<div><form class="form-inline mt-5" method="get" action="">
	<label class="sr-only" for="colorName">Color Name</label>
	<input type="text" class="rounded-0 form-control mb-2 mr-sm-2 mb-sm-0" id="colorName" name="colorName" placeholder="The deep dark void...">

	<label class="sr-only" for="hexCode">Hex Code</label>
	<div class="input-group mb-2 mr-sm-2 mb-sm-0">
		<div class="input-group-prepend">
			<div class="rounded-0 input-group-text">#</div>
		</div>
		<input type="text" class="rounded-0form-control" id="hexCode" name="hexCode" placeholder="a1b2c3" maxlength="6" size="6">
	</div>

	<button type="submit" class="btn btn-secondary rounded-0">Add Color</button>
</form></div>';

	}

	function getColors() {

		$request = pg_query(getDb(), "select id, name, hex from color order by name");
		return $results = pg_fetch_all($request);		
	
	}

	function displayColor($id, $name, $hex, $showDeleteColor = true, $deleteFromPaletteId = 0) {

		$output = '
			<div class="card rounded-0">
				<div class="card-header row" id="color' . $id . '" style="margin: 0 !important; padding: 0 !important; background-color: #FFFFFF;">
					<div class="col m-auto"><strong>' . $name . '</strong> <span class="text-secondary">#' . $hex . '</span></div>
					<div class="col m-auto" style="border: 1px solid #000; height: 30px; width: 60px; background-color: #' . $hex . ';"></div>';
		
		if ($showDeleteColor) {

			if (assignedPalettes($id) > 0) {

				// The inactive version of the button
				// Shouldn't delete a color if it is in any palettes
				$output .= '<div class="col col-sm-auto text-right">
						<button class="btn" disabled><i class="far fa-trash-alt"></i></button>
					</div>';
			}
			else {

				// Okay to delete this one
				$output .= '<div class="col col-sm-auto text-right">
						<form method="post" action="">
							<button class="btn text-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
							<input type="hidden" name="deleteColorId" value="' . $id . '">
						</form>
					</div>';
			}

		}

		if ($deleteFromPaletteId > 0) {

				$output .= '<div class="col col-sm-auto text-right">
						<form method="post" action="">
							<button class="btn text-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
							<input type="hidden" name="deleteColorId" value="' . $id . '">
							<input type="hidden" name="deleteFromPaletteId" value="' . $deleteFromPaletteId . '">
						</form>
					</div>';

		}

		$output .= '</div>
			</div>';

		return $output;

	}

	function assignedPalettes($color_id) {

		$request = pg_query(getDb(), "SELECT count(*) FROM color_palette WHERE color_id = " . $color_id);
		return pg_fetch_row($request)[0];

	}


	function addColor($name, $hex) {

		$sql = "INSERT INTO color (name, hex) VALUES ('" . $name . "', '" . $hex . "');";

		$db = getDb(); // So that we can check pg_last_error later

		$request = pg_query($db, $sql);

		if ($request) {
			$_SESSION['info'] = "<strong>" . $name . "</strong> was added to the color list.";
			$newUrl = removeParams(assembleCurrentUrl(), [ 'colorName', 'hexCode' ]);
			header('Location: '.$newUrl);
			exit();
		}
		else {
			$_SESSION['error'] = cleanUpErrorMessage(pg_last_error($db));
		}

	}

	function getColorName($color_id) {

		$request = pg_query(getDb(), "SELECT name FROM color WHERE id = " . $color_id);
		return pg_fetch_row($request)[0];

	}

	function getPaletteName($palette_id) {

		$request = pg_query(getDb(), "SELECT name FROM palette WHERE id = " . $palette_id);
		return pg_fetch_row($request)[0];

	}


	function deleteColor($color_id) {

		$name = getColorName($color_id);

		$sql = "DELETE FROM color WHERE id = " . $color_id;

		$db = getDb(); // So that we can check pg_last_error later

		$request = pg_query($db, $sql);

		if ($request) {
			$_SESSION['info'] = "<strong>" . $name . "</strong> was removed from the color list.";
			$newUrl = removeParams(assembleCurrentUrl(), []);
			header('Location: '.$newUrl);
			exit();
		}
		else {
			$_SESSION['error'] = cleanUpErrorMessage(pg_last_error($db));
		}		

	}

	function deleteColorFromPalette($color_id, $palette_id) {

		$name = getColorName($color_id);

		$sql = "DELETE FROM color_palette WHERE color_id = " . $color_id . ' and palette_id = kjflsdkfls' . $palette_id;

		$db = getDb(); // So that we can check pg_last_error later

		$request = pg_query($db, $sql);

		if ($request) {
			$_SESSION['info'] = "<strong>" . $name . "</strong> was removed from the <strong> " . getPaletteName($palette_id) . "</strong> palette.";
			$newUrl = removeParams(assembleCurrentUrl(), []);
			header('Location: '.$newUrl);
			exit();
		}
		else {
			$_SESSION['error'] = cleanUpErrorMessage(pg_last_error($db));
		}		

	}


?>