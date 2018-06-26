<form class="form-inline mt-5" method="get" action="">
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
</form>

<?php 

	require_once('database.php');

	function getColors() {
		$db = getDb();
		$request = pg_query($db, "select id, name, hex from color order by name");
		return $results = pg_fetch_all($request);		
	}

	function displayColor($id, $name, $hex) {

		return '
			<div class="card rounded-0">
				<div class="card-header row" id="color' . $id . '" style="margin: 0 !important; padding: 0 !important; background-color: #FFFFFF;">
					<h5 class="mb-0 col">
						<button class="btn">' . $name . '</button>
					</h5>
					<div class="col m-auto" style="border: 1px solid #000; height: 30px; width: 60px; background-color: #' . $hex . ';"></div>
					<div class="col text-right">
						<button class="btn">X</button>
					</div>
				</div>
			</div>';

	}

	function addColor($name, $hex) {


	}

	function deleteColor($color_id) {

		
	}


?>