<?php
    include("lib/connection.php");
    $id = "";
    $erro = "";
    /*echo "<pre>";
    print_r($_GET);
    echo "</pre>";
    exit();*/
    if($_GET) {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if(!empty($id)) {
            $query = mysql_query("SELECT  `l`.`lead_id`, `s`.`situacao_nome`, `l`.`situacao_id`, `l`.`lead_nome`, `i`.`informacao_email`, `i`.`informacao_site`, `l`.`lead_conta`, `i`.`informacao_telefone`, `i`.`informacao_telefone2`, `o`.`origem_nome`, `uf`.`estado_nome`, `c`.`cidade_nome`, `e`.`endereco_cep`, `e`.`endereco_logradouro`, `e`.`endereco_numero`, `e`.`endereco_complemento`, `e`.`endereco_bairro`, `i`.`informacao_obs`, `u`.`usuario_nome`, `l`.`usuario_id` FROM `lead` `l` JOIN `informacao` `i` ON `l`.`informacao_id` = `i`.`informacao_id` LEFT JOIN `endereco` `e` ON `l`.`endereco_id` = `e`.`endereco_id` LEFT JOIN `cidade` `c` ON `e`.`cidade_id` = `c`.`cidade_id` LEFT JOIN `estado` `uf` ON `c`.`estado_id` = `uf`.`estado_id` LEFT JOIN `origem` `o` ON `i`.`origem_id` = `o`.`origem_id` JOIN `situacao` `s` ON `l`.`situacao_id` = `s`.`situacao_id` JOIN `usuario` `u` ON `l`.`usuario_id` = `u`.`usuario_id` WHERE `l`.`lead_id` = $id");
            if(mysql_num_rows($query) > 0) {
                $lead = mysql_fetch_row($query);
            } else {
                echo "<meta http-equiv=\"refresh\" content=\"0;url=http://{$_SERVER["HTTP_HOST"]}/home/listar/lead\">";
                exit();
            }
        }
    }
    /*echo "<pre>";
    print_r($oport);
    echo "</pre>";*/
?>

