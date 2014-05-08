<?php
    include("lib/connection.php");
?>
<div id="da-content-area">
	<div class="grid_4">
		<div class="da-panel">
			<div class="da-panel-header">
				<span class="da-panel-title">
					<span class="label label-inverse pr_5">
						<!--<i class="hidden-tablet"></i>-->
						<img alt="VENDAS" src="http://<?=$_SERVER['HTTP_HOST']?>/application/img/ico_porcentagem_branco.png"/>
					</span>

					<strong class="tt_uc">&nbsp;Comiss&otilde;es </strong>
				</span>
			</div>
	
			<div class="da-panel-content">
				<div class="da-panel-padding">
					<div class="row-fluid">
						<label class="dsp_ib flt_rgt btn disabled">
	               			 <b>2&nbsp;Comiss&otilde;es</b>
	               		</label>
	
						<div class="da-filter hidden-phone hidden-tablet">
							<a class="accordion-toggle dsp_ib flt_rgt btn btn-inverse" data-toggle="collapse" title="Filtrar"  data-parent="#sanfona" href="#filtro">
								<i class="icon-filter icon-white"></i> Filtro
							</a>
							
							<div class="accordion pr_0" id="sanfona">
								<div class="accordion-group pr_0 brd_none">
									<div class="accordion-heading"></div>
									<div id="filtro" class="accordion-body collapse closed">
										<span class="accordion-toggle dsp_b btn btn-inverse disabled">&nbsp;</span>
										<div class="accordion-inner well">
											<form class="form-horizontal" name="fmbusca" method="post" id="fmbusca" action="http://bobsoftware.com.br/erp/comissoes/listar">
												<fieldset>
													<div class="control-group">
														<div class="control-group">
														    <label class="control-label">
														        Vendedor
														    </label>
													        <div class="controls">
													            <select name="vendedor" id="vendedor" class="input_full">
													            	<option value="">Todos</option>
										            				<option  value="1">Teste Lead 1</option>
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
																		<input type="text" value="" name="data_inicio" id="data_inicio" onkeyup="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeydown="Mascara(this,Data);" maxlength="10" class="input_full datepicker"/>
																	</div>
																	<div class="span1 lh_200 al_ctr">e</div>
																	<div class="span5">
																		<input type="text" name="data_fim" id="data_fim" value=""onkeyup="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeydown="Mascara(this,Data);" maxlength="10" class="input_full datepicker"/>
																	</div>
																</div>
															</div>
														</div>
													</div>
													
													<div class="form-actions al_rgt">
														<button href="javascript:void(0)" class="btn btn-success">
															<i class="icon-search icon-white"></i>Filtrar
														</button>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<table class="da-table">
							<thead>
								<tr>
									<th>Vendedor</th>
									<th>Data</th>
									<th>Valor da Comiss&atilde;o</th>
									<th>Situa&ccedil;&atilde;o</th>
									<th>A&ccedil;&otilde;es</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                                $query = mysql_query("SELECT `c`.`oportunidade_id`, `ct`.`contato_nome`, `l`.`lancamento_vencimento`, `l`.`lancamento_valor`, (IF(`l`.`lancamento_vencimento` < current_date(), 'A pagar', 'Pendente')) AS `situacao` FROM `comissao` `c` JOIN `oportunidade` `o` ON `c`.`oportunidade_id` = `o`.`oportunidade_id` LEFT JOIN `contato` `ct` ON `o`.`pessoa_vendedor` = `ct`.`pessoa_id` JOIN `lancamento` `l` ON `c`.`lancamento_id` = `l`.`lancamento_id`");
                                if(mysql_num_rows($query) > 0):
                                    while($comissao = mysql_fetch_row($query)):
                            ?>
								<tr onmouseover="mouse(this);">
									<td data-th="Vendedor"><?=$comissao[1]?></td>
									<td data-th="Data" class="al_rgt"><?=date("d/m/Y", strtotime($comissao[2]))?></td>
									<td data-th="Comiss&aatilde;o" class="al_rgt"><?=number_format($comissao[3],2,",",".")?></td>
									<td data-th="Situa&ccedil;&atilde;o"><?=$comissao[4]?></td>
									<td data-th="A&ccedil;&otilde;es">
										<a title="Visualizar Pedido" href="http://<?=$_SERVER["HTTP_HOST"]?>/pedidos/form/visualizar/<?=$comissao[0]?>/gerados" id="btn_visualizar" class="btn">
											<i class="icon-list-alt"></i>
										</a>
									</td>
								</tr>
                            <?php
                                    endwhile;
                                else:
                            ?>
                                <tr class="odd">
        							<td class="center" colspan="5">Nenhum registro encontrado.</td>
        						</tr>
                            <? endif; ?>
							</tbody>
						</table>
					</div>
					<div class="pagination"></div>
				</div>	
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>