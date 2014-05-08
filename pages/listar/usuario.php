            <div id="da-content-area">
                <div id='resp_exclusao' class="warning" style="display:none;"></div>

            <div class="grid_4">

                <div class="da-panel">
	
					<div class="da-panel-header">

						<span class="da-panel-title">

							<span class="label label-inverse pr_5"><i class="icon-user icon-white"></i></span>
							<strong class="tt_uc">Usu&aacute;rios</strong>

						</span>
							
								<span class="da-panel-btn">
									<a  href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/usuario" class="btn btn-primary"><i class="icon-plus icon-white"></i> Novo</a>
								</span>
							

					</div>
					
					<div class="da-panel-content">
						<div class="da-panel-padding">

                            
                            
                            <div class="thumbnail">
							<table class="da-table">
								<thead>
									<tr>
										<th>Nome</th>
										
										<th>E-mail</th>
										
										<th>N&iacute;vel</th>
										
										<th>Ativo</th>
										
										<th>A&ccedil;&otilde;es</th>
									</tr>
								</thead>
								<tbody>
									
																			<tr onmouseover="mouse(this);">
											<td data-th="nome">Carlos Oliveira</td>
											
											<td data-th="e-mail">carlos.eduardo02@gmail.com</td>
											
											<td data-th="tipo de cadastro">Proprietário</td>
											
											<td data-th="ativo"><span class='label label-success pr_5'>SIM</span></td>
											
											<td data-th="A&ccedil;&otilde;es" nowrap>
													
														<a onclick="fLink('http://<?=$_SERVER['HTTP_HOST']?>/home/form/usuario/conta')" class="btn btn-inverse" title="Editar">
															<i class="icon-pencil icon-white" id="editar" onmouseover='mouse(this);'></i>
														</a>
													   
																												
											</td>
										</tr>
																	</tbody>
							
							</table>
                            </div>
							
							<div class="pagination"></div>
					
						</div>
						
					</div>
				
				</div>
		
			</div>
		
			<div class="clear"></div>
</div>