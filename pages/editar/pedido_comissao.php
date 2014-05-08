<?php
    include("lib/connection.php");

    $acao = "";
    $id = "";
    if($_GET) {
        $acao = $_GET["acao"];
        $id = $_GET["id"];

        if(!empty($id)) {
            $pedido = mysql_query("SELECT `o`.`oportunidade_id`, `o`.`oportunidade_nome`, `v`.`contato_nome`, `u`.`usuario_nome`, `c`.`conta_razao_social`, `cc`.`contato_nome`, `o`.`oportunidade_dt_fec`, `o`.`oportunidade_descricao`, `o`.`oportunidade_neg_vl`, `tp`.`tipo_parcela_sigla`, `o`.`pessoa_vendedor`, `u`.`usuario_id` FROM `oportunidade` `o` LEFT JOIN `conta` `c` ON `o`.`pessoa_conta` = `c`.`pessoa_id` LEFT JOIN `contato` `cc` ON `o`.`pessoa_contato` = `cc`.`pessoa_id` LEFT JOIN `contato` `v` ON `o`.`pessoa_vendedor` = `v`.`pessoa_id` JOIN `usuario` `u` ON `o`.`usuario_id` = `u`.`usuario_id` JOIN `tipo_parcela` `tp` ON `o`.`tipo_parcela_id` = `tp`.`tipo_parcela_id` WHERE `o`.`oportunidade_id` = $id");
            if(mysql_num_rows($pedido) > 0) {
                $ped = mysql_fetch_row($pedido);
            }
        }
    }
