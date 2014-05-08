<select name="origem" id="origem">
    <option value="">Selecione</option>
<?php
    include("../../lib/connection.php");
	if (!empty($_GET["id"])) {
		$consulta = mysql_query("SELECT * FROM `origem`");
 
		while ($ori = mysql_fetch_array($consulta)) {
			echo "<option  value='{$ori["origem_id"]}' " . ($ori["origem_id"] == $_GET["id"] ? "selected" : "") . ">{$ori["origem_nome"]}</option>";
		}
	} else {
        $consulta = mysql_query("SELECT * FROM `origem`");
     
        while ($ori = mysql_fetch_array($consulta)) {
            echo "<option  value='{$ori["origem_id"]}'>{$ori["origem_nome"]}</option>";
        }
	}
?>
</select>
<a class="badge badge-inverse" href="#modal_origem" onclick="BuscarOrigem();" onmouseover="mouse(this);" data-toggle="modal" style="cursor: pointer;">Editar</a>