<?php
	include ("../../lib/connection.php");

	$consulta = mysql_query("SELECT * FROM `origem` WHERE origem_nome LIKE '%{$_GET['nome']}%'");

	while ($origem = mysql_fetch_array($consulta)) {
		echo "<div class='control-group-linha'>" .
			"<i style='margin-top: -1px;' class='close flt_lft' onmouseover='mouse(this);'" .
			"onclick=\"if(confirm('Deseja realmente excluir?')){DeletarOrigem({$origem['origem_id']})};\"> x&nbsp;" .
			"</i><label class='flt_lft' id='origem_{$origem['origem_id']}' style='display:inline;' onclick='EditarOrigem(this.id)'>" .
			"{$origem['origem_nome']}</label></div>";
	}
?>