?>
<div id="da-content-area">
    <script>
        $(document).ready(function () {
            BuscarItens();
       	});
    
        function BuscarItens() 
        {
        	var url = dominio + diretorio() + "/oportunidades/BuscarItens/visualizar/<?=$ped[0]?>";
        	ajaxHTMLProgressBar('resp_itens', url, false, false);
        }

        function CriarInputs(qtd)
        {
        	$('#div_parcelamento').html('');
        	
        	var total = $("#servico").val();
        	
        	total = parseFloat(total.replace(',',"."));
        	
        	var parcela = total/qtd;
        	
        	parcela = parcela.toFixed(2) + "";
        	
        	parcela = parcela.replace('.',",")
        	
        	if(qtd>1)
        	{	
        		
        		for(var i=1;i<=qtd;i++)
        		{
        			var id = "parcela_"+i;
        			
        			var string = "&nbsp;&nbsp;";
        			
        			if(i<10)
        			{
        				string = "&nbsp;&nbsp;&nbsp;";
        			}
        			
        			$('#div_parcelamento').append('<br/>'+i+'/'+qtd+string);
        			
        			$('<input>').attr({ type: 'text', id: id, value:parcela,name:id}).addClass('span1').appendTo('#div_parcelamento');
        			
        			$('#'+id).maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."})
        			
        			$('#'+id).val('0,00');
        			
        			$('#div_parcelamento').append('<br/>');
        			
        		}
        		
        		$("#parcela_1").focus();
        	}
        	
        }
        
        function CalculaTotal()
        {
        	var total = 0;
        	
        	var servico = 0;
        	
        	var parcelas = 0;
        	
        	if($("#servico").val()!="")
        	{
        		servico = $("#servico").val();
        		
        		servico = parseFloat(servico.replace(',',"."));
        	}
        	
        	if($("#parcela_servico").val()!="")
        	{
        	
        		parcelas = parseInt($("#parcela_servico").val());
        	
        	}
        	
        	if((servico!="")&&(parcelas!=""))
        	{
        		total = servico*parcelas;
        	}
        	
        	total = numberFormat(total.toFixed(2));// + "";
        
        	$("#strong_total").html(" = R$&nbsp;"+total);	
        	
        	
        }
        
        function numberFormat(n) 
        {
        	var parts=n.toString().split(".");
        	return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (parts[1] ? "," + parts[1] : "");
        }
    </script>

    <article>
    	<div class="grid_4">
    		<div class="da-panel">
    			<div class="da-panel-header">
    				<span class="da-panel-title">
    					<span class="label label-inverse pr_5">
                            <img src="http://<?=$_SERVER["HTTP_HOST"]?>/application/images/icons/white/32/cur_dollar.png" width="16"/>
                        </span>
    					<strong class="tt_uc">Novo pedido de venda</strong>
    				</span>
    			</div>
    			<div class="da-panel-content">
    				<div class="da-panel-padding">
    					<form class="form-horizontal" action="http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/gerar/<?=$ped[0]?>"  method="post" enctype="multipart/form-data" name="form_pedidos" id="form_pedidos">
    						<fieldset>
    							<input type="hidden" name="cod_opt" id="cod_opt" value="<?=$ped[0]?>"/>
    							<input type="hidden" name="cod_grupo" id="cod_grupo" value="8d8e353b98d5191d5ceea1aa3eb05d43"/>
    							<input type="hidden" name="cod_versao" id="cod_versao" value="1.20"/>
    
    							<span class="badge flt_rgt">Cadastrado por: <?=$ped[3]?>
    								<input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=$ped[11]?>"/>
    							</span>

    							<div class="control-group-linha">
    								<label class="control-label">* Nome da Oportunidade:</label>
    								<div class="controls">
    									<div class="dsp_b pr_5">
    										<?=$ped[1]?>
    										<div class=" checkbox inline" style="margin-top:-6px;">
                                                <strong>Vendedor:</strong> <?=empty($ped[2]) ? "Nenhum" : $ped[2]?>
                                            </div>
    									</div>
    								</div>
    							</div>
    							<div class="control-group-linha">
    								<label class="control-label"> Conta:&nbsp;</label>
    								<div class="controls">
    									<div class="dsp_b pr_5">
    									 	<?=empty($ped[4]) ? "Nenhuma" : $ped[4]?>
    										<div class=" checkbox inline" style="margin-top:-6px;">
    											<strong>Contato:&nbsp;</strong> <?=$ped[5]?>
                                            </div>
    									</div>
    								</div>
    							</div>
    							<div class="control-group-linha">
    								<label class="control-label">* Data da venda:</label>
    								<div class="controls padding-visualiza">
                                        <strong class="dsp_b pr_5"><?=date("d/m/Y", strtotime($ped[6]))?></strong>
    								</div>
    							</div>
    							<div class="control-group">
    								<label class="control-label" style="padding-top:10px;">Descri&ccedil;&atilde;o:</label>
    								<div class="control-group" style="padding-top:10px;">
    									<div class="controls well">
    										<strong class="dsp_b pr_5"><?=$ped[7]?></strong>
    									</div>
    								</div>	
    							</div>
								<div class="control-group">
									<label class="control-label">Produtos e Servi&ccedil;os:&nbsp;</label>
									<div class="control-group">
										<div class="controls well" align="center" id="resp_itens"></div>
									</div>
								</div>
								<div>  
    								<label class="control-label">Pagamento:&nbsp;</label>
    								<div class="control-group">
    									<div class="controls" id="div_negociacao">
											<table align="center" style="background: #fff;" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Valor negociado = R$&nbsp;<?=number_format($ped[8], 2, ",", ".")?>/<?=$ped[9]?></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="background:#fff">
															<div class="tabbable">
																<ul class="nav nav-tabs">
																	<li class="active">
																		<a href="#tab1" data-toggle="tab">*Parcelas</a>
																	</li>
																	<li>
                                                                        <a href="#tab2" data-toggle="tab">*Comiss&otilde;es</a>
                                                                    </li>
																</ul>
																<div class="tab-content">
																	<div class="tab-pane fade in active" id="tab1">
                                                                    <?php
                                                                        $parcela = mysql_query("SELECT * FROM `parcelas` WHERE `oportunidade_id` = $id");
                                                                        $cont = 1;
                                                                        $total = mysql_num_rows($parcela);
                                                                    ?>
                                                                        <div id="div_parcelamento">
                                                                            <strong>Parcelada em <?=$total?> vezes </strong><br/>
                                                                    <?php while($par = mysql_fetch_row($parcela)): ?>
                                                                            <strong><i class="icon-chevron-right"></i>  <?=number_format($par[2], 2, ",", ".")?> no dia <?=date("d/m/Y", strtotime($par[2]))?></strong><br />
																		</div>
                                                                    <?php endwhile; ?>
																	</div>
																	<div class="tab-pane fade" id="tab2">
                                                                    	<div class="padding">	
																			<div id="div_comissao">
																			<?php
                                                                                if(empty($ped[2])):
                                                                            ?>
                                                                            	<strong>N&atilde;o existe comiss&atilde;o a se pagar neste pedido</strong>
                                                                            <?php
                                                                                else:
                                                                                    $comissao = mysql_query("SELECT `l`.`lancamento_valor`, `l`.`lancamento_vencimento` FROM `comissao` `c` JOIN `lancamento` `l` ON `c`.`lancamento_id` = `l`.`lancamento_id` WHERE `c`.`oportunidade_id` = $id");
                                                                                    $com = mysql_fetch_row($comissao);    
                                                                            ?>
																				<strong>Comiss&otilde;es:</strong><br/>
                                                                                <strong><i class='icon-chevron-right'></i> R$ <?=number_format($com[0], 2, ",", ".")?> no dia <?=date("d/m/Y", strtotime($com[1]))?></strong><br/> 
																			<?php endif; ?>
                                                                            </div>
																		</div>
																	</div>
																</div>	
															</div>
														</td>
													</tr>	
												</tbody>	
											</table>
    									</div>
    								</div>
    							</div>
    							<div class="form-actions al_rgt">
                                <?php if($acao == "alterar"): ?>
                                    <a href="#" onClick="JavaScript: window.history.go(-2);" class="btn btn-inverse"><i class="icon-remove icon-white"></i>
                                        Cancelar
                                    </a>
									<button onclick="$('#form_pedido').submit();" class="btn btn-success"><i class="icon-ok icon-white"></i>
										Gerar Pedido
									</button>
                                <?php endif; ?>
    							</div>
    						</fieldset>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </article>
</div>