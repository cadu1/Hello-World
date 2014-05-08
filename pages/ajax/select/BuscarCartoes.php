<?php
    include("../../lib/connection.php");
?>
<table class="da-table">
	<thead>
		<tr>
			<th>Cart&atilde;o</th>
			<th>Vence no dia</th>
			<th>Dia limite para compra</th>
			<th>Limite</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>
	</thead>
	<tbody>
        <?php
            $query = mysql_query("SELECT `cartao_credito_id`,`cartao_credito_nome`,`cartao_credito_dia_fat`,`cartao_credito_dia_limite`,`cartao_credito_limite` FROM `cartao_credito`");
            if(mysql_num_rows($query) > 0):
                while($cartao = mysql_fetch_array($query)):
        ?>
        <tr>
			<td data-th="Cart&atilde;o"><?=$cartao[1]?></td>
			<td class="al_rgt" data-th="Dia do vencimento"><?=$cartao[2]?></td>
			<td class="al_rgt" data-th="Dia do vencimento"><?=$cartao[3]?></td>
			<td class="al_rgt" data-th="Limite"><?=number_format($cartao[4], 2, ",", ".")?></td>
			<td data-th="A&ccedil;&otilde;es" nowrap="">
				<a class="btn btn-inverse" data-toggle="modal" href="#modal_cartao" title="Editar" onclick="EditarCartao(<?=$cartao[0]?>);">
					<i class="icon-pencil icon-white"></i>
				</a>
				<a class="btn btn-warning" title="Excluir" onclick="DelCartao(<?=$cartao[0]?>);">
					<i class="icon-remove-sign icon-black"></i>
				</a>
			</td>
		</tr>
        <?php
                endwhile;
            else:
        ?>
        <tr>
		    <td colspan="5">Nenhum registro encontrado</td>
		</tr>
        <?php endif; ?>	
	</tbody>
</table>
<?php exit(); ?>