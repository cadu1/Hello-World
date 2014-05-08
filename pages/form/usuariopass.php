<div id="da-content-area">
	<article>
		<div class="grid_4">
			<div class="da-panel">
				<div class="da-panel-header">
					<span class="da-panel-title">
						<span class="label label-inverse pr_5"><i class="icon-lock icon-white"></i></span>
						<strong class="tt_uc">Alterar senha</strong>
					</span>
				</div>
			
				<div class="da-panel-content">			
					<div class="da-panel-padding">
						<form action="http://bobsoftware.com.br/erp/login/alterar_senha" method="post" enctype="multipart/form-data" name="form_alterar_senha" id="form_alterar_senha">
						  <fieldset>
							<div class="control-group">
								<label class="control-label">Senha:</label>
								<div class="controls">
									<input class="input_full" placeholder="Nova Senha" type="password" name="senha" id="senha" value="" />	
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">Confirma Senha:</label>
	
								<div class="controls">
									<input type="password" placeholder=" Confirma Nova Senha" class="input_full" name="confirma_senha" id="confirma_senha" value="" />	
								</div>
							</div>
							<div class="form-actions al_rgt">
								<button onclick="JavaScript: window.history.back();"  class="btn btn-inverse"><i class="icon-remove icon-white"></i> Cancelar</button>
								<button onclick="$('#form_alterar_senha').submit();" class="btn btn-success"><i class="icon-ok icon-white"></i> Salvar</button>
							</div>						
						  </fieldset>
						</form>
					 </div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</article>
</div>