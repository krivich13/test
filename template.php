<!DOCTYPE html>
<html>
	<head>
  		<meta charset="utf-8" />
  		<title>Тест</title>
  		<style>
			body{
				font-family: "Trebuchet MS", sans-serif;
				margin: 50px;
			}
		</style>
  		<script src="jquery-3.5.1.min.js"></script>
  		<link rel="stylesheet" type="text/css" href="jqueryui/jquery-ui.min.css"/>
  		<script src="jqueryui/jquery-ui.min.js"></script>
  		<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
		<script src="script.js"></script>
 	</head>
 	<body>

		<table id="table_id" class="display">
		    <thead>
		        <tr>
		            <?foreach ($arResult[0] as $key => $value) {
		            	echo "<th>".$key."</th>";
		        	}
		        	echo "<th></th>";
		        	echo "<th></th>";?>
		        </tr>
		    </thead>
		    <tbody>
		        <?foreach ($arResult as $record) {
		            echo "<tr>";
		            foreach ($record as $key => $value) {
		            	echo "<th>".$value."</th>";
		            }
		            echo "<th><button class=\"asset-edit\" value=\"".$record["id"]."\">Правка</button></th>";
		            echo "<th><button type=\"submit\" name=\"id\" class=\"asset-remove\" value=\"".$record["id"]."\">Удалить</button></th>";
		            echo "</tr>";
		        	}?>
		    </tbody>
		   	<tfoot>
	            <tr>
	                <th colspan="9" style="text-align:right">Сумма денежных активов: <?=$summ?></th>
	            </tr>
	        </tfoot>
		</table>

		<button id="add-asset">Добавить актив</button>

		<div id="add-asset-form" title="Добавить актив">
			<form action="index.php">
			    <fieldset>
			      <input type="hidden" name="operation" value="add">
			      <label for="name">Название</label>
			      <input type="text" name="name" value="" class="text ui-widget-content ui-corner-all"><br>
			      <label for="type_asset">Тип актива</label>
			      <select name="type_asset">
			        <?foreach ($arAssetTypes as $value) {
		            		echo "<option value=".$value["id"].">".$value["name"]."</option>";
		            	}?>
			      </select><br>
			      <div class="custom-fields">
			      </div>
			      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			    </fieldset>
			</form>
		</div>

		<div id="edit-asset-form" title="Редактировать актив">
			<form action="index.php">
			    <fieldset>
			      <input type="hidden" name="operation" value="update">
			      <input type="hidden" name="type_asset" value="">
			      <label for="name">Название</label>
			      <input type="text" name="name" value="" class="text ui-widget-content ui-corner-all"><br>
			      <label for="asset_name">Тип актива</label>
			      <input type="text" name="asset_name" value="" class="text ui-widget-content ui-corner-all" disabled><br>
			      <div class="custom-fields">
			      </div>
			      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			    </fieldset>
			</form>
		</div>

		<div id="remove-asset-form" title="Удалить актив">
			<form action="index.php">
			      <input type="hidden" name="operation" value="remove">
			      <input type="hidden" name="id" value="">
			      <input type="hidden" name="type_asset" value="">
			      <input type="hidden" name="id_asset" value="">
			      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			</form>
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Вы действительно хотите удалить актив "</p>
		</div>

	</body>
</html>