<div id="da-content-area">
	<script>
		function executaJquery() {
		    $('.conteudo').show("slow");
		    $('#botaoBot').show("slow");
		    $('#botaoTop').show("slow");
		    $('#mostrar').hide("slow");
		    $('#botaoFooter').show("slow");
		}

		$(document).ready(function () {
		    $('.conteudo').hide();
		    $('#botaoBot').hide();
		    $('#botaoTop').hide();
		    $('#botaoFooter').hide();
		});
		    
		$(function () {
		    $("#data").datepicker({
		        dateFormat:'dd/mm/yy',
		        dayNames:[
		            'Domingo', 'Segunda', 'Ter�a', 'Quarta', 'Quinta', 'Sexta', 'S&aacute;bado', 'Domingo'
		        ],
		        dayNamesMin:[
		            'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
		        ],
		        dayNamesShort:[
		            'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'S�b', 'Dom'
		        ],
		        monthNames:[
		            'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
		            'Outubro', 'Novembro', 'Dezembro'
		        ],
		        monthNamesShort:[
		            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
		            'Out', 'Nov', 'Dez'
		        ],
		        nextText:'Pr&oacute;ximo',
		        prevText:'Anterior'
		    });
		});
		
		$(function () {
		    $("#hora").mask("99:99");
		})
		
		$(function () {
		    $("#data_followup").datepicker({
		        dateFormat:'dd/mm/yy',
		        dayNames:[
		            'Domingo', 'Segunda', 'Tera', 'Quarta', 'Quinta', 'Sexta', 'S&aacute;bado', 'Domingo'
		        ],
		        dayNamesMin:[
		            'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
		        ],
		        dayNamesShort:[
		            'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sb', 'Dom'
		        ],
		        monthNames:[
		            'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
		            'Outubro', 'Novembro', 'Dezembro'
		        ],
		        monthNamesShort:[
		            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
		            'Out', 'Nov', 'Dez'
		        ],
		        nextText:'Pr&oacute;ximo',
		        prevText:'Anterior'
		    });
		});
		
		function GravaEntidade(tipo)
		{
			var url = dominio + diretorio();
			
			if(tipo=="novo_contato")
			{
				url+="/crm/GravarContato";
				
				tipo = "contato";
			}
			
			if(tipo=="nova_conta")
			{
				url+="/crm/GravarConta";
				
				tipo = "conta";
			}
			
			var nome = $("#"+tipo).val();
			
			CarregandoAntes();
			
			$.post(url,{nome:nome},function (data) 
			{
				CarregandoDurante();
				
				var resp = data.split("|")
				
				if(resp[0]==1)
				{
					$("#msg_loading").html(resp[1]);
					
					CarregandoDepois('',10000);
		
					return resp[2];	
				}
				else
				{
					CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
				}
			});
		}
		
		$(function () {
		    $('#conta').each(function () {
		
		        var url = dominio + diretorio() + "/crm/AutoCompleteConta?callback=?";
		        var autoCompelteElement = this;
		
		        $(this).autocomplete({source:url,
		            select:function (event, ui) {
		
		                if(ui.item.id=="nova_conta")
						{
							GravaEntidade(ui.item.id);
						}
						
						$(autoCompelteElement).val(ui.item.label);
		
		                var conta = ui.item.value,
		                        div = $("<div>").addClass("pr_5"),
		                        div2 = $("<div>").text(conta),
		                        a = $("<label>").addClass("close flt_lft").attr({
		                            title:"Remover " + conta
		                        }).text(" x ");
		                a.click(function () {
		                    div2.html('');
		                    $("#nomeconta").val('');
		                    $("#codconta").val('');
		                    $("#codconta").val('');
		                    $("#conta").val('');
		                    $("#conta").show();
		                });
		                a.appendTo(div2),
		                        div2.appendTo(div),
		                        div.insertAfter("#conta");
		                $("#conta").hide();
		                $("#nomeconta").val(conta);
		                $("#codconta").val(ui.item.id);
		            }
		        });
		    });
		
		    $('#contato').each(function () {
		
		        var url = dominio + diretorio() + "/home/AutoCompleteContato";
		        var url2 = dominio + diretorio() + "/interacoes/AddContato/inserir/";
		        var url3 = dominio + diretorio() + "/interacoes/DelContato/inserir/";
		
		        var autoCompelteElement = this;
		        var formElementName = $(this).attr('name');
		        var hiddenElementID = formElementName + '_autocomplete_hidden';
		        $(this).attr('name', formElementName + '_autocomplete_label');
		        /* create new hidden input with name of orig input */
		        $(this).after("<input type=\"hidden\" name=\"" + formElementName + "\" id=\"" + hiddenElementID + "\" />");
		
		        $(this).autocomplete({source:url,
		            select:function (event, ui) {
		                if(ui.item.id=="novo_contato")
						{
							var url4 = dominio + diretorio();
			
							url4+="/crm/GravarContato";
							
							var nome = $("#contato").val();
							
							CarregandoAntes();
							
							$.post(url4,{nome:nome},function (data) 
							{
								CarregandoDurante();
								
								var resp = data.split("|")
								
								if(resp[0]==1)
								{
									$("#msg_loading").html(resp[1]);
									
									CarregandoDepois('',10000);
		
									$.post(url2, {contato:resp[2]}, function (data) 
									{
										if (data != -1) 
										{
											$(autoCompelteElement).val(ui.item.label);
		
											var conta = ui.item.value,
													div = $("<div>").addClass("pr_5"),
													div2 = $("<div>").text(conta),
													a = $("<label>").addClass("close flt_lft").attr({
														title:"Remover " + conta
													}).text(" x ");
											a.click(function () {
												div2.html('');
												$.post(url3, {contato:ui.item.id}, function (data) {
												});
											});
											a.appendTo(div2),
													div2.appendTo(div),
													div.insertAfter("#contato");
											$("#contato").val('');
										}
										else 
										{
											return false;
										}
									});	
								}
								else
								{
									CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
								}
							});
						}
						else
						{
							$.post(url2, {contato:ui.item.id}, function (data) {
								if (data != -1) {
									$(autoCompelteElement).val(ui.item.label);
		
									var conta = ui.item.value,
											div = $("<div>").addClass("pr_5"),
											div2 = $("<div>").text(conta),
											a = $("<label>").addClass("close flt_lft").attr({
												title:"Remover " + conta
											}).text(" x ");
									a.click(function () {
										div2.html('');
										$.post(url3, {contato:ui.item.id}, function (data) {
										});
									});
									a.appendTo(div2),
											div2.appendTo(div),
											div.insertAfter("#contato");
									$("#contato").val('');
								}
								else {
									return false;
								}
							});
						}
					}
		        });
		    });
		});
		
		function DelContato(id) {
		
		    var interacao = document.getElementById('cod_interacao').value;
		    var url = dominio + diretorio() + "/interacoes/DelContato/inserir/";
		
		    $("#loading").html('Carregando...');
		
		    $.post(url, {contato:id}, function (data) {
		        if (data == -1) {
		            $("#loading").html("Ocorreu um erro, tente novamente");
		        }
		        if (data == -2) {
		            $("#loading").html("Ao menos um contato deve ser mantido");
		        }
		        else {
		            $("#loading").html("Removido com Sucesso");
		            $("#resposta").html(data);
		        }
		    });
		}
	</script>
	
	<div class="modal hide" id="modal-lembrete">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&#215;</button>
	        <h2 class="pr_5 mr_0">
				Lembrete de atividade
				<i style="cursor: pointer;" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);" title="N&atilde;o se preocupe com o excesso de atividades, um e-mail ser&aacute; enviado para voc&eecirc; sempre que um lembrete for salvo !"></i>
			</h2>
		</div>
	    <div class="modal-body" style="height:285px;overflow:hidden;">
	       <div class="form-horizontal">
				<form>
					<fieldset>
						<div class="control-group">
							<input type="hidden" name="id_tf" id="id_tf" class="input_maior" value="" />
							
							<div class="control-group">
								<label class="control-label">*Enviar em:</label>
								
								<div class="controls">
									<input type="text" name="data_lembrete" id="data_lembrete" class="datepicker" value="18/01/2014"/>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">*Hor&aacute;rio do compromisso:</label>
								
								<div class="controls">
									<input type="text" name="hora_lembrete" id="hora_lembrete" value=""/>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label"> *Descri&ccedil;&atilde;o:</label>
								
								<div class="controls">
									<textarea id="desc_lembrete" name="desc_lembrete" rows="5" cols="40"></textarea>
								</div>
							</div>
							<div class="control-group">
								<div class="controls al_rgt">
									<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
									<a class="btn btn-primary" onclick="GravarLembrete();">Salvar</a>
								</div>
							</div>
						</div>	
					</fieldset>
				</form>
			</div>
		</div>
	</div>	
	
	<div class="grid_4">
    	<div class="da-panel">
        	<div class="da-panel-header">
        		<span class="da-panel-title">
        			<span class="label label-inverse pr_5"><img width="16" src="http://<?=$_SERVER['HTTP_HOST']?>/dev/application/images/icons/white/16/users.png"></span>
        			&nbsp;
        			<strong class="tt_uc">Atividade</strong>
        		</span>
        		<span class="da-panel-btn">
        			<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/historico" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova</a>
        		</span>
        	</div>
        	
        	<div class="da-panel-content">
            	<div class="da-panel-padding">
                	<form class="form-horizontal" action="http://bobsoftware.com.br/erp/interacoes/valida/inserir"
                	      method="post" enctype="multipart/form-data" name="form_interacoes" id="form_interacoes">
                        <fieldset>
                        	<input type="hidden" name="cod_interacao" id="cod_interacao" value=""/>
                        	<input type="hidden" name="user" id="user" value="1572"/>
                        	<span class="badge flt_rgt">Cadastrado por: Carlos Oliveira</span>
                        	<div class="control-group">
                        	    <label class="control-label">* Data:</label>
                        	
                        	    <div class="controls">
	           	                    <input class="datepicker" type="text" maxlength="10" name="data" id="data" class="input_menor" value="17/01/2014"/>
                        	    </div>
                        	</div>
                        	
                        	<div class="control-group">
                        	    <label class="control-label">* Hora:</label>
                        	
                        	    <div class="controls">
	           	                    <input type="text" id="hora" name="hora" value="17:18"/>
                        	    </div>
                        	</div>
                        	
                        	<div class="control-group">
                        	    <label class="control-label">Conta:</label>
                        	
                        	    <div class="controls">
    	       	                    <input class="input_full" type="text" id="conta" placeholder="Buscar" value=""/>
        	           	            <input type="hidden" name="nomeconta" id="nomeconta" value=""/>
                       	            <input type="hidden" name="codconta" id="codconta" value=""/>
               	                </div>
                        	</div>
                        	
                        	<div class="control-group">
                        	    <label class="control-label">Contatos:</label>
                        	
                        	    <div class="controls">
                        		    <input class="input_full" id="contato" type="text" placeholder="Buscar"/><br>
                        	        <div id="resposta" name="resposta" ></div>
                        	    </div>
                        	</div>
                        	
                            <div class="control-group">
                        	   <label class="control-label">* Motivo:</label>
                        	
                        	   <div class="controls">
                        	       <div class="pr_5" style="margin-top:-6px;">
                        	           <label class="radio inline">
                            	           <input type="radio" name="motivo" value="1" id="motivo1" onclick="carrega_motivos(this.value);"/>
                            	           Atendimento
                        	           </label>
                        	           <label class="radio inline">
                        	               <input type="radio" name="motivo" value="2" id="motivo2" onclick="carrega_motivos(this.value);"/>
                        	        	   Venda
                      	        	    </label>
                        	    	</div>
                                    <div id="div_motivos"></div>
                                </div>
			                 </div>
                        	
                        	<div class="control-group">
                        	    <label class="control-label">* Canal</label>
                        	
                        	    <div class="controls">
               	                    <select name="canal" id="canal">
                      	                <option value="" selected="">Selecione</option>
                       	                <option  value="5">Chat Online</option>
                       	                <option  value="2">E-mail</option>
                       	                <option  value="6">Facebook</option>
                       	                <option  value="4">Reunião</option>
                       	                <option  value="3">Skype</option>
                       	                <option  value="1">Telefone</option>
									</select>
               	                </div>
                        	</div>
                        	
                        	<div class="control-group">
                        	    <label class="control-label">* Tipo</label>
                        	
                        	    <div class="controls">
									<div class="pr_5">
                        	        	<label class="radio inline">
                        	            	<input type="radio" name="tipo" value="1" id="tipo1"/>
                        	            	Ativo
										</label>
                        	            <label class="radio inline">
                        	            	<input type="radio" name="tipo" value="2" id="tipo2"/>
                        	            	Receptivo
                        	            </label>
									</div>
								</div>
                        	</div>
                        	
                        	<div class="control-group">
                        	    <label class="control-label"> * Descri&ccedil;&atilde;o:</label>
                        	    <div class="controls">
                        			<textarea cols="40" rows="5" name="obs" id="obs"></textarea>
								</div>
                        	</div>
                        	<div class="form-actions al_rgt">
               	                <button onclick="JavaScript: window.history.back();return false;" class="btn btn-inverse">
               	                	<i class="icon-remove icon-white"></i> 
               	                	Cancelar
                   	            </button>
                   	            <button onclick="$('#form_interacoes').submit();" class="btn btn-success">
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
	
	<div id="fundo_cobre" class="fundo" style="display:none;"></div>
	
	<script>
	    $("#carga").mask("99:99:99");
	    $('#fbusca_contas').keydown(function (e) {
	        if (e.keyCode == 13) {
	            busca_contas(auxdiv);
	            return false;
	        }
	    });
	    $('#fbusca_contatos').keydown(function (e) {
	        if (e.keyCode == 13) {
	            BuscaContatosBox('contatos', 1);
	            return false;
	        }
	    });
	</script>
</div>