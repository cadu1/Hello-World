<table class="da-table">
<thead>
	<tr>
        <th>C&oacute;d.</th>
		<th>Nome</th>
		<th>IPI(%)</th>
		<th>Categoria Princ.</th>
        <th>Situação</th>
		<th>A&ccedil;&otilde;es</th>
	</tr>
</thead>
<tbody>
<?php
    include("../lib/connection.php");
    $result = mysql_query("SELECT * FROM `categoria_produto`");
    if(mysql_num_rows($result) > 0) {
        while($cat = mysql_fetch_array($result)) {
            echo "<tr>";
            echo "<td class='al_rgt' data-th='C&oacute;d.'>{$cat['categoria_produto_id']}</td>";
    		echo "<td title='Nome' data-th='Nome'><strong>{$cat['categoria_produto_nome']}</strong></td>";	
    		echo "<td class='al_rgt' data-th='IPI'> " . str_replace(".", ",", $cat['categoria_produto_ipi']) . "</td>";	
    		echo "<td class='al_rgt' data-th='Categoria principal'>{$cat['categoria_produto_pai_id']}</td>";
    		echo "<td class='al_rgt' data-th='Valor de Custo'>" . ($cat['categoria_produto_status'] ? "Ativo" : "Inativo") . "</td>";
    		echo "<td nowrap='' data-th='A&cedil;&otilde;es'>" .
    			"<a title='Editar' onclick='EditarCategoria(\"{$cat['categoria_produto_id']}\");' href='#modal_categoria' data-toggle='modal' class='btn btn-inverse'>" .
    				"<i class='icon-pencil icon-white'></i>" .
    			"</a>" .
    			"<a title='Excluir' onclick='DelCategoria(\"{$cat['categoria_produto_id']}\");' class='btn btn-warning'>" .
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