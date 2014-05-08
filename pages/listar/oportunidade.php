<?php
    include("lib/connection.php");

    $query = mysql_query("SELECT COUNT(*) AS total FROM `oportunidade`");
    $rows = mysql_fetch_row($query);

    $query = mysql_query("SELECT COUNT(`oportunidade_id`), (SELECT SUM(IF(`oportunidade_vl_periodo` <> 0.00, `oportunidade_vl_periodo`, `oportunidade_neg_vl`))) FROM `oportunidade` WHERE `status_oportunidade_id` = 1");
    $ganhas = mysql_fetch_array($query);
    $query = mysql_query("SELECT COUNT(`o`.`oportunidade_id`) AS total, SUM(`p`.`parcelas_valor`) AS vl_total FROM `oportunidade` `o` JOIN `parcelas` `p` ON `o`.`oportunidade_id` = `p`.`oportunidade_id` WHERE `o`.`status_oportunidade_id` = 2
");
    $andamento = mysql_fetch_array($query);
    $query = mysql_query("SELECT COUNT(`o`.`oportunidade_id`) AS total, SUM(`p`.`parcelas_valor`) AS vl_total FROM `oportunidade` `o` JOIN `parcelas` `p` ON `o`.`oportunidade_id` = `p`.`oportunidade_id` WHERE `o`.`status_oportunidade_id` = 0
");
    $perdemos = mysql_fetch_array($query);
?>
<div id="da-content-area">
<script>
    function busca_cidades(estado) {
        var url = dominio + diretorio() + "/crm/BuscaCidades/"+estado;
        ajaxHTMLProgressBar('resp_cidade', url, false, false);
    }

    $(function () {
        $("#fechamento_inicio").datepicker({
            dateFormat:'dd/mm/yy',
            dayNames:[
                'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'
            ],
            dayNamesMin:[
                'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
            ],
            dayNamesShort:[
                'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'
            ],
            monthNames:[
                'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
                'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort:[
                'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                'Out', 'Nov', 'Dez'
            ],
            nextText:'Pr&oacute;ximo',
            prevText:'Anterior'
        });
    });

    $(function () {
        $("#fechamento_fim").datepicker({
            dateFormat:'dd/mm/yy',
            dayNames:[
                'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'
            ],
            dayNamesMin:[
                'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
            ],
            dayNamesShort:[
                'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'
            ],
            monthNames:[
                'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
                'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort:[
                'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                'Out', 'Nov', 'Dez'
            ],
            nextText:'Pr&oacute;ximo',
            prevText:'Anterior'
        });
    });
    $(function () {
        $("#data_fim_contrato").datepicker({
            dateFormat:'dd/mm/yy',
            dayNames:[
                'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'
            ],
            dayNamesMin:[
                'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
            ],
            dayNamesShort:[
                'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'
            ],
            monthNames:[
                'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
                'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort:[
                'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                'Out', 'Nov', 'Dez'
            ],
            nextText:'Pr&oacute;ximo',
            prevText:'Anterior'
        });
    });
    $(function () {
        $("#data_inicio_contrato").datepicker({
            dateFormat:'dd/mm/yy',
            dayNames:[
                'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'
            ],
            dayNamesMin:[
                'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
            ],
            dayNamesShort:[
                'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'
            ],
            monthNames:[
                'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
                'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort:[
                'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                'Out', 'Nov', 'Dez'
            ],
            nextText:'Pr&oacute;ximo',
            prevText:'Anterior'
        });
    });
    $(function ($) { // Alocar tarefa
        // Quando o formul�rio for enviado, essa fun��o � chamada
        $("#form_contrato").submit(function () {
            var url = dominio + diretorio() + "/oportunidades/GeraContrato";
            // Exibe mensagem de carregamento
            $("#loading").css('height', '40px');
            $("#loading").show();
            $("#loading").html("Carregando...");
            // Fazemos a requis�o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav�s do m�todo POST
            // Se resposta for false, ou seja, n�o ocorreu nenhum erro
            $.post(url, {oportunidade:$("#id_opt_contrato").val(), nome:$("#nome").val(), datai:$("#data_inicio_contrato").val(), dataf:$("#data_fim_contrato").val(), descricao:$("#descricao").val()}, function (resposta) {
                $("#loading").html(resposta);

            });

            return false;
        });
    });

    function busca_contratos() {
        $("#nome").val('');

        $("#data_inicio_contrato").val('');

        $("#data_fim_contrato").val('');

        $("#descricao").val('');

        var url = dominio + diretorio() + "/oportunidades/BuscaContrato";
        // Exibe mensagem de carregamento
        $("#loading").css('height', '40px');
        $("#loading").show();
        $("#loading").html("Carregando...");
        $.post(url, {oportunidade:$("#id_opt_contrato").val()}, function (resposta) {

            var dados = resposta.split("|");

            $("#nome").val($.trim(dados[0]));

            $("#data_inicio_contrato").val(dados[1]);

            $("#data_fim_contrato").val(dados[2]);

            $("#descricao").val(dados[3]);

            document.getElementById('loading').style.display = 'none';

            //$("#loading").html(resposta);
        });
    }

    $('#fmbusca input').keydown(function (e) {
        if (e.keyCode == 13) {

            $('#fmbusca').attr('action', 'http://bobsoftware.com.br/erp/oportunidades/listar/1/Resultados');
            $('#fmbusca').submit();
        }
    });

    function exportar() {
        $('#fmbusca').attr('action', 'http://bobsoftware.com.br/erp/oportunidades/listar/1/Resultados/0/0/exportar');
        $('#fmbusca').submit();

    }

    $(function () {
        $('#input_busca').each(function () {
            var url = dominio + diretorio() + "/oportunidades/AutoCompleteBuscar?callback=?";
            var autoCompelteElement = this;

            $(this).autocomplete({source:url,
                select:function (event, ui) {
                    $(autoCompelteElement).val(ui.item.label);
                    fLink(dominio + diretorio() + '/oportunidades/form/visualizar/' + ui.item.id);
                }
            });
        });
    });
</script>

	<div class="grid_4">
    <div class="da-panel">
    <div class="da-panel-header">
    	<span class="da-panel-title">
    		<span class="label label-inverse pr_5">
                <i class="icon-briefcase icon-white"></i>
            </span>
    		<strong class="tt_uc">Oportunidades</strong>
    		<span class="box_tools_space">
                <div class="btn-group">
                    <input type="text" style="padding: 9px;" placeholder="Digite a conta ou contato..." id="input_busca"/>
                </div>
            </span>
            <span class="da-panel-btn">
    			<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/oportunidade" class="btn btn-primary">
    				<i class="icon-plus icon-white"></i>Nova
    			</a>
            </span>
    	</span>
    </div>

    <div class="da-panel-content">

    <div class="da-panel-padding">
    
        <div class="container-fluid clr_both">
    <div class="row-fluid">

    
    
    <div class="span12">

    <div class="span3 ws_nw hidden-phone hidden-tablet">
        <a class="btn btn-mini" href="#" id="btn_exportar" onclick="exportar();">
            <i class="icon-download icon-black"></i>Exportar
        </a>
    </div>

    <div class="span9">
    <label class="dsp_ib flt_rgt btn disabled">
        <b><?=$rows[0]?>&nbsp;OPORTUNIDADES</b>
    </label>

    <div class="da-filter hidden-phone hidden-tablet">
    <a class="accordion-toggle dsp_ib flt_rgt btn btn-inverse" data-toggle="collapse" title="Filtrar"
       data-parent="#sanfona" href="#filtro">
        <i class="icon-filter icon-white"></i> Filtro
    </a>

    <div class="accordion pr_0" id="sanfona"> <!-- Precisa de css inline / id="sanfona" -->

    <div class="accordion-group pr_0 brd_none">
    <div class="accordion-heading">

    </div>

    <div id="filtro" class="accordion-body collapse closed">
    <span class="accordion-toggle dsp_b btn btn-inverse disabled">&nbsp;</span>

    <div class="accordion-inner well">

    <form class="form-horizontal" name="fmbusca" method="post" id="fmbusca" action="http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/listar/1/Resultados">
    <fieldset>
            <div class="control-group">
            <label class="control-label">
                Usu&aacute;rio
            </label>
            <div class="controls">
                <select class="input_full" id="nomeuser" name="nomeuser">
                    <option value="todos">Todos</option>
                    <?php
                        $usuario = mysql_query("SELECT * FROM `usuario` WHERE `usuario_ativo` IS TRUE");
                        while($usu = mysql_fetch_array($usuario)) {
                            echo "<option value='{$usu['usuario_id']}'>{$usu['usuario_nome']}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
                <div class="control-group">
            <label class="control-label">
              Vendedor
            </label>
            <div class="controls">
                <select class="input_full" name="vendedor" id="vendedor">
                    <option value="">Selecione</option>
                    <?php
                        $vendedor = mysql_query("SELECT `p`.`pessoa_id` AS `id`, IFNULL(`co`.`contato_nome`, `c`.`conta_nome_fantasia`) AS `nome` FROM `pessoa` `p` LEFT JOIN `contato` `co` ON `p`.`pessoa_id` = `co`.`pessoa_id` LEFT JOIN `conta` `c` ON `p`.`pessoa_id` = `c`.`pessoa_id` WHERE `p`.`situacao_id` = 13");
                        while($ven = mysql_fetch_array($vendedor)) {
                            echo "<option value='{$ven['id']}'>{$ven['nome']}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">
                Oportunidade
            </label>
            <div class="controls">
                <input class="input_full" type="text" id="oportunidade" name="oportunidade"  value=""/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">
                Conta
            </label>

            <div class="controls">
                <input class="input_full" type="text" id="conta" name="conta" value=""/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contato</label>

            <div class="controls">
                <input class="input_full" id="contato" name="contato" value=""/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Estado</label>
            <div class="controls">
                <select class="input_full" name="uf" id="uf" onchange="busca_cidades(this.value);" > 
                    <option value="">Selecione</option>
                    <?php
                        $estado = mysql_query("SELECT * FROM `estado`");
                        while($est = mysql_fetch_array($estado)) {
                            echo "<option value='{$est['estado_id']}'>{$est['estado_nome']}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
    
        <div class="control-group">

            <label class="control-label">Cidade</label>

            <div id="resp_cidade" class="controls"> 
                <select class="input_full" name="cidade" id="cidade">
                    <option value="">Selecione</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Est&aacute;gio</label>
            <div class="controls">
                <select class="input_full" name="estagio" id="estagio">
                    <option value="">Selecione</option>
                    <?php
                        $situacao = mysql_query("SELECT * FROM `situacao` WHERE `situacao_oport` IS TRUE");
                        while($sit = mysql_fetch_array($situacao)) {
                            echo "<option value='{$sit['situacao_id']}'>{$sit['situacao_nome']}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                Chance de Sucesso
            </label>

            <div class="controls">
                <select class="input_full" name="chance" id="chance">
                    <option value="">Selecione</option>
                    <option  value=10>At&eacute;&nbsp;10%</option>
                    <option  value=20>At&eacute;&nbsp;20%</option>
                    <option  value=30>At&eacute;&nbsp;30%</option>
                    <option  value=40>At&eacute;&nbsp;40%</option>
                    <option  value=50>At&eacute;&nbsp;50%</option>
                    <option  value=60>At&eacute;&nbsp;60%</option>
                    <option  value=70>At&eacute;&nbsp;70%</option>
                    <option  value=80>At&eacute;&nbsp;80%</option>
                    <option  value=90>At&eacute;&nbsp;90%</option>
                    <option  value=99>At&eacute;&nbsp;99%</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                Per&iacute;odo
            </label>

            <div class="controls">
                <div class="row-fluid">
                    <div class="span5">
                        <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" type="text"  id="data_inicio" name="data_inicio" value=""/>
                               
                    </div>
                    <div class="span1 lh_200 al_ctr">
                        e
                    </div>
                    <div class="span5">
                        <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);"  onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" value="" type="text"  id="data_fim" name="data_fim"/>
                    </div>
                </div>

            </div>
        </div>

        <div class="control-group">
            <label class="control-label">
                Fechamento Prov&aacute;vel
            </label>

            <div class="controls">
                <div class="row-fluid">
                    <div class="span5">
                        <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);"  onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" type="text"  maxlength="10" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" id="fechamento_inicio" name="fechamento_inicio" value=""/>
                               
                    </div>
                    <div class="span1 lh_200 al_ctr">
                        e
                    </div>
                    <div class="span5">
                        <input class="input_full datepicker" value="" type="text" id="fechamento_fim" name="fechamento_fim"/>
                             
                    </div>
                </div>

            </div>
        </div>
        <div class="form-actions al_rgt">
            <button href="javascript:void(0)"
                    onclick="$('#fmbusca').attr('action','http://bobsoftware.com.br/erp/oportunidades/listar/1/Resultados');$('#fmbusca').submit();"
                    class="btn btn-success"><i class="icon-search icon-white"></i> Filtrar
            </button>
        </div>
    </fieldset>

    </form>

    </div>

    </div>
    </div>
    </div>
    </div>
    </div>

    <div title="Estes s&atilde;o os totais acumulados das oportunidades, eles s&atilde;o atualizados conforme voc&ecirc; configura os filtros" style="padding-top:2px;">        
        <span class="label label-success">Ganhamos: <?=$ganhas[0]?> | R$ <?php echo (empty($ganhas[1]) ? "0,00" : str_replace(".", ",", $ganhas[1]));?></span>
        <span class="label label-info">Em andamento: <?=$andamento[0]?> | R$ <?php echo (empty($andamento[1]) ? "0,00" : str_replace(".", ",", $andamento[1]));?></span>
        <span class="label label-important">Perdemos: <?=$perdemos[0]?> | R$ <?php echo (empty($perdemos[1]) ? "0,00" : str_replace(".", ",", $perdemos[1]));?></span>

        <i id="tip_totais" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    </div>

    <table class="da-table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Chance de Sucesso</th>
                <th width="50px">Oportunidade</th>
                <th>Conta</th>
                <th>Contato</th>
                <th>Est&aacute;gio</th>
                <th>Total (R$)</th>
                <th>
                    A&ccedil;&otilde;es 
                    <i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-white" id="tip_acoes" title="Nos est&aacute;gios: 'Aguardando pedido de venda' e 'Pedido gerado' a oportunidade n&atilde;o pode ser editada ou excluida. Para editar ou excluir, remova o pedido em Vendas->Pedidos de venda"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = mysql_query("SELECT `o`.`oportunidade_id`, `o`.`oportunidade_data`, `o`.`oportunidade_chance_suc`,`o`.`oportunidade_nome`,`co`.`conta_razao_social`, `c`.`contato_nome`,`o`.`status_oportunidade_id`, (SELECT IF(`o`.`oportunidade_vl_periodo` <> 0.00, `o`.`oportunidade_vl_periodo`, `o`.`oportunidade_neg_vl`)), `o`.`oportunidade_faturado` FROM `oportunidade` `o` LEFT JOIN `contato` `c` ON `o`.`pessoa_contato` = `c`.`pessoa_id` LEFT JOIN `conta` `co` ON `o`.`pessoa_conta` = `co`.`pessoa_id`
");
                if(mysql_num_rows($query) > 0) {
                    while($oport = mysql_fetch_array($query)) {
            ?>
            <tr onmouseover="mouse(this);">
                <td data-th="Data" class="al_rgt" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?=date("d/m/Y", strtotime($oport[1]))?>
                </td>
                <td data-th="Chance de Sucesso" class="al_rgt" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?=str_replace(".", ",", $oport[2]) . "%"?>
                </td>
                <td data-th="Oportunidade" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?=$oport[3]?>
                </td>
                <td data-th="Conta" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?=$oport[4]?>
                </td>
                <td data-th="Contato" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?=$oport[5]?>
                </td>
                <td data-th="Est&aacute;gio" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?php
                        switch ($oport[6]) {
                            case "2":
                                echo '<span class="label label-info">Em andamento</span>';
                                break;
                            case "1":
                                echo '<span class="label label-success">Ganhamos</span>';
                                break;
                            case "0":
                                echo '<span class="label label-important">Perdemos</span>';
                                break;
                        }
                    ?>
                </td>
                <td data-th="Total (R$)" class="al_rgt" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/visualizar/<?=$oport[0]?>')">
                    <?php echo (empty($oport[7]) ? "0,00" : str_replace(".", ",", $oport[7]));?>
                </td>
                <td data-th="A&ccedil;&otilde;es">
                <?php if(empty($oport[8])): ?>
                    <a title="Editar" id="editar" onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/oportunidades/form/alterar/<?=$oport[0]?>')" class="btn btn-inverse">
                        <i class="icon-pencil icon-white"></i>
                    </a>
                    <a title="Excluir" id="excluir" onclick="fConfirm('Tem certeza que deseja excluir?', 'http://bobsoftware.com.br/erp/oportunidades/excluir/<?=$oport[0]?>')" class="btn btn-warning">
                        <i class="icon-remove-sign icon-black"></i>
                    </a>
                <?php else: ?>
                    <span class="label">Oportunidade faturada</span>
                <?php endif; ?>
                </td>
            </tr>
            <?php
                    }
                } else {
                    echo '<td class="center" colspan="8">Nenhum registro encontrado.</td>';
                }
            ?>
        </tbody>
    </table>

    </div>

    <div class="pagination"></div>

    </div>

    </div>

    </div>
    </div>
    </div>

    <div class="clear"></div>

    <script type="text/javascript"><!--
    $('#fmbusca input').keydown(function (e) {
        if (e.keyCode == 13) {
            $('#fmbusca').submit();
        }
    });
    //--></script>
</div>
</div>