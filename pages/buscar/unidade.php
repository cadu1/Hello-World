<table class="da-table">
<thead>
	<tr>
        <th>C&oacute;d.</th>
		<th>Nome</th>
		<th>Sigla</th>
		<th>A&ccedil;&otilde;es</th>
	</tr>
</thead>
<tbody>
<?php
    include("../lib/connection.php");
    $result = mysql_query("SELECT * FROM `unidade_medida`");
    
    if(mysql_num_rows($result)) {
        while($uni = mysql_fetch_array($result)) {
            echo "<tr>";
            echo "<td class='al_rgt' data-th='C&oacute;d.'>{$uni['unidade_medida_id']}</td>";
    		echo "<td title='Nome' data-th='Nome'><strong>{$uni['unidade_medida_nome']}</strong></td>";	
    		echo "<td class='al_rgt' data-th='Sigla'>{$uni['unidade_medida_sigla']}</td>";
    		echo "<td nowrap='' data-th='A&cedil;&otilde;es'>" .
    			"<a title='Editar' onclick='EditarUnidade(\"{$uni['unidade_medida_id']}\");' href='#modal_unidade' data-toggle='modal' class='btn btn-inverse'>" .
    				"<i class='icon-pencil icon-white'></i>" .
    			"</a>" .
    			"<a title='Excluir' onclick='DelUnidade(\"{$uni['unidade_medida_id']}\");' class='btn btn-warning'>" .
    				"<i class='icon-remove-sign icon-black'></i>" .
    			"</a>" .
    		"</td>";
            echo "</tr>";
        }
    } else {
        echo '<tr class="odd"><td align="center" colspan="7">Nenhum registro encontrado.</td></tr>';
    }
 ?>
</tbody>
</table>