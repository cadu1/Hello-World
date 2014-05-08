<?php
    include("../../lib/connection.php");
?>
<table class="da-table">
	<thead>
		<tr>
			<th>Nome</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>
	</thead>
	<tbody>
        <?php
            $query = mysql_query("SELECT `c`.`caixa_id`, `c`.`caixa_nome` FROM `caixa` `c` LEFT JOIN `conta_corrente` `cc` ON `c`.`caixa_id` = `cc`.`caixa_id` WHERE `cc`.`caixa_id` IS NULL");
            if(mysql_num_rows($query) > 0):
                while($caixa = mysql_fetch_array($query)):
        ?>
		<tr>
			<td data-th="Conta"><?=$caixa[1]?></td>
			<td data-th="A&ccedil;&otilde;es" nowrap>
				<a class="btn btn-inverse" data-toggle="modal" href="#modal_caixapequeno" title="Editar" onclick="EditarCaixap(<?=$caixa[0]?>);">
					<i class="icon-pencil icon-white"></i>
				</a>
				<a class="btn btn-warning" title="Excluir" onclick="DelCaixap(<?=$caixa[0]?>);">
					<i class="icon-remove-sign icon-black"></i>
				</a>
			</td>
		</tr>
        <?php
                endwhile;
            else:
        ?>
        <tr>
			<td colspan="2">Nenhum registro encontrado</td>
		</tr>
        <?php endif; ?>
	</tbody>
</table>
<?php exit(); ?>