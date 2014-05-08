<?php
    include("../../lib/connection.php");
    $id = "";
    if($_GET) {
        $id = $_GET["id"];
    } else {
        exit();
    }
?>
<table class="table table-bordered table-striped" align="center" style="background: #fff;">
	<thead>
		<tr>
			<th>Item</th>
			<th>Tipo</th>
			<th>Qtd</th>
			<th>Valor (R$)</th>
			<th colspan="2">Valor original (R$)</th>
		</tr>
	</thead>
	<tbody>
    <?php
        $query = mysql_query("SELECT `p`.`produto_nome`, `po`.`produto_oportunidade_qtd`, `po`.`produto_oportunidade_vl`, `p`.`produto_vl_venda` FROM `produto_oportunidade` `po` JOIN `produto` `p` ON `po`.`produto_id` = `p`.`produto_id` WHERE `po`.`oportunidade_id` = $id");
        if(mysql_num_rows($query) > 0):
            while($item = mysql_fetch_array($query)):
    ?>
		<tr title="1">
			<td title="Nome" data-th="Produto/Serviccedil;o"><?=$item[0]?></td>	
			<td title="Tipo" data-th="Tipo">produto</td>	
			<td title="Quantidade" class="al_rgt" data-th="Quantidade"><?=$item[1]?></td>
			<td title="Valor" class="al_rgt" data-th="Valor"><?=number_format($item[2],2,",",".")?></td>
			<td colspan="2" class="al_rgt" data-th="Valor de tabela"><?=number_format($item[3],2,",",".")?></td>
		</tr>
    <?php
            endwhile;
        else:
            echo '<td colspan="6" data-th="Produto/Serviccedil;o" title="Produto/Serviccedil;o" style="background: #fff;">Nenhum produto ou servi&ccedil;o adicionado</td>';
        endif;
        $query = mysql_query("SELECT SUM(`produto_oportunidade_vl`) FROM `produto_oportunidade` WHERE `oportunidade_id` = $id");
        $vl_total = mysql_fetch_row($query);
    ?>
		<tr>
			<td class="al_rgt" colspan="4" data-th="Produto/Serviccedil;o" title="Produto/Serviccedil;o" style="background: #fff;" align="left"><strong>Subtotal (R$)</strong></td>
			<td colspan="2" class="al_rgt" data-th="Produto/Serviccedil;o" title="Produto/Serviccedil;o" style="background: #fff;"><strong><?=number_format($vl_total[0],2,",",".")?></strong></td>
		</tr>
	</tbody>
</table>
<?php
    exit();
?>