<?php
    include("../../lib/connection.php");
?>
<span class="tt_uc"></span>	
<table class="da-table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Limite</th>
            <th>Banco</th>
            <th>Ag&ecirc;ncia</th>
            <th>N&uacute;mero</th>
            <th>A&ccedil;&otilde;es</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $contas = mysql_query("SELECT `c`.`caixa_id`,`c`.`caixa_nome`, `cc`.`conta_corrente_limite`, `b`.`banco_nome`, `cc`.`conta_corrente_agencia`, `cc`.`conta_corrente_num` FROM `caixa` `c` JOIN `conta_corrente` `cc` ON `c`.`caixa_id` = `cc`.`caixa_id` JOIN `banco` `b` ON `cc`.`banco_id` = `b`.`banco_id`");
            if(mysql_num_rows($contas) > 0):
                while($conta = mysql_fetch_array($contas)):
        ?>
        <tr>
            <td data-th="Conta"><label><?=$conta[1]?></label></td>
            <td data-th="Limite" class="al_rgt"><label class="text-info"><?=number_format($conta[2], 2, ",", ".")?></label></td>
            <td data-th="Banco"><label class="text-info"><?=$conta[3]?></label></td>
            <td data-th="Ag&ecirc;ncia" class="al_rgt"><label class="text-info"><?=$conta[4]?></label></td>
            <td data-th="N&uacute;mero" class="al_rgt"><label class="text-info"><?=$conta[5]?></label></td>
            <td data-th="A&ccedil;&otilde;es" nowrap>
                <a class="btn btn-inverse" data-toggle="modal" href="#modal_conta" title="Editar" onclick="EditarConta(<?=$conta[0]?>);">
                    <i class="icon-pencil icon-white"></i>
                </a>
                <a class="btn btn-warning" title="Excluir" onclick="DelConta(<?=$conta[0]?>);">
                    <i class="icon-remove-sign icon-black"></i>
                </a>
            </td>
        </tr>
        <?php 
                endwhile;
            else: 
        ?>
        <tr>
            <td colspan="6">Nenhum registro encontrado</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php exit(); ?>