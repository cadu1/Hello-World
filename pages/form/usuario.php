<div id="da-content-area">
	<script>
		$(document).ready (function(){
			var teste = 10;
			
			if(teste != 1)	
			{
				$(".esconde").hide();
			}
		})
		function dec2hex(numero) 
		{
			var base = 16;
			var digito = new Array();
			var i = 0;
		
			while (numero != 0) 
			{
			  i++;
			  digito[i] = numero % base;
			  numero = Math.floor(numero / base);
			}
			var value = "";
			while (i >= 1)  
			{
			  switch (digito[i]) 
			  {
				case 10: { value += "A"; break }
				case 11: { value += "B"; break }
				case 12: { value += "C"; break }
				case 13: { value += "D"; break }
				case 14: { value += "E"; break }
				case 15: { value += "F"; break }
				default: { value += digito[i]; break }
			  }
			  i--;
			}
			return value;
		}
		
		function Gerar_senha() 
		{
			var senha ="";
			// c�digos ASCII decimais
			var min = 32;
			var max = 126;
			var caracter;		
			for (i = 1; i <= 12; i++) 
			{
				caracter = min + Math.floor((Math.random() * (max - min)));  // 32 a 126
			  	caracter = "%" + dec2hex(caracter);
			 	caracter = unescape(caracter);
			 	senha += caracter;
			}
			document.getElementById('senha_gerada').innerHTML="<br/><span class='badge badge-info'>"+senha+"</span>";
			document.getElementById('senha').value = senha;
			document.getElementById('confirma_senha').value = senha;
		}
		  
		function Cargo(nivel)
		{
			if(nivel==30)
			{
				document.getElementById('div_cargo').style.display = "inline";
			}
			else
			{
				document.getElementById('div_cargo').style.display = "none";
			}
		}
	</script>
	<article>
		<div class="grid_4">
			<div class="da-panel">
				<div class="da-panel-header">
					<span class="da-panel-title">
						<span class="label label-inverse pr_5"><i class="icon-bookmark icon-white"></i></span>
						<strong class="tt_uc">Usu&aacute;rios</strong>
					</span>
					<span class="da-panel-btn">
						<a href="http://bobsoftware.com.br/erp/usuario/form" class="btn btn-primary"><i class="icon-plus icon-white"></i> Novo</a>
					</span>
				</div>		
			
				<div class="da-panel-content">
					<div class="da-panel-padding">	
						<div id='resp_exclusao' class="alert alert-error" style="display:none;"></div>
						
						<form action="http://bobsoftware.com.br/erp/usuario/inserir" method="post" enctype="multipart/form-data" name="form_usuario" id="form_usuario" class="form-horizontal">
							<fieldset>
								<div class="control-group">
									<input type="hidden" name="cod_usuario" id="cod_usuario" value="" />
									<label class="control-label">* Nome</label>
									<div class="controls">
										<input type="text" name="nome" id="nome" class="input_full" placeholder="Digite seu nome" value="" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">* E-mail</label>
									<div class="controls">
										<input type="text" name="email" id="email" class="input_full" placeholder="Digite seu e-mail" value="">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">* Senha</label>
									<div class="controls">
										<input type="password" class="span3" placeholder="Digite sua Senha" name="senha" id="senha" value="">&nbsp;
										<button type="button" onmouseover="mouse(this);" onclick="Gerar_senha();" class="btn btn-inverse">
	                            			<i class="icon-random icon-white"></i>
	                            			Gerar Senha
	                            		</button>
	                            		<div class="help-block" id="senha_gerada"></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">* Confirmar Senha</label>
									<div class="controls">
										<input type="password" class="span3" placeholder="Confirme sua Senha" name="confirma_senha" id="confirma_senha" value=""/>
									</div>
								</div>
										
								<div class="control-group">
									<label class="control-label">* N&iacute;vel</label>
									
									<div class="controls">
										<select name="nivel" id="nivel" class="span4" onchange="Cargo(this.value);">
										   <option value="20">Administrador</option>
										   <option value="30">Usuário</option>												
										</select>
										<div style="display:none;margin-left:5px" id="div_cargo">	
											<label class="checkbox inline"><input type="checkbox" name="cargo_usuario[]" value="crm"/>CRM&nbsp;</label>
											<label class="checkbox inline"><input type="checkbox" name="cargo_usuario[]" value="financeiro"/>Financeiro</label>
											<label class="checkbox inline"><input type="checkbox" name="cargo_usuario[]" value="vendas"/>Vendas</label>
											<label class="checkbox inline"><input type="checkbox" name="cargo_usuario[]" value="projetos"/>Projetos</label>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">* Ativo?</label>
									 
									<div class="controls">
										<select id="status" name="status">
											<option value="1" selected="">Sim</option>
											<option value="0" >N&atilde;o</option>
										</select>
									</div>
								</div>
										
								<div class="control-group">
									<label class="control-label">Alterar senha no pr&oacute;ximo acesso?</label>
									
									<div class="controls">
										<select name="status_senha" id="status_senha">
											<option value="0" selected="">Sim</option>
											<option value="1" >N&atilde;o</option>
										</select>
									</div>
								</div>
										
								<div class="control-group">
									<label class="control-label">Enviar e-mail?</label>
									<div class="controls">
										<select name="envia_email" id="envia_email">
											<option value="1" selected="">Sim</option>
											<option value="0">N&atilde;o</option>
										</select>
									</div>
								</div>
								
								<div class="form-actions al_rgt">
									<button class="btn btn-inverse" onclick="JavaScript: window.history.back();return false;">
										<i class="icon-remove icon-white"></i> 
										Cancelar
									</button>
									<button href="javascript:void(0)" onclick="$('#form_usuario').submit();" class="btn btn-success">
										<i class="icon-ok icon-white"></i> 
										Salvar
									</button>
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