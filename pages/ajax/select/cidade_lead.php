<select name="cidade" id="cidade" class="input_full">
    <option value="">Selecione</option>
    <?php
    	include ("../../lib/connection.php");

    	if (((int)$_GET['id']) > 0) {
    		$cid = mysql_query("SELECT * FROM `cidade` WHERE `estado_id` = " . $_GET['id']);
    		while ($cidade = mysql_fetch_array($cid)) {
    			echo "<option value='{$cidade['cidade_id']}'>{$cidade['cidade_nome']}</option>";
    		}
    	}
    ?>
</select>