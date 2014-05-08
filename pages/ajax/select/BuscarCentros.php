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
        $query = mysql_query("SELECT * FROM `centro_custo`");
        if(mysql_num_rows($query) > 0):
            while($custo = mysql_fetch_array($query)):
    ?>
		<tr>
			<td data-th="Nome"><?=$custo[1]?></td>	
			<td data-th="A&ccedil;&otilde;es" nowrap>
				<a class="btn btn-inverse" data-toggle="modal" href="#modal_centro" title="Editar" onclick="EditarCentro(<?=$custo[0]?>);">
					<i class="icon-pencil icon-white"></i>
				</a>
				<a class="btn btn-warning" title="Excluir" onclick="DelCentro(<?=$custo[0]?>);">
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