<div id="da-content-area">
    <script>
        $(function () {
            MascaraFoneNova('fone');
            MascaraFoneNova('fone2');
        });
        
        function busca_cidades(estado) 
        {
        var url = dominio + diretorio() + "/leads/BuscaCidades/"+estado;
        
        ajaxHTMLProgressBar('resp_cidade', url, false, false);
        
        }
        
        function converter() {
        var url = dominio + diretorio() + "/leads/Converter/" + $("#cod_lead").val();
        
        var lead = $("#cod_lead").val();
        
        if (lead == "") {
        alert("Verifique o campo lead");
        
        return false;
        
        }
        
        var status = $("#status").val();
        var nome = $("#nome").val();
        var email = $("#email").val();
        var site = $("#site").val();
        var conta = $("#conta").val();
        var fone = $("#fone").val();
        var fone2 = $("#fone2").val();
        var origem = $("#origem").val();
        var uf = $("#uf").val();
        var cidade = $("#cidade").val();
        var cep = $("#cep").val();
        var rua = $('#rua').val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var bairro = $("#bairro").val();
        var obs = $("#obs").val();
        
        // Exibe mensagem de carregamento
        
        CarregandoAntes();
        
        $.post(url, {status:status, nome:nome, email:email, site:site, conta:conta, fone:fone,fone2:fone2, cidade:cidade, cep:cep, rua:rua, numero:numero, complemento:complemento, bairro:bairro,uf:uf,origem:origem,obs:obs}, function (resposta) {
        
        resposta = resposta.split("|");
        
        CarregandoDurante();
        
        if (resposta[0] == 1) {
        window.location = "https://bobsoftware.com.br/erp/crm/contatos_form/visualizar/"+resposta[1];
        }
        else 
        {
        if (resposta[0] == -1) 
        {
        $("#msg_loading").html('Lead J&aacute; existe');
        
        }
        if(resposta[0]==-2)
        {
        $("#msg_loading").html('Informe a conta');
        
        }
        if(resposta[0]==-3)
        {
        $("#msg_loading").html('Informe a conta e o contato');
        
        }
        else
        {
        $("#msg_loading").html('Erro durante o processo');
        
        }
        
        }
        
        CarregandoDepois('loading',2000);
        });
        
        
        }
        
        function GravarOrigem()
        {
        
        CarregandoAntes();
        
        var url = dominio + diretorio() + "/crm/GravarOrigem";
        
        $.post(url,{nome:$("#input_origem").val()}, function(data)
        {
        var resp = data.split("|");
        
        CarregandoDurante();
        
        if(resp[0]==1)
        {
        $("#input_origem").val('');
        
        BuscarOrigem();
        
        BuscarOrigemSelect();
        
        $("#msg_loading").html(resp[1]);
        
        }
        else
        {
        $("#msg_loading").html(resp[1]);
        
        }
        
        CarregandoDepois('loading',2000);
        
        });
        
        
        
        }
        
        function BuscarOrigem()
        {
        var url = dominio + diretorio() + "/crm/BuscarOrigem/"+$("#input_origem").val();
        
        ajaxHTMLProgressBar('resp_origem', url, false, false);
        
        }
        
        function BuscarOrigemSelect()
        {
        var url = dominio + diretorio() + "/crm/BuscarOrigemSelect/"+$("#origem").val();
        
        ajaxHTMLProgressBar('resp_origem_select', url, false, false);
        
        }
        
        function EditarOrigem(i)
        {
        
        var id ="#"+i;
        
        var label = $(id).html();
        
        var campo = id.split("_");
        
        var idorigem = campo[1];
        
        $(id).editable(dominio+diretorio()+"/crm/EditarOrigem",{
        name 		: 'nome',
        width   	: 180,
        height   	: 15,
        submitdata : {id:idorigem,label:label },
        submit		: 'OK',
        
        });
        
        BuscarOrigemSelect(id);
        }
        
        function DeletarOrigem(i)
        {
        
        CarregandoAntes();
        
        var url = dominio + diretorio() + "/crm/DeletarOrigem";
        
        $.post(url,{id:i}, function(data)
        {
        BuscarOrigem();
        
        BuscarOrigemSelect();
        
        $("#loading").hide();
        
        });
        
        }
    </script>

    <article>
        <div class="modal hide" id="modal_origem" style="width:500px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&#215;</button>
                <h2 class="pr_5 mr_0">Origens</h2>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <fieldset>
                        <div class="well control-group">
                            <label style="display:inline;">Nova:</label>
                            &nbsp;
                            <div style="display:inline;">
                                <input type="text" onkeyup="BuscarOrigem();" name="input_origem" id="input_origem" size="15" maxlength="50" value=""/>
                                <a class="btn btn-primary" onclick="GravarOrigem();">Salvar</a>
                             	<div onmouseover="$('#tip_origem').tooltip();">&nbsp;<i onmouseover="mouse(this);$(this).tooltip();" id="tip_origem"  data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black flt_rgt" data-original-title="Digite o nome de uma origem existente.Para criar uma nova, clique em salvar.Para editar d&ecirc; um duplo clique sobre alguma origem existente.Para deletar clique no 'x' do lado direito da origem"></i></div>
                            </div>
                        </div>

                        <div id="resp_origem" align="center"></div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
            </div>
        </div>
        
        <div class="grid_4">
            <div class="da-panel">
                <div class="da-panel-header">
                    <span class="da-panel-title">
                        <span class="label label-inverse pr_5"><i><img src="http://<?=$_SERVER["HTTP_HOST"]?>/application/images/icons/white/16/user_comment.png"/></i></span>
                        &nbsp;
                        <strong class="tt_uc">Leads</strong>
                        <span class="box_tools_space">
                      		<div class="btn-group">
                                <a data-toggle="modal" href="#modal-converter" class="btn btn-large btn-inverse"><i class="icon-refresh icon-white"></i> Converter</a>
                            </div>
                        </span>
                    </span>
                    <span class="da-panel-btn">
                        <a href="http://<?$_SERVER["HTTP_HOST"]?>/leads/form" class="btn btn-primary"><i class="icon-plus icon-white"></i> Novo</a>
                    </span>
                </div>

                <div class="da-panel-content">
                    <div class="da-panel-padding">
                        <form action="" method="post" enctype="multipart/form-data" name="form_leads" id="form_leads" class="form-horizontal">
                            <fieldset>
                                <input type="hidden" name="cod_lead" id="cod_lead" value="<?=$lead[0]?>"/>

                                <span class="badge flt_rgt">Cadastrado por: <?=$lead[18]?>
                                    <input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=$lead[19]?>"/>
                                </span>

                                <div class="control-group-linha">
                                    <label class="control-label"> Situa&ccedil;&atilde;o</label>

                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[1]?></strong>
                                        <input type="hidden" id="status" value="<?=$lead[2]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <input type="hidden" name="cod_lead" id="cod_lead" value="<?=$lead[0]?>"/>
                                    <label class="control-label">Nome</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[3]?></strong>
                                        <input type="hidden" name="nome" id="nome" value="<?=$lead[3]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">E-mail</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[4]?></strong>
                                        <input type="hidden" name="email" id="email" value="<?=$lead[4]?>"/>
                                    </div>
                                </div>
                                
                                <div class="control-group-linha">
                                    <label class="control-label">Site</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[5]?></strong>
                                        <input type="hidden" name="site" id="site"  value="<?=$lead[5]?>"/>
                                    </div>
                                </div>
                                
                                <div class="control-group-linha">
                                    <label class="control-label">Conta</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[6]?></strong>
                                        <input type="hidden" name="conta" id="conta" value="<?=$lead[6]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Telefone</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[7]?></strong>
                                        <input type="hidden" name="fone" id="fone" size="20"  maxlength="20" value="<?=$lead[7]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Telefone&nbsp;2:</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[8]?></strong>
                                        <input type="hidden" name="fone2" id="fone2" size="20"  maxlength="20" value="<?=$lead[8]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Origem:</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[9]?></strong>
                                        <input type="hidden" name="origem" id="origem" value="<?=$lead[10]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Estado</label>
                                    <div class="controls">
                                        <input type="hidden" name="uf" id="uf" value="<?=$lead[11]?>"/>
                                        <strong class='dsp_b pr_5'><?=$lead[11]?></strong>
                                    </div>
                                </div>
                               
                                <div class="control-group-linha">
                                    <label class="control-label">Cidade:</label>
                                    <div class="controls">
                                        <input type="hidden" name="cidade" id="cidade" value="<?=$lead[12]?>"/>
                                        <strong class='dsp_b pr_5'><?=$lead[12]?></strong>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">CEP:</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[13]?></strong>
                                        <input type="hidden" name="cep" id="cep" value="<?=$lead[13]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Rua:</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[14]?></strong>
                                        <input type="hidden" name="rua" id="rua" value="<?=$lead[14]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">N&#176;</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[15]?></strong>
                                        <input type="hidden" name="numero" id="numero" value="<?=$lead[15]?>" />
                                    </div>
                                </div>
                                
                                <div class="control-group-linha">
                                    <label class="control-label">Complemento</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[16]?></strong>
                                        <input type="hidden" name="complemento" id="complemento" value="<?=$lead[16]?>" size="20"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Bairro:</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[17]?></strong>
                                        <input type="hidden" name="bairro" id="bairro" value="<?=$lead[17]?>"/>
                                    </div>
                                </div>

                                <div class="control-group-linha">
                                    <label class="control-label">Observa&ccedil;&otilde;es:</label>
                                    <div class="controls">
                                        <strong class="dsp_b pr_5"><?=$lead[18]?></strong>
                                        <input type="hidden" name="obs" id="obs" value="<?=$lead[18]?>"/>
                                    </div>
                                </div>

                                <div class="form-actions al_rgt">
                                    <a title="Editar" class="btn btn-inverse" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/alterar/<?=$lead[0]?>')">
                                        <i class="icon-pencil icon-white"></i> Editar
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal hide" id="modal-converter">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&#215;</button>
                <h2 class="pr_5 mr_0">Convers&atilde;o</h2>
            </div>
            <div class="modal-body">
                <h5>
                    O processo de convers&atilde;o &eacute; irrevers&iacute;vel.<br/><br/>
                    Ap&oacute;s ser convertido, o lead n&atilde;o ser&aacute; mais exibido.<br/><br/>
                </h5>
            </div>
            <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
            <a onclick="converter();" class="btn btn-primary">Converter Lead</a>
            </div>
        </div>
        
        <div class="clear"></div>
        
    </article>
    
    
    <!--<a id="excluir" onmouseover='mouse(this);' onclick="verifica_exclusao_usuario('2');" class="button">
    <span>Excluir</span>
    </a>-->
</div>