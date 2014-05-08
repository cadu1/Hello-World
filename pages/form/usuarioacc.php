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
						<span class="label label-inverse pr_5">
							<i class="icon-bookmark icon-white"></i>
						</span>
						<strong class="tt_uc">Meus dados</strong>
					</span>
					<span class="da-panel-btn">
						<a  href="http://bobsoftware.com.br/erp/usuario/form" class="btn btn-primary">
							<i class="icon-plus icon-white"></i>
							Novo
						</a>
					</span>
				</div>		
			
				<div class="da-panel-content">
					<div class="da-panel-padding">	
						<div id='resp_exclusao' class="alert alert-error" style="display:none;"></div>
						
						<form action="http://bobsoftware.com.br/erp/usuario/alterar" method="post" enctype="multipart/form-data" name="form_usuario" id="form_usuario" class="form-horizontal">
							<fieldset>
								<div class="control-group">
									<input type="hidden" name="cod_usuario" id="cod_usuario" value="1572" />
									<label class="control-label">* Nome</label>
									 
									<div class="controls">
										<input type="text" name="nome" id="nome" class="input_full" placeholder="Digite seu nome" value="Carlos Oliveira" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">* E-mail</label>
									
									<div class="controls">
										<input type="text" name="email" id="email" class="input_full" placeholder="Digite seu e-mail" value="carlos.eduardo02@gmail.com"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Imagem</label>
	                                <div class="controls">
	                                	<input class="input-file input_full" id="fileInput" name="imagem" type="file"/>
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
	<!--<a id="excluir" onmouseover='mouse(this);' onclick="verifica_exclusao_usuario('1572');" class="button">
		<span>Excluir</span>
	</a>-->
</div>