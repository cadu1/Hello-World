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
            $query = mysql_query("SELECT `o`.`oportunidade_id`, `o`.`oportunidade_nome`, `u`.`usuario_nome`, `o`.`usuario_id`, `o`.`oportunidade_data`, `v`.`contato_nome`, `o`.`oportunidade_descricao`, `o`.`oportunidade_neg_vl`, `o`.`oportunidade_periodo`, `o`.`oportunidade_vl_periodo`, `ca`.`conta_razao_social`, `co`.`contato_nome`, `o`.`oportunidade_dt_fec`, `o`.`status_oportunidade_id`, `o`.`oportunidade_chance_suc`, IFNULL(`ct`.`conta_razao_social`, `ctt`.`contato_nome`), IF(`ca`.`conta_razao_social` <> NULL, 'Conta', 'Contato'), `tp`.`tipo_parcela_sigla` FROM `oportunidade` `o` JOIN `usuario` `u` ON `o`.`usuario_id` = `u`.`usuario_id` LEFT JOIN `contato` `v` ON `o`.`pessoa_vendedor` = `v`.`pessoa_id` LEFT JOIN `conta` `ca` ON `o`.`pessoa_conta` = `ca`.`pessoa_id` JOIN `contato` `co` ON `o`.`pessoa_contato` = `co`.`pessoa_id` LEFT JOIN `pessoa` `p` ON `o`.`pessoa_concorrente` = `p`.`pessoa_id` LEFT JOIN `conta` `ct` ON `p`.`pessoa_id` = `ct`.`pessoa_id` LEFT JOIN `contato` `ctt` ON `p`.`pessoa_id` = `ctt`.`pessoa_id` JOIN `tipo_parcela` `tp` ON `o`.`tipo_parcela_id` = `tp`.`tipo_parcela_id` WHERE `o`.`oportunidade_id` = $id");
            if(mysql_num_rows($query) > 0) {
                $oport = mysql_fetch_row($query);
                $query = mysql_query("SELECT `parcelas_valor`, `parcelas_data` FROM `parcelas` WHERE `oportunidade_id` = $id");
                $qtd_parc = mysql_num_rows($query);
                while($ped_parc[] = mysql_fetch_row($query));
                $tp_parc = mysql_query("SELECT * FROM `tipo_parcela`");
                $query = mysql_query("SELECT `produto_id`, `produto_oportunidade_qtd`, `produto_oportunidade_vl` FROM `produto_oportunidade` WHERE `oportunidade_id` = $id");
                
            } else {
                echo "<meta http-equiv=\"refresh\" content=\"0;url=http://{$_SERVER["HTTP_HOST"]}/home/listar/oportunidade\">";
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
        $(document).ready(function () {
            BuscarItens();
        });

        function BuscarItens() {
        	var url = dominio + diretorio() + "/oportunidades/BuscarItens/visualizar/<?=$oport[0]?>";
        	ajaxHTMLProgressBar('resp_itens', url, false, false);
        }
    </script>
    <article>
        <div class="grid_4">
            <div class="da-panel">
                <div class="da-panel-header">
                	<span class="da-panel-title">
                		<span class="label label-inverse pr_5">
                            <span class="label label-inverse pr_5"><i class="icon-briefcase icon-white"></i></span>
                        </span>
                		<strong class="tt_uc">
                			Oportunidades
                		</strong>
                	</span>
                	<span class="da-panel-btn">
                		<a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/form/oportunidade" class="btn btn-primary">
                            <i class="icon-plus icon-white"></i> Nova
                        </a>
                	</span>
                </div>
                <div class="da-panel-content">
                    <div class="da-panel-padding">
                        <div class="tabbable"> <!-- Only required for left/right tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab1" data-toggle="tab"><?=$oport[1]?></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1">
                                    <form class="form-horizontal" action="http://<?=$_SERVER["HTTP_HOST"]?>/oportunidades/valida/alterar" id="form_opt" method="post" enctype="multipart/form-data" name="form_opt">
                                        <fieldset>
                                            <input type="hidden" name="gerar_pedido" id="gerar_pedido" value="" />
                                            <input type="hidden" name="cod_opt" id="cod_opt" value="<?=$oport[0]?>>"/>
                
                                            <!-- campos pedido -->
                                            <input type="hidden" name="hpedido_acao" id="hpedido_acao" value="" />
                                            <input type="hidden" name="hrepetir_data_parcelas" id="hrepetir_data_parcelas" value="" />
                                            <input type="hidden" name="hdata_comissoes_pedido" id="hdata_comissoes_pedido" value="" />
                                            <input type="hidden" name="hconta_comissoes_pedido" id="hconta_comissoes_pedido" value="" />
                                            <input type="hidden" name="hcategoria_comissoes_pedido" id="hcategoria_comissoes_pedido" value="" />
                                            <input type="hidden" name="hdata_parcelas_pedido" id="hdata_parcelas_pedido" value="" />
                                            <input type="hidden" name="hconta_parcelas_pedido" id="hconta_parcelas_pedido" value="" />
                                            <input type="hidden" name="hcategoria_parcelas_pedido" id="hcategoria_parcelas_pedido" value="" />
                                            <!-- end   -->
                
                                            <span class="badge flt_rgt">Cadastrado por: <?=$oport[2]?>
                                                <input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=$oport[3]?>"/>
                                            </span>
                                            <div class="control-group-linha">
                                                <label class="control-label">* Data:</label>
                                                <div class="controls">
                                                    <strong class="dsp_b pr_5"><?=date("d/m/Y", strtotime($oport[4]))?></strong>
                                                </div>
                                            </div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">* Oportunidade:</label>
                                                <div class="controls">
                                                    <strong class="dsp_b pr_5"><?=$oport[1]?></strong>
                                                </div>
                                            </div>
                
                                            <div id="div_vendedor" class="control-group-linha">
                                    			<label class="control-label">Vendedor:</label>
                
                                    			<div class="controls">
                                    				<strong class='dsp_b pr_5'><?=$oport[5]?></strong>
                                    			</div>
                                       		</div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">Descri&ccedil;&atilde;o:</label>
                
                                                <div class="controls">
                                                    <strong class="dsp_b pr_5"><?=$oport[6]?></strong>
                                                </div>
                                            </div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">* Quem est&aacute; em prospec&ccedil;&atilde;o ?</label>
                
                                                <div class="controls">
                                                    <strong class="dsp_b pr_5"><?=$oport[16]?></strong>
                                                </div>
                                            </div>
                
                                            <div id="div_conta" style='<?=empty($oport[10]) ? "display:none;" : "display:block;"?>'  class="control-group-linha">
                                                <label class="control-label">Conta:</label>
                
                                                <div class="controls">
                                                    <strong class='dsp_b pr_5'><?=empty($oport[10]) ? "display:none;" : "display:block;"?></strong>
                                                </div>
                                            </div>
                
                                            <div id="div_contato"  style='<?=empty($oport[11]) ? "display:none;" : "display:block;"?>' class="control-group-linha">
                                                <label class="control-label">Contato:</label>
                
                                                <div class="controls">
                                                    <strong class='dsp_b pr_5'><?=$oport[11]?></strong>
                                                </div>
                                            </div>
                
                                       		<div>  
                                       			<label class="control-label">Produtos e Servi&ccedil;os:&nbsp;</label>
                
                                       			<div class="control-group-linha">
                                       				<div class="controls well" align="center" id="resp_itens"></div>
                                       			</div>
                                       		</div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">Valor negociado:</label>
                
                                                <div class="controls">
                                                <?php if(empty($oport[8])): ?>
                                                    <strong class="dsp_b pr_5">R$&nbsp;<?=number_format($oport[7], 2, ",", ".") . "/" . $oport[17]?></strong>
                                                <?php else: ?>
                                                    <strong class="dsp_b pr_5">R$&nbsp;<?=number_format($oport[7], 2, ",", ".") . "/" . $oport[17]?> durante <?=$oport[8] . " " . $oport[17]?>s = R$&nbsp;<?=number_format($oport[9], 2, ",", ".")?></strong>
                                                <?php endif; ?>
                                                </div>
                                            </div>
                
                                            <div>  
                                            	<label class="control-label">Negocia&ccedil;&atilde;o:&nbsp;</label>
                
                                            	<div class="control-group-linha">
                                            		<div class="controls well" id="div_negociacao">
                                   						<div id="div_parcelamento">
                                                        <?php if($qtd_parc > 1): $i = 1;?>
                                                            <strong>Parcelada em <?$qtd_parc?> vezes </strong>
                                                        <?php foreach($ped_parc AS $valor): ?>
                                                            <br/><br/><?="$i/$qtd_parc"?>&nbsp;&nbsp;&nbsp;<strong><i class='icon-chevron-right'></i>  <?=$valor?></strong>
                                                        <?php 
                                                                $i++;endforeach;
                                                            else:
                                                        ?>
                                                            <strong>Pagamento &agrave; vista</strong>
                                                        <?php endif; ?>
                                            			</div>
                                            		</div>
                                            	</div>
                                            </div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">* Fechamento prov&aacute;vel:</label>
                
                                                <div class="controls">
                                                    <strong class='dsp_b pr_5'><?=date("d/m/Y", strtotime($oport[12]))?></strong>            
                                                </div>
                                            </div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">Situa&ccedil;&atilde;o:</label>
                
                                                <div class="controls">
                                                    <div class="btn-group al_lft">
                                                    <?php if($oport[13] == 2): ?>
                                                        <label onclick="Situacao(this.id);" id="andamento" class='btn dropdown-toggle btn-info disabled' href="#">Andamento</label>
                                                    <?php elseif($oport[13] == 1): ?>
                                                        <label onclick="Situacao(this.id);" id="andamento" class="btn dropdown-toggle btn-success disabled" href="#">Ganhamos</label>
                                                    <?php elseif($oport[13] == 0): ?>
                                                        <label onclick="Situacao(this.id);" id="andamento" class='btn dropdown-toggle btn-danger disable' href="#">Perdemos</label>
                                                    <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">Chance de sucesso:</label>
                
                                                <div class="controls">
                                                    <strong class="dsp_b pr_5"><?=$oport[14]?></strong>
                                                </div>
                                            </div>
                
                                            <div class="control-group-linha">
                                                <label class="control-label">Concorrente:</label>
                
                                                <div class="controls">
                                                    <strong class='dsp_b pr_5'><?=$oport[15]?></strong>
                                                </div>
                                            </div>
                
                                            <div class="form-actions al_rgt">
                                                <a title="Editar" class="btn btn-inverse" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/oportunidades/form/alterar/<?=$oport[0]?>')">
                                                    <i class="icon-pencil icon-white"></i> Editar
                                          		</a>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                
                                <div class="tab-pane fade in" id="tab2">
                                    <div class="accordion" id="versoes_anteriores"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="abativa" id="abativa" value=""/>
                </div>
            </div>
        </div>
    </article>
</div>