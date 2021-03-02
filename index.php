<?
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$link = mysqli_connect("test", "test", "test");

if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}

mysqli_select_db($link,"test");

// Добавить, изменить, удалить актив
if (isset($_GET["operation"])){
	// получаем имя таблицы, в которой будем добавлять, изменять, удалять актив
	$sql = "SELECT `table_name` FROM `types_asset` WHERE `id` = ".$_GET["type_asset"];
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
	$assetTable = $row["table_name"];

	// получаем поля активов для определённого типа актива
	$sql = "SELECT *  FROM `fields` WHERE `type_asset_id` = ".$_GET["type_asset"];
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
	    $arFields[$row["code"]] = "";
	}

	// отфильтровываем в $_GET все параметры, не являющиеся полями таблицы
	$arFields = array_intersect_key($_GET, $arFields);

	if ($_GET["operation"] == 'remove') { // удаление
		$sql = "DELETE FROM `".$assetTable."` WHERE `".$assetTable."`.`id` = ".$_GET["id_asset"];
		$result = mysqli_query($link, $sql);
		$sql = "DELETE FROM `assets` WHERE `assets`.`id` = ".$_GET["id"];
		$result = mysqli_query($link, $sql);
	} elseif ($_GET["operation"] == 'add') {
		// Сформируем из ключей и значений строки полей и их значений соответственно для запроса в бд
		foreach ($arFields as $key => $value) {
			$strFields = $strFields."`".$key."`, ";
			$strValues = $strValues."'".$value."', ";
		}
		$strFields = rtrim($strFields, ", ");
		$strValues = rtrim($strValues, ", ");

		// Выполняем два insert. Первый в таблицу конкретного типа актива, второй - в общую
		$sql = "INSERT INTO `".$assetTable."` (`id`, ".$strFields.") VALUES (NULL, ".$strValues.")";
		$result = mysqli_query($link, $sql);
		if ($result) {
			$lastID = mysqli_insert_id($link);
			$sql = "INSERT INTO `assets` (`id`, `name`, `type_asset`, `id_asset`) VALUES (NULL, '".$_GET["name"]."', ".$_GET["type_asset"].", $lastID)";
			$result = mysqli_query($link, $sql);
		}
	} elseif ($_GET["operation"] == 'update') {
		// Сформируем набор пар [ключ]=>[значение] для запроса UPDATE
		$pairs = "";
		foreach ($arFields as $key => $value) {
			$pairs = $pairs."`".$key."` = '".$value."', ";
		}
		$pairs = rtrim($pairs, ", ");

		$sql = "SELECT `id_asset` FROM `assets` WHERE `id` = ".$_GET["asset_id"];
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_assoc($result);
		$assetId = $row["id_asset"];
		$sql = "UPDATE `assets` SET `name` = '".$_GET["name"]."' WHERE `assets`.`id` = ".$_GET["asset_id"];
		$result = mysqli_query($link, $sql);
		$sql = "UPDATE `".$assetTable."` SET ".$pairs." WHERE `".$assetTable."`.`id` = ".$assetId;
		$result = mysqli_query($link, $sql);
	}
	header("Location: index.php");
}

// подгружаем общую таблицу активов
$sql = "SELECT a.id, a.name, a.type_asset, a.id_asset, ta.name `type_asset_name`, m.par, c.coeff FROM `assets` a INNER JOIN `types_asset` ta ON ta.id = a.type_asset LEFT JOIN `money` m ON m.id = a.id_asset AND a.type_asset = 1 LEFT JOIN `currency` c ON m.currency_id = c.id";
$result = mysqli_query($link, $sql);
$summ = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $arResult[] = $row;
    $summ = $summ + $row["par"] * $row["coeff"];
}

// Подгружаем типы активов
$sql = "SELECT * FROM `types_asset`";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $arAssetTypes[] = $row;
}

include 'template.php';
?>