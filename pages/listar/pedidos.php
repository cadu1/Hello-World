<?php
    include("lib/connection.php");
    $acao = "";
    $ret = "";
    $erro = false;
    if($_POST) {
        $acao = $_POST["acao"];
        $ret = $_POST["ret"];
        if($acao == "gerar" && (int)$ret == 1) {
            $msg = "Pedido gerado com sucesso - O pedido agora é exibido em \"Pedidos Gerados\" e \"Pré Faturamento\".";
        }
    } elseif($_GET) {
        $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";
        $ret = isset($_GET["ret"]) ? $_GET["ret"] : "";
        if($acao == "cancelar" && (int)$ret > 0) {
            $result = mysql_query("UPDATE `oportunidade` SET `oportunidade_pedido` = FALSE, `status_oportunidade_id` = 2 WHERE `oportunidade_id`= $ret");
            if($result) {
                $msg = "Pedido cancelado com sucesso, a oportunidade voltou para o status \"Em andamento\".";
            } else {
                $erro = true;
                $msg = "Problemas ao cancelar, tente novamente mais tarde.";
            }
        }
    }
?>
<div id="da-content-area">
    <script>
    	$(document).ready(function () {
            BuscarPedidos();
    	});

    	function BuscarPedidos() {
    		var url = dominio + diretorio() + "/home/pedido/BuscarPedidos";
    		ajaxHTMLProgressBar('resp_pedidos_gerados', url, false, false);
    	}
    	
    	function CancelarPedidos(pedido) {
    		//if(confirm("Deseja cancelar o pedido ?")) {	
    			var url = dominio + diretorio() + "/pedidos/cancelar/gerados/"+pedido;
                $.post(url, function (data) {
                    resp = data.split("|");
                    
                    if(resp[0]==1) {
                    	$("#msg_success").html(resp[1]);
                    	$("#msg_success").show();
                    	BuscarPedidos();
                    } else {
                    	$("#msg_error").html(resp[1]);
                    	$("#msg_error").show();
                    }
                });
            //}
   	   }
    </script>

    <div class="grid_4">
    	<div class="da-panel">
    		<div class="da-panel-header">
    			<span class="da-panel-title">
    				<span class="label label-inverse pr_5">
    					<i class="icon-list-alt icon-white"></i>
    				</span>
    				<strong class="tt_uc">
    					&nbsp;Pedidos de Venda 
    					<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_pedidos" title="Ao marcar uma oportunidade com 'Ganhamos' ela passa a ser exibida como um Pedido de venda na aba 'Pedidos a Gerar', ap&oacute;s gerar esta venda, ela pode ser faturada em financeiro e depois lan&ccedil;ada em contas a pagar e a receber."></i>
                    </strong>
    		    </span>
    		</div>
    		<div class="da-panel-content">
    			<div class="da-panel-padding">
    				<div class="tabbable">
                        <?php if($erro): ?>
    					<div class="alert alert-error" style="display:inline;" id="msg_error">
                            <a class="close" data-dismiss="alert" href="#">×</a>
    						<?=$msg?>
    					</div>
                        <?php else: ?>
    					<div class="alert alert-success" style="display:<?=!empty($msg) ? "inline" : "none"?>;" id="msg_success">
                        <?php if(empty($acao)): ?>
    					   <a class="close" data-dismiss="alert" href="#">&times;</a>
                       <?php elseif(!empty($acao) && !empty($ret)): ?>
    						<a class="close" data-dismiss="alert" href="#">×</a>
    						<?=$msg?>
                       <?php endif; ?>
    					</div>
                        <? endif; ?>
    					<div class="tabbable"> <!-- Only required for left/right tabs -->
    						<br/><ul class="nav nav-tabs">
    							<li class="active">
    								<a href="#tab1" data-toggle="tab">Pedidos a Gerar</a>
    							</li>
    							<li>
    								<a href="#tab2" data-toggle="tab">Pedidos Gerados</a>
    							</li>
    						</ul>
    						<div class="tab-content">
    							<div class="tab-pane fade in active" id="tab1">
    								<div class="container-fluid clr_both">
    									<div class="row-fluid">
    										<table class="da-table">
    											<thead>
    												<tr>
    													<th>Data de fechamento</th>
    													<th>Oportunidade</th>
    													<th>Conta</th>
    													<th>Contato</th>
    													<th>Total (R$)</th>
    													<th>A&ccedil;&otilde;es</th>
    												</tr>
    											</thead>
    											<tbody>
                                                <?php
                                                    $pedidos = mysql_query("SELECT `o`.`oportunidade_id`, `o`.`oportunidade_dt_fec`, `o`.`oportunidade_nome`, `c`.`conta_razao_social`, `cc`.`contato_nome`, `oportunidade_neg_vl` FROM `oportunidade` `o` LEFT JOIN `conta` `c` ON `o`.`pessoa_conta` = `c`.`pessoa_id` LEFT JOIN `contato` `cc` ON `o`.`pessoa_contato` = `cc`.`pessoa_id` WHERE `o`.`status_oportunidade_id` = 1 AND `o`.`oportunidade_pedido` = FALSE AND `o`.`oportunidade_faturado` = FALSE");
                                                    if(mysql_num_rows($pedidos) > 0):
                                                        while($pedido = mysql_fetch_row($pedidos)):
                                                ?>
                                                    <tr onmouseover="mouse(this);">
                                                        <td data-th="Data" class="al_rgt" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/visualizar/<?=$pedido[0]?>')"><?=date("d/m/Y", strtotime($pedido[1]))?></td>
    													<td data-th="Oportunidade" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/visualizar/<?=$pedido[0]?>')"><?=$pedido[2]?></td>
    													<td data-th="Conta" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/visualizar/<?=$pedido[0]?>')"><?=empty($pedido[3]) ? "N&atilde;o Possui" : $pedido[3]?></td>
    													<td data-th="Contato" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/visualizar/<?=$pedido[0]?>')"><?=empty($pedido[4]) ? "N&atilde;o Possui" : $pedido[3]?></td>
    													<td data-th="Total (R$)" class="al_rgt" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/visualizar/<?=$pedido[0]?>')"><?=number_format($pedido[5], 2, ",", ".")?></td>
    													<td data-th="A&ccedil;&otilde;es">
                                                            <a title="Gerar Pedido" href="http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/alterar/<?=$pedido[0]?>" id="btn_gerar" class="btn btn-inverse">
                                                                <i class="icon-share-alt icon-white"></i>
    														</a>
                                                            <a onclick="fConfirm('Tem certeza que deseja cancelar o pedido? A oportunidade voltara para andamento.', 'http://<?=$_SERVER["HTTP_HOST"]?>/home/pedidos/cancelar/<?=$pedido[0]?>');" title="Cancelar Pedido - A respectiva oportunidade voltar&aacute; para o status andamentos e n&atilde;o ser&aacute; mais exibida aqui" id="excluir"  class="btn btn-warning">
                                                                <i class="icon-ban-circle icon-black"></i>
    														</a>
                                                        </td>
  													</tr>
                                                    <?php
                                                            endwhile;
                                                        else:
                                                    ?>
                                                    <tr class="odd">
														<td class="center" colspan="6">Nenhum registro encontrado.</td>
													</tr>
                                                    <?php endif; ?>
                                                </tbody>
    										</table>
    									</div>
    									<div class="pagination"></div>
    								</div>
    							</div>
    							<div class="tab-pane fade in " id="tab2">
    								<div class="container-fluid clr_both">
    									<div class="row-fluid" id="resp_pedidos_gerados">
    									</div>
    								</div>
    							</div>
    						</div>
    					</div>		
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="clear"></div>
    </div>    
    	<script type="text/javascript"><!--
            $('#fmbusca input').keydown(function (e) {
                if (e.keyCode == 13) {
                    $('#fmbusca').attr('action', 'http://bobsoftware.com.br/erp/crm/listar/contas/1/Resultados/1')
                    $('#fmbusca').submit();
                }
            });
        //--></script>
</div>