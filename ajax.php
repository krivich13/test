<?
if (isset($_GET["type_asset"])) {
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$link = mysqli_connect("test", "test", "test");

	if ($link == false){
	    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
	}

	mysqli_select_db($link,"test");

	// подгружаем поля из спец таблицы на основе выбранного типа актива
	$sql = "SELECT * FROM `fields` WHERE `type_asset_id` = ".$_GET["type_asset"];
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
	    $arFields[] = $row;
	}

	if (isset($_GET["id"])) {
		// получаем имя таблицы, из которой будем подгружать актив для редактирования
		$sql = "SELECT `table_name` FROM `types_asset` WHERE `id` = ".$_GET["type_asset"];
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_assoc($result);
		$assetTable = $row["table_name"];

		// получаем сам актив для редактирования
		$sql = "SELECT ".$assetTable.".* FROM assets JOIN ".$assetTable." ON ".$assetTable.".id = assets.id_asset WHERE assets.id = ".$_GET["id"];
		$result = mysqli_query($link, $sql);
		$asset = mysqli_fetch_assoc($result);
	}

	// формируем html - код ответа

	if (isset($_GET["id"])) {
		echo "<input type=\"hidden\" name=\"asset_id\" value=\"".$_GET["id"]."\">";
	}
	foreach ($arFields as $field) {
		echo "<label for=\"".$field["code"]."\">".$field["name"]."</label>";
		if ($field["type"] == "input") {
			echo "<input type=\"text\" name=\"".$field["code"]."\" id=\"".$field["code"]."\" value=\"".$asset[$field["code"]]."\" class=\"text ui-widget-content ui-corner-all\"><br>";
		} elseif ($field["type"] == "select") {
			echo "<select id=\"".$field["code"]."\" name=\"".$field["code"]."\">";
			$sql = "SELECT * FROM `".$field["table_of_values"]."`";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
	    		$arSelectVals[] = $row;
	    	}
			foreach ($arSelectVals as $selOpt) {
		        $selected = "";
		        if ($selOpt["id"] == $asset[$field["code"]]) {
		        	$selected = " selected";
		        }
		        echo "<option value=".$selOpt["id"].$selected.">".$selOpt["name"]."</option>";
		    }
	    	echo "</select><br>";
		}
	}
}
?>