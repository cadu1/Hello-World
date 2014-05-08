<?php
    include("../../lib/connection.php");
?>
<table class="table table-bordered table-striped" align="center" style="background: #fff;">
	<thead>
		<tr>
			<th>Item</th>
			<th>Tipo</th>
			<th>Qtd</th>
			<th>Valor (R$)</th>
			<th >Valor original (R$)</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>
	</thead>
	<tbody>
        <?php
            $query = mysql_query("SELECT `it`.*, `p`.`produto_nome`, `p`.`produto_vl_venda` FROM `itens_temporario` `it` JOIN `produto` `p` ON `it`.`produto_id` = `p`.`produto_id` WHERE `it`.`usuario_id` = {$_COOKIE['id']}");
            if(mysql_num_rows($query) > 0) {
                while($item = mysql_fetch_array($query)) {
        ?>
		<tr title="<?=$item['usuario_id']?>">
			<td title="Nome"  data-th="Produto/Servi&ccedil;o"><?=$item['produto_nome']?></td>
			<td title="Tipo" data-th="Tipo">produto</td>
			<td title="Quantidade" class="al_rgt" data-th="Quantidade"><?=$item['itens_temporario_qtd']?></td>
			<td title="Valor" class="al_rgt" data-th="Valor"><?=$item['itens_temporario_vl']?></td>
			<td  class="al_rgt" data-th="Valor de tabela"><?=$item['produto_vl_venda']?></td>
			<td nowrap="" data-th="A&ccedil;&otilde;es">
				<a title="Excluir" onclick="DelItem('<?=$item['usuario_id']?>');" class="btn btn-warning">
					<i class="icon-remove-sign icon-black"></i>
				</a>
			</td>
		</tr>
        <?php
                }
            } else {
                echo '<td colspan="6" data-th="Produto/Serviccedil;o" title="Produto/Serviccedil;o" style="background: #fff;">Nenhum produto ou servi&ccedil;o adicionado</td>';
            }
            $query = mysql_query("SELECT SUM(`itens_temporario_vl`) AS total FROM `itens_temporario` WHERE `usuario_id` = {$_COOKIE['id']}");
            $vl = mysql_fetch_row($query);
            $vl = empty($vl[0]) ? "0,00" : $vl[0];
        ?>
		<tr>
			<td class="al_rgt" colspan="4" data-th="Produto/Servi&ccedil;o" title="Produto/Servi&ccedil;o" style="background: #fff;" align="left">
                <strong>Subtotal (R$)</strong>
            </td>
			<td class="al_rgt" data-th="Produto/Serviccedil;o" title="Produto/Serviccedil;o" style="background: #fff;">
                <strong><?=str_replace(".", ",", $vl)?></strong>
            </td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php
    exit();
?>