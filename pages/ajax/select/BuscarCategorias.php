<?php
    include("../../function/function.php");
?>
<table class="da-table">
    <thead>
    	<tr>
    		<th>Nome</th>
    		<th>Tipo</th>
    		<th>Ações</th>
    	</tr>
    </thead>
    <tbody>
    	<?php montarCategoria(); ?>
    </tbody>
</table>
<div id="div_categorias" style="display:none;" >
	<select id="pai_categoria" onchange="ConfigTipo();">
        <option id="pai_categoria_0" value="">Selecione</option>
        <?php
            $sql = mysql_query("SELECT `categoria_id`,`categoria_nome` FROM `categoria` WHERE `id_subcategoria` IS NULL AND `categoria_id` <> 1");
            while($cat = mysql_fetch_row($sql)):
        ?>
        <option id="pai_categoria_<?=$cat[0]?>" value="<?=$cat[0]?>"><?=$cat[1]?></option>
        <?php endwhile; ?>
	</select>
	<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_categoria_pai" title="Atrav&eacute;s deste campo, voc&ecirc; informa que uma categoria &eacute; subcategoria de outra"></i>
</div>