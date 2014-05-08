<?php
    include("../../lib/connection.php");
?>
<table class="da-table">
	<thead>
		<tr>
			<th>Data da venda</th>
			<th>Oportunidade</th>
			<th>Conta</th>
			<th>Contato</th>
			<th>Total (R$)</th>
		</tr>
	</thead>
	<tbody>
    <?php
        $pedidos = mysql_query("SELECT `o`.`oportunidade_id`, `o`.`oportunidade_dt_fec`, `o`.`oportunidade_nome`, `c`.`conta_razao_social`, `cc`.`contato_nome`, `oportunidade_neg_vl` FROM `oportunidade` `o` LEFT JOIN `conta` `c` ON `o`.`pessoa_conta` = `c`.`pessoa_id` LEFT JOIN `contato` `cc` ON `o`.`pessoa_contato` = `cc`.`pessoa_id` WHERE `o`.`status_oportunidade_id` = 1 AND `o`.`oportunidade_pedido` = TRUE AND `o`.`oportunidade_faturado` = FALSE");
        if(mysql_num_rows($pedidos) > 0):
            while($pedido = mysql_fetch_row($pedidos)):
    ?>
        <tr onmouseover="mouse(this);" style="cursor: pointer;">
			<td data-th="Data" class="al_rgt" onclick="fLink('https://bobsoftware.com.br/erp/pedidos/form/visualizar/3/faturados')"><?=date("d/m/Y", strtotime($pedido[1]))?></td>
			<td data-th="Oportunidade" onclick="fLink('https://bobsoftware.com.br/erp/pedidos/form/visualizar/3/faturados')"><?=$pedido[2]?></td>
			<td data-th="Conta" onclick="fLink('https://bobsoftware.com.br/erp/pedidos/form/visualizar/3/faturados')"><?=empty($pedido[3]) ? "N&atilde;o Possui" : $pedido[3]?></td>
			<td data-th="Contato" onclick="fLink('https://bobsoftware.com.br/erp/pedidos/form/visualizar/3/faturados')"><?=empty($pedido[4]) ? "N&atilde;o Possui" : $pedido[4]?></td>
			<td data-th="Total (R$)" class="al_rgt" onclick="fLink('https://bobsoftware.com.br/erp/pedidos/form/visualizar/3/faturados')"><?=number_format($pedido[5],2,",",".")?></td>
		</tr>
    <?php
            endwhile;
        else:
    ?>
		<tr>
			<td class="center" colspan="5">Nenhum registro encontrado.</td>
		</tr>
    <?php endif; ?>
	</tbody>
</table>