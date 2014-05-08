$(document).ready(function() {
     
    $().ajaxStart(function() { $('#loading').show(); });
    $().ajaxStop(function() { $('#loading').hide(); });
     
}); 

function CarregandoAntes()
{
	
	$("#msg_loading").html('Carregando...');
	
	$("#loading").show();
	
	$("#progress_bar").show();
	
	$("#close").hide();
}

function CarregandoDurante()
{
	$("#progress_bar").hide();
		
	$("#close").show();
}

function CarregandoDepois(id,tempo)
{
	id = "#"+id;
	
	setTimeout(function() { $('#loading').hide();}, tempo);

}

function isNumeric(str)
{
  var er = /^[0-9]+$/;
  return (er.test(str));
}


function verifica_pagina(pagina)
{
	var caminho = location.pathname;
	
	caminho = caminho.split('/');
	
	var controller = caminho.indexOf(pagina);
	
	if(controller!=-1)
	{
		controller = caminho[controller];
	
	}
	
	return controller;

}
function MascaraFoneNova(id)
{
		
	var phone_fields, phone_mask;

	id = "#"+id;

	phone_fields = $(id);

	phone_mask = /^(\(?1[1-9]\)? ?9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g;

	phone_fields.each(function() {
	  var mask, phone_field;
	  phone_field = $(this);
	  mask = phone_field.val().match(phone_mask) ? '(00) 00000-0000' : '(00) 0000-0000';
	  return phone_field.mask(mask, {
		onKeyPress: function(phone, e, currentField, options) {
		  if (phone.match(phone_mask)) 
		  {
			return $(currentField).mask('(00) 00000-0000', options);
		  }
		  else 
		  {
			return $(currentField).mask('(00) 0000-0000', options);
		  }
		}
	  });
	});
	
}


//variavel ajax

var ajax = null;

//variavel que define o tratamento do retorno 

var aux_ajax = null;

var dominio =  "http://"+document.domain;

var base_url = diretorio();

//CARGA
var carga=0;

var ct = false;

//Array dos id's
var vid = new Array();
//Fun��o que localiza o diretorio do sistema
function diretorio()
{
	
	var dir;

	if(document.domain=="bobsoftware.com.br")
	{
		var path = location.pathname;
		path = path.split('/');
		dir = path[1];
		dir = dir.split('/');
		dir="/"+dir;
	}
	else
	{
		dir = "";

	}
	
	return dir;

}

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

//fun��o que faz a requisi��o ajax

function requisicaoAjax(url)
{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			ajax = new XMLHttpRequest();
	   
		}
		else
		{// code for IE6, IE5
			ajax =new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		ajax.timeout = 10000; // 10 segundos
		if(ajax != null)
		{
		  
		   var html="";
		  ajax.ontimeout = function()
			{
				alert("Tempo limite do servidor atingido");
			}
		  ajax.onreadystatechange = function()
			{
				$("#loading").css('color','black');
				$("#loading").html("Carregando...");
			
				
				// Controle do box com os status - Inicialmente o box desaparece

				var respajax = false;

				if (ajax.readyState==4 && ajax.status==200)
				{
										
					if(aux_ajax=="gtf")
					{
						$('#form_atividades').submit();
					}
					if(aux_ajax=="tarefas") // Refeito, verifica se permanece
					{
							//<td><label onmouseover='mouse(this);' id='lbl_"+cont2+"' onclick='add_tarefa(document.getElementById(\"cod"+cont2+"\").value);'>[+]</label></td>
							var resposta = ajax.responseText.split("|");
							html = "<table id='tarefas-header' align='center' class='list'>";
							html+="<thead>";
							html+="<tr>";
							html+="<td>C&oacute;digo</td><td>Nome da tarefa</td>";
							html+="<td>Descri&ccedil;&atilde;o</td><td>Observa&ccedil;&atilde;o</td>";
							html+="<td>Tipo</td><td>Carga Hor&aacute;ria</td><td>Adicionar</td>";
							html+="</tr>";
							html+="</thead>";
							var cont=1;
							var cont2=1;
							var cont3=1;
							var tamtab = Math.floor(resposta.length/7);
							var tipo = resposta[resposta.length-1]; // diz se estou adicionando uma ou varias
							var evento="";
							var id;
							tamtab++;
							for(var i=0;i<resposta.length-1;i++)
							{
								if((cont==1)||(cont==6))  //1� e 6� coluna escreve inputs
								{
									if(cont==1) id ='cod'+cont2; else id ='carga'+cont2;									
									
									html+="<td>";
										if(cont==1)
										{
											html+="<input type='hidden' size='4px' name='codh"+cont2+"' id='codh"+cont2+"' value="+resposta[i]+"></input>";
										}
										html+="<input type='text'disabled size='4px' name='cod"+cont2+"' id="+id+" value="+resposta[i]+"></input>";
									html+="</td>";
									
								}
								else
								{
									id="";
									
									
									if(cont==2)
									{
										id='nome'+cont2;
										
									}	
									html+="<td id="+id+">";
										html+=resposta[i];
									html+="</td>";
									
								}
								if(cont==6) 
								{	
									if(tipo=='unica')
									{
										
										evento = "onclick = 'document.getElementById(\"lbl_nometarefa\").innerHTML = document.getElementById(\"nome"+cont2+"\").innerHTML;document.getElementById(\"codtarefa\").value = document.getElementById(\"codh"+cont2+"\").value;'";
										
									}
									if(tipo=='multiplas')
									{
										evento = "onclick='add_tarefa(document.getElementById(\"cod"+cont2+"\").value);'";
									}
									html+="<td><label onmouseover='mouse(this);' id='lbl_"+cont2+"' "+evento+" >[+]</label></td>"; // botao de adicionar
									html+="</tr>";
									cont=0;
									cont2++;
									//if(cont2>tamtab)html+="<tr><td colspan='7' align='center'><label align='center' class='button' onmouseover='mouse(this);' onclick='fechar(\"div_tarefas\");fechar(\"fundo_cobre\");'><span>Concluir</span></label></td>";
								}
								cont++;
							}
							document.getElementById('dv_mae').innerHTML = html;
							
							
					}
					if(aux_ajax=="add_tarefa")
					{
						var resposta = ajax.responseText.split("|");
						var cont=1;
						var linhas =  document.getElementById('tbl_tarefas').rows.length;
						html = "<tr>";
						for(var i=0;i<resposta.length-2;i++) // Ultimo sao as horas totais
						{
								if(cont==1)
								{
									id = resposta[i];								
								}
								html+="<td>";
									html+=resposta[i];
								html+="</td>";
								cont++;		
						}
						html+="<td align='center'>";
								html+="<label onmouseover='mouse(this);' onclick='rmvtf("+id+");'>[X]</label>";
						html+="</td>";	
						html+="</tr>";
						horas = resposta[resposta.length-2];
						
						if((resposta[1]!="existe")&&(resposta[1]!="erro"))
						{	
								document.getElementById('tbl_tarefas').innerHTML += html;
								
								document.getElementById('carga').value = horas;

								document.getElementById('hcarga').value = horas;	
						}
						else
						{
							if(resposta[1]=="existe")
							{
							
								alert("Tarefa existente")
							
							}
							if(resposta[1]=="erro")
							{
							
								alert("Ocorreu um erro durante o processo");
								
								return false;
							
							}
						
						
						}
						
					}
					
					if(aux_ajax=="remove_tarefa")
					{
						var resposta = ajax.responseText.split("|");
						var tabela =  document.getElementById('tbl_tarefas');
						var linhas =  tabela.rows.length;
						for(var i=0;i<linhas;i++)
						{
							if(resposta[1]==tabela.rows[i].cells[0].innerHTML)
							{
								tabela.deleteRow(i);
								break;
							}
								
						}
						
						document.getElementById('carga').value = resposta[2];
						document.getElementById('hcarga').value = resposta[2];	
						
					}
					if((aux_ajax=="int_contatos")||(aux_ajax=="int_contas"))
					{
						
						var resp = ajax.responseText.split("|");
											
						if(resp[1]=="1")
						{
							alert("Gravado com Sucesso");
							$('.conteudo').hide();
							$('#mostrar').show();
							$('#Teste').hide();
							$('#mostraCadContato').hide();
							$('#cadastra').hide();
							document.getElementById('cod_interacao').value="";
							document.getElementById('nomerel').value="";
							document.getElementById('un').selectedIndex =0;
							document.getElementById('resposta').innerHTML="";
							document.getElementById('idProspeccao').selectedIndex =0;
							document.getElementById('tiporel').selectedIndex =0;
							document.getElementById('int_obs').value="";
							document.getElementById('interacoes_corpo').innerHTML="<img align='center' src='"+dominio+diretorio()+"/application/img/carregando.gif"+"'>";
							busca_interacoes();
						
						}
						if(resp[1]=="0")
						{
							alert("Preencha todos os campos");
							
						}
						if(resp[1]=="-1")
						{
							alert("Ocorreu um erro durante o processo, tente novamente");
							
							return false;
						}
						if(resp[1]=="-2")
						{
							alert("Adicione pelo menos um contato");
						}
						
						
					}	
					
					if(aux_ajax=="busca_produtos")
					{
							
							var resposta = ajax.responseText.split("|");
							html = "<table border='0' id='tarefas-header' align='center' class='form'>";
							html+="<thead>";
							html+="<tr class='header-tarefas'>";
							html+="<td>C&oacute;digo</td><td>Nome do Produto</td>";
							html+="<td>Descri&ccedil;&atilde;o</td><td>Tipo</td>";
							html+="<td class='right'>Margem</td><td class='right'>Valor</td><td class='right'>Adicionar</td>";
							html+="</tr>";
							html+="</thead>";
							var cont=1;
							var cont2=1;
							var cont3=1;
							var tamtab = Math.floor(resposta.length/8);
							var tipo = resposta[resposta.length-1]; // diz se estou adicionando uma ou varias
							var evento="";
							var id;
							var alinhamento;
							tamtab++;
							for(var i=0;i<resposta.length-1;i++)
							{
								
								switch(cont)
								{
									case 1: id="cod"+cont2;break;
									case 2: id="nome"+cont2;break;
									case 3: id="desc"+cont2;break;
									case 4: id="tipo"+cont2;break;
									case 5: id="margem"+cont2;break;
									case 6: id="valor"+cont2;break;
																
								}
								alinhamento = "left";
								/*
								if((cont==5))
								{
								
									alinhamento = "right";
								}
								*/
								html+="<td class='"+alinhamento+"' id="+id+">";
									html+=resposta[i];
								html+="</td>";
									
								
								if(cont==6) 
								{	
									
									evento = "onclick='add_produto(document.getElementById(\"cod"+cont2+"\").innerHTML);'";
									html+="<td id=add"+cont2+"><label onmouseover='mouse(this);' id='lbl_"+cont2+"' "+evento+" >[+]</label></td>"; // botao de adicionar
									html+="</tr>";
									cont=0;
									cont2++;
									
								}
								cont++;
							}
							document.getElementById('dv_mae').innerHTML = html;
							
							
					}
					if(aux_ajax=="add_produto")
					{
						var resposta = ajax.responseText.split("|");
						var cont=1;
						var aux;
						var valor;
						var auxproduto=0;
						var totalgeral = 0; 
						
						var tipo_produto;
						
						
						if(resposta[1]==1)
						{
							id = resposta[2];
							
							html = "<tr id='tr_"+id+"'>";
							
							document.getElementById("qtd_opt").value = document.getElementById("qtd_produto").value = 1;
							document.getElementById("preco_produto_opt").value = document.getElementById("preco_produto").value = resposta[4]; // Preco na opt
							document.getElementById("cod_produto_montado").value = resposta[2];
							document.getElementById("lbl_nomeprod").innerHTML = resposta[3];
							document.getElementById("lbl_margemprod").innerHTML = resposta[6];
							document.getElementById("preco_produto_original").value = resposta[4]; // Preco do Produto
							document.getElementById("tipo_produto").value = resposta[5];
							
							for(var i=2;i<resposta.length;i++)
							{
										
										if(i==4)
										{
											auxproduto = resposta[i];
											
											document.getElementById('preco_produto_original').value = auxproduto; //unitario tabelado
											
											document.getElementById('preco_produto_opt').value = auxproduto; // nao existe na opt logo o preco eh o unitario original
										
										}
										else
										{	
											if(i==5)
											{	
												
												if(resposta[i]=="bem")
												{
													valor = document.getElementById('startup').value;
													
													valor = desmascarar(valor);
													
													auxproduto = desmascarar(auxproduto);
													
													auxproduto = parseFloat(auxproduto) + parseFloat(valor);
													
													auxproduto = auxproduto.toFixed(2);
				
													auxproduto = converteFloatMoeda(auxproduto);
													
													document.getElementById('startup').value = auxproduto;
												
												}
												if(resposta[i]=="servico")
												{
													valor = document.getElementById('servico').value;
																								
													valor = desmascarar(valor);
													
													auxproduto = desmascarar(auxproduto);
													
													auxproduto = parseFloat(auxproduto) + parseFloat(valor);
													
													auxproduto = auxproduto.toFixed(2);
													
													auxproduto = converteFloatMoeda(auxproduto);
													
													document.getElementById('servico').value = auxproduto;
												
												}
												
												tipo_produto=resposta[i];
											
											}
											else
											{	
												if((i!=2)&&(i!=6))
												{	
													html+="<td onmouseover='mouse(this);' onclick='monta_produto("+id+");'>";
														html+=resposta[i];
													html+="</td>";
												}
											}
										
										}
									
									
											
							}
							html+="<td align='center'>";
									html+="<label onmouseover='mouse(this);' onclick='rmvprod("+id+");'>[X]</label>";
							html+="</td>";	
							html+="</tr>";
							
							document.getElementById('tblresp_produtos').innerHTML += html;
												
							totalgeral = parseFloat(desmascarar(document.getElementById('startup').value))+ parseFloat(desmascarar(document.getElementById('servico').value));
							
							totalgeral = totalgeral.toFixed(2);
							
							totalgeral = converteFloatMoeda(totalgeral);

							document.getElementById('totalgeral').value = totalgeral;
							
							alert("Adicionado com sucesso");
							
							parcelar(tipo_produto);
						}
						if(resposta[1]==-1)
						{
							alert("Ocorreu um erro durante o processo");
							
							return false;
						
						}
						if(resposta[1]==-2)
						{
							alert("Produto existente");
						
						}
										
					}
					
					if(aux_ajax=="gravar")
					{
						
						alert(ajax.responseText);
						
						
					}
					if(aux_ajax=="busca_contas")
					{
						
						document.getElementById('resp_contas').innerHTML = ajax.responseText;
						
						
					}
					if(aux_ajax=="busca_contatos")
					{
						//facil
						document.getElementById('resp_contatos').innerHTML = ajax.responseText;
						
						
					}
					if(aux_ajax=="busca_interacoes")
					{
						
						document.getElementById('interacoes_corpo').innerHTML = ajax.responseText;
						
						
					}
					if(aux_ajax=="vincular")
					{
						var resposta = ajax.responseText.split("|");
						
						if(resposta[0]==0)
						{
							alert("Houve um erro, tente novamente"); 
							
							$("#loading").hide();
							
							return false;
						}
						if(resposta[0]==-1)
						{
							alert("Selecione o relacionamento"); 
							
							$("#loading").hide();
							
							return false;
						}
						if(resposta[0]==-2)
						{
							alert("Relacionamento repetido");
							
							$("#loading").hide();
							
							return false;
						}
						if(resposta[0]==-3)
						{
							$("#loading").css('color','red');
							$("#loading").html("Erro ao atualizar"); return false;
						}
						if(resposta[0]=="alterado")
						{
							
							var jsIdContato = $('#cod_contato').val();
							var jsAbaAtiva = $('#abativa').val();
							var jsTipoAtivo = $('#tipoAtivo').val();
	 

							if(jsTipoAtivo == "conta" && jsAbaAtiva == "abacontas")
							{
								listaVinculoConta(jsIdContato,'');
							}
							if(jsTipoAtivo == "conta" && jsAbaAtiva == "abacontatos")
							{
								listaVinculo(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abacontatos")
							{
								listaVinculoContatoContato(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abaamizade")
							{	
								listaVinculoContatoAmizade(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abafamilia")
							{
								listaVinculoContatoFamilia(jsIdContato,'');
							}
							
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abacontas")
							{ 
								listaVinculoContatoConta(jsIdContato,'');
							}
							
							
							$("#loading").show();
							$("#loading").html("Vinculado com sucesso");
							$("#loading").fadeOut(2000);
							
							
						}
						else
						{
						
							var jsIdContato = $('#cod_contato').val();
							var jsAbaAtiva = $('#abativa').val();
							var jsTipoAtivo = $('#tipoAtivo').val();
 


							if(jsTipoAtivo == "conta" && jsAbaAtiva == "abacontas")
							{
								listaVinculoConta(jsIdContato,'');
							}
							if(jsTipoAtivo == "conta" && jsAbaAtiva == "abacontatos")
							{
								listaVinculo(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abacontatos")
							{
								listaVinculoContatoContato(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abaamizade")
							{	
								listaVinculoContatoAmizade(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abafamilia")
							{
								listaVinculoContatoFamilia(jsIdContato,'');
							}
							if(jsTipoAtivo == "contato" && jsAbaAtiva == "abacontas")
							{
								listaVinculoContatoConta(jsIdContato,'');
							}

							$("#loading").show();
							$("#loading").html("Vinculado com sucesso");
							$("#loading").fadeOut(2000);
							
						}
					}
					if(aux_ajax=="remove_interacao")
					{
					
						resp = ajax.responseText.split("|");
						
						if(resp[0]!="0")
						{	
							id = resp[2];
						
							id ="contato_"+resp[2];
						
							obj = document.getElementById(id);	
						
							
							if(obj!=null)
							{	
								if(!obj.parentNode.removeChild(obj))
								{
									salert("Ocorreu um erro durante o processo");
									return false;
								}
								else
								{
									alert("Removido com sucesso");
									
								}
						
							}
							else
							{
								document.getElementById(id).innerHTML = "";
							}
						}
						else
						{
							alert("Ocorreu um erro durante o processo");
							return false;
						}
						cursor("default");
					}
					
					if(aux_ajax=="interar")
					{
						var resp = ajax.responseText.split("|");
						var id;
						if((resp[1]!="Existe")&&(resp[1]!="Selecione")&&(resp[1]!=undefined))
						{
							id="contato_"+resp[4];
							var controle = false;
							if(document.getElementById('cod_contato')!= undefined )
							{
									if(resp[4]==document.getElementById('cod_contato').value)
									{
										
										controle = true;
									}
									
							}
							if(!controle)
							{
								alert(resp[1]);
							
								document.getElementById('resposta').innerHTML +="<label onmouseover=\"mouse(this);\" id='"+id+"' onclick=\"remove_interacao(this.id);\">[X]&nbsp;<u>"+resp[2]+"</u></label><br><br>";
							
							}
						
						}
						else
						{	
							if(resp[1]=="Existe")
							{
								alert("Contato anteriormente adicionado");
							}
							else
							{
								alert("Ocorreu um erro durante o processo,tente novamente");
								
								return false;
							}
						}
						
						cursor("default");
					}
					if(aux_ajax=="buscacrm")
					{
						var resposta = ajax.responseText.split("|");
						var aba = resposta[1];
						document.getElementById(aba).innerHTML = resposta[2]; 
						
					}
					if(aux_ajax=="box_vinculos")
					{
						var resposta = ajax.responseText.split("|");
						
						if(resposta[0]==1)
						{
							document.getElementById('operacao_vinculo').value = "alterar";
							document.getElementById('id_vinculo').value = resposta[1];
							document.getElementById('email_vinculo').value = resposta[2];
							document.getElementById('fone_vinculo').value = resposta[3];
							document.getElementById('ramal_vinculo').value = resposta[4];
							document.getElementById('cargo_vinculo').value = resposta[5];
							cobre();
							abrir('dados_transitorios');
						
						}
						else
						{
							$("#loading").css('color','red');
							$("#loading").html = "Erro ao buscar V&iacute;nculo";
						
						}
					
					}
					if(aux_ajax=="status_vinculo")
					{
						
						var resposta = ajax.responseText.split("|");
						var resp = resposta[1];
						var tr ="tr_"+resposta[2];
						var cor = resposta[3];
						var idh ="hdd_"+resposta[2];
						if(resp=="1")
						{
							
							var status="Ativo / Inativo"
							document.getElementById(idh).value=cor;
							if(cor==0) 
							{	
								cor="red";
								status = "Inativo [+]";
							}
							if(cor==1) 
							{	
								cor="green";
								status = "Ativo [-]";
							}
							//document.getElementById(tr+"_1").style.color=cor;
							document.getElementById(tr+"_2").innerHTML+="";
							document.getElementById(tr+"_2").style.color=cor;
							document.getElementById(tr+"_3").style.color=cor;
							document.getElementById(tr+"_3").innerHTML=status;
							document.getElementById(tr+"_4").style.color=cor;
							document.getElementById(tr+"_5").style.color=cor;
							
						}
					}
					if(aux_ajax=="monta_produto")
					{
						var resposta = ajax.responseText.split("|");
						
						if(resposta[1]!="-1")
						{
							document.getElementById('resp_produtos').innerHTML ="";
							document.getElementById("qtd_opt").value = document.getElementById("qtd_produto").value = resposta[1];
							document.getElementById("preco_produto_opt").value = document.getElementById("preco_produto").value = resposta[2]; // Preco na opt
							document.getElementById("cod_produto_montado").value = resposta[3];
							document.getElementById("lbl_nomeprod").innerHTML = resposta[4];
							document.getElementById("lbl_margemprod").innerHTML = resposta[5];
							document.getElementById("preco_produto_original").value = resposta[6]; // Preco do Produto
							document.getElementById("tipo_produto").value = resposta[7]; 
						}
						else
						{
						
							alert("Tente novamente");
						
						}
					
					
					}
					if(aux_ajax=="remove_produto")
					{
					
						var resposta = ajax.responseText.split("|");
						
						if(resposta[1]!="-1")	
						{
							
							var id = resposta[2];	
							
							id = "tr_"+id;
							
							var obj = document.getElementById(id);	
		
							if(!obj.parentNode.removeChild(obj))
							{
								document.getElementById('resp_produtos').innerHTML = "<font color='red'>Erro ao Remover Produto</font>";
								return false;
							}
							else
							{
								var tipo_produto = resposta[3]; // bem ou servico
								
								if(tipo_produto==-1)
								{
									document.getElementById('resp_produtos').innerHTML = "<font color='red'>Erro ao Remover Produto</font>";
									return false;
								
								}
								
								var qtd_produto = parseFloat(resposta[4]);
								
								var preco_opt = parseFloat(resposta[5]); // acumulado
								
								var totalgeral = 0;
								
								var totalremovido =  0;
								
								var auxproduto = 0;
								
								totalremovido = qtd_produto * preco_opt;
								
								if(tipo_produto=="bem")
								{
									valor = document.getElementById('startup').value;
									
									valor = parseFloat(desmascarar(valor));
									
									auxproduto = valor - totalremovido;
									
									auxproduto = auxproduto.toFixed(2);
									
									auxproduto = converteFloatMoeda(auxproduto);
									
									document.getElementById('startup').value = auxproduto;
									
								}
								if(tipo_produto=="servico")
								{
									valor = document.getElementById('servico').value;
									
									valor = desmascarar(valor);
									
									auxproduto = valor - totalremovido;
									
									auxproduto = auxproduto.toFixed(2);
									
									auxproduto = converteFloatMoeda(auxproduto);
									
									document.getElementById('servico').value = auxproduto;
								
								}
								
								totalgeral = parseFloat(desmascarar(document.getElementById('startup').value))+ parseFloat(desmascarar(document.getElementById('servico').value));
								
								totalgeral = totalgeral.toFixed(2);
								
								totalgeral = converteFloatMoeda(totalgeral);

								document.getElementById('totalgeral').value = totalgeral;
								
								document.getElementById('resp_produtos').innerHTML = "<font color='green'>Removido com Sucesso</font>";
								
								document.getElementById('lbl_nomeprod').innerHTML =" Nenhum Produto Selecionado";
								
								document.getElementById('lbl_margemprod').value=" %";
								
								document.getElementById('qtd_produto').value="";
								
								document.getElementById('preco_produto').value="";
								
								document.getElementById('cod_produto_montado').value="";
								
								document.getElementById('preco_produto_original').value="";
								
								document.getElementById('tipo_produto').value="";
								
								document.getElementById('preco_produto_opt').value="";
								
								document.getElementById('qtd_opt').value="";
								
								parcelar(tipo_produto);
							}
						}
						else
						{
							document.getElementById('resp_produtos').innerHTML = "<font color='red'>Erro ao Remover Produto</font>";
							
						}
						
						
					
					}
					if(aux_ajax=="vincula_atividades_produtos")
					{
						var resposta = ajax.responseText.split("|");
						
						var atividade = resposta[2];
						
						var carga_horaria = resposta[3];
						
						document.getElementById('loading').style.height = "40px";
						
						document.getElementById('loading').innerHTML = resposta[1];
						
						document.getElementById('td_cargaperson_'+atividade).innerHTML = carga_horaria;
						
						if(carga_horaria=="00:00:00") // remover
						{
							$('.check_'+atividade).attr('checked', '');
						
						}
						else // adicionar
						{
						
							$('.check_'+atividade).attr('checked', 'checked'); 
						
						}
						respajax = true;
						
						buscaAtividadesSimples()
					
					}
					if(aux_ajax=="vincula_tarefas_produtos")
					{
						var resposta = ajax.responseText.split("|");
						
						respajax = true;
						
						carga_horaria = resposta[2];
						
						atividade = resposta[3];
						
						document.getElementById('loading').style.height = "40px";
						
						document.getElementById('loading').innerHTML = resposta[1];
						
						document.getElementById('td_cargaperson_'+atividade).innerHTML = carga_horaria;
						
						var check = document.getElementById('chk_atv_'+atividade);
						
						if(check.checked)
						{
							if(carga_horaria=="00:00:00")	
							{	
								check.checked = false;
							}
						
						}
						else
						{
							
								check.checked = true;
							
						
						}
						
					
					}
					if(aux_ajax=="busca_produtos_projeto")
					{
						var resposta = ajax.responseText;
						
						$("#resp_produtos").html(resposta);
					
					}
					if(aux_ajax=="busca_atividades")
					{
						var resposta = ajax.responseText.split("|");
						
						if(resposta[1]!=-1)
						{
							document.getElementById(resposta[2]).innerHTML = resposta[1];	
						}
						
						respajax = false;
					
					}
					if(aux_ajax=="tarefas_atividades")
					{
						var resposta = ajax.responseText.split("|");
						
						var tipo_busca = resposta[3];
												
						var id; 
						
						if(tipo_busca=="extras_projeto")	
						{	
							id ="td_box_tarefas_atvextra_"+resposta[1];
						}
						else
						{
							id ="td_box_tarefas_atv_"+resposta[1];
						}
						
						document.getElementById(id).innerHTML = resposta[2];	
					
					}
					if(aux_ajax=="busca_tarefas_extras")
					{
						var resposta = ajax.responseText;
						
						document.getElementById("resp_tarefas_extras").innerHTML = resposta;	
						
					}
					if(aux_ajax=="busca_tarefas_usuario")
					{
						var resposta = ajax.responseText;
						
						document.getElementById("resp_cron_user").innerHTML = resposta;	
						
					}
					if(aux_ajax=="dados_alocacao")
					{
						var resposta = ajax.responseText.split("|");
						
						var cont = 0;
					
						document.getElementById('produto_tarefa_alocar').options[0].value = resposta[2];
		
						document.getElementById('produto_tarefa_alocar').options[0].text = resposta[3];	

						document.getElementById('atividade_tarefa_alocar').options[0].value = resposta[4];
						
						document.getElementById('atividade_tarefa_alocar').options[0].text = resposta[5];
						
						document.getElementById('tarefa_alocar_id').value = resposta[6];
						
						document.getElementById('tarefa_alocar').value = resposta[7];
						
						document.getElementById('carga_estimada').value = resposta[8];
					
						var select = document.getElementById("user_tarefa_alocar");
						
						for(cont=0;cont<select.length;cont++)
						{
							
							if(select.options[cont].value == resposta[9])
							{
								select.selectedIndex = cont;
								
							}

						}	
					
				
						select = document.getElementById("status_tarefa_alocar");
						
						for(cont=0;cont<select.length;cont++)
						{
							
							if(select.options[cont].value == resposta[10])
							{
								select.selectedIndex = cont;
								
							}

						}
						
						document.getElementById('datai_tarefa_alocar').value = resposta[11];
						
						document.getElementById('dataf_tarefa_alocar').value = resposta[18];
						
						select = document.getElementById("prioridade_tarefa_alocar");
						
						for(cont=0;cont<select.length;cont++)
						{
							
							if(select.options[cont].value == resposta[12])
							{
								select.selectedIndex = cont;
								
							}

						}	
						
						
						
						document.getElementById('anexo_tarefa_alocar').value = resposta[13];
						
						document.getElementById('descricao_tarefa_alocar').value = resposta[14];
						
						if(resposta[15]==1)
						{	
							document.getElementById('cortesia_sim').checked = true;
						}
						if(resposta[15]==0)
						{
							document.getElementById('cortesia_nao').checked = true;
						
						}
						
						document.getElementById('comentario_tarefa_alocar').value = resposta[16];
						
						
						select = document.getElementById("responsavel_tarefa_alocar");
						
						for(cont=0;cont<select.length;cont++)
						{
						
							if(select.options[cont].value == resposta[17])
							{
								select.selectedIndex = cont;
								
							}

						}	
						
						document.getElementById('extra_tarefa_alocar').value = resposta[19];
						
						document.getElementById('carga_tarefa_alocar').value = resposta[20];
						
						cobre();
					
						abrir('div_alocar_tarefas');
						
					
					
					}
					if(aux_ajax=="grava_prodmontado")
					{
						var resposta = ajax.responseText.split("|");
						
						if(resposta[1]!="-1")	
						{	
							
							document.getElementById('resp_produtos').innerHTML = "<font color='green'>Gravado com Sucesso</font>";
						
						}
						
						document.getElementById('resp_produtos').style.display = "inline";
					}
					if((aux_ajax=="int_contas1")||(aux_ajax=="int_contatos1"))
					{
						//document.getElementById('cod_interacao').value = ajax.responseText;
						$("#cod_interacao").val(ajax.responseText);
						$("#cod_interacao").val($.trim($("#cod_interacao").val()));
						executaJquery();
						
					}
					if(aux_ajax=="int_interacoes1")
					{
						$("#cod_interacao").val(ajax.responseText);
						$("#cod_interacao").val($.trim($("#cod_interacao").val()));
						executaJquery();
					}
					if(!respajax) // padronizar os box de mensagem
					{	
						document.getElementById('loading').style.display = "none";
					}
				}
				if(aux_ajax=="carregar_paineis")
				{
						var resposta = ajax.responseText.split("|");
						
						var painel = "corpo_"+resposta[1];
						
						document.getElementById(painel).innerHTML = resposta[2];								
				}
				if (ajax.readyState==4 && ((ajax.status==500)||(ajax.status==404)))
				{
					document.getElementById('loading').style.height = "50px";
					
					document.getElementById('loading').innerHTML = "<font color='red'>Ocorreu um erro, por favor recarregue a p&aacute;gina</font>";
					
					return false;
				
				}
				
				//seta a funcao que sera chamada quando o ajax for retornado
				cursor("default");
			}
		  ajax.open("GET",url,true);
		  //inicia o tranporte
		  ajax.send();
		
		}

	
		}

//FUNCOES GENERICAS


function mostra_filtros(aba)
{	
	
	var display = document.getElementById(aba).style.display;
	
	var id='#'+aba;
	
	if(display == 'none')
	{
		$(id).show('fast');
	}
	else
	{
		$(id).hide('fast');
		document.getElementById(aba).style.display = "none";
	}	
}//fim da fun�ao ativaAba



function carregar_url(url)
{
	document.getElementById('loading').style.display = "inline";
	
	window.setTimeout('requisicaoAjax("'+url+'")',900); 
}

function desmascarar(valor)
{
	valor = valor.replace(".","");
													
	aux = valor.indexOf(",");
																										
	if(aux>-1)
	{
		valor = valor.replace(",",".");
	}
	
	return valor;

}

function carregando(id)
{

	document.getElementById(id).innerHTML = "<img src='"+dominio+diretorio()+"/application/img/carregando.gif"+"'>";

}

//valida o CNPJ digitado
function ValidarCNPJ(ObjCnpj)
{
        var cnpj = ObjCnpj.value;
        var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
        var dig1= new Number;
        var dig2= new Number;
        
        exp = /\.|\-|\//g
        cnpj = cnpj.toString().replace( exp, "" ); 
        var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));
                
        for(i = 0; i<valida.length; i++){
                dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
                dig2 += cnpj.charAt(i)*valida[i];       
        }
        dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
        dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));
        
        if(((dig1*10)+dig2) != digito)  
        {        
				alert('CNPJ Incorreto!');
				
				return false;	
		}
		else
		{
			return true;
		
		}
}


function display_paineis(painel)
{
	var elemento = document.getElementById("corpo_"+painel);
	
	var painel_corpo="#corpo_"+painel;	
	
	if (elemento.style.display=="none")	
	{	
		$(painel_corpo).fadeIn(1000,function(){
			
			carregar_paineis(painel);
			
		}); // ou slideDown()
	}
	else
	{
		$(painel_corpo).fadeOut(1000,function(){
		}); // ou slideDown()

	}	
}
function display_projeto(painel)
{
	var elemento = document.getElementById("corpo_"+painel);
	
	var painel_corpo="#corpo_"+painel;	
	
	if (elemento.style.display=="none")	
	{	
		$(painel_corpo).fadeIn(1000,function(){
			
			//carregar_paineis(painel);
			
		}); // ou slideDown()
	}
	else
	{
		$(painel_corpo).fadeOut(1000,function(){
			
				
		}); // ou slideDown()

	}	
}
// PAINEIS
function carregar_paineis(painel)
{
	
	aux_ajax="carregar_paineis";
	
	var painel_corpo="corpo_"+painel;
	
	document.getElementById(painel_corpo).innerHTML ="<div align='center'><img src='"+dominio+diretorio()+"/application/img/carregando.gif"+"'></div>"; ;
	
	var url = dominio+diretorio()+"/ajax/index";
	
	url+="?tipo="+aux_ajax;
	
	url+="&painel="+painel;
	
	carregar_url(url);
	
}

// Atividades/Tarefas/Produtos em Projetos

function busca_produtos_projeto(contrato)
{
	aux_ajax = "busca_produtos_projeto";
	
	var url = dominio+diretorio()+"/ajax/index";
	
	url+="?tipo="+aux_ajax;
	
	url+="&contrato="+contrato;
	
	carregar_url(url);




}


function box_alocar_tarefas(atividade,tarefa,produto,alocacao,tipo)
{
	
	// Tipo - extras ou contratadas 
	
	var aux=""; // Para montar os IDS
	
	var prod_id;
	
	var indice;
	
	if(tipo=='alterar_alocacao')
	{
		
		aux_ajax = 'dados_alocacao';
		
		$("#id_alocacao").val(alocacao);
		
		$("#operacao_tarefa_alocar").val('alterar');
	
		var url = dominio+diretorio()+"/ajax/index";
	
		url+="?tipo="+aux_ajax;
	
		url+="&id_alocacao="+alocacao;
		
		carregar_url(url);
		
		
	}
	else
	{	
		
		var prod_nome;
		
		var atividade_nome;
		
		var tarefa_nome;
		
		var tarefa_carga;
		
		if(tipo=='extras_projeto')
		{	
		
			aux = "slc_prod_atv_"+atividade;
			
			indice = document.getElementById(aux).selectedIndex;
			
			prod_id = document.getElementById(aux).options[indice].value;
			
			prod_nome = document.getElementById(aux).options[indice].text;
			
			indice = document.getElementById(aux).selectedIndex;
			
			aux = "box_atvextra_"+atividade;
		
			atividade_nome = document.getElementById(aux).innerHTML;
		
			aux = "box_atvextra_"+atividade+"_tf_nome_"+tarefa;
			
			tarefa_nome = document.getElementById(aux).innerHTML;
			
			aux = "box_atvextra_"+atividade+"_tf_carga_"+tarefa;
			
			tarefa_carga = document.getElementById(aux).innerHTML;
			
			$("#extra_tarefa_alocar").val('1'); // Tarefa extra
		
		}
		else
		{
			aux = "produto_"+produto+"_nome";
		
			indice = document.getElementById(aux).selectedIndex;
			
			prod_id = produto;
			
			prod_nome = document.getElementById(aux).innerHTML;
		
			aux = "box_atv_"+atividade;
			
			atividade_nome = document.getElementById(aux).innerHTML;
		
			aux = "box_atv_"+atividade+"_tf_nome_"+tarefa;
			
			tarefa_nome = document.getElementById(aux).innerHTML;
			
			aux = "box_atv_"+atividade+"_tf_carga_"+tarefa;
			
			tarefa_carga = document.getElementById(aux).innerHTML;
			
			$("#extra_tarefa_alocar").val('0'); // Tarefa contratada
		
		
		}

		document.getElementById('produto_tarefa_alocar').options[0].value = prod_id;
		
		document.getElementById('produto_tarefa_alocar').options[0].text = prod_nome;	

		document.getElementById('atividade_tarefa_alocar').options[0].value = atividade;
		
		document.getElementById('atividade_tarefa_alocar').options[0].text = tarefa_nome;
			
		document.getElementById('tarefa_alocar').value = tarefa_nome;
		
		document.getElementById('tarefa_alocar_id').value = tarefa;
		
		document.getElementById('carga_estimada').value = tarefa_carga;
	
		document.getElementById('user_tarefa_alocar').selectedIndex = 0;
		
		document.getElementById('status_tarefa_alocar').selectedIndex = 0;
		
		document.getElementById('datai_tarefa_alocar').value = '';
		
		document.getElementById('dataf_tarefa_alocar').value = '';
		
		document.getElementById('carga_tarefa_alocar').value = '';
		
		document.getElementById('prioridade_tarefa_alocar').selectedIndex = 1;
		
		$("#anexo_tarefa_alocar").val('');
		
		$("#descricao_tarefa_alocar").val('');
		
		$("#comentario_tarefa_alocar").val('');
		
		$("#data_tarefa_alocar").val('');
		
		$("#operacao_tarefa_alocar").val('inserir');
		
		$("#id_alocacao").val('');
		
		document.getElementById('responsavel_tarefa_alocar').selectedIndex = $("#cod_responsavel").val();
		
		document.getElementById('cortesia_sim').checked = false;
		
		document.getElementById('cortesia_nao').checked = true;
		
		cobre();
	
		abrir('div_alocar_tarefas');
	}
	

}

// PRODUTOS / OPORTUNIDADES

function box_tarefas_atividades(atividade,produto,tipo)
{
	// tipo me informa se estou na tela de projetos ou de produtos
	
	aux_ajax = 'tarefas_atividades';

	var id;
	
	if(tipo=="extras_projeto")
	{
		id = "box_tarefas_atvextra_"+atividade;
	}
	else
	{
		id = "box_tarefas_atv_"+atividade;
	
	}
	var elemento = document.getElementById(id);
	
	carregando("td_"+id);
	
	var tarefas_box="#"+id;	
	
	var url = dominio+diretorio()+"/ajax/index";
	
	url+="?tipo="+aux_ajax;
	
	url+="&atv="+atividade;
	
	url+="&produto="+produto; // Produto ou Projeto
	
	url+="&tipo_busca="+tipo;
	
	if (elemento.style.display=="none")	
	{	
		$(tarefas_box).fadeIn(1000,function(){
			
				carregar_url(url); 
		
		}); // ou slideDown()
	}
	else
	{
		$(tarefas_box).fadeOut(1000,function(){
			
				
		}); // ou slideDown()

	}

}

function busca_produtos(nome)
{
	aux_ajax="busca_produtos";
	
	var url = dominio+diretorio()+"/ajax/index";
	
	url+="?tipo=busca_produtos";
			
	url+="&nome="+nome;
	
	cursor("wait");	
	
	carregar_url(url);

}

function add_produto(id)
{	
	aux_ajax ='add_produto';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&id="+id;
	carregar_url(url);
}

function rmvprod(id)
{	
	aux_ajax ='remove_produto';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&id="+id;
	carregar_url(url);
}


function monta_produto(id)
{
	aux_ajax ='monta_produto';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&id="+id;
	carregar_url(url);
}

function grava_prodmontado(id)
{
	aux_ajax ='grava_prodmontado';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&id="+id;
	url+="&qtd="+document.getElementById('qtd_produto').value;
	url+="&preco="+document.getElementById('preco_produto').value; // novo preco
	carregar_url(url);
	
}

function ajusta_preco_produtos()
{
	var preco = document.getElementById('preco_produto_original').value;
	
	var margem = document.getElementById('lbl_margemprod').innerHTML;
	
	var npreco = document.getElementById('preco_produto').value;
		
	var preco_opt = document.getElementById('preco_produto_opt').value; // acumulado

	var tipo_produto = document.getElementById('tipo_produto').value; // bem ou servico
	
	var qtd_produto = parseFloat(document.getElementById('qtd_produto').value);
	
	var qtd_opt = parseFloat(document.getElementById('qtd_opt').value);
	
	var totalgeral =  0;
	
	var auxproduto = 0;
	
	var expressao = 0;
	
	preco_opt = desmascarar(preco_opt);
	
	preco = desmascarar(preco);
	
	npreco = parseFloat(desmascarar(npreco));
	
	npreco = npreco.toFixed(2);
	
	if((qtd_produto<=0)||(npreco<=0))
	{
		document.getElementById('resp_produtos').innerHTML = "<font color='red'>Os valores devem ser maiores que zero</font>";
	
		return false;
	}
	else
	{
		margem = parseFloat(margem);
		
		margem = margem/100;
		
		var precolimite = preco*margem;
		
		precolimite = preco - precolimite; //limite para diminuir o preco, aumentar eh livre

		if(npreco<precolimite)
		{
			document.getElementById('resp_produtos').innerHTML = "<font color='red'>Margem excedida</font>";
			
			document.getElementById('preco_produto').focus();
			
		}
		else
		{
			if(tipo_produto=="bem")
			{
				valor = document.getElementById('startup').value;
				
				valor = desmascarar(valor);
				
				if((npreco!=preco_opt)&&(qtd_opt==qtd_produto))
				{
					expressao = (npreco - preco_opt)*qtd_produto;
				}
				if((qtd_opt!=qtd_produto)&&(npreco==preco_opt))
				{
					expressao = (qtd_produto-qtd_opt)*npreco;
					
				}
				if((qtd_opt!=qtd_produto)&&(npreco!=preco_opt))
				{
					expressao = ((npreco*qtd_produto)-(preco_opt*qtd_opt));
				
				}
				
				auxproduto = expressao + parseFloat(valor); // multiplica pelo unitario
				
				auxproduto = auxproduto.toFixed(2);
				
				auxproduto = converteFloatMoeda(auxproduto);
				
				document.getElementById('startup').value = auxproduto;
				
				document.getElementById('preco_produto_opt').value =  converteFloatMoeda(npreco);
				
				document.getElementById('qtd_opt').value =  qtd_produto;
													
			}
			if(tipo_produto=="servico")
			{
				valor = document.getElementById('servico').value;
																									
				valor = desmascarar(valor);
														
				if((npreco!=preco_opt)&&(qtd_opt==qtd_produto))
				{
					expressao = (npreco - preco_opt)*qtd_produto;
				}
				if((qtd_opt!=qtd_produto)&&(npreco==preco_opt))
				{
					expressao = (qtd_produto-qtd_opt)*npreco;
					
				}
				if((qtd_opt!=qtd_produto)&&(npreco!=preco_opt))
				{
					expressao = ((npreco*qtd_produto)-(preco_opt*qtd_opt));
				
				}
				
				auxproduto = expressao + parseFloat(valor); // multiplica pelo unitario
				
				auxproduto = auxproduto.toFixed(2);
				
				auxproduto = converteFloatMoeda(auxproduto);
														
				document.getElementById('servico').value = auxproduto;
													
				document.getElementById('preco_produto_opt').value =  converteFloatMoeda(npreco); // novo valor acumulado na oportunidade
				
				document.getElementById('qtd_opt').value =  qtd_produto; // novo valor acumulado na oportunidade
			}
			
			totalgeral = parseFloat(desmascarar(document.getElementById('startup').value))+ parseFloat(desmascarar(document.getElementById('servico').value));
			
			totalgeral = totalgeral.toFixed(2);
			
			totalgeral = converteFloatMoeda(totalgeral);

			document.getElementById('totalgeral').value = totalgeral;
			
			parcelar(tipo_produto);
			
		
			return true;
	
		}
	}

}

function parcelar(tipo)
{
	var elemento,elemento1;
	
	if(tipo=="bem") tipo = "startup";
	
	if(tipo=="startup")
	{
		elemento1 = document.getElementById('pstartup');
		 
		elemento = document.getElementById('parcelas1'); 
	}
	if(tipo=="servico")
	{
		elemento1 = document.getElementById('pservico');
		
		elemento = document.getElementById('parcelas2'); 
		
	}
	if((elemento.value!="")&&(elemento1.value!=""))
	{
		var total = document.getElementById(tipo).value;
		
		var parcelas = parseFloat(elemento1.value);

		total = desmascarar(total);
		
		total = parseFloat(total);
		
		total = total / parcelas;
					
		total = total.toFixed(2);
					
		total = converteFloatMoeda(total);

		elemento.value = total;

	}
}

// Mudar cursor
function cursor(seta)
{
	
	document.body.style.cursor  = seta;

}

function remove_vinculo(id,idtr)
{
		
	aux_ajax="remove_vinculo";
	
	obj = document.getElementById(idtr);	
		
	if(!obj.parentNode.removeChild(obj))
	{
		alert("falhou");
		return false;
	}	
	var url = dominio+diretorio()+"/ajax/index";
	
	url+="?tipo=remove_vinculo";
			
	url+="&id="+id;
			
	carregar_url(url);
				
}


function oportunidade_cliente(nome,id,tipo,div)
{
		if((div=="cliente")||(div=="concorrente"))	
		{	
			if(div=="cliente") // Conta
			{	
				document.getElementById('lbl_nomeconta').innerHTML = nome;
				document.getElementById('nomeconta').value = nome;
				document.getElementById('codconta').value = id;
				fechar('div_clientes');fechar('fundo_cobre');
			}
			if(div=="concorrente")
			{
				
				document.getElementById('lbl_nomecon').innerHTML = nome;
				document.getElementById('nomecon').value = nome;
				document.getElementById('codcon').value = id;
				document.getElementById('tipocon').value = tipo;
				document.getElementById('radiosim').checked = true;
				fechar('div_clientes');fechar('fundo_cobre');
			
			}
		}
		else
		{
				alert("Houve um erro - tente novamente");
		}		
}

function oportunidade_contato(nome,id,tipo,div)
{
	if(div=="cliente")
	{	
		document.getElementById('lbl_nomeCont').innerHTML = nome;
		document.getElementById('nomeCont').value = nome;
		document.getElementById('codCont').value = id;
		fechar('div_clientesContato');fechar('fundo_cobre');
	}

}

function relacionamento_cliente(nome,id,tipo,div)
{
	if(div=="contatos")
	{	
		var url = dominio+diretorio()+"/interacoes/AdicionaContato";
		
		var idProspeccao = document.getElementById('idProspeccao').value;
		
		var interacao = document.getElementById('cod_interacao').value;
		
		$("#loading").html('Carregando...');
		
		$("#loading").show();
		
		$.post(url,{contato:id,nomecontato:nome,prospeccao:idProspeccao,interacao:interacao},function(data)
		{
			if(data==-1)
			{	
				$("#loading").html('Contato j&aacute; adicionado');
			}	
			else
			{	
				$("#loading").html('Adicionado com sucesso');
			
				$("#resposta").html(data);
			}
		});
		
	}
	if(div=="contas")
	{
		document.getElementById('lbl_nomeconta').innerHTML = nome;
		document.getElementById('codconta').value = id;
		fechar('div_contas');fechar('fundo_cobre');
		
		/*
		var pagina = verifica_pagina('interacoes');
		
		if(pagina=="interacoes")
		{
			carrega_prospect();
		}
		*/	
	}
	if(div=="lancamentos")
	{
		
		document.getElementById('lbl_nomecli').innerHTML = nome;
		document.getElementById('nomecli').value = nome;
		document.getElementById('codcli').value = id;
		document.getElementById('tipoentidade').value = tipo; // Teste, alterar pois pode ser os dois
		fechar('div_clientes');fechar('fundo_cobre');
		
	}
}


//interacoes,lancamentos

function BuscaContatosBox(div,pagina)
{
			
	var arg = document.getElementById('buscacontatos').value;
			
	var url = dominio+diretorio()+"/contato/BuscaContatoBox/"+div+"/"+pagina+"/"+arg; 
			
	ajaxHTMLProgressBar('resp_contatos',url,false,false);
		
}

function BuscaContasBox(div,pagina)
{
			
	var arg = document.getElementById('buscacontas').value;
			
	var url = dominio+diretorio()+"/contas/BuscaContaBox/"+div+"/"+pagina+"/"+arg; 
			
	ajaxHTMLProgressBar('resp_contas',url,false,false);
		
}




function monta_box_followup(interacao)
{
	$('#int_followup').val(interacao);
	
	$('#data_followup').val('');
	
	$("#obs_followup").val('');
	
	/*
	
	$('#emails_prospects_followup').val('');
	
	$('#nomes_prospects_followup').val('');
	
	var url = dominio+diretorio()+"/interacoes/NomeProspects/"+interacao;
	
	ajaxHTMLProgressBar('nomes_prospects_followup',url,false,false);
	*/
}

function consulta_followup(interacao)
{
	var url = dominio+diretorio()+"/interacoes/ConsultaLembrete/"+interacao;
	
	ajaxHTMLProgressBar('resp_agenda',url,false,false);
}


function emails_prospects_followup(prospect)
{
	var url = dominio+diretorio()+"/interacoes/EmailsProspect/"+prospect;
	
	ajaxHTMLProgressBar('emails_prospects_followup',url,false,false);
}

function salvar_followup()
{
	var data = $("#data_followup").val();
	
	var obs = $("#obs_followup").val();
	
	var interacao = $("#int_followup").val();
	
	var url = dominio+diretorio()+"/interacoes/SalvarFollowup";
	
	$('#loading').show();
	
	$('#loading').html('Carregando...');
	
	$.post(url, {data:data,obs:obs,interacao:interacao}, function(data)
	{
		$('#loading').html(data);
	}); // Fim do POST

}

function validaInteracoes()
{
	var motivo1 = document.getElementById('motivo1').checked;
	var motivo2 = document.getElementById('motivo2').checked;
	if((motivo1 == false)&&(motivo2 == false))
	{
		alert("Preencha o campo motivo");
		return false;
	}
	else
	{
		gravar_interacoes1();
				
	}
			
}

function esconder_int()
{

	$("#oculto").fadeOut(1000,function(){
	});

}

function busca_interacoes()
{	
	var url = dominio+diretorio()+"/interacoes/BuscaInteracoesAjax";
	ajaxHTMLProgressBar('interacoes_corpo',url,false,false);
}

function gravar_interacoes1() //primeira parte
{	
	
	var data = document.getElementById('data').value;
	var hora = document.getElementById('hora').value;
	var motivo = document.getElementById('submotivo').value;
	var url = dominio+diretorio()+"/interacoes/gravaInteracao";
	$.post(url,{data:data,hora:hora,motivo:motivo},function(data)
	{
		$("#cod_interacao").val(data);
		$("#cod_interacao").val($.trim($("#cod_interacao").val()));
		executaJquery();
	});

}
function limpar_interacoes()
{
	$('.conteudo-mostrar').hide();
	
	$('#mostrar').show();
	
	$('#Teste').hide();
	
	$('#mostraCadContato').hide();
	
	$('#cadastra').hide();
	
	document.getElementById('motivo1').checked = false;
	
	document.getElementById('motivo2').checked = false;
	
	$("#div_motivos").html('');
	
	document.getElementById('idProspeccao').selectedIndex = 0;
	
	$("#lbl_nomeconta").html('Selecione');
	
	$("#cod_conta").html('');
	
	document.getElementById('canal').selectedIndex = 0;
	
	document.getElementById('tipo1').checked = false;
	
	document.getElementById('tipo2').checked = false;
	
	$("#int_obs").html('');
	
	$("#resposta").html('');
	
}

function gravar_interacoes2()
{
	var data = document.getElementById('data').value;
	var hora = document.getElementById('hora').value;
	var motivo = document.getElementById('submotivo').value;
	var prospeccao = document.getElementById('idProspeccao').value;
	var conta = document.getElementById('codconta').value;
	var canal = document.getElementById('canal').value;
	var interacao = document.getElementById('cod_interacao').value;
	var tipo1 = document.getElementById('tipo1').checked;
	var tipo = false;
	if(tipo1==true)
	{	
		tipo = document.getElementById('tipo1').value;
	}
	else
	{
		tipo = document.getElementById('tipo2').value;
	}
	var desc = document.getElementById('int_obs').value;
	var url = dominio+diretorio()+"/interacoes/gravaInteracao2";
	$.post(url,{data:data,hora:hora,motivo:motivo,prospeccao:prospeccao,conta:conta,canal:canal,tipo:tipo,desc:desc,interacao:interacao},function(data)
	{
		$("#loading").html(data);
		$("#loading").show();
		busca_interacoes();
	});
}

function carrega_motivos(tipo,submotivo)
{
	var url = dominio+diretorio()+"/interacoes/BuscaMotivos/"+tipo+"/"+submotivo;
			
	ajaxHTMLProgressBar('div_motivos',url,false,false);

    var id = "#motivo"+tipo;
    $(id).addClass("active");
}

//
function busca_contas(div)
{	
	document.getElementById('resp_contas').innerHTML ="<img src='"+dominio+diretorio()+"/application/img/carregando.gif"+"'>";
	aux_ajax ='busca_contas';
	auxdiv = div;
	var arg = document.getElementById('buscacontas').value;
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&div="+div;
	url+="&arg="+arg;
	carregar_url(url); 
	
}
function busca_contatos(div)
{	
	document.getElementById('resp_contatos').innerHTML ="<img src='"+dominio+diretorio()+"/application/img/carregando.gif"+"'>";  
	aux_ajax ='busca_contatos';
	auxdiv = div;
	var arg = document.getElementById('buscacontatos').value;
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&div="+div;
	url+="&arg="+arg;
	carregar_url(url); 
	
}



function busca_contatos_contas()
{		
	
	var idContas = document.getElementById('codconta').value;
	var jsBuscaContas = document.getElementById('buscacontatos').value;
	
	var url = dominio+diretorio()+"/oportunidades/listaContato";
			

	var parametros = "idConta="+idContas+"&buscaContas="+jsBuscaContas;
				

	req.open("POST", url, true);
	

	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	// Acessar o evento onreadystatechange para o objeto XMLHttpRequest
	req.onreadystatechange = function() 
	{
		if(req.readyState == 4 && req.status == 200) 
		{
			var return_data = req.responseText;
			
			document.getElementById("resp_contatos").innerHTML = return_data;
			
			document.getElementById('loading').style.display = "none";
			
		}
	}
	
	req.send(parametros); // Realmente executar o pedido
			
	document.getElementById('loading').innerHTML = "Carregando...";
	
	document.getElementById('loading').style.display = "inline";
	
	document.getElementById("resp_contatos").innerHTML = "<img src='"+dominio+diretorio()+"/application/img/carregando.gif"+"'>"; 

	
}


//VINCULOS
function buscacrm(aba,arg)
{	
	cursor("wait");
	aux_ajax ='buscacrm';
	//var ent = document.getElementById('slentidade').value;
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&arg="+arg;
	url+="&aba="+aba;
	url+="&nome="+nome;
	//url+="&ent="+ent;
	carregar_url(url); 
	
}

function vincular(i,j,aba)
{	
	cursor("wait");
	aux_ajax ='vincular';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&arg="+i;
	url+="&arg2="+j;
	url+="&aba="+aba;
	carregar_url(url);
	
}
function vincula_dados_transitorios(i,j,aba)
{
		cursor("wait");
		aux_ajax ='vincular';
		var email = document.getElementById('email_vinculo').value;
		var fone = document.getElementById('fone_vinculo').value;
		var ramal = document.getElementById('ramal_vinculo').value;
		var cargo = document.getElementById('cargo_vinculo').value;
		var operacao = document.getElementById('operacao_vinculo').value;
		var vinculo = document.getElementById('id_vinculo').value;
		var url = dominio+diretorio()+"/ajax/index";
		url+="?tipo="+aux_ajax;
		url+="&arg="+i;
		url+="&arg2="+j;
		url+="&aba="+aba;
		url+="&email="+email;
		url+="&fone="+fone;
		url+="&ramal="+ramal;
		url+="&cargo="+cargo;
		url+="&operacao="+operacao;
		url+="&id="+vinculo;
		carregar_url(url);


}

function box_vinculos(vinculo,operacao)
{
	if(operacao=="alterar")
	{	
		aux_ajax = "box_vinculos";
		var url = dominio+diretorio()+"/ajax/index";
		url+="?tipo="+aux_ajax;
		url+="&vinculo="+vinculo;
		carregar_url(url);

	}
	if(operacao=="inserir")
	{
		cobre();
		abrir('dados_transitorios');
		$("#operacao_vinculo").val('');
		$("#email_vinculo").val('');
		$("#fone_vinculo").val('');
		$("#ramal_vinculo").val('');
		$("#cargo_vinculo").val('');
		
	}
	/*
	if(operacao=="visualizar")
	{
		
		
	}
	*/
}

function status_vinculo(id,status)
{
	aux_ajax ='status_vinculo';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&id="+id;
	url+="&status="+status;
	carregar_url(url);

}

/* Usuarios */

function verifica_exclusao_usuario(user)
{
	var url = dominio+diretorio()+"/usuario/VerificaExclusao";
	
	var url2 = dominio+diretorio()+"/usuario/excluir/"+user;
			
	if(confirm('Tem certeza que deseja excluir? Todos os logs ser\u00E3o perdidos'))
	{
		$.post(url, {user:user}, function(data)
		{
			if(data!=1)
			{
				$("#resp_exclusao").html(data);
				$("#resp_exclusao").show('fast');
			}
			else
			{
				fLink(url2);
			}
		});
	}// Fim do POST


}

/* Projetos */

function zerar_tarefas()
{
	aux_ajax ='zerar_tarefas';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	carregar_url(url);

}
// Tarefas e Atividades


function busca_atividades(cod,tipo)
{
	aux_ajax ='busca_atividades';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&tipo_busca="+tipo;
	url+="&arg="+cod;
	if(tipo=="atividades_projetos")
	{
		carregando('resp_atividades');
		url+="&contrato="+document.getElementById('contrato').value;
	}
	if(tipo=="produtos_atividades_projetos")
	{
		carregando('resp_atividades_alocar');
		var texto = "<h3>Atividades relacionadas a "+$("#produto_"+cod+"_nome").html()+"</h3>"; 
		$("#header_produto_atividades").html(texto);
		//url+="&projeto="+document.getElementById('cod_projeto').value;
	
	}
	carregar_url(url);

}

$(function($) { // Alocar tarefa
	// Quando o formul�rio for enviado, essa fun��o � chamada
	$("#form_alocar_tarefa").submit(function() 
	{
		aux_ajax = 'alocar_tarefa';
		var url = dominio+diretorio()+"/ajax/index";
		url+="?tipo="+aux_ajax;
		url+="&operacao="+$("#operacao_tarefa_alocar").val();
		url+="&id_alocacao="+$("#id_alocacao").val();
		// Colocamos os valores de cada campo em uma v�riavel para facilitar a manipula��o
		var projeto = $("#projeto_tarefa_alocar").val();
		var produto = $("#produto_tarefa_alocar").val();
		if(produto=="")
		{
			alert("Selecione o produto (fora do box)");
			
			return false;
		
		}
		var atividade = $("#atividade_tarefa_alocar").val();
		var tarefa = $("#tarefa_alocar_id").val();
		var user = $("#user_tarefa_alocar").val();
		var status = $("#status_tarefa_alocar").val();
		var data_inicio = $("#datai_tarefa_alocar").val();
		var data_fim = $("#dataf_tarefa_alocar").val();
		var prioridade = $("#prioridade_tarefa_alocar").val();
		var anexo = $("#anexo_tarefa_alocar").val();
		var descricao = $("#descricao_tarefa_alocar").val();
		var cortesia = $('input:radio[name=cortesia_tarefa_alocar]:checked').val();
		var comentario = $("#comentario_tarefa_alocar").val();
		var responsavel = $("#responsavel_tarefa_alocar").val();
		var extra = $("#extra_tarefa_alocar").val();
		// Exibe mensagem de carregamento
		$("#loading").css('height','40px');
		$("#loading").show();
		$("#loading").html("Carregando...");
		// Fazemos a requis�o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav�s do m�todo POST
		$.post(url, {projeto: projeto, produto:produto, atividade: atividade, tarefa: tarefa, user:user, status:status, data_inicio:data_inicio,data_fim:data_fim, prioridade:prioridade, anexo:anexo, descricao:descricao, cortesia:cortesia, comentario:comentario, responsavel:responsavel,extra:extra}, function(resposta) {
				$("#loading").html(resposta);
				// Se resposta for false, ou seja, n�o ocorreu nenhum erro
				
			});
		
		return false;
		
		});
		
		
	
	});

function busca_tarefas_extras()
{
	carregando('resp_tarefas_extras');
	aux_ajax ='busca_tarefas_extras';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&projeto="+$('#cod_projeto').val();
	carregar_url(url); 

}

function busca_tarefas_usuario(projeto,user)
{
	carregando('resp_cron_user');
	aux_ajax ='busca_tarefas_usuario';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	//url+="&projeto="+projeto;
	url+="&usuario="+user;
	carregar_url(url); 

}
	
function add_tarefas()
{	
	aux_ajax ='add_tarefas';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	carregar_url(url); 

}


function add_tarefa(i)
{
	aux_ajax ='add_tarefa';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&i="+i;
	carregar_url(url); 

}

function vincula_atividades_produtos(id_objeto)
{
	id_objeto = id_objeto.split("_");
	var id = id_objeto[2];
	aux_ajax ='vincula_atividades_produtos';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&atividade="+id;
	url+="&produto="+document.getElementById('cod_produto').value;
	carregar_url(url);
}

function vincula_tarefas_produtos(id_objeto)
{
	id_objeto = id_objeto.split("_");
	var tarefa = id_objeto[2];
	var atividade = id_objeto[4];
	aux_ajax ='vincula_tarefas_produtos';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&tarefa="+tarefa;
	url+="&atividade="+atividade;
	url+="&produto="+document.getElementById('cod_produto').value;
	carregar_url(url);

	
}


function rmvtf(y)
{
	aux_ajax ='remove_tarefa';
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&i="+y;
	url+="&a="+document.getElementById('cod_atividade').value;
	carregar_url(url); 
}

function gtf(tipo)
{
	aux_ajax = tipo;
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+tipo;	
	carregar_url(url);
	

}

//Repensar l�gica do ct
function busca_tarefas(tipo)
{
	aux_ajax = 'tarefas'; 
	var url = dominio+diretorio()+"/ajax/index";
	url+="?tipo="+aux_ajax;
	url+="&arg="+tipo;
	if(!ct)	
	{	
		carregar_url(url); 
		ct = true;
	}
}	



  /*   @brief Converte um valor em formato float para uma string em formato moeda
      @param valor(float) - o valor float
      @return valor(string) - o valor em moeda
   */
   function converteFloatMoeda(valor){
      var inteiro = null, decimal = null, c = null, j = null;
      var aux = new Array();
      valor = ""+valor;
      c = valor.indexOf(".",0);
       //encontrou o ponto na string
      if(c > 0){
         //separa as partes em inteiro e decimal
         inteiro = valor.substring(0,c);
         decimal = valor.substring(c+1,valor.length);
      }else{
         inteiro = valor;
      }
      
      //pega a parte inteiro de 3 em 3 partes
      for (j = inteiro.length, c = 0; j > 0; j-=3, c++){
         aux[c]=inteiro.substring(j-3,j);
      }
	  
      //percorre a string acrescentando os pontos
      inteiro = "";
      for(c = aux.length-1; c >= 0; c--){
         inteiro += aux[c]+'.';
      }
      //retirando o ultimo ponto e finalizando a parte inteiro
      
      inteiro = inteiro.substring(0,inteiro.length-1);
      
      //decimal = parseInt(decimal);
      if(isNaN(decimal)){
         decimal = "00";
      }else{
         decimal = ""+decimal;
         if(decimal.length === 1){
            decimal = decimal+"0";
         }
      }
      
      
      valor = inteiro+","+decimal;
      
	  
	  return valor;

   }


//TRANSPARENCIA
function cobre()
{
	document.body.style.overflow = "hidden";//esconde as barras de rolagem Douglas dia 03/02/2012
	document.getElementById('fundo_cobre').style.display ="inline"; 
	
}

function seleciona_check()
{
	
	var checks = document.getElementsByTagName("input");
	for(var i=1;i<4;i++)
	{
		
		
				if(!checks[i].checked)
				{
					checks[i].checked=true;
				
				}
				else
				{
					checks[i].checked=false;
				
				}
			
	
		
	}
	
}


function menu(menu)
{
	if(document.getElementById(menu).style.display == 'inline') 
	{	
		fechar(menu); 
	}
	else
	{
		 abrir(menu);
	}
}


function fechar(popup)
{
	document.getElementById(popup).style.display = 'none';
	
	document.getElementById('loading').style.display = 'none';
	document.body.style.overflow = "scroll";//habilita de novo as barras de rolagem inutilizadas na fun�ao Cobre() Douglas dia 03/02/2012
}

function abrir(popup)
{
     document.getElementById(popup).style.display = 'inline';

}


function mouse(ref)
{
        ref.style.cursor  = "pointer";
}




//ANTIGAS FUNCOES e FUNCOES GERAIS

function checkAll(type) 
{
	var inputs = document.getElementsByTagName('input');
	
	var length = inputs.length;

	if (type == 'check') 
	{
		type = 'true';
	}
	if (type == 'uncheck') 
	{
		type = 'false';
	}
	if (type == 'invert') 
	{
		type = '!inputs[i].checked';
	}
	for (var i = 0; i < length; i++) 
	{
		if (inputs[i].type == 'checkbox' && inputs[i].id.search('check_prospects') != '-1') 
		{
			inputs[i].checked = eval(type);
		}
	}
}

function horizontal() 
{
 
   var navItems = document.getElementById("lista").getElementsByTagName("li");
    
   for (var i=0; i< navItems.length; i++) {
      if(navItems[i].className == "submenu")
      {
         if(navItems[i].getElementsByTagName('ul')[0] != null)
         {
            navItems[i].onmouseover=function() {this.getElementsByTagName('ul')[0].style.display="block";this.style.backgroundColor = "#f9f9f9";}
            navItems[i].onmouseout=function() {this.getElementsByTagName('ul')[0].style.display="none";this.style.backgroundColor = "#FFFFFF";}
         }
      }
   }
 
}




function fLink(link) {
	if(link)
		window.location.href = link;
}

function fConfirm(str, link) {
	if(link) {
		if(confirm(str))
			window.location.href = link;
	}
}

function moeda(valor, casas, separdor_decimal, separador_milhar)
{

	var valor_total = parseInt(valor * (Math.pow(10,casas)));
	var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
	var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));


	if(centavos%10 == 0 && centavos+"".length<2 ){
	centavos = centavos+"0";
	}else if(centavos<10){
	centavos = "0"+centavos;
	}

	var milhares = parseInt(inteiros/1000);
	inteiros = inteiros % 1000;

	var retorno = "";

	if(milhares>0){
	retorno = milhares+""+separador_milhar+""+retorno
	if(inteiros == 0){
	inteiros = "000";
	} else if(inteiros < 10){
	inteiros = "00"+inteiros;
	} else if(inteiros < 100){
	inteiros = "0"+inteiros;
	}
	}
	retorno += inteiros+""+separdor_decimal+""+centavos;


	return retorno;

}


function changeFieldsStatus(status) {

	if(status == '2') {
	
		var auxTitle = document.title.split('|');		
		document.title = auxTitle[0] + '| Cliente';
		
		document.getElementById('label_name').innerHTML = 'Cliente';	
		
		document.getElementById('form_type').value = 'cliente';
		
		var objDisplayCliente = document.getElementsByClassName('displayCliente');
		
		for (i=0; i < objDisplayCliente.length; i++) {

			objDisplayCliente[i].style.display = 'table-row';
		}
		
	}
	
	if(status == '1') {
		
		var auxTitle = document.title.split('|');		
		document.title = auxTitle[0] + '| Prospect';
		
		document.getElementById('label_name').innerHTML = 'Prospect';	
		
		document.getElementById('form_type').value = 'prospect';		
		
		var objDisplayCliente = document.getElementsByClassName('displayCliente');
		
		for (i=0; i < objDisplayCliente.length; i++) {

			objDisplayCliente[i].style.display = 'none';
		}		
		
	}
	
}

function getEndereco() {

	if($.trim($("#cep").val()) != ""){
	 
	$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
	 
		if (resultadoCEP["tipo_logradouro"] != '') {
			if (resultadoCEP["resultado"]) {
	 
				 $("#rua").val(unescape(resultadoCEP["tipo_logradouro"]) + ": " + unescape(resultadoCEP["logradouro"]));
				 $("#bairro").val(unescape(resultadoCEP["bairro"]));
				 $("#cidade").val(unescape(resultadoCEP["cidade"]));
				 $("#uf").val(unescape(resultadoCEP["uf"]));
				 
				$("#rua").focus();
				
			}
		 } 
	 
	  });
	}
	 
}

function getEnderecoSelect() {

	if($.trim($("#cep").val()) != ""){
	 
	$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
	 
		if (resultadoCEP["tipo_logradouro"] != '') {
			if (resultadoCEP["resultado"]) {
	 
				 $("#rua").val(unescape(resultadoCEP["tipo_logradouro"]) + ": " + unescape(resultadoCEP["logradouro"]));
				 
				 $("#bairro").val(unescape(resultadoCEP["bairro"]));
				 
				 $("#rua").focus();
				
			}
		 } 
	 
	  });
	}
	 
}

function displayFieldsAlerta(alerta) {

	if(alerta == '1') {
	
		var objDisplayAlerta = document.getElementsByClassName('displayAlerta');
		
		for (i=0; i < objDisplayAlerta.length; i++) {

			objDisplayAlerta[i].style.display = 'table-row';
		}		
		
	}
	else {
	
		var objDisplayAlerta = document.getElementsByClassName('displayAlerta');
		
		for (i=0; i < objDisplayAlerta.length; i++) {

			objDisplayAlerta[i].style.display = 'none';
		}			
	
	}
	
}

function displayFieldsUsuario(tipo_cadastro) {

	if(tipo_cadastro == '1') {
		
		var objDisplayFranquia = document.getElementsByClassName('displayFranquia');
		
		for (i=0; i < objDisplayFranquia.length; i++) {

			objDisplayFranquia[i].style.display = 'none';
		}		
	
		var objDisplayFranqueador = document.getElementsByClassName('displayFranqueador');
		
		for (i=0; i < objDisplayFranqueador.length; i++) {

			objDisplayFranqueador[i].style.display = 'table-row';
		}		
		
	}
	else {

		var objDisplayFranqueador = document.getElementsByClassName('displayFranqueador');
		
		for (i=0; i < objDisplayFranqueador.length; i++) {

			objDisplayFranqueador[i].style.display = 'none';
		}		
	
		var objDisplayFranquia = document.getElementsByClassName('displayFranquia');
		
		for (i=0; i < objDisplayFranquia.length; i++) {

			objDisplayFranquia[i].style.display = 'table-row';
		}		
		
	}
	
}

$(document).ready(function() {

  
  $("#form_curso").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,nome,Por favor preencha corretamente: Nome."
    ]
  });
  
  $("#form_alterar_senha").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
	  "required,senha,Por favor preencha corretamente: Senha.",
	  "required,confirma_senha,Por favor preencha corretamente: Confirma Senha.",
	  "same_as,senha,confirma_senha,Os campos Senha e Confirma Senha n&atilde;o correspondem."
    ]
  });  
  
  $("#form_cliente").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,nome,Por favor preencha corretamente: Nome."
    ]
  });  
  
  $("#form_prospect").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,nome,Por favor preencha corretamente: Nome."
    ]
  });    
  
  $("#form_cliente_historico").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,texto,Por favor preencha corretamente: Texto."
    ]
  });   
  
  $("#form_cliente_agendamento").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,cod_cliente,Por favor preencha corretamente: Cliente.",
      "required,cod_usuario,Por favor preencha corretamente: Usu&aacute;rio.",
      "required,texto,Por favor preencha corretamente: Texto.",
      "required,data_hora,Por favor preencha corretamente: Data e Hora.",
      "required,alerta,Por favor preencha corretamente: Receber Alerta.",
      "required,alerta_minuto,Por favor preencha corretamente: Quantos minutos antes.",
      "required,alerta_email,Por favor preencha corretamente: Enviar para qual e-mail.",
	  "valid_email,alerta_email,Por favor preencha um E-mail v&aacute;lido."
    ]
  });  
  
  $("#form_turma").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,cod_curso,Por favor selecione: Curso.",
      "required,nome,Por favor preencha corretamente: Nome."
    ]
  });     
  
  $("#form_franquia").RSV({
	errorTextIntro:"Verifique os erros abaixo:",
	displayType: "display-html",	
    rules: [
      "required,nome,Por favor preencha corretamente: Nome."
    ]
  });  
  
});

