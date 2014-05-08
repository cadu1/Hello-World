<table class="da-table">
	<thead>
		<tr>
			<th>Produto</th>
			<th>Referencia</th>
			<th>Categoria</th>
			<th>Fornecedor</th>
			<th>Data Cadastro</th>
            <th>A&ccedil;&otilde;es</th>
		</tr>
	</thead>
	<tbody>
    <?php
        include("../lib/connection.php");
        
        $sql = mysql_query("SELECT `pr`.`produto_nome`, `pr`.`produto_referencia`, `pr`.`produto_dt_cad`,`pr`.`produto_id`, `cp`.`categoria_produto_nome` AS categoria, IFNULL(`c`.`conta_nome_fantasia`,`co`.`contato_nome`) AS nome, `um`.`unidade_medida_nome` AS unidade FROM `produto` `pr` JOIN `categoria_produto` `cp` ON `pr`.`categoria_produto_id` = `cp`.`categoria_produto_id` JOIN `unidade_medida` `um` ON `pr`.`unidade_medida_id` = `um`.`unidade_medida_id` LEFT JOIN `conta` `c` ON `pr`.`pessoa_id` = `c`.`pessoa_id` LEFT JOIN `contato` `co` ON `pr`.`pessoa_id` = `co`.`pessoa_id`");
        
        if(mysql_num_rows($sql) > 0) {
            while($produto = mysql_fetch_array($sql)) {
                echo "<tr>" .
        			"<td title=\"Produto\" data-th=\"Produto\"><strong>{$produto['produto_nome']}</strong></td>" .
        			"<td class=\"al_rgt\" data-th=\"Referencia\">{$produto['produto_referencia']}</td>" .
        			"<td class=\"al_rgt\" data-th=\"Categoria\">{$produto['categoria']}</td>" .
        			"<td class=\"al_rgt\" data-th=\"Fornecedor\">{$produto['nome']}</td>" .
                    "<td class=\"al_rgt\" data-th=\"Data Cadastro\">" . date("d/m/Y", strtotime($produto['produto_dt_cad'])) . "</td>" .
        			"<td nowrap=\"\" data-th=\"A&ccedil;&otilde;es\">" .
        				"<a title=\"Editar\" onclick=\"EditarProduto('{$produto['produto_id']}');\" href=\"#modal_produto\" data-toggle=\"modal\" class=\"btn btn-inverse\">" .
        					"<i class=\"icon-pencil icon-white\"></i>" .
        				"</a>" .
        				"<a title=\"Excluir\" onclick=\"DelProduto('{$produto['produto_id']}');\" class=\"btn btn-warning\">" .
        					"<i class=\"icon-remove-sign icon-black\"></i>" .
        				"</a>" .
        			"</td>" .
        		"</tr>";
            }
        } else {
            echo '<tr class="odd"><td align="center" colspan="7">Nenhum registro encontrado.</td></tr>';
        }
    ?>
	</tbody>
</table>