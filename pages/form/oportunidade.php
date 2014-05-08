<?php
    include("lib/connection.php");
    mysql_query("DELETE FROM `itens_temporario` WHERE `usuario_id` = {$_COOKIE['id']}");
    mysql_query("DELETE FROM `parcelas_temporario` WHERE `usuario_id` = {$_COOKIE['id']}");
    $cod_usuario = "";
?>
<div id="da-content-area">
	<script>
		$(function () {
			function GravaEntidade(tipo) {
				var url = dominio + diretorio();
				
				if(tipo=="novo_contato") {
					url+="/crm/GravarContato";
					tipo = "contato";
				}
				
				if(tipo=="nova_conta") {
					url+="/crm/GravarConta";
					tipo = "conta";
				}
				
				var nome = $("#"+tipo).val();
				
				CarregandoAntes();
				
				$.post(url,{nome:nome},function (data) {
					CarregandoDurante();
					
					var resp = data.split("|")
					
					if(resp[0]==1) {
						$("#msg_loading").html(resp[1]);
						
						if(tipo=="conta") {
							$("#codconta").val(resp[2]);
						}
						if(tipo=="contato") {
							$("#codcontato").val(resp[2]);
						}
						
						CarregandoDepois('',10000);	
					} else {
						CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
					}
				});
			}

			$('#vendedor').each(function () {
				var url = dominio + diretorio() + "/oportunidades/AutoCompleteVendedor";
				var autoCompelteElement = this;
		
				$(this).autocomplete({source:url,
					select:function (event, ui) {
		
						$(autoCompelteElement).val(ui.item.label);
		
						var contato = ui.item.value,
								div = $("<div>").addClass("pr_5"),
								div2 = $("<div>").text(contato),
								a = $("<label>").addClass("close flt_lft").attr({
									title:"Remover " + contato
								}).text(" x ");
						a.click(function () {
							div2.html('');
							$("#codvendedor").val('');
							$("#vendedor").val('');
							$("#vendedor").show();
						});
						a.appendTo(div2),
						div2.appendTo(div),
						div.insertAfter("#vendedor");
						$("#vendedor").hide();
						$("#codvendedor").val(ui.item.id);
					}
				});
			 });
   
			$('#conta').each(function () {
				var url = dominio + diretorio() + "/home/AutoCompleteConta";
				var autoCompelteElement = this;
			
				$(this).autocomplete({source:url,
					select:function (event, ui) {
			
						if(ui.item.id=="nova_conta") {
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
				var autoCompelteElement = this;
			
				$(this).autocomplete({source:url,
					select:function (event, ui) {
			
						if(ui.item.id=="novo_contato") {
							GravaEntidade(ui.item.id);
						}
			
						$(autoCompelteElement).val(ui.item.label);
			
						var contato = ui.item.value,
								div = $("<div>").addClass("pr_5"),
								div2 = $("<div>").text(contato),
								a = $("<label>").addClass("close flt_lft").attr({
									title:"Remover " + contato
								}).text(" x ");
						a.click(function () {
							div2.html('');
							$("#nomecontato").val('');
							$("#codcontato").val('');
							$("#contato").val('');
							$("#contato").show();
						});
						a.appendTo(div2),
								div2.appendTo(div),
								div.insertAfter("#contato");
						$("#contato").hide();
						$("#nomecontato").val(contato);
			
						if(ui.item.id!="novo_contato") {
							$("#codcontato").val(ui.item.id);
						}	
					}
				});
			});
	
			$('#item_venda').each(function () {
				var autoCompelteElement = this;
				var url = dominio + diretorio() + "/home/AutoCompleteItens";
				
				$(this).autocomplete({source:url,
					select:function (event, ui) {
						$(autoCompelteElement).val(ui.item.value);
						var item = ui.item.value;
						var tipo = ui.item.label.split("-");
						var aux = false;
						
						for(i=0;i<tipo.length;i++) {
							if(($.trim(tipo[i])=="produto")||($.trim(tipo[i])=="serviço")) {
								aux = tipo[i];
								if($.trim(tipo[i])!="produto") aux = "servico";
								break;
							}
						}
						
						tipo = $.trim(aux);
						$("#tipo_item").val(tipo);
						$("#cod_item").val(ui.item.id);
					}
				});
			});

			$('#concorrente').each(function () {
				var url = dominio + diretorio() + "/oportunidades/AutoCompleteContaContato";
				var autoCompelteElement = this;
				
				$(this).autocomplete({source:url, 
					select:function (event, ui) {
						$(autoCompelteElement).val(ui.item.value);
						
						var con = ui.item.value,
						div = $("<div>").addClass("pr_5"),
						div2 = $("<div>").text(con),
						a = $("<label>").addClass("close flt_lft").attr({
							title:"Remover " + con
						}).text(" x ");
						a.click(function () {
							div2.html('');
							$("#nomecon").val('');
							$("#codcon").val('');
							$("#concorrente").val('');
							$("#tipocon").val('');
							$("#concorrente").show();
						});
						a.appendTo(div2),
						div2.appendTo(div),
						div.insertAfter("#concorrente");
						$("#concorrente").hide();
						$("#nomecon").val(con);
						$("#codcon").val(ui.item.id);
						var tipo = ui.item.label.split("-");
						tipo = $.trim(tipo[1]);
						$("#tipocon").val(tipo);
					}
				});
			});
	
	 $('#int_contato').each(function () {
	
				var url = dominio + diretorio() + "/crm/AutoCompleteContato?callback=?";

				var url2 = dominio + diretorio() + "/interacoes/AddContato/inserir";

				var url3 = dominio + diretorio() + "/interacoes/DelContato/inserir";
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
						
							var nome = $("#int_contato").val();
							
							CarregandoAntes();
							
							$.post(url4,{nome:nome},function (data) 
							{
								CarregandoDurante();
								
								var resp = data.split("|")
								
								if(resp[0]==1)
								{
									$("#msg_loading").html(resp[1]);
									
									id = resp[2];
									
									CarregandoDepois('',10000);	
									
									$.post(url2, {contato:id}, function (data) {

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
													div.insertAfter("#resposta_int_contatos");
											$("#int_contato").val('');
										}
										else {
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
							id = ui.item.id;
							
							$.post(url2, {contato:id}, function (data) {

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
											div.insertAfter("#resposta_int_contatos");
									$("#int_contato").val('');
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

			$(document).ready(function () {
				$('.texto').tooltip();
				$("#servico").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
				$("#qtd_item").maskMoney({showSymbol:true, symbol:"", decimal:"", thousands:"", precision:0});
				$("#valor_item").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
				BuscarItens();
			});

function ShowParcela(tipo) {

	if (tipo != 'fixo') {

		if (tipo == "hora") {
			
			$("#parcela_servico").val(1);
			
			$("#tipo_parcelas").html('<strong>Horas</strong>');

		}

		if (tipo == "mes") {
			$("#tipo_parcelas").html('<strong>Meses</strong>');

		}

		if (tipo == "ano") {
			$("#tipo_parcelas").html('<strong>Anos</strong>');

		}

		$("#tipo_parcelas").show();

		$("#tipo_parcelas").css('display', 'inline');

		$("#div_parcelas").show();

		$("#div_parcelas").css('display', 'inline');

	}
	else {

		$("#tipo_parcelas").html('');

		$("#tipo_parcelas").hide();

		$("#div_parcelas").hide();

	}


}

			function Situacao(id) {
				if (id == "ganhamos") {
					$("#ganhamos").addClass('btn-success');
					$("#perdemos").removeClass('btn-danger');
					$("#andamento").removeClass('btn-warning');
					$("#situacao").val(1)
				}
				if (id == "perdemos") {
					$("#perdemos").addClass('btn-danger');
					$("#andamento").removeClass('btn-warning');
					$("#ganhamos").removeClass('btn-success');
					$("#situacao").val(0)
				}
				if (id == "andamento") {
					$("#andamento").addClass('btn-warning');
					$("#ganhamos").removeClass('btn-success');
					$("#perdemos").removeClass('btn-danger');
					$("#situacao").val(2)
				}
			}

function limpa_oportunidade() {
	var url = dominio + diretorio() + "/oportunidades/LimpaOportunidades";
	// Exibe mensagem de carregamento
	$("#loading").css('height', '40px');
	$("#loading").show();
	$("#loading").html("Carregando...");
	$.post(url, function (resposta) {
		var dados = resposta.split("|");

		document.getElementById('loading').style.display = 'none';
	});

}


function DelInteracoes(id)
{
	var url = dominio + diretorio() + "/interacoes/excluir/"+id+"/ajax";

	if(confirm('Tem certeza que deseja excluir?'))
	{
	
		CarregandoAntes();
		
		$.post(url, function (data) {
			var resp = data.split("|");	
				
			CarregandoDurante();
			
			$("#msg_loading").html(resp[1]);
				
			CarregandoDepois('',2000);
			
			if (resp[0] == 1) 
			{
				ListarInteracoes();
			}
			
		});
	}	

}

function GravarInteracao()
{
	var url = dominio + diretorio() + "/oportunidades/GravarInteracao";
	
	CarregandoAntes();
	
	$.post(url, {oportunidade:$("#cod_opt").val(),data:$("#int_data").val(),hora:$("#int_hora").val(),motivo:$("#int_motivo").val(),canal:$("#int_canal").val(),tipo:$('input:radio[name=int_tipo]:checked').val(),obs:$("#int_obs").val()}, function (data) {
		
		resp = data.split("|");
		
		CarregandoDurante();
		
		if(resp[0]==1)
		{
			$("#int_hora").val(resp[2]);
			
			$("#int_data").val(resp[3]);
			
			$("#int_tipo1").attr("checked",false);
			
			$("#int_tipo2").attr("checked",false);
			
			$("#int_motivo").attr("checked",false);
			
			$("#int_motivo2").attr("checked",false);
			
			$("#int_obs").val('');
			
			$("#int_canal").val('');
			
			$("#div_motivos").html('');
			
			$("#div_mae_contatos").html('<div id="resposta_int_contatos" name="resposta_int_contatos"></div>');
			
			$("#int_conta").val('');
			
			$("#modal_interacoes").modal('hide');
				
			ListarInteracoes();
			
		}
		
		$("#msg_loading").html(resp[1]);
		
		CarregandoDepois();
	
	});


}

function ListarInteracoes()
{

	var url = dominio + diretorio() + "/oportunidades/BuscaInteracoes/";

	ajaxHTMLProgressBar('historico_interacoes', url, false, false);

}

function ConfigProspect(valor)
{
	
	if(valor=="contato")
	{
		$("#div_contato").show();
		
		$("#div_conta").hide();
		
		$("#conta").val('');
		
		$("#nomeconta").val('');
		
		$("#codconta").val('');
	}
	if(valor=="conta")
	{
		$("#div_conta").show();
		$("#div_contato").show();
	}
	



}

		function FormItens() {
			$('#nome_item').val('Adicionar produtos/servi&ccedil;os');
			$('#qtd_item').val('1');
			$('#valor_item').val('');

			var url = dominio + diretorio() + "/oportunidades/FormItem";

			CarregandoAntes();

			$.post(url,{item:$("#cod_item").val()}, function(data) {
				var resp = data.split("|");

				CarregandoDurante();

				if(resp[0] == 1) {
					$("#nome_item").html(resp[1]);
					$('#valor_item').val(resp[2]);

					if(resp[3]=="produto") {
						$("#div_qtd").show();
						$("#ipi").html(resp[4]);
					} else {
						$("#div_qtd").hide();
						$("#ipi").html('');	
					}

					$("#modal_itens").modal('show');
				} else {
					$("#msg_loading").html(resp[1]);
				}

				CarregandoDepois('loading',3000);
			});
		}

		function AddItem() {
			CarregandoAntes();
			
			var url = dominio + diretorio() + "/oportunidades/AddItem";
			
			$.post(url,{item:$("#cod_item").val(),qtd:$("#qtd_item").val(),valor:$("#valor_item").val()}, function(data) {
				var resp = data.split("|");
				
				CarregandoDurante();
				
				if(resp[0]==1) {
					$("#item_venda").val('');
					$("#cod_item").val('');
					$("#qtd_venda").val('');
					$("#valor_item").val('');
					
					BuscarItens();
					
					$("#msg_loading").html(resp[1]);
					$("#servico").val(resp[2]);
					$("#modal_itens").modal('hide');
					
					CalculaTotal();
				} else {
					$("#msg_loading").html(resp[1]);
				}
				
				CarregandoDepois('loading',4000);
			});
		}
	
function BuscarParcelas()
{
	var url = dominio + diretorio() + "/oportunidades/BuscarParcelas//inserir";

	$.post(url,function(data)
	{
		var resp = data.split("|");
		
		CarregandoDurante();
		
		if(resp[0]==1)
		{
			$("#div_parcelamento").html(resp[1]);
		
			$("#negociacao_parcelada").attr("checked",true);
		
			$("#div_qtd_parcelas").show();
		
			$("#qtd_parcelas").val(resp[2]);
		}
		else
		{
								$("#negociacao_vista").attr("checked",true);	
			
					
		}
	
	});
	
	
}	
	
			function BuscarItens() {
				var url = dominio + diretorio() + "/BuscarItens/cadastro";
				ajaxHTMLProgressBar('resp_itens', url, false, false);
			}

			function BuscarItensVersao(id) 
			{
				var url = dominio + diretorio() + "/oportunidades/BuscarItensVersao/"+id;
				ajaxHTMLProgressBar('div_box_item_'+id, url, false, false);
			}

			function DelItem(i) {
				if(confirm("Deseja realmente excluir ?")) {	

					CarregandoAntes();

					var url = dominio + diretorio() + "/oportunidades/DelItem";
					$.post(url,{id:i}, function(data) {
						var resp = data.split("|");
						
						CarregandoDurante();
						
						if(resp[0]==1) {
							BuscarItens();
							
							$("#servico").val(resp[2]);
							
							CalculaTotal();
						}
						$("#msg_loading").html(resp[1]);
			
						CarregandoDepois('loading',5000);
					});
				}
			}

			function CheckNegociacao(valor) {
				if(valor=="parcelada") {
					$("#div_qtd_parcelas").show();
				} else {
					$('#div_parcelamento').html('');
					$("#qtd_parcelas").val('');
					$("#div_qtd_parcelas").hide();
				}
			}

			function ConfigFormPedido(flag) {
				if(flag=='error') {
					$("#data_comissoes").val($("#hdata_comissoes_pedido").val());
					$("#conta_comissoes").val($("#hconta_comissoes_pedido").val());
					$("#categoria_comissoes").val($("#hcategoria_comissoes_pedido").val());
					$("#data_parcelas").val($("#hdata_parcelas_pedido").val());
					$("#conta_parcelas").val($("#hconta_parcelas_pedido").val());
					$("#categoria_parcelas").val($("#hcategoria_parcelas_pedido").val());
					$("#pedido_acao").val($("#hpedido_acao").val());
					$("#repetir_data_parcelas").val($("#hrepetir_data_parcelas").val());
					
					ConfigDivsPedido()
				} else {
				   $("#gerar_pedido").val("");
				}
				
				var qtd = $('#qtd_parcelas').val();
				
				if(qtd==0) {
					qtd=1;
				}
			
				if(qtd==1) {
					$("#div_tipo_parcela").html('');
				} else {	
					var html;
					
					html='<div id="txt_conta_lan">';
					html+='<label class="checkbox inline"> <input name="repetir" type="checkbox" onclick="ConfigRepetir();" id="repetir_data_parcelas" value="1"> Repita este dia para os demais meses ou informe as datas <a data-toggle="modal" href="#modal_parcelas" onclick="CriarInputsPedido();">aqui</a></label>';
					html+='</div>';
					
					$("#div_tipo_parcela").html(html);
					
					if($("#hrepetir_data_parcelas").val()==1) {
						$('#repetir_data_parcelas').attr('checked', true);
					} else {
						$('#repetir_data_parcelas').attr('checked', false);
					}
				}
				
				ConfigDivsPedido();
				
				var url = dominio+diretorio()+"/oportunidades/VerificaComissao";
				
				CarregandoAntes();
				
				$.post(url,{vendedor:$("#codvendedor").val()},function(data) {
					var resp = data.split("|");
					
					CarregandoDurante();
					
					if(resp[1]==1) {
						$("#div_comissao").show();
					} else {
						$("#div_comissao").hide();	
					}
					$("#msg_loading").html(resp[2]);
				
					CarregandoDepois('',100);
					
					$('#modal_pedido').modal('show');
				});
			}

function ConfigRepetir()
{
	if($("#repetir_data_parcelas").is(":checked"))
	{
		$("#hrepetir_data_parcelas").val(1);
		
		//$('#repetir_data_parcelas').attr('checked', false);
	
	}
	else
	{
		$("#hrepetir_data_parcelas").val(0);
	
	}
	

}

function ConfigDivsPedido()
{

	if($("#pedido_acao").val()=="faturar")
	{
		$("#div_conta_parcela").show();
		
		$("#div_categoria_parcela").show();
		
		$("#div_conta_comissao").show();
		
		$("#div_categoria_comissao").show();
	
	}
	else
	{
		$("#div_conta_parcela").hide();
		
		$("#div_categoria_parcela").hide();
		
		$("#div_conta_comissao").hide();
		
		$("#div_categoria_comissao").hide();
	}

}


function ConfigPedido()
{
	
	$("#hdata_comissoes_pedido").val($("#data_comissoes").val());
	
	$("#hconta_comissoes_pedido").val($("#conta_comissoes").val());
	
	$("#hcategoria_comissoes_pedido").val($("#categoria_comissoes").val());
	
	$("#hdata_parcelas_pedido").val($("#data_parcelas").val());
	
	$("#hconta_parcelas_pedido").val($("#conta_parcelas").val());
	
	$("#hcategoria_parcelas_pedido").val($("#categoria_parcelas").val());
	
	//$("#hrepetir_data_parcelas").val($("#repetir_data_parcelas").val());
	
	if($("#repetir_data_parcelas").is(":checked"))
	{
		$("#hrepetir_data_parcelas").val(1);
		
		//$('#repetir_data_parcelas').attr('checked', false);
	
	}
	else
	{
		$("#hrepetir_data_parcelas").val(0);
	
	}
	
	$("#hpedido_acao").val($("#pedido_acao").val());
	
	$('#gerar_pedido').val(1);
	
	$('#form_opt').submit();


}

		function CriarInputsPedido() {
			var qtd = $('#qtd_parcelas').val();
			
			$('#div_datas').html('');
			
			if(qtd==0) {
				qtd=1;
			}
			
			for(var i=1;i<=qtd;i++) {
				var id = "data_"+i;
				var string = i+"/"+qtd+"&nbsp;&nbsp;";
				
				$('#div_datas').append('<br/>'+string);
				$('<input>').attr({ type: 'text', id: id, value:'',name:id}).addClass('datepicker span2').appendTo('#div_datas');
				$('#'+id).datepick();
				$('#div_datas').append('<br/>');
			}
			
			$('#data_1').val($('#data_parcelas').val());
		}

		function GravarParcelasPedido() {
			var qtd = $('#qtd_parcelas').val();
			
			$("#data_parcelas").val($("#data_1").val()); // Iguala a data personalizada e a padrao
			
			if(qtd==0) {
				qtd=1;
			}
			
			var url = dominio+diretorio()+"/oportunidades/GravarParcelasPedido";
			var string = "";
			var string2 = "";
			
			for(var i=1;i<=qtd;i++) {
				var id="#data_"+i;
				
				if($(id).val()!="") {	
					string+=$(id).val();
					if(qtd!=i) string+="&"
				}
				
				id = "#parcela_"+i;
				
				if($(id).val()!="") {	
					string2+=$(id).val();
					if(qtd!=i) string2+="&"
				}
			}
			
			CarregandoAntes();
			
			$.post(url,{datas_parcelas:string,valores_parcelas:string2},function(data) {
				var resp = data.split("|");
				
				CarregandoDurante();
				
				if(resp[0]==1) {
					$("#modal_parcelas").modal('hide');
				}
				
				$("#msg_loading").html(resp[1]);
				
				CarregandoDepois('',5000);
			});
		}


function CriarInputs(qtd)
{
	$('#div_parcelamento').html('');
	
	var total = $("#servico").val();
	
	if(total=="")
	{

		total = 0;
	}
	else
	{
		total = total.replace('.',"");

		total = parseFloat(total.replace(',',"."));

	}

	var periodo = $("#parcela_servico").val();
	
	if((periodo=="")||($("#tipo_parcela").val()=="fixo"))
	{
		periodo = 1;
	}
	else
	{
		periodo = periodo.replace('.',"");

		periodo = parseFloat(periodo.replace(',',"."));

	}

	var parcela_acumulada = 0;
	
	var parcela = (total*periodo)/qtd;
	
	parcela = moeda(parcela, 2, ",", "."); // Arredondamento monetario

	aux_parcela = parcela.replace('.',"");

	aux_parcela = parseFloat(aux_parcela.replace(',',".")); // valor arredondado, sem estar formatado

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
			
			$('#'+id).maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
			
			$('#'+id).val(parcela);
			
			$('#div_parcelamento').append('&nbsp;&nbsp;');
			
			$('#div_parcelamento').append('<br/>');
			
			parcela_acumulada=parcela_acumulada+aux_parcela;

		}
	
		if(parcela_acumulada<(total*periodo))
		{
			parcela = aux_parcela+((total*periodo)-parcela_acumulada);

			parcela = moeda(parcela, 2, ",", "."); // Arredondamento monetario

			$('#'+id).val(parcela);
		}
		if(parcela_acumulada>((total*periodo)*periodo))
		{

			parcela = aux_parcela-((total*periodo)-parcela_acumulada);

			parcela = moeda(parcela, 2, ",", "."); // Arredondamento monetario

			$('#'+id).val(parcela);
		}

		$("#parcela_1").focus();
		
		

	}
	else
	{
		$("#negociacao_vista").attr("checked",true);
		
		$("#qtd_parcelas").val('');
		
		$("#div_qtd_parcelas").hide();
	
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
		
		servico = servico.replace('.',"");
		
		servico = servico.replace(',',".");
		
		servico = parseFloat(servico);
		
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

	$("#strong_total").show();
	
	$("#strong_total").html(" = R$&nbsp;"+total);

	CriarInputs($('#qtd_parcelas').val());	
	
}

function numberFormat(n) 
{
	var parts=n.toString().split(".");
	return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (parts[1] ? "," + parts[1] : "");
}

function GravarPrivacidade()
{
	var url = dominio + diretorio() + "/oportunidades/GravarPrivacidade";

	var usuarios = new Array();
		$(".chk_users:checked").each(function() {
		   usuarios.push($(this).val());
	});

	usuarios = JSON.stringify(usuarios);

	CarregandoAntes();
	
	$.post(url, {oportunidade:$("#cod_opt").val(),usuarios:usuarios}, function (data) {
		
		resp = data.split("|");
		
		CarregandoDurante();
		
		$("#msg_privacidade").removeClass();
		
		if(resp[0]!=0)
		{
			$("#msg_privacidade").addClass('alert alert-success'); 
		}
		else
		{
			$("#msg_privacidade").addClass('alert alert-danger');
		}
		
		$("#msg_privacidade").html(resp[1]);
		
		CarregandoDepois('',1000);
	
	});
}
	</script>
	<article>
		<div class="grid_4">
			<div class="da-panel">
				<!-- Modais -->
				<div class="modal hide" id="modal_itens">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&#215;</button>
						<h2 class="pr_5 mr_0" style="display:inline;" id="nome_item">Adicionar Produto/Servi&ccedil;o</h2>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<form>
								<fieldset>
									<div class="control-group">
										<input type="hidden" name="id_item" id="id_item"  value="" />
										
										<div class="control-group">
											<label class="control-label">*Quantidade:</label>
											<div class="controls">
												<input style="width:50px;" type="text" name="qtd_item" id="qtd_item" class="input_menor" value="" />
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">*Valor:</label>
											<div class="controls">
												<input style="width:100px;" type="text" name="valor_item" id="valor_item" class="input_menor" value="" />
											</div>
										</div>
										<div class="control-group" id="div_qtd">
											<label class="control-label">% IPI</label>
											<label class="checkbox inline" id="ipi"></label>
										</div>
										<div class="control-group">
											<div class="controls al_rgt">
												<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
												<a class="btn btn-primary" onclick="AddItem();">Salvar</a>
											</div>
										</div>
									</div>	
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<div class="modal hide" id="modal_interacoes">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&#215;</button>
						<h2 class="pr_5 mr_0">Nova Atividade</h2>
					</div>
					<div class="modal-body" style="max-height:420px;">
						<div class="form-horizontal">
							<form>
								<fieldset>
									<div class="control-group">
										<label class="control-label">* Data:</label>
										<div class="controls">
											<input class="datepicker" type="text" maxlength="10" name="int_data" id="int_data" class="input_menor"  value="<?=date("d/m/Y")?>"/>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">* Hora:</label>
										<div class="controls">
											<input type="text" id="int_hora" name="int_hora" value="<?=date("H:i")?>"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Conta:</label>
										<div class="controls">
											<strong class="dsp_b pr_5" id="int_conta"></strong>	
											<input type="hidden" name="int_nomeconta" id="int_nomeconta" value=""/>
											<input type="hidden" name="int_codconta" id="int_codconta" value=""/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Contatos:</label>
										<div class="controls">
											<input class="input_full" id="int_contato" type="text" placeholder="Buscar"/>
											<strong class="dsp_b pr_5"></strong>	
											<div id="div_mae_contatos">	
												<div id="resposta_int_contatos" name="resposta_int_contatos"></div>
											</div>	
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">* Motivo - <strong>Venda</strong></label>
										<div class="controls">	
											<select name="int_motivo" id="int_motivo">
												<option value="">Selecione</option>
												<?php
													$sql = mysql_query("SELECT * FROM `motivo`");
													while($mot = mysql_fetch_array($sql)):
												?>
												<option value="<?=$mot[0]?>"><?=$mot[1]?></option>
												<?php endwhile; ?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">* Canal</label>
										<div class="controls">
											<select name="int_canal" id="int_canal">
												<option value="">Selecione</option>
												<?php
													$sql = mysql_query("SELECT * FROM `canal`");
													while($can = mysql_fetch_array($sql)):
												?>
											   <option value="<?=$can[0]?>"><?=$can[1]?></option>
											   <?php endwhile; ?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">* Tipo</label>
										<div class="controls">
											<div class="dsp_pr_5">
												<?php
													$sql = mysql_query("SELECT * FROM `tipo`");
													while($tip = mysql_fetch_array($sql)):
												?>
												<label class="radio inline">
													<input type="radio" name="int_tipo" value="<?=$tip[0]?>" id="int_tipo<?=$tip[0]?>"/> <?=$tip[1]?>
												</label>
												<?php endwhile; ?>
											</div>
										</div>
									</div>
									<div class="control-group">
										<div class="control-group">
											<label class="control-label"> * Descri&ccedil;&atilde;o:</label>
											<div class="controls">
												<textarea class="input_full" style="height: 50px;" name="int_obs" id="int_obs"></textarea>
											</div>
										</div>
										<div class="control-group">
											<div class="controls al_rgt">
												<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
												<a class="btn btn-primary" onclick="GravarInteracao();">Salvar</a>
											</div>
										</div>
									</div>	
								</fieldset>
							</form>
				
						</div>
					</div>
				</div>
				<div class="modal hide" id="modal_parcelas">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&#215;</button>
						<h2 class="pr_5 mr_0" style="display:inline;" id="nome_item">Informe as datas das parcelas</h2>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<form>
								<fieldset>
									<div class="control-group" id="div_datas"></div>
									<div class="control-group">
										<div class="controls al_rgt">
											<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
											<a class="btn btn-primary" onclick="GravarParcelasPedido();">Ok</a>
										</div>
									</div>					
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<div class="modal hide"  id="modal_pedido">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&#215;</button>
						<h2 class="pr_5 mr_0">Criar Pedido</h2>
					</div>
					<div class="modal-body" style="max-height:420px;">
						<div class="form-horizontal">
							<form>
								<fieldset>
									<div class="control-group">
										<label class="control-label">* A&ccedil;&atilde;o:</label>
										<div class="controls">
											<select name="pedido_acao" id="pedido_acao" onchange="ConfigDivsPedido();">
												<option value="gerar">Gerar Pedido</option>
												<option value="faturar">Faturar Pedido</option>
											</select>	
										</div>
									</div>
									<div class="padding well">	
										<h2>Parcelas</h2>
										<label class="control-label al_lft" style="width:50px;">Data:</label>
										<input style="width:100px;" class="datepicker" type="text" maxlength="10" name="data_parcelas" id="data_parcelas" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);"/>
										<div class="control-group" id="div_tipo_parcela"></div>
										<div class="control-group" id="div_conta_parcela" style="display:none;">
											<label id="txt_conta_lan"> Lan&ccedil;ar na conta:</label>
											<div>
												<select id="conta_parcelas" class="input_full" name="conta_parcelas">
													<option value="">Selecione</option>
												</select>
											</div>
										</div>
										<div class="control-group" id="div_categoria_parcela" style="display:none;">
											<label id="txt_conta_lan"> Categoria:</label>
											<div>
												<select id="categoria_parcelas" class="input_full" name="categoria_parcelas">
													<option value="">Selecione</option>
													<?php
														$sql = mysql_query("SELECT * FROM `categoria`");
														while($cat = mysql_fetch_array($sql)):
													?>
														<option value="<?=$cat[0]?>"><?=$cat[1]?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="padding well" id="div_comissao" style="display:none;">	
										<div class="control-group">
											<h2>Comiss&atilde;o</h2>
											<label class="control-label al_lft" style="width:50px;">Data:</label>
											<input style="width:80px;"  class="datepicker" type="text" maxlength="10" name="data_comissoes" id="data_comissoes" class="input_menor"  onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);"  />
										</div>
										<div class="control-group" id="div_conta_comissao" style="display:none;">
											<label id="txt_conta_lan"> Lan&ccedil;ar na conta:</label>
											<div>
												<select id="conta_comissoes" class="input_full" name="conta_comissoes">
													<option value="">Selecione</option>
												<?php
													$sql = mysql_query("SELECT `c`.`caixa_id` AS id, `c`.`caixa_nome` AS nome FROM `caixa` `c` JOIN `conta_corrente` `cc` ON `c`.`conta_corrente_id` = `cc`.`conta_corrente_id`");
													while($cont = mysql_fetch_array($sql)):
												?>
													<option value="<?=$cont[0]?>"><?=$cont[1]?></option>
												<?php endwhile; ?>
												</select>
											</div>
										</div>
										<div class="control-group" id="div_categoria_comissao" style="display:none;">
											<label id="txt_conta_lan"> Categoria:</label>
											<div>
												<select id="categoria_comissoes" class="input_full" name="categoria_comissoes">
													<option value="">Selecione</option>
													<?php
														$sql = mysql_query("SELECT * FROM `categoria`");
														while($cat = mysql_fetch_array($sql)):
													?>
													<option value="<?=$cat[0]?>"><?=$cat[1]?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="control-group">
										<div class="controls al_rgt">
											<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
											<a id="btn_gerar_pedido" onclick="ConfigPedido();" class="btn btn-success"><i class="icon-ok icon-white"></i> Salvar </a>
										</div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<!-- Header -->
				<div class="da-panel-header">
					<span class="da-panel-title">
						<span class="label label-inverse pr_5">
							<span class="label label-inverse pr_5">
								<i class="icon-briefcase icon-white"></i>
							</span>
						</span>
						<strong class="tt_uc">Oportunidades</strong>
					</span>
					<span class="da-panel-btn">
						<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/oportunidade" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova</a>
					</span>
				</div>
				<div class="da-panel-content">
					<div class="da-panel-padding">
						<div class="tabbable"> <!-- Only required for left/right tabs -->
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab1" data-toggle="tab">[Nova Oportunidade] Vers&atilde;o 1.0</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab1">
									<?php if(isset($oport) && $oport): ?>
									<div class="alert alert-success">Gravado com sucesso</div>
									<?php endif; ?>
									<form class="form-horizontal" action="http://<?=$_SERVER['HTTP_HOST']?>/home/oportunidades/valida/inserir" id="form_opt" method="post" enctype="multipart/form-data" name="form_opt">
										<fieldset>
											<input type="hidden" name="gerar_pedido" id="gerar_pedido" value="" />
                                            <input type="hidden" name="cod_opt" id="cod_opt" value=""/>
                                            <input type="hidden" name="cod_grupo" id="cod_grupo" value="f93b8bbbac89ea22bac0bf188ba49a61"/>
                                            <input type="hidden" name="cod_versao" id="cod_versao" value="1.0"/>
											
											<!-- campos pedido -->
											<input type="hidden" name="hpedido_acao" id="hpedido_acao" value="<?=$hpedido_acao?>" />
											<input type="hidden" name="hrepetir_data_parcelas" id="hrepetir_data_parcelas" value="<?=$hrepetir_data_parcelas?>" />
											<input type="hidden" name="hdata_comissoes_pedido" id="hdata_comissoes_pedido" value="<?=$hdata_comissoes_pedido?>" />
											<input type="hidden" name="hconta_comissoes_pedido" id="hconta_comissoes_pedido" value="<?=$hconta_comissoes_pedido?>" />
											<input type="hidden" name="hcategoria_comissoes_pedido" id="hcategoria_comissoes_pedido" value="<?=$hcategoria_comissoes_pedido?>" />
											<input type="hidden" name="hdata_parcelas_pedido" id="hdata_parcelas_pedido" value="<?=$hdata_parcelas_pedido?>" />
											<input type="hidden" name="hconta_parcelas_pedido" id="hconta_parcelas_pedido" value="<?=$hconta_parcelas_pedido?>" />
											<input type="hidden" name="hcategoria_parcelas_pedido" id="hcategoria_parcelas_pedido" value="<?=$hcategoria_parcelas_pedido?>" />
											<!-- end   -->
											<span class="badge flt_rgt">Cadastrado por: <?=$_COOKIE['nome']?>
                                                <input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=$_COOKIE['id']?>"/>
											</span>
											<div class="control-group">
												<label class="control-label">* Data:</label>
												<div class="controls">
													<input class="datepicker" type="text" maxlength="10" name="data" id="data" class="input_menor" value=""/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">* Oportunidade:</label>
												<div class="controls">
													<input type="text" name="nome" id="nome" class="input_full" value=""/>
												</div>
											</div>
											<div id="div_vendedor" class="control-group">
												<label class="control-label">Vendedor:</label>
												<div class="controls">
													<input class="input_full ui-autocomplete-input" type="text" id="vendedor" name="vendedor" placeholder="Buscar" value="" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
													<input type="hidden" name="codvendedor" id="codvendedor" value=""/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Descri&ccedil;&atilde;o:</label>
												<div class="controls">
													<textarea class="input_full" name="descricao" id="descricao"></textarea>
												</div>
											</div>
											<div>  
												<label class="control-label">Produtos e Servi&ccedil;os:&nbsp;
													<i title="Agora voc&ecirc; pode adicionar produtos e servi&ccedil;os &agrave; suas oportunidades, basta digitar o nome do produto ou servi&ccedil;o que o sistema encontr&aacute;-lo. Ap&oacute;s isso, clique no bot&atilde;o +" id="tip_itens" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
												</label>
												<div class="form-inline al_ctr">
													<label class="btn-group">
														<input type="text" id="item_venda" class="input-medium search-query ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
													</label>
													<input type="hidden" id="cod_item"/>
													<input type="hidden" id="tipo_item"/>
													<a title="Adicionar" class="btn btn-inverse" data-toggle="modal" onclick="FormItens();"><i class="icon-plus icon-white"></i></a>
												</div>
												<br/>
												<div class="control-group">
													<div class="controls well" align="center" id="resp_itens"></div>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Valor negociado:</label>
												<div class="controls  ">
													<input type="text" placeholder="R$" class="span1" size="8px"  name="servico" id="servico" value="" onblur="CalculaTotal();CriarInputs($('#qtd_parcelas').val());"/>
													<select class="span2" name="tipo_parcela" onchange="ShowParcela(this.value);CalculaTotal();CriarInputs($('#qtd_parcelas').val())" id="tipo_parcela">
													<?php
														$tp_parc = mysql_query("SELECT * FROM `tipo_parcela`");
														while($parc = mysql_fetch_array($tp_parc)): 
													?>
															<option value="<?=$parc[1]?>"><?=$parc[2]?></option>
													<?php endwhile; ?>
													</select>
													<span id="div_parcelas" style='display:none;'>
														<b class="">Durante</b>
														<input class="span1" type="text" name="parcela_servico" id="parcela_servico"  value="1" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);"  onblur="CalculaTotal();CriarInputs($('#qtd_parcelas').val())"/>
														<span id="tipo_parcelas" style='display:none;'>
															<strong></strong>
														</span>
														<strong id='strong_total' style='display:none;'></strong>
													</span>
												</div>
											</div>
											<div>  
												<label class="control-label">Negocia&ccedil;&atilde;o:&nbsp;</label>
												<div class="control-group">
													<div class="controls well" id="div_negociacao">
														<label class="radio inline">
															<input type="radio" name="negociacao" value="vista" id="negociacao_vista" onclick="CheckNegociacao(this.value);"/>&Agrave; vista
														</label>
														<br/>
														<label class="radio inline">
															<input type="radio" name="negociacao" value="parcelada" id="negociacao_parcelada" onclick="CheckNegociacao(this.value);" />Parcelada em
														</label>
														<label class="radio inline" id="div_qtd_parcelas" style='display:none;'>
															<input type="text" value="" id="qtd_parcelas" name="qtd_parcelas" size="8px" class="span1" placeholder="X" align="center" onblur="CriarInputs(this.value);"/>&nbsp;&nbsp;Vezes
														</label>
														<div id="div_parcelamento"></div>
													</div>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">* Quem est&aacute; em prospec&ccedil;&atilde;o ?</label>
												<div class="controls">
													<div class="pr_5">
														<label class="radio inline">
															<input type="radio" onclick="ConfigProspect(this.value);" name="prospect" value="conta" id="prospect_conta"/>Conta
														</label>
														<label class="radio inline">
															<input type="radio" onclick="ConfigProspect(this.value);" name="prospect" value="contato" id="prospect_contato"/>Contato
														</label>
														&nbsp;
														<i title="Marque aqui para quem voc&ecirc; est&aacute; vendendo. Para uma pessoa f&iacute;sica escolha 'Contato', Para uma pessoa jur&iacute;dica escolha 'Conta'" id="tip_prospect" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
													</div>
												</div>
											</div>
											<div id="div_conta" style='display:none;'  class="control-group">
												<label class="control-label">Conta:</label>
												<div class="controls">
													<input class="input_full" type="text" id="conta" placeholder="Buscar" value=""/>
													<input type="hidden" name="nomeconta" id="nomeconta" value=""/>
													<input type="hidden" name="codconta" id="codconta" value=""/>
												</div>
											</div>
											<div id="div_contato"  style='display:none;' class="control-group">
												<label class="control-label">Contato:</label>
												<div class="controls">
													<input class="input_full" type="text" id="contato" placeholder="Buscar" value=""/>
													<input type="hidden" name="nomecontato" id="nomecontato" value=""/>
													<input type="hidden" name="codcontato" id="codcontato" value=""/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">* Fechamento prov&aacute;vel:</label>
												<div class="controls">
													<input type="text" class="span2 datepicker" placeholder="" maxlength="10" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" name="fechamento" id="fechamento" class="input_menor" value=""/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Situa&ccedil;&atilde;o:</label>
												<div class="controls">
													<div class="btn-group flt_lft">
														<label onclick="Situacao(this.id);" id="andamento" class='btn dropdown-toggle' href="#">Andamento</label>
													</div>
													<div class="btn-group flt_lft">
														<label onclick="Situacao(this.id);" id="ganhamos" class='btn dropdown-toggle' href="#">Ganhamos</label>
													</div>
													<div class="btn-group flt_lft">
														<label onclick="Situacao(this.id);" id="perdemos" class='btn dropdown-toggle' href="#">Perdemos</label>
													</div>&nbsp;
													<i title="Quando criar ou versionar uma oportunidade, a situa&ccedil;&atilde;o da Conta ou Contato mudar&aacute; de status automaticamente seguindo este modelo:  Em Andamento muda para - Em Prospec&ccedil&atilde;o. Ganhamos muda para - Cliente. Perdemos muda para - Suspeito"  id="tip_status" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
													<input type="hidden" id="situacao" name="situacao" value=""/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Chance de sucesso:</label>
												<div class="controls">
													<input class="alinhaDireita" type="text" size="2px" maxlength="100" name="chance" id="chance" class="input_menor" onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" value=""/>&nbsp;<b>%</b>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Concorrente:</label>
												<div class="controls">
													<input class="input_full" type="text" id="concorrente" placeholder="Buscar" value=""/>
													<input type="hidden" name="nomecon" id="nomecon" value=""/>
													<input type="hidden" name="codcon" id="codcon" value=""/>
													<input type="hidden" name="tipocon" id="tipocon" value=""/>
												</div>
											</div>
											<div class="form-actions al_rgt">
												<a href="JavaScript: window.history.back(-1);" class="btn btn-inverse"><i class="icon-remove icon-white"></i> Cancelar  </a>
												<a  href="#da-header-toolbar" class="btn btn-primary" onclick="ConfigFormPedido();"> <i class="icon-list-alt icon-white"></i> Criar Pedido </a>
												<button  class="btn btn-success"><i class="icon-ok icon-white"></i> Salvar </button>
											</div>
										</fieldset>
									</form>
								</div>
								<div class="tab-pane fade in" id="tab2">
									<div class="accordion" id="versoes_anteriores">
									</div>
								</div>
								<div class="tab-pane fade in" id="tab3">
									<div class="da-panel-header">
										<span class="da-panel-title">
											<span class="label label-inverse pr_5"><i><img
													src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/16/users.png"/></i></span>
											<strong class="tt_uc ws_nw al_ctr">Atividades</strong>
										</span>
										<span class="da-panel-btn">
											<a class="btn btn-inverse" data-toggle="modal" href="#modal_interacoes"><i class="icon-plus icon-white"></i> Nova</a>
										</span>
									</div>
									<div class="da-padding">
										<div class="accordion" id="historico_interacoes"> </div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="abativa" id="abativa" value=""/>
				</div>
			</div>
		</div>
	</article>
	<script>
		$('#fbusca_contas').keydown(function (e) {
			if (e.keyCode == 13) {
				busca_contas(auxdiv);
				return false;
			}
		});
		$('#fbusca_contatos').keydown(function (e) {
			if (e.keyCode == 13) {
				busca_contatos_contas();
				return false;
			}
		});
	</script>
</div>