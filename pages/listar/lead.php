<?php
    include("lib/connection.php");
?>
<div id="da-content-area">
    <script>
		// controle campos
		function controlecampos(valor) {
			switch (valor) {
				case "rural":
					document.getElementById('industria').checked = false;
					document.getElementById('comercio').checked = false;
					document.getElementById('servico').checked = false;
					document.getElementById('ong').checked = false;
					break;
				case "ong":
					document.getElementById('industria').checked = false;
					document.getElementById('comercio').checked = false;
					document.getElementById('servico').checked = false;
					document.getElementById('rural').checked = false;
					break;
			}
			return true;
		}

		function busca_cidades(estado) {
			var url = dominio + diretorio() + "/leads/BuscaCidades/"+estado;
			ajaxHTMLProgressBar('resp_cidade', url, false, false);
		}
		
		function exportar() {
			$('#fmbusca').attr('action', 'http://bobsoftware.com.br/erp/leads/listar/1/Resultados/1/exportar');
			$('#fmbusca').submit();
		}

		$(function () {
			$('#input_busca').each(function () {
				var url = dominio + diretorio() + "/leads/AutoCompleteBuscar";
				var autoCompelteElement = this;

				$(this).autocomplete({source:url,
					select:function (event, ui) {

						$(autoCompelteElement).val(ui.item.label);
						fLink(dominio + diretorio() + '/leads/form/visualizar/' + ui.item.id);
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
						<i>
							<img src="http://<?=$_SERVER["HTTP_HOST"]?>/application/images/icons/white/16/user_comment.png"/>
						</i>
					</span>

					<strong class="tt_uc">Leads </strong>

					<span class="box_tools_space">
						<div class="btn-group">
							<input type="text" style="padding: 9px;" placeholder="Nome,e-mail,telefone ou conta..." id="input_busca"/>
						</div>
					</span>
					<span class="da-panel-btn">
						<a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/form/lead" class="btn btn-primary">
							<i class="icon-plus icon-white"></i>Novo
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
								<a class="btn btn-mini" href="#box_importar" data-toggle="modal"><i class="icon-upload icon-black"></i> Importar</a>
								<a class="btn btn-mini" href="#" onclick="exportar();"><i class="icon-download icon-black"></i> Exportar</a>
							</div>

							<div class="span9">
								<label class="dsp_ib flt_rgt btn disabled">
									<b>1&nbsp;LEAD</b>            
								</label>

								<div class="da-filter hidden-phone hidden-tablet">
									<a class="accordion-toggle dsp_ib flt_rgt btn btn-inverse" data-toggle="collapse" title="Filtrar" data-parent="#sanfona" href="#filtro">
										<i class="icon-filter icon-white"></i> 
										Filtro
									</a>

									<div class="accordion pr_0" id="sanfona"> <!-- Precisa de css inline / id="sanfona" -->

										<div class="accordion-group pr_0 brd_none">
											<div class="accordion-heading">
											</div>

											<div id="filtro" class="accordion-body collapse closed">
												<span class="accordion-toggle dsp_b btn btn-inverse disabled">
													&nbsp;
												</span>

												<div class="accordion-inner well">
													<form class="form-horizontal" name="fmbusca" method="post" id="fmbusca" action="http://<?=$_SERVER["HTTP_HOST"]?>/leads/listar/1/Resultados/1">
														
														<fieldset>
															<div class="control-group">
																<label class="control-label">Nome</label>

																<div class="controls">
																	<input type="text" style="height:25" name="nome" class="input_full" value=""/>
																</div>
															</div>
															
															<div class="control-group">
																<label class="control-label">Estado</label>

																<div class="controls">
																	<select class="input_full" name="uf" id="uf" onchange="busca_cidades(this.value);" > 
																		<option value="">Selecione</option>
																	<?php
                                                                        $query = mysql_query("SELECT * FROM `estado`");
                                                                        while($est = mysql_fetch_row($query)):
                                                                    ?>
                                                                        <option value="<?=$est[0]?>"><?=$est[1]?></option>
                                                                    <?php endwhile; ?>    
                                                                    </select>
																</div>
															</div>

															<div class="control-group">
																<label class="control-label">Cidade</label>

																<div id="resp_cidade" class="controls">
																</div>
															</div>

															<div class="control-group">
																<label class="control-label">Origem:</label>
																    <div class="controls">
    																	<select class="input_full" name="origem" id="origem">
    																		<option value="">Selecione</option>
                                                                            <?php
                                                                                $query = mysql_query("SELECT * FROM `origem`");
                                                                                while($ori = mysql_fetch_row($query)):
                                                                            ?>
                                                                            <option value="<?=$ori[0]?>"><?=$ori[1]?></option>
                                                                            <?php endwhile; ?>
																	   </select>
																    </div>
															</div>

															<div class="form-actions al_rgt">
																<button href="javascript:void(0)" onclick="$('#fmbusca').attr('action','http://<?=$_SERVER["HTTP_HOST"]?>/leads/listar/1/Resultados/1/listar');$('#fmbusca').submit();" class="btn btn-success"><i class="icon-search icon-white"></i>Filtrar
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
						</div>
						<div class="modal fade hide" id="box_importar">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&#215;</button>
								<h2 class="pr_5 mr_0">Importar Dados</h2>
							</div>
							<div class="modal-body">
								<div>
									<fieldset title="Instru&ccedil;&otilde;es">
										<legend class="dsp_n">Passo 1</legend>
										<p>Crie o arquivo de importa&ccedil;&atilde;o confome o exemplo abaixo (os telefones devem vir com ddd informado):</p>
										<p>Clique no bot&atilde;o para baixar o arquivo modelo&nbsp;&nbsp;<a href="http://bobsoftware.com.br/erp/download/leads_modelo.xls" class="btn btn-mini"><i class="icon-download icon-black"></i> Baixar</a></p>
										<p>A extens&atilde;o deve ser xls (excel 2003) ou xlsx (excel 2007)</p>
									</fieldset>

									<fieldset title="Importa&ccedil;&atilde;o">
										<legend class="dsp_n">Passo 2</legend>
										<form id="frm_import" class="form-horizontal" action="http://<?$_SERVER["HTTP_HOST"]?>/leads/importar" method="post" enctype="multipart/form-data">
											<div class="control-group">
												<label class="control-label">* Importar Arquivo</label>

												<div class="controls">
													<input class="input-file input_full" id="fileInput" name="file_leads" type="file"/>
												</div>
											</div>
											<div class="control-group al_rgt">
												<button href="javascript:void(0)" onclick="$('#frm_import').submit();"
														class="btn btn-success">Enviar Arquivo
												</button>
											</div>
										</form>
									</fieldset>
								</div>

								<script>
									$('#step').stepy({
										backLabel:'&laquo; Voltar',
										block:true,
										errorImage:true,
										nextLabel:'Avan&ccedil;ar &raquo;',
										titleClick:true,
										validate:true
									});

									$('#step').validate({
										errorPlacement:function (error, element) {
											$('#step div.stepy-error').append(error);
										}, rules:{
											'user':{ maxlength:1 },
											'email':'email',
											'checked':'required',
											'newsletter':'required',
											'password':'required',
											'bio':'required',
											'day':'required'
										}, messages:{
											'user':{ maxlength:'User field should be less than 1!' },
											'email':{ email:'Invalid e-mail!' },
											'checked':{ required:'Checked field is required!' },
											'newsletter':{ required:'Newsletter field is required!' },
											'password':{ required:'Password field is requerid!' },
											'bio':{ required:'Bio field is required!' },
											'day':{ required:'Day field is requerid!' }
										}
									});
								</script>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
							</div>
						</div>

						<table class="da-table">
							<thead>
    							<tr>
    								<th>Situa&ccedil;&atilde;o</th>
								    <th>Nome</th>
								    <th>E-mail</th>
								    <th>Conta</th>
								    <th>Telefone&nbsp;</th>
								    <th>A&ccedil;&otilde;es</th>
							     </tr>
							</thead>
							<tbody onmouseover="mouse(this);" title="Visualizar">
                            <?php
                                $query = mysql_query("SELECT `l`.`lead_id`, `l`.`lead_nome`, `s`.`situacao_nome`, `i`.`informacao_email`, `l`.`lead_conta`, `i`.`informacao_telefone` FROM `lead` `l` JOIN `situacao` `s` ON `l`.`situacao_id` = `s`.`situacao_id` JOIN `informacao` `i` ON `l`.`informacao_id` = `i`.`informacao_id`");
                                if(mysql_num_rows($query) > 0):
                                    while($lead = mysql_fetch_row($query)):
                            ?>
								<tr>
                                    <td data-th="situa&ccedil;&atilde;o" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/visualizar/<?=$lead[0]?>')"><?=$lead[1]?></td>
                                    <td data-th="nome" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/visualizar/<?=$lead[0]?>')"><?=$lead[2]?></td>
                                    <td data-th="e-mail" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/visualizar/<?=$lead[0]?>')"><?=$lead[3]?></td>
                                    <td data-th="conta (empresa)" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/visualizar/<?=$lead[0]?>')"><?=$lead[4]?></td>
                                    <td data-th="fone" class="al_rgt" onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/visualizar/<?=$lead[0]?>')"><?=$lead[5]?></td>
                                    <td data-th="a&ccedil;&otilde;es" nowrap class="al_rgt">
										<a onclick="fLink('http://<?=$_SERVER["HTTP_HOST"]?>/leads/form/alterar/<?=$lead[0]?>')" class="btn btn-inverse" title="Editar">
											<i class="icon-pencil icon-white"></i>
										</a>
										<a onclick="fConfirm('Tem certeza que deseja excluir?', 'http://<?=$_SERVER["HTTP_HOST"]?>/leads/excluir/<?=$lead[0]?>')" class="btn btn-warning" title="Excluir">
											<i class="icon-remove-sign icon-black"></i>
										</a>
    								</td>
    							</tr>
                            <?php 
                                    endwhile; 
                                else:
                            ?>
                                <tr><td align="center" colspan="7">Nenhum registro encontrado.</td></tr>
                            <?php endif; ?>
                            </tbody>
						</table>
					</div>
					<div class="pagination"></div>
				</div>
			</div>
		</div>

		<div class="clear"></div>

		<script type="text/javascript">
		<!--
			$('#fmbusca input').keydown(function (e) {
				if (e.keyCode == 13) {
					$('#fmbusca').attr('action', 'http://<?=$_SERVER["HTTP_HOST"]?>/leads/listar/1/Resultados/1/listar');
					$('#fmbusca').submit();
				}
			});
		//-->
		</script>
		</div>
	</div>
</div>