$(function(){  
	$("#data_nascimento").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior',
		changeMonth: true,
		changeYear: true,
		yearRange: '1920:2011'		
	});  
});

$(function(){  
	$("#datarel").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
}); 

 

$(function(){  
	$("#data_inicio").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
}); 


$(function(){  
	$("#divIdEmktDataFinal").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
}); 


$(function(){  
	$("#divIdEmktDataInicial").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
}); 




$(function(){  
	$("#data_fim").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
});

$(function(){  
	$("#data").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
});

$(function(){  
	$("#data_startup").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
}); 

$(function(){  
	$("#data_servico").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
});  
 
$(function(){  
	$("#fechamento").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
});  

$(function(){  
	$("#idDadaInicioProspc").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
});
$(function(){  
	$("#idDadaFinalProspc").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'  
		],  
		monthNames: [  
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',  
		'Outubro','Novembro','Dezembro'  
		],  
		monthNamesShort: [  
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',  
		'Out','Nov','Dez'  
		],  
		nextText: 'Pr&oacute;ximo',  
		prevText: 'Anterior'	
	});  
}); 
		
function urlencode( str ) 
{
 
	var histogram = {}, tmp_arr = [];
	var ret = (str+'').toString();
 
	var replacer = function(search, replace, str) {
		var tmp_arr = [];
		tmp_arr = str.split(search);
		return tmp_arr.join(replace);
	};
 
	// The histogram is identical to the one in urldecode.
	histogram["'"]   = '%27';
	histogram['(']   = '%28';
	histogram[')']   = '%29';
	histogram['*']   = '%2A';
	histogram['~']   = '%7E';
	histogram['!']   = '%21';
	histogram['%20'] = '+';
	histogram['\u20AC'] = '%80';
	histogram['\u0081'] = '%81';
	histogram['\u201A'] = '%82';
	histogram['\u0192'] = '%83';
	histogram['\u201E'] = '%84';
	histogram['\u2026'] = '%85';
	histogram['\u2020'] = '%86';
	histogram['\u2021'] = '%87';
	histogram['\u02C6'] = '%88';
	histogram['\u2030'] = '%89';
	histogram['\u0160'] = '%8A';
	histogram['\u2039'] = '%8B';
	histogram['\u0152'] = '%8C';
	histogram['\u008D'] = '%8D';
	histogram['\u017D'] = '%8E';
	histogram['\u008F'] = '%8F';
	histogram['\u0090'] = '%90';
	histogram['\u2018'] = '%91';
	histogram['\u2019'] = '%92';
	histogram['\u201C'] = '%93';
	histogram['\u201D'] = '%94';
	histogram['\u2022'] = '%95';
	histogram['\u2013'] = '%96';
	histogram['\u2014'] = '%97';
	histogram['\u02DC'] = '%98';
	histogram['\u2122'] = '%99';
	histogram['\u0161'] = '%9A';
	histogram['\u203A'] = '%9B';
	histogram['\u0153'] = '%9C';
	histogram['\u009D'] = '%9D';
	histogram['\u017E'] = '%9E';
	histogram['\u0178'] = '%9F';
 
	// Begin with encodeURIComponent, which most resembles PHP's encoding functions
	ret = encodeURIComponent(ret);
 
	for (search in histogram) {
		replace = histogram[search];
		ret = replacer(search, replace, ret) // Custom replace. No regexing
	}
 
	// Uppercase for full PHP compatibility
	return ret.replace(/(\%([a-z0-9]{2}))/g, function(full, m1, m2) {
		return "%"+m2.toUpperCase();
	});
 
	return ret;
}
 
// Url encode/decode 
 
function urldecode( str ) 
{
 
	var histogram = {};
	var ret = str.toString();
 
	var replacer = function(search, replace, str) {
		var tmp_arr = [];
		tmp_arr = str.split(search);
		return tmp_arr.join(replace);
	};
 
	// The histogram is identical to the one in urlencode.
	histogram["'"]   = '%27';
	histogram['(']   = '%28';
	histogram[')']   = '%29';
	histogram['*']   = '%2A';
	histogram['~']   = '%7E';
	histogram['!']   = '%21';
	histogram['%20'] = '+';
	histogram['\u20AC'] = '%80';
	histogram['\u0081'] = '%81';
	histogram['\u201A'] = '%82';
	histogram['\u0192'] = '%83';
	histogram['\u201E'] = '%84';
	histogram['\u2026'] = '%85';
	histogram['\u2020'] = '%86';
	histogram['\u2021'] = '%87';
	histogram['\u02C6'] = '%88';
	histogram['\u2030'] = '%89';
	histogram['\u0160'] = '%8A';
	histogram['\u2039'] = '%8B';
	histogram['\u0152'] = '%8C';
	histogram['\u008D'] = '%8D';
	histogram['\u017D'] = '%8E';
	histogram['\u008F'] = '%8F';
	histogram['\u0090'] = '%90';
	histogram['\u2018'] = '%91';
	histogram['\u2019'] = '%92';
	histogram['\u201C'] = '%93';
	histogram['\u201D'] = '%94';
	histogram['\u2022'] = '%95';
	histogram['\u2013'] = '%96';
	histogram['\u2014'] = '%97';
	histogram['\u02DC'] = '%98';
	histogram['\u2122'] = '%99';
	histogram['\u0161'] = '%9A';
	histogram['\u203A'] = '%9B';
	histogram['\u0153'] = '%9C';
	histogram['\u009D'] = '%9D';
	histogram['\u017E'] = '%9E';
	histogram['\u0178'] = '%9F';
 
	for (replace in histogram) {
		search = histogram[replace]; // Switch order when decoding
		ret = replacer(search, replace, ret) // Custom replace. No regexing   
	}
 
	// End with decodeURIComponent, which most resembles PHP's encoding functions
	ret = decodeURIComponent(ret);
 
	return ret;
}
		
		