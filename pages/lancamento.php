<?php
    $sem = date("w");
    $inicio = "";
    $fim = "";

    $mounths = array(1 => "janeiro", 2 => "fevereiro", 3 => "mar&ccedil;o", 4 => "abril", 5 => "maio", 6 => "junho", 7 => "julho", 8 => "agosto", 9 => "setembro", 10 => "outubro", 11 => "novembro", 12 => "dezembro");

    $mes = $mounths[date("n")];

    if($sem == 0 || $sem == 6) {
        if($sem == 0) {
            $inicio = date("d/m/Y");
            $fim = date("d/m/Y", strtotime("+6 days"));
        } else {
            $inicio = date("d/m/Y", strtotime("-6 days"));
            $fim = date("d/m/Y");
        }
    } else {
        $fi = 6 - $sem;
        $inicio = date("d/m/Y", strtotime("-$sem days"));
        $fim = date("d/m/Y", strtotime("+$fi days"));
    }
?>
<div id="da-content-area">
    <script>
        $(document).ready(function () {
        	ListarReceitas();
        	ListarDespesas();
        	ListarLancamentos();
        	
        	$("#valor_lan").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
        	$("#valor_centro_lan").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
        	$("#valor_tf").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
        	$("#baixa_valor").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
        	
        	$(function() {
	            $('.accordion').on('show', function (e) {
	                 $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
	            });
	        
	            $('.accordion').on('hide', function (e) {
	                $(this).find('.accordion-toggle').not($(e.target)).removeClass('active');
	            });
        	});
        });
        
        function Completar()
        {
        	$(function () {
        		$('#entidade_lan').each(function () {
        			var autoCompelteElement = this;
        			var url = dominio + diretorio() + "/lancamentos/AutoCompleteContaContato/"+$("#tipo_lan").val()+"?callback=?";
        			
        			$(this).autocomplete({source:url, select:function (event, ui) {
        				if((ui.item.id=="novo_contato")||(ui.item.id=="nova_conta"))
        				{
        					GravaEntidade(ui.item.id);
        				}
        				
        				$(autoCompelteElement).val(ui.item.value);
        
        				var con = ui.item.value,
        						div = $("<div id='txt_entidade_lancamento'>").addClass("pr_5"),
        						div2 = $("<div>").text(con),
        						a = $("<label>").addClass("close flt_lft").attr({
        							title:"Remover " + con
        						}).text(" x ");
        				a.click(function () {
        					div2.html('');
        					$("#codent").val('');
        					$("#entidade_lan").val('');
        					$("#tipoent").val('');
        					$("#entidade_lan").show();
        				});
        				a.appendTo(div2),
        				div2.appendTo(div),
        				div.insertAfter("#entidade_lan");
        				$("#entidade_lan").hide();
        				$("#codent").val(ui.item.id);
        				var tipo = ui.item.label.split("-");
        				
        				var entidade = false;
        				
        				for(i=0;i<tipo.length;i++)
        				{
        					if(($.trim(tipo[i])=="conta")||($.trim(tipo[i])=="contato"))
        					{
        						entidade = tipo[i];
        						break;
        					}
        				}
        				tipo = $.trim(entidade);
        				$("#tipoent").val(tipo);
        			}});
        		});
        	});	
        }
        
        function GravaEntidade(tipo)
        {
        	var url = dominio + diretorio();
        	var nome = $("#entidade_lan").val();
        	
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
        	
        	CarregandoAntes();
        	
        	$.post(url,{nome:nome},function (data) 
        	{
                CarregandoDurante();
        		
        		var resp = data.split("|")
        		
        		if(resp[0]==1)
        		{
        			$("#msg_loading").html(resp[1]);
        			$("#codent").val(resp[2]);
        			$("#tipoent").val(tipo);
        			
        			CarregandoDepois('',10000);	
        		}
        		else
        		{
        			CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
        		}
        	});
        }
        
        function FormLan(tipo,id,fatura)
        {
        	$("#tipo_lan").val(tipo);
        	
        	var url = dominio + diretorio() + "/lancamentos/Zerar";
        
        	CarregandoAntes();
            
        	$("#repetir_lan").children().filter(function(index, option) {
        		return option.value==="variavel";
        	}).remove();
        	
        	$.post(url,function (data) 
        	{
                CarregandoDurante();
        		
        		var resp = data.split("|")
        		
        		if(resp[0]==1)
        		{
        			if(tipo=='receita')
        			{
        				$("#txt_tipo_lancamento").html('Nova Receita');
        				$("#txt_status_lan").html('Recebida');
        				$("#txt_fonte_lan").html('Cliente:');
        				$("#txt_conta_lan").html('*Destino:');
        				$("#categorias").html($("#cat_receitas").html());
        			}
        
        			if(tipo=='despesa')
        			{
        				$("#txt_tipo_lancamento").html('Nova Despesa');
        				$("#txt_status_lan").html('Paga');
        				$("#txt_fonte_lan").html('Fornecedor/Colaborador:');
        				$("#txt_conta_lan").html('*Origem:');
        				$("#categorias").html($("#cat_despesas").html());
        			}
        			
        			if(resp[1]!="")
        			{
        				$("#msg_loading").html(resp[1]);
        				
        				CarregandoDepois('',10000);
        			}
        			else
        			{
        				CarregandoDepois('',1000);
        			}
        			
        			Completar();
        			
        			if(id=="")
        			{	
        				VerificaCartao();
        			}
        			
        			if(fatura=='fatura')
        			{
        				$("#div_pgto").hide();
        				$("#div_conta_lan").hide();
        				$("#div_forma_lan").hide();
        				$("#label_status_lan").hide();
        			}
        			else
        			{
        				$("#div_conta_lan").show();
        				$("#label_status_lan").show();
        				$("#div_forma_lan").show();
        			}
        			
        			$("#div_obs_boleto_lan").hide();
        			$("#vencimento_original").hide();
        			$("#ico_vctooriginal").hide();
        			$("#ico_vctooriginal").attr("title","");
        			$(".valor_categoria").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
        			$("#categorias .resp_categorias").html('');
        			$("#categorias .categoria").val('');
        			$("#categorias .tipo_categoria").val('');
        			$("#categorias .valor_categoria").val('');
        			$("input:radio[name='lancamento_repeticao']").attr("checked",false);
        			
        			if(id!="")
        			{
        				EditarLan(id,fatura);
        			}
        		}
        		else
        		{
        			CarregandoDepois('Ocorreu um erro no servidor, por favor atualize',3000);
        		}
        	});
        }
        
        function LimparLan()
        {
        	$("#id_lan").val('');
        	$("#usuario_lancamento").attr("title","Cadastrado por Carlos Oliveira");
        	$("#desc_lan").val('');
        	$("#valor_lan").val('');
        	$("#vencimento_lan").val('');
        	$("#recebimento_lan").val('');
        	$("#categorias select").val('');
        	$('#destino_lan').val('');
        	$("#codent").val('');
        	$("#entidade_lan").val('');
        	$("#tipoent").val('');
        	$("#entidade_lan").show('');
        	$('#txt_entidade_lancamento').remove();
        	$("#doc_lan").val('');
        	$("#numdoc_lan").val('')
        	$("#pagamento_lan").val('');
        	$("#categorias").html('');
        	$("#repetir_lan").val('');
           	$("#resp_centros").html('');
        	$("#resp_conta").html('');
        	$("#centro_lan").val('');
        	$("#tipo_centro_lan").val('');
        	$("#valor_centro_lan").val('');
        	$("#resp_forma").html('');
        	
        	document.getElementById("status_lan").checked = false;
        	document.getElementById("div_pgto").style.display = "none";
        	document.getElementById("div_repete").style.display = "none";
        	document.getElementById('repetir_lan').disabled = false;	
        	document.getElementById('qtd_lan').disabled = false;	
        	
        	$("#qtd_lan").val('');
        	$("#obs_lan").val('');
        	$("input:radio[name='lancamento_repeticao']").attr("checked",false);
        	$("#grupo_lan").val('');
        	
        	Completar();
        }
        	
        function AcaoLan()
        {
        	if($("#grupo_lan").val()!="")
        	{
        		if(VerificaLan())
        		{
        			$("#modal_lan").modal('hide');
        			$("#modal_repetir").modal('show');
        			$('#btn_repetir').unbind('click');
        			
        			$("#btn_repetir").click(function() {
        				GravarLan();
        			});
        		}
        		else
        		{
        			$("#op_1").attr("checked",true);
        			
        			GravarLan();
        		}
        	}	
        	else
        	{
        		GravarLan();
        	}
        }
        
        function VerificaLan()
        {
        	if($("#vf_desc_lan").val()!=$("#desc_lan").val()) return true;
        	
        	if($("#vf_valor_lan").val()!=$("#valor_lan").val()) return true;
        	
        	if($("#vf_vencimento_lan").val()!=$("#vencimento_lan").val()) return true;
        	
        	if($("#vf_categoria_lan").val()!=$("#categorias select").val()) return true;
        	
        	if($("#vf_destino_lan").val()!=$("#destino_lan").val()) return true;
        	
        	if($("#vf_entidade_lan").val()!=$("#entidade_lan").val()) return true;
        	
        	if($("#vf_doc_lan").val()!=$("#doc_lan").val()) return true;
        	
        	if($("#vf_numdoc_lan").val()!=$("#numdoc_lan").val()) return true;
        	
        	if($("#vf_pagamento_lan").val()!=$("#pagamento_lan").val()) return true;
        	
        	if($("#vf_obs_lan").val()!=$("#obs_lan").val()) return true;
        	
        	if($("#vf_obsboleto_lan").val()!=$("#obs_boleto_lan").val()) return true;
        	
        	return false;
        }
        
        function AcaoDeletarLan(grupo,id,boleto,tipo)
        {
        	$("input:radio[name='lancamento_repeticao']").attr("checked",false);
        	
        	if(grupo!="")
        	{
        		$("#modal_repetir").modal('show');
        		$('#btn_repetir').unbind('click');
        		
        		$("#btn_repetir").click(function() {
        			DelLanGrupo(grupo,id,tipo)
        		});
        	}
        	else
        	{
        		DelLan(id,boleto,tipo);
        	}
        }
        	
        function GravarLan()
        {
        	
        	var url = dominio + diretorio() + "/lancamentos/GravarLancamento";
        	var recebida = 0;
        	var flag_taxa = 0;
        	
        	CarregandoAntes();
        	
        	if(($("#pagamento_lan").val()==2)&&($("#cartoes_lan").val()=="")&&($("#tipo_lan").val()==2))
        	{
        		$("#msg_loading").html('Por favor, selecione o cart&atilde;o de cr&eacute;dito');
        	
        		return false;
        	}
        	
        	if(($("#vf_valor_lan").val()!=$("#valor_lan").val())&&($("#pagamento_lan").val()==1)&&($("#tipo_lan").val()=="receita"))
        	{
        		$("#msg_loading").html('O valor da taxa banc&aacute;ria ser&aacute; somado ao valor do lan&ccedil;amento');
        	
        		flag_taxa = 1;
        	}
        	
        	if($("#status_lan").is(':checked'))
        	{
        		recebida = 1;
        	}
        	
        	$.post(url, {id:$("#id_lan").val(),tipo:$("#tipo_lan").val(),desc:$("#desc_lan").val(),valor:$("#valor_lan").val(),vencimento:$("#vencimento_lan").val(),recebida:recebida,recebimento:$("#recebimento_lan").val(),categoria:$("#categorias .categoria").val(),conta:$('#destino_lan').val(),entidade:$('#codent').val(),tipo_entidade:$('#tipoent').val(),doc:$("#doc_lan").val(),numdoc:$("#numdoc_lan").val(),forma_pagamento:$("#pagamento_lan").val(),repetir:$("#repetir_lan").val(),qtd:$("#qtd_lan").val(),obs:$("#obs_lan").val(),centro:$("#centro_lan").val(),tipo_centro:$("#tipo_centro_lan").val(),valor_centro:$("#valor_centro_lan").val(),grupo:$("#grupo_lan").val(),controle_repeticao:$("input:radio[name='lancamento_repeticao']:checked").val(),flag_taxa:flag_taxa,obs_boleto_lan:$("#obs_boleto_lan").val(),cartao_lan:$("#cartoes_lan").val(),fatura:$("#fatura_id").val()}, function (data) {
        		
        		resp = data.split("|");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			$("#modal_lan").modal('hide');
        			$('#seta').val('');
        			$("#usuario_lancamento").attr("title","Cadastrado por Carlos Oliveira");
        			
        			LimparLan();
        			ListarLancamentos();
        				
        			ListarLancamentosFatura($("#fatura_id").val(),'');
        			
        			ListarReceitas();
        			ListarDespesas();
        			
        			if(resp[3]!=0)
        			{	
        				Boleto($.trim(resp[3]));
        			}
        			
        			$("#modal_repetir").modal('hide');
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',7000);
        	});
        }
        
        function FormBaixaLan(id,tipo_lan)
        {
        	var url = dominio + diretorio() + "/lancamentos/EditarLancamento";
        	
        	$.post(url, {lan:id,tipo_lan:tipo_lan,tipo_lan:tipo_lan}, function (data) {
        		resp = data.split("~");
        		
        		if(resp[0]!=0)
        		{
        			$("#tipo_lan_baixa").val(tipo_lan);
        			$("#baixa_lan_id").val($.trim(resp[0]));
        			$("#baixa_titulo_lan").html("Baixa: "+$.trim(resp[2]));
        			$("#baixa_valor").val($.trim(resp[3]));
        			$("#baixa_conta").val(resp[8]);	
        			$("#baixa_doc").val(resp[12]);
        			$("#baixa_numdoc").val(resp[13]);
        			$("#baixa_formapagamento").val(resp[14]);
        			$("#baixa_data").val('20/01/2014');
        		}
        		else
        		{
        			$("#modal_baixa").modal('hide');
        		}
        	});
        }
        
        function BaixaLan(id)
        {
        	var url = dominio + diretorio() + "/lancamentos/BaixaLancamento";
        		
        	CarregandoAntes();
        	
        	$.post(url, {id:id,valor:$("#baixa_valor").val(),data:$("#baixa_data").val(),conta:$("#baixa_conta").val(),doc:$("#baixa_doc").val(),num:$("#baixa_numdoc").val(),forma:$("#baixa_formapagamento").val(),tipo_lan:$("#tipo_lan_baixa").val()}, function (data) {
        		
        		resp = data.split("|");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			$("#baixa_lan_id").val('');
        			$("#baixa_titulo_lan").html('');
        			$("#baixa_valor").val('');
        			$("#baixa_conta").val('');	
        			$("#baixa_doc").val('');
        			$("#baixa_numdoc").val('');
        			$("#baixa_formapagamento").val('');
        			$("#baixa_data").val('20/01/2014');
        			$("#modal_baixa").modal('hide');
        			$('#seta').val('');
        			
        			ListarLancamentos();
        			ListarReceitas();
        			ListarDespesas();
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',7000);
        	});
        }
        
        function EditarLan(id,tipo_lan)
        {
        	
        	var url = dominio + diretorio() + "/lancamentos/EditarLancamento";
        	
        	$.post(url, {lan:id,tipo_lan:tipo_lan,fatura:$("#fatura_id").val()}, function (data) {
        		
        		resp = data.split("~");
        		
        		if(resp[0]!=0)
        		{
        			$("#id_lan").val($.trim(resp[0]));
        			$("#tipo_lan").val($.trim(resp[1]));
        			$("#txt_tipo_lancamento").html(resp[2]);	
        			$("#desc_lan").val(resp[2]);
        			$("#valor_lan").val(resp[3]);
        			$("#vencimento_lan").val(resp[4]);
        			
        			if($.trim(resp[5])==1)
        			{
        				document.getElementById("status_lan").checked = true;
        				
        				if(tipo_lan!="fatura")
        				{		
        					document.getElementById('div_pgto').style.display = "inline";
        				}	
        			}
        			else
        			{
        				document.getElementById("status_lan").checked = false;
        				
        				document.getElementById('div_pgto').style.display = "none";
        			}
        			
        			$("#recebimento_lan").val(resp[6]);
        			$("#categorias select").val(resp[7]);
        			$('#destino_lan').val(resp[8]);
        			$("#codent").val($.trim(resp[9]));
        			$("#tipoent").val(resp[10]);
        			$("#entidade_lan").val($.trim(resp[11]));
        			$("#entidade_lan").show();
        			$("#doc_lan").val(resp[12]);
        			$("#numdoc_lan").val(resp[13])
        			$("#pagamento_lan").val(resp[14]);
        			
        			if(resp[15]!="")
        			{	
        				$('#repetir_lan').append('<option value="variavel">Sim</option>');
        				
        				document.getElementById('repetir_lan').disabled = true;	
        				document.getElementById('div_repete').style.display = 'inline';
        				document.getElementById('qtd_lan').disabled = true;	
        			}
        			else
        			{
        				$("#repetir_lan").children().filter(function(index, option) {
        					return option.value==="variavel";
        				}).remove();
        				
        				document.getElementById('repetir_lan').disabled = false;	
        				document.getElementById('qtd_lan').disabled = false;	
        			}	
        			
        			$("#repetir_lan").val(resp[15]);
        			$("#qtd_lan").val(resp[16]);
        			$("#obs_lan").val(resp[17]);
    
        			$("#usuario_lancamento").attr("title","Cadastrado por "+resp[18]);
        		
        			$("#grupo_lan").val(resp[19]);
        			
        			if((resp[4]!=resp[20])&&(resp[20]!="")&&(resp[20]!="00/00/0000"))
        			{	
        				$("#ico_vctooriginal").show();
        				$("#ico_vctooriginal").attr("title",resp[20]);
        			}
        			
        			$("#obs_boleto_lan").val(resp[21]);
        			
        			ListarCentros();
        			VerificaLimite();
        			AvisoBoleto();
        			VerificaCartao();
        			
        			$("#vf_id_lan").val($("#id_lan").val());
        			$("#vf_desc_lan").val($("#desc_lan").val());
        			$("#vf_valor_lan").val($("#valor_lan").val());
        			$("#vf_vencimento_lan").val($("#vencimento_lan").val());
        			$("#vf_status_lan").val($("#id_lan").val());
        			$("#vf_recebimento_lan").val($("#vencimento_lan").val());
        			$("#vf_categoria_lan").val(resp[7]);
        			$("#vf_destino_lan").val($("#destino_lan").val());
        			$("#vf_entidade_lan").val($("#entidade_lan").val());
        			$("#vf_doc_lan").val($("#doc_lan").val());
        			$("#vf_numdoc_lan").val($("#numdoc_lan").val());
        			$("#vf_pagamento_lan").val($("#pagamento_lan").val());
        			$("#vf_obs_lan").val($("#obs_lan").val());
        			$("#vf_obs_boleto_lan").val($("#obs_boleto_lan").val());
        		}
        		else
        		{
        			$("#modal_lan").modal('hide');
        		}
        	});
        }

        function DelLan(id,boleto,tipo)
        {
        	var msg="";
        	
        	if(boleto)
        	{
        		msg = " SE O BOLETO FOI ENVIADO AO CLIENTE ELE N\u00C3O SER\u00C1 MAIS VISUALIZADO PELO MESMO";
        	}
        	
        	if(confirm("Tem certeza que deseja excluir ?"+msg))
        	{	
        		var url = dominio + diretorio() + "/lancamentos/DelLan";
        		
        		CarregandoAntes();
        		
        		$.post(url, {lan:id,tipo:tipo,fatura:$("#fatura_id").val()}, function (data) {
        			resp = data.split("|");
        			
        			CarregandoDurante();
        			
        			if(resp[0]==1)
        			{
        				$("#seta").val('');
        				
        				ListarLancamentos();
        				ListarReceitas();
        				ListarDespesas();
        				
        				if(tipo=="fatura")
        				{
        					ListarLancamentosFatura($("#fatura_id").val(),'');
        				}
        			}
        			
        			$("#msg_loading").html(resp[1]);
        			
        			CarregandoDepois('',3000);
        		});
        	}
        }
        
        function DelLanGrupo(grupo,id,tipo)
        {
        	var url = dominio + diretorio() + "/lancamentos/DelLanGrupo";
        		
        	CarregandoAntes();
        		
        	$.post(url, {grupo:grupo,controle_repeticao:$("input:radio[name='lancamento_repeticao']:checked").val(),id:id,tipo:tipo,fatura:$("#fatura_id").val()}, function (data) {
        		resp = data.split("|");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			$("#seta").val('');
        			
        			ListarLancamentos();
        			ListarReceitas();
        			ListarDespesas();
        			
        			if(tipo=="fatura")
        			{
        				ListarLancamentosFatura($("#fatura_id").val(),'');
        			}
        			
        			$("#modal_repetir").modal('hide');
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',6000);
        	});
        }
        
        function FiltrarGeral()
        {
        	$("#lan_valor_periodo").val('-');
        	$("#lan_dia").removeClass('btn-primary');
        	$("#lan_semana").removeClass('btn-primary');
        	$("#lan_mes").removeClass('btn-primary');
        	$("#lan_ano").removeClass('btn-primary');
        	$("#lan_previsto").removeClass('btn-primary');
        	$("#lan_atrasado").removeClass('btn-danger');
        	$("#lan_realizado").removeClass('btn-warning');
        	$("#receitas_valor_periodo").val('-');
        	$("#receitas_dia").removeClass('btn-primary');
        	$("#receitas_semana").removeClass('btn-primary');
        	$("#receitas_mes").removeClass('btn-primary');
        	$("#receitas_ano").removeClass('btn-primary');
        	$("#receitas_previsto").removeClass('btn-primary');
        	$("#receitas_atrasado").removeClass('btn-danger');
        	$("#receitas_realizado").removeClass('btn-warning');
        	$("#despesas_valor_periodo").val('-');
        	$("#despesas_dia").removeClass('btn-primary');
        	$("#despesas_semana").removeClass('btn-primary');
        	$("#despesas_mes").removeClass('btn-primary');
        	$("#despesas_ano").removeClass('btn-primary');
        	$("#despesas_previsto").removeClass('btn-primary');
        	$("#despesas_atrasado").removeClass('btn-danger');
        	$("#despesas_realizado").removeClass('btn-warning');
        	$("#status").val('');
        	
        	if($("#aba").val()=="lancamentos")
        	{
        		ListarLancamentos();
        	}
        	if($("#aba").val()=="receitas")
        	{
        		ListarReceitas();
        	}
        	
        	if($("#aba").val()=="despesas")
        	{
        		ListarDespesas();
        	}
        }
        
        function ListarLancamentos(tipo) {
        
        	var url = dominio + diretorio() + "/lancamentos/BuscarLancamentos";
        
        	CarregandoAntes();
        
        	$.post(url, {status:$("#status").val(),tipo_periodo:$("#periodo_lan").val(),valor_periodo:$("#lan_valor_periodo").val(),seta:$("#seta").val(),entidade:$("#entidade_filtro").val(),categoria_filtro:$("#categoria_filtro").val(),conta_filtro:$("#conta_filtro").val(),centro_custo:$("#centros_filtro").val(),nosso_numero:$("#nn_filtro").val()}, function (data) {
        		var resp = data.split("~");
        		
        		$("#lan_valor_periodo").val($.trim(resp[0]));
        		$("#resp_lan").html(resp[1]);
        
        		CarregandoDepois('',1000);
        	});
        }
        
        function ListarReceitas()
        {
        
        	var url = dominio + diretorio() + "/lancamentos/BuscarLancamentos/Receitas";
        
        	CarregandoAntes();
        
        	$.post(url, {status:$("#status").val(),tipo_periodo:$("#periodo_receitas").val(),valor_periodo:$("#receitas_valor_periodo").val(),seta:$("#seta").val(),entidade:$("#entidade_filtro").val(),categoria_filtro:$("#categoria_filtro").val(),conta_filtro:$("#conta_filtro").val(),centro_custo:$("#centros_filtro").val(),nosso_numero:$("#nn_filtro").val()}, function (data) {
        		var resp = data.split("~");
        		
        		$("#receitas_valor_periodo").val($.trim(resp[0]));
        		$("#resp_receita").html(resp[1]);
        		
        		CarregandoDepois('',1000);
        	});
        }
        
        function ListarDespesas()
        {
        	var url = dominio + diretorio() + "/lancamentos/BuscarLancamentos/Despesas";
        	
        	CarregandoAntes();
        
        	$.post(url, {status:$("#status").val(),tipo_periodo:$("#periodo_despesas").val(),valor_periodo:$("#despesas_valor_periodo").val(),seta:$("#seta").val(),entidade:$("#entidade_filtro").val(),categoria_filtro:$("#categoria_filtro").val(),conta_filtro:$("#conta_filtro").val(),centro_custo:$("#centros_filtro").val(),nosso_numero:$("#nn_filtro").val()}, function (data) {
        		var resp = data.split("~");
        		
        		$("#despesas_valor_periodo").val($.trim(resp[0]));
        		$("#resp_despesa").html(resp[1]);
        
        		CarregandoDepois('',1000);
        	});
        }
        
        function ListarLancamentosFatura(fatura,string)
        {
        	var url = dominio + diretorio() + "/lancamentos/BuscarLancamentosFatura";
        
        	$("#fatura_id").val(fatura);
        	
        	if(string!='')
        	{	
        		$("#txt_nome_fatura").html(string);
        	}
        	
        	CarregandoAntes();
        
        	$.post(url, {fatura:fatura}, function (data) {
        		$("#resp_lan_fatura").html(data);
        
        		CarregandoDepois('',1000);
        	});
        }
        
        function GravarTf()
        {
        	var url = dominio + diretorio() + "/lancamentos/GravarTf";
        	
        	CarregandoAntes();
        
        	$.post(url, {id:$("#id_tf").val(),desc:$("#desc_tf").val(),origem:$("#origem_tf").val(),destino:$("#destino_tf").val(),valor:$("#valor_tf").val(),data:$("#data_tf").val(),entidade:$("#entidade").val()}, function (data) {
        		resp = data.split("|");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			$("#modal_transferencia").modal('hide');
        			
        			LimparTf();
        			
        			$("#seta").val('');
        			
        			ListarLancamentos();
        			ListarReceitas();
        			ListarDespesas();
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',7000);
        	});
        }
        
        function EditarTf(id)
        {
        	var url = dominio + diretorio() + "/lancamentos/EditarTf";
        	
        	$.post(url, {id:id}, function (data) {
        		resp = data.split("~");
        		
        		if(resp[0]!=0)
        		{
        			$("#id_tf").val(resp[1]);
        			$("#desc_tf").val(resp[2]);
        			$("#data_tf").val(resp[3]);
        			$("#origem_tf").val(resp[4]);
        			$("#destino_tf").val(resp[5]);
        			$("#valor_tf").val(resp[6]);
        			$("#usuario_transferencia").attr("title","Cadastrado por "+resp[7]);
        		}
        	});
        }
        
        function DelTf(id)
        {
        	if(confirm("Tem certeza que deseja excluir ?"))
        	{	
        		var url = dominio + diretorio() + "/lancamentos/DelTf";
        		
        		$.post(url, {lan:id}, function (data) {
        			resp = data.split("|");
        			
        			CarregandoDurante();
        			
        			if(resp[0]==1)
        			{
        				$("#seta").val('');
        				
        				ListarLancamentos();
        				ListarReceitas();
        				ListarDespesas();
        			}
        			
        			$("#msg_loading").html(resp[1]);
        			
        			CarregandoDepois('',3000);
        		});
        	}
        }
        
        function LimparTf()
        {
        	$("#usuario_transferencia").attr("title","Cadastrado por Carlos Oliveira");
        	$("#id_tf").val('');
        	$("#data_tf").val('');
        	$("#desc_tf").val('');
        	$("#origem_tf").val('');
        	$("#destino_tf").val('');
        	$("#valor_tf").val('');
        	$("#resp_origem").html('');
        }
        
        function FiltroStatus(id)
        {
        	var aux = id.split("_");
        	var tipo = aux[0];
        	var filtro = aux[1];
        	var status = $("#status").val();
        	
        	id = "#"+id;
        	
        	if (filtro == "previsto") 
        	{
        		if(status==-1)
        		{
        			$(id).removeClass('btn-success');
        		
        			$("#status").val('');
        		}
        		else
        		{
        			$(id).addClass('btn-success');
        			
        			$("#status").val(-1);
        		}
        		
                $("#"+tipo+"_atrasado").removeClass('btn-danger');
                $("#"+tipo+"_realizado").removeClass('btn-warning');
        		
        		if(tipo=='lan') ListarLancamentos();
        		
        		if(tipo=='receitas') ListarReceitas();
        		
        		if(tipo=='despesas') ListarDespesas();
            }
        
            if (filtro == "atrasado") 
        	{
        		if(status==-2)
        		{
        			$(id).removeClass('btn-danger');
        		
        			$("#status").val('');
        		}
        		else
        		{
        			$(id).addClass('btn-danger');
        			
        			$("#status").val(-2);
        		}
        	
                $("#"+tipo+"_realizado").removeClass('btn-warning');
                $("#"+tipo+"_previsto").removeClass('btn-success');
        		
        		if(tipo=='lan') ListarLancamentos();
        		
        		if(tipo=='receitas') ListarReceitas();
        		
        		if(tipo=='despesas') ListarDespesas();
            }
        
            if (filtro == "realizado") 
        	{
                if(status==1)
        		{
        			$(id).removeClass('btn-warning');
        		
        			$("#status").val('');
        		}
        		else
        		{
        			$(id).addClass('btn-warning');
        			
        			$("#status").val(1);
        		}
        	    
        		$("#"+tipo+"_previsto").removeClass('btn-success');
                $("#"+tipo+"_atrasado").removeClass('btn-danger');
        		
        		if(tipo=='lan') ListarLancamentos();
        		
        		if(tipo=='receitas') ListarReceitas();
        		
        		if(tipo=='despesas') ListarDespesas();
            }
        }
        
        function FiltraSeta(id, aba)
        {
        	var aux = id.split("_");
        	var tipo = aux[0];
        	var filtro = aux[1];
        	var id2 = "#periodo_"+aba;
        	var periodo = $(id2).val();
        	
        	id = "#"+id;
        	
        	if (filtro == "dia") 
        	{
                $(id).addClass('btn-primary');
        			
        		$(id2).val('dia');
        		
        		$("#"+tipo+"_semana").removeClass('btn-primary');
        		$("#"+tipo+"_mes").removeClass('btn-primary');
                $("#"+tipo+"_ano").removeClass('btn-primary');
        		$("#"+tipo+"_valor_periodo").val('<?=date('d/m/Y')?>');
            }
        	
        	if (filtro == "semana") 
        	{
                $(id).addClass('btn-primary');
        			
        		$(id2).val('semana');
        		
        		$("#"+tipo+"_dia").removeClass('btn-primary');
        		$("#"+tipo+"_mes").removeClass('btn-primary');
                $("#"+tipo+"_ano").removeClass('btn-primary');
        		$("#"+tipo+"_valor_periodo").val('<?=$inicio . " - " . $fim?>');
            }
        	
        	if (filtro == "mes") 
        	{
        		$(id).addClass('btn-primary');
        			
        		$(id2).val('mes');
        		
        		$("#"+tipo+"_dia").removeClass('btn-primary');
        		$("#"+tipo+"_semana").removeClass('btn-primary');
                $("#"+tipo+"_ano").removeClass('btn-primary');
        		$("#"+tipo+"_valor_periodo").val('<?=$mes . "/" . date("Y")?>');
            }
        	
        	if (filtro == "ano") 
        	{
                $(id).addClass('btn-primary');
        			
        		$(id2).val('ano');
        		
        		$("#"+tipo+"_dia").removeClass('btn-primary');
        		$("#"+tipo+"_mes").removeClass('btn-primary');
                $("#"+tipo+"_semana").removeClass('btn-primary');
        		$("#"+tipo+"_valor_periodo").val('<?=date('Y')?>');
            }
        	
        	if(tipo=='lan') ListarLancamentos();
        		
        	if(tipo=='receitas') ListarReceitas();
        		
        	if(tipo=='despesas') ListarDespesas();
        }
        
        function EscondeRecebido()
        {
        	var recebido = document.getElementById('div_pgto').style.display;
        	
        	if(recebido=="none")
        	{
        		document.getElementById('div_pgto').style.display = "inline";
        	
        		$("#recebimento_lan").val($("#vencimento_lan").val());
        	}
        	else
        	{
        		document.getElementById('div_pgto').style.display = "none";
        	}
        }
        
        function EscondeRepetir(periodo)
        {
        	if(periodo!="")
        	{
        		document.getElementById('div_repete').style.display = "inline";
        	}
        	else
        	{
        		$("#qtd_lan").val('');
        		
        		document.getElementById('div_repete').style.display = "none";
        	}
        }
        
        function ControleContas(conta,combo)
        {
        	if(conta=="") { 
	        	conta =0; 
        	}
        	
        	var id = combo+"_"+conta;
        	
        	var id_combo = combo+"_tf";
        	var combo = document.getElementById(id_combo);
        	
        	for(var i = 0;i<combo.length;i++)
        	{
        		combo.options[i].style.display = "block"; 
        	}
        	
        	if(conta!=0)
        	{
        		document.getElementById(id).style.display = "none";
        	}
        }
        
        function Boleto(id)
        {
        	var url = dominio + diretorio() + "/lancamentos/VerificaBoleto";
        			
        	CarregandoAntes();
        		
        	$.post(url, {lan:id}, function (data) 
        	{
        		CarregandoDurante();
        				
        		$("#resp_boleto").html(data);
        		$("#modal_boleto").modal('show');
        		
        		CarregandoDepois('',1000);
        		
        		$("#botao_copiar").zclip({
        			path: "application/js/zeroclipboard/ZeroClipboard.swf",
        			copy: function() {
            	            return $("#txt_link").val();
            	    },
            	    afterCopy: function() {
        				alert('Link Copiado');
        			}
        		});
        	});
        }
        
        function SegundaViaBoleto(id)
        {
        	var url = dominio + diretorio() + "/lancamentos/SegundaViaBoleto";
        			
        	CarregandoAntes();
        		
        	$.post(url, {lan:id}, function (data) 
        	{
        		CarregandoDurante();
        				
        		$("#resp_boleto").html(data);
        		
        		CarregandoDepois('',1000);
        	});
        }	
        
        function AvisoBoleto()
        {
        	var url = dominio + diretorio() + "/lancamentos/AvisoBoleto";
        		
        	if($("#tipo_lan").val()=="receita")
        	{	
        		$.post(url, {lan:$("#id_lan").val(),forma:$("#pagamento_lan").val(),conta:$("#destino_lan").val(),tipo:$("#tipo_lan").val()}, function (data) 
        		{
        			resp = data.split("|");
        			
        			if(resp[0]==1)
        			{
        				$("#div_obs_boleto_lan").show();
        			}
        			else
        			{
        				$("#div_obs_boleto_lan").hide();
        			}
        			
        			$("#resp_forma").html(resp[1]);
        		});
        	}
        	else
        	{
        		$("#resp_forma").html('');
        	}
        }
        
        function VerificaCartao()
        {
        	var url = dominio + diretorio() + "/lancamentos/VerificaCartao";
        	
        	if(($("#tipo_lan").val()=="despesa")&&($("#pagamento_lan").val()==2))
        	{	
        		$.post(url, {fatura:$("#fatura_id").val()}, function (data) 
        		{
        			resp = data.split("|");
        			
        			if(resp[0]==1)
        			{
        				$("#cartoes_lan").show();
        				$("#cartoes_lan").val($.trim(resp[1]));
        				$("#div_pgto").hide();
        				$("#div_conta_lan").hide();
        				$("#label_status_lan").hide();
        			}
        			else
        			{
        				$("#div_conta_lan").show();
        				$("#label_status_lan").show();
        				$("#cartoes_lan").hide();
        			}
        		});
        	}
        	else
        	{
        		$("#div_conta_lan").show();
        		$("#label_status_lan").show();
        		$("#cartoes_lan").hide();
        	}
        }
        
        function EmitirSegundaVia(id)
        {
        	var url = dominio + diretorio() + "/lancamentos/EmitirSegundaVia";
        	
        	CarregandoAntes();
        	
        	$.post(url, {lan:id,valor:$("#via2_valor").val(),data:$("#via2_data").val(),conta:$("#via2_conta").val()}, function (data) {
        		
        		resp = data.split("|");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			ListarLancamentos();
        			ListarReceitas();
        			ListarDespesas();
        			
        			$("#modal_lan").modal('hide');
        			
        			window.open(resp[2],'_blank');
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',7000);
        	});
        }
        
        function AddCentro(centro)
        {
        	var url = dominio + diretorio() + "/lancamentos/AddCentro";
        		
        	CarregandoAntes();
        	
        	$.post(url, {centro:$("#centro_lan").val(),tipo:$("#tipo_centro_lan").val(),valor:$("#valor_centro_lan").val(),valor_lan:$("#valor_lan").val(),lan:$("#id_lan").val()}, function (data) {
        		
        		resp = data.split("~");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			var centros = $("#resp_centros").html()+resp[2];
        			
        			$("#centro_lan").val('');
        			$("#tipo_centro_lan").val('');
        			$("#valor_centro_lan").val('');
        			$("#resp_centros").html(centros);
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',4000);
        	});
        }
        
        function DelCentro(centro) 
        {
            var url = dominio + diretorio() + "/lancamentos/DelCentro";
        
        	CarregandoAntes();
            
        	$.post(url, {centro:centro,lan:$("#id_lan").val()}, function (data) {
        		resp = data.split("|");
        		
        		CarregandoDurante();
        		
        		if(resp[0]==1)
        		{
        			ListarCentros();
        		}
        		
        		$("#msg_loading").html(resp[1]);
        		
        		CarregandoDepois('',4000);
        	});
        }
        
        function ListarCentros()
        {
        	var url = dominio + diretorio() + "/lancamentos/BuscarCentros/"+$("#id_lan").val();
        	
        	ajaxHTMLProgressBar('resp_centros', url, false, false);
        }
        
        function VerificaLimite()
        {
        	var url = dominio + diretorio() + "/lancamentos/VerificaLimite";
        	
        	$.post(url,{conta:$("#destino_lan").val(),valor:$("#valor_lan").val()},function (data) {
        		$("#resp_conta").html(data);	
        	});
        }
        
        function VerificaLimiteTf()
        {
        	var url = dominio + diretorio() + "/lancamentos/VerificaLimite";
        	
        	$.post(url,{conta:$("#origem_tf").val(),valor:$("#valor_tf").val()},function (data) {
        		$("#resp_origem").html(data);	
        	});
        }
        
        function Exportar()
        {
        	var url = dominio + diretorio() + "/lancamentos/BuscarLancamentos";
        	
        	$("#tipo_listagem").val('exportar');
        	
        	if($("#aba").val()=="lancamentos")
        	{
        		$("#tipo_periodo").val($("#periodo_lan").val());
        		$("#valor_periodo").val($("#lan_valor_periodo").val());
        	}
        	if($("#aba").val()=="receitas")
        	{
        		url+="/Receitas";
        		
        		$("#tipo_periodo").val($("#periodo_receitas").val());
        		$("#valor_periodo").val($("#receitas_valor_periodo").val());
        	}
        	
        	if($("#aba").val()=="despesas")
        	{
        		url+="/Despesas";
        		
        		$("#tipo_periodo").val($("#periodo_despesas").val());
        		$("#valor_periodo").val($("#despesas_valor_periodo").val());
        	}
        	
        	$('#form_busca').attr('action',url);
        	$('#form_busca').submit();
        }
    </script>
    
    <article>
    	<div  class="modal fade hide hidden-phone" id="started_financeiro">
    	
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" onclick="CancelaVideo('Financeiro');">&#215;</button>
    			<h2 class="pr_5 mr_0" style="display:inline;">
    				V&iacute;deo Tutorial - M&oacute;dulo Financeiro
    			</h2>
    			<i title="Acessando pela primeira vez? Este v&iacute;deo ir&aacute; te ajudar, para n&atilde;o visualiz&aacute;-lo mais selecione a op&ccedil;&atilde;o abaixo do v&iacute;deo e feche esta caixa. Para ver novamente basta clicar no icone ao lado da palavra financeiro" id="tip_video" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);"></i>
    		</div>
    		<div class="modal-body">
    		
    			<iframe width="530" height="315" src="http://www.youtube.com/embed/DcR4hHlUrRQ" frameborder="0" allowfullscreen></iframe>
    		
    			
    			<label class="checkbox inline">
    
    				<input type="checkbox" id="check_video" name="check_video">N&atilde;o exibir mais este v&iacute;deo automaticamente
    	         
    			</label>
    			
    		</div>
    	</div>
    	
    	<form>
    		<input type="hidden"  id="vf_id_lan" name="vf_id_lan" value="" /> <!-- vf = cerifica -->
    		<input type="hidden" id="vf_desc_lan" name="vf_desc_lan" value="" />
    		<input type="hidden" id="vf_valor_lan" name="vf_valor_lan" value="" />
    		<input type="hidden" id="vf_vencimento_lan" name="vf_vencimento_lan" value="" />
    		<input type="hidden" id="vf_status_lan" name="vf_status_lan" value="" />
    		<input type="hidden" id="vf_recebimento_lan" name="vf_recebimento_lan" value="" />
    		<input type="hidden" id="vf_categoria_lan" name="vf_recebimento_lan" value="" />
    		<input type="hidden" id="vf_destino_lan" name="vf_destino_lan" value="" />
    		<input type="hidden" id="vf_entidade_lan" name="vf_entidade_lan" value="" />
    		<input type="hidden" id="vf_doc_lan" name="vf_doc_lan" value="" />
    		<input type="hidden" id="vf_numdoc_lan" name="vf_numdoc_lan" value="" />
    		<input type="hidden" id="vf_pagamento_lan" name="vf_pagamento_lan" value="" />
    		<input type="hidden" id="vf_obs_lan" name="vf_obs_lan" value="" />
    		<input type="hidden" id="vf_obs_boleto_lan" name="vf_obs_boleto_lan" value="" />
    	</form>
    	
    	<div id="cat_receitas" style="display:none">
    		<select class="categoria" id="cat_receita_select">
    			<option value="">Selecione</option>
    			<option value="1">Ajuste de caixa</option>
    			<option value="11">Aplicações financeiras</option>
    			<option value="12">Devolução de adiantamento</option>
    			<option value="10">Vendas</option>
    		</select>
    	</div>
    	<div id="cat_despesas" style="display:none">
    		<select id="cat_despesa_select" class="categoria">
    			<option value="">Selecione</option>
    			<option value="7">Água</option>
    			<option value="10001">&nbsp;&nbsp;&#8226;&nbsp;Sub Aguá</option>	
    			<option value="2">Aluguel</option>
    			<option value="3">Internet</option>
    			<option value="8">Luz</option>
    			<option value="4">Material de escritório</option>
    			<option value="5">Salários</option>
    			<option value="6">Taxas e tarifas</option>
    			<option value="9">Telefone</option>
    		</select>
    	</div>
    	
    	<div class="grid_4">
    		<div class="da-panel">
    			<div class="modal hide" id="modal_boleto">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&#215;</button>
    					<h2 class="pr_5 mr_0" id="baixa_titulo_lan" style="display:inline;">Boleto </h2>
    				</div>
    				<div class="modal-body" style="overflow:auto">
    					<div id="resp_boleto" class="form-horizontal"></div>
    				</div>
    			</div>
    			
    			<div class="modal hide" id="modal_baixa">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&#215;</button>
    					<h2 class="pr_5 mr_0" id="baixa_titulo_lan" style="display:inline;">Baixa: </h2>
    				</div>
    				<div class="modal-body" style="overflow:auto">
    					<div class="form-horizontal">
    						<form>
    							<fieldset>
    								<input type="hidden" name="baixa_lan_id" id="baixa_lan_id">
    								<input type="hidden" name="tipo_lan_baixa" id="tipo_lan_baixa" class="input_maior" value="" />
    								
    								<div class="control-group">
    									<div class="control-group">
    										<label class="control-label"> *Data do pagamento:</label>

    										<div class="controls">
    											<input type="text" name="baixa_data" id="baixa_data" class="datepicker" style="width:80px;" value="20/01/2014" />
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<label class="control-label"> *Valor:</label>
    										
    										<div class="controls">
    											<input style="width:80px;" type="text" value="" name="baixa_valor" id="baixa_valor"/>
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<label class="control-label" id="txt_conta_baixa"> *Conta:</label>
    
    										<div class="controls">
    											<select name="baixa_conta" id="baixa_conta" style="width: 150px;">
    												<option value="">Selecione</option>
													<option value="2">Teste Caixa</option>
													<option value="1">Teste Conta</option>
												</select>
    										</div>
    									</div>
    								
    									<div class="control-group">
    										<label class="control-label">Documento:</label>
    
    										<div class="controls">
    											<select name="baixa_doc" id="baixa_doc" style="width: 150px;">
    												<option value="">Selecione</option>
    												<option value="1">Recibo</option>
    												<option value="2">Nota Fiscal</option>
    												<option value="3">Cupom Fiscal</option>
    											</select>
    											<label class="checkbox inline">N&uacute;mero:</label>
    											<input name="baixa_numdoc" id="baixa_numdoc" type="text" class="input_menor" style="width:100px;" value="" onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" />
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<label class="control-label">*Forma de Pagamento:</label>
    
    										<div class="controls">
    											<select name="baixa_formapagamento" id="baixa_formapagamento" style="width: 150px;">
    												<option value="">Selecione</option>
													<option value="1">Boleto</option>
													<option value="2">Cartão de crédito</option>
													<option value="3">Cartão de débito</option>
													<option value="4">Cheque</option>
													<option value="7">Débito em conta</option>
													<option value="5">Depósito</option>
													<option value="6">Dinheiro</option>
													<option value="8">PagSeguro</option>
												</select>
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<div class="controls al_rgt">
    											<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    											<a class="btn btn-primary" onclick="BaixaLan($('#baixa_lan_id').val());">Salvar</a>
    										</div>
    									</div>
    								</div>	
    							</fieldset>
    						</form>
    
    					</div>
    				</div>
    			</div>
    			
    			<div id="modal_lan" class="modal hide fade" tabindex="-1" data-width="760" style="z-index:2000;">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&#215;</button>
    					<h2 class="pr_5 mr_0" id="txt_tipo_lancamento" style="display:inline;">Novo Lan&ccedil;amento</h2>
    					<i id="usuario_lancamento" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por"></i>
    				</div>
    				<div class="modal-body" > <!--style="max-height:520px;overflow:auto"-->
    					<div class="form-horizontal">
    						<form>
    							<fieldset>
    								<div class="control-group">
    									<div class="control-group">
    										<label class="control-label"> *Descri&ccedil;&atilde;o:</label>
    										
    										<div class="controls">
    											<input type="hidden" name="id_lan" id="id_lan" class="input_maior" value="" />
    											<input type="hidden" name="grupo_lan" id="grupo_lan" value="" />
    											<input type="text" name="desc_lan" id="desc_lan" class="input_maior" value="" />
    											<label class=" checkbox inline"> *Valor:</label>
    											<input style="width:80px;" type="text" value="" name="valor_lan" id="valor_lan" onblur="VerificaLimite();">
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label" id="lbl_vctooriginal"> *Vencimento <i id='ico_vctooriginal' onclick="ConfigVencimentoOriginal('mostrar');" class="hidden-phone hidden-tablet icon-plus-sign icon-black"></i></label>
    
    										<div class="controls">
    											<input type="text" name="vencimento_lan" id="vencimento_lan" class="datepicker" style="width:80px;" value="" />
    											<label id="label_status_lan" style="margin-left:20px;" class="checkbox inline"><p id="txt_status_lan" style="margin-bottom:-20px;">Recebida</p><input type="checkbox" value="1" id="status_lan" name="status_lan" onclick="EscondeRecebido();"></label>
    											<div id="div_pgto" style="display:none;">	
    												<label class="checkbox inline">Quando?</label>
    												<input type="text" name="recebimento_lan" id="recebimento_lan" class="datepicker" style="width:80px;" value="" />
    											</div>
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<label class="control-label"> *Categoria / Subcategoria</label>
    
    										<div class="controls" id="categorias">
    											<select name="categoria_lan" id="categoria_lan" style="width: 150px;">
    											</select>
    										</div>
    									</div>
    										
    									<div class="control-group">
    										<label class="control-label">Centro de custo:</label>
    
    										<div class="controls">
    											<select name="centro_lan" id="centro_lan" style="width: 100px;">
    												<option value="">Selecione</option>
													<option value="1" >Informática</option>
    											</select>
    											&nbsp;
    											<div style="display:inline;">	
    												<select name="tipo_centro_lan" id="tipo_centro_lan" style="width:60px;">
    													<option value=""></option>
    													<option value="porcentagem">%</option>
    													<option value="valor">R$</option>
    												</select>	
    												<label class=" checkbox inline">Valor:</label>
    												<input name="valor_centro_lan" id="valor_centro_lan" style="width:50px;" type="text" value="">
    												&nbsp;
    												<i onclick="AddCentro();" class="hidden-phone hidden-tablet icon-plus icon-black" onmouseover="mouse(this);" title="Adicionar centro de custo"></i>
    											</div>
    											<br/><br/>
    											<div id="resp_centros"></div>
    										</div>
    									</div>
    										
    									<div class="control-group" id="div_conta_lan">
    										<label class="control-label" id="txt_conta_lan"> *Destino:</label>
    
    										<div class="controls">
    											<select name="destino_lan" id="destino_lan" onchange="VerificaLimite();AvisoBoleto()" style="width: 150px;">
    												<option value="">Selecione</option>
													<option value="2">Teste Caixa</option>
													<option value="1">Teste Conta</option>
												</select>
    											<div id="resp_conta" style="display:inline;"></div>
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label" id="txt_fonte_lan">*Cliente:</label>
    
    										<div class="controls">
    											<input style="width: 140px;" type="text" name="entidade_lan" id="entidade_lan" class="input_menor" size="10px" value="" placeholder="Buscar" />
    											<input type="hidden" name="tipocli" id="tipoent" size="10px" value="" />
    											<input type="hidden" name="codcli" id="codent" size="10px" value="" />
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label">Documento:</label>
    
    										<div class="controls">
    											<select name="doc_lan" id="doc_lan" style="width: 150px;">
    												<option value="">Selecione</option>
    												<option value="1">Recibo</option>
    												<option value="2">Nota Fiscal</option>
    												<option value="3">Cupom Fiscal</option>
    											</select>
    											<label class="checkbox inline">N&uacute;mero:</label>
    											<input name="numdoc_lan" id="numdoc_lan" type="text" class="input_menor" style="width:100px;" value="" onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" />
    										</div>
    									</div>
    									<div class="control-group" id="div_forma_lan">
    										<label class="control-label">Forma de Pagamento:</label>
    
    										<div class="controls">
    											<select name="pagamento_lan" id="pagamento_lan" onchange="AvisoBoleto();VerificaCartao();" style="width: 150px;">
    												<option value="">Selecione</option>
													<option value="1">Boleto</option>
													<option value="2">Cartão de crédito</option>
													<option value="3">Cartão de débito</option>
													<option value="4">Cheque</option>
													<option value="7">Débito em conta</option>
													<option value="5">Depósito</option>
													<option value="6">Dinheiro</option>
													<option value="8">PagSeguro</option>
												</select>
    											<select name="cartoes_lan" id="cartoes_lan" style="display:none;width:100px;">
    												<option value="">Selecione</option>
													<option value="1">Teste Cartão</option>
												</select>	
    											<div id="resp_forma" style="display:inline;"></div>
    											<div id="div_cartoes_lan" style="display:none;"></div>
    										</div>
    									</div>
    									<div class="control-group"  style="display:none;" id="div_obs_boleto_lan">
    										<label class="control-label">Descri&ccedil;&atilde;o para o boleto&nbsp;<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_menu" title="Caso este campo fique em branco, ser&aacute; mostrado no boleto o que est&aacute; configurado na conta banc&aacute;ria"></i>:</label>
    
    										<div class="controls">
    											<textarea class="input_full" name="obs_boleto_lan" id="obs_boleto_lan" style="height: 30px;"></textarea>
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label">Repetir:</label>
    
    										<div class="controls">
    											<select name="repetir_lan" id="repetir_lan" style="width: 150px;" onchange="EscondeRepetir(this.value);" >
    												<option value="">N&atilde;o</option>
    												<option value="semana">Semanalmente</option>
    												<option value="quinzena">Quinzenalmente</option>
    												<option value="mes">Mensalmente</option>
    												<option value="bimestre">Bimestralmente</option>
    												<option value="trimestre">Trimestralmente</option>
    												<option value="semestre">Semestralmente</option>
    												<option value="ano">Anualmente</option>
    											</select>
    											<div id="div_repete" style="display:none;">	
    												<label class="checkbox inline">Quantas vezes?</label>
    												<input type="text" name="qtd_lan" id="qtd_lan" class="input_menor" style="width:50px;margin-left:20px;" value="" />
    											</div>
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label"> Obs:</label>
    
    										<div class="controls">
    											<textarea class="input_full" name="obs_lan" id="obs_lan" style="height: 50px;" name="int_obs" id="int_obs"></textarea>
    										</div>
    									</div>
    								</div>	
    							</fieldset>
    						</form>
    					</div>
    				</div>
    				<div class="modal-footer">
    					<div class="control-group">
    						<div class="controls al_rgt">
    							<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    							<a class="btn btn-primary" onclick="AcaoLan();">Salvar</a>
    						</div>
    					</div>
    				</div>
    			</div>
    			
    			<div class="modal hide" id="modal_transferencia">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&#215;</button>
    					<h2 class="pr_5 mr_0" style="display:inline;">Nova Transfer&ecirc;ncia</h2>
    					<i id="usuario_transferencia" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por"></i>
    				</div>
    				<div class="modal-body" style="max-height:420px;">
    					<div class="form-horizontal">
    						<form>
    							<fieldset>
    								<div class="control-group">
    									<div class="control-group">
    										<label class="control-label">*Data:</label>
    										
    										<div class="controls">
    											<input type="text" name="data_tf" id="data_tf" class="datepicker" value=""/>
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<label class="control-label"> *Descri&ccedil;&atilde;o:</label>
    										
    										<div class="controls">
    											<input type="hidden" name="id_tf" id="id_tf" class="input_maior" value="" />
    											<input type="text" name="desc_tf" id="desc_tf" class="input_maior" value="" />
    										</div>
    									</div>
    									
    									<div class="control-group">
    										<label class="control-label"> *Origem:</label>
    
    										<div class="controls">
    											<select name="origem_tf" id="origem_tf" onclick="ControleContas(this.value,'destino');VerificaLimiteTf();">
    												<option id="origem_0" value="">Selecione</option>
    												<option id="origem_2" value="2">Teste Caixa</option>
    												<option id="origem_1" value="1">Teste Conta</option>
												</select>
    											<div id="resp_origem" style="display:inline;"></div>
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label"> *Destino:</label>
    
    										<div class="controls">
    											<select name="destino_tf" id="destino_tf" onclick="ControleContas(this.value,'origem');">
    												<option id="destino_0" value="">Selecione</option>
													<option id="destino_2" value="2">Teste Caixa</option>
													<option id="destino_1" value="1">Teste Conta</option>
												</select>
    										</div>
    									</div>
    									<div class="control-group">
    										<label class="control-label"> *Valor:</label>
    
    										<div class="controls">
    											<input onkeyup="VerificaLimiteTf();" type="text" value="" name="valor_tf" id="valor_tf">
    										</div>
    									</div>
    									<div class="control-group">
    										<div class="controls al_rgt">
    											<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    											<a class="btn btn-primary" onclick="GravarTf();">Salvar</a>
    										</div>
    									</div>
    								</div>	
    							</fieldset>
    						</form>
    					</div>
    				</div>
    			</div>
    			
    			<div class="modal hide" id="modal_repetir">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&#215;</button>
    					<h2 class="pr_5 mr_0" style="display:inline;">Lan&ccedil;amento com Repeti&ccedil;&atilde;o</h2>
    				</div>
    				<div class="modal-body">
    					<div class="control-group">
    						<form>
    							<fieldset>
    								<input type="hidden" value="0" name="controle_repetir" id="controle_repetir">
    								    <div class="alert">
    										<button type="button" class="close" data-dismiss="alert">&times;</button>
    										<strong>Aten&ccedil;&atilde;o!</strong> Caso lan&ccedil;amentos com boleto sejam excluidos, os boletos n&atilde;o ser&atilde;o mais visualizados
    									</div>
    								<div class="control-group">
    									<div>
    										Deseja que a a&ccedil;&atilde;o seja aplicada apenas a este lan&ccedil;amento, todos os lan&ccedil;amentos da repeti&ccedil;&atilde;o ou a este e tamb&eacute;m aos seguintes ?
    									</div>
    									<br/>
    									<div>
    										<label class="radio inline">
    											<input type="radio" id="op_1" name="lancamento_repeticao" value="1"/>&nbsp;Somente este lan&ccedil;amento&nbsp;
    											<i title="Todos os outros lan&ccedil;amentos da repeti&ccedil;&atilde;o permanecer&atilde;o inalterados" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    										</label>
    									</div>
    									<div>
    										<label class="radio inline">
    											<input type="radio" id="op_2" name="lancamento_repeticao" value="2"/>&nbsp;Este lan&ccedil;amento e tamb&eacute;m os seguintes&nbsp;
    											<i title="Este lan&ccedil;amento e os seguintes ser&atilde;o afetados por esta a&ccedil;&atilde;o" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    										</label>
    									</div>
    									<div>
    										<label class="radio inline">
    											<input type="radio" id="op_3" name="lancamento_repeticao" value="3"/>&nbsp;Todos os lan&ccedil;amentos da repeti&ccedil;&atilde;o&nbsp;
    											<i title="Todos os outros lan&ccedil;amentos da repeti&ccedil;&atilde;o ser&atilde;o afetados por esta a&ccedil;&atilde;o" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    										</label>
    									</div>
    									<br/>
    								</div>
    								<div class="control-group">
    									<div class="controls al_rgt">
    										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    										<a class="btn btn-primary" id="btn_repetir">Continuar</a>
    									</div>
    								</div>
    							</fieldset>
    						</form>
    					</div>
    				</div>
    			</div>
    			
    			<div class="modal hide" id="modal_cartao_credito">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&#215;</button>
    					<h2 class="pr_5 mr_0" style="display:inline;" id="txt_nome_fatura"></h2>
    				</div>
    				<div class="modal-body" style="max-height:420px;">
    					<input type="hidden" id="fatura_id" name="fatura_id">
    					<input type="hidden" id="tipo_lan" name="tipo_lan"> 
    					<div id="resp_lan_fatura"></div>
    				</div>
    				
    				<div class="modal-footer">
    					<div class="control-group">
    						<div class="controls al_rgt">
    							<a href="#" class="btn" data-dismiss="modal">Voltar</a>
    							<span><a id="btn_nova_despesa_cartao" class="btn btn-danger" data-toggle="modal" href="#modal_lan" onclick="LimparLan();$('#pagamento_lan').val(2);FormLan('despesa','');">Nova Despesa</a></span>
    						</div>
    					</div>
    				</div>
    			</div>
    			
    			<div class="da-panel-header">
    				<span class="da-panel-title row-fluid">
    					<span class="label label-inverse pr_5"><img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/32/cur_dollar.png" width="16"/></span>
    					<strong class="tt_uc">
                           Lan&ccedil;amentos
    					</strong>
						<a href="#started_financeiro" data-toggle="modal"  title="Clique aqui para ver o v&iacute;deo tutorial">
							<i class="icon-facetime-video icon-black"></i>
						</a>
    							
    					<span class="flt_rgt span5">	
    						<span><a  class="btn btn-info" data-toggle="modal" href="#modal_lan" onclick="LimparLan();FormLan('receita','');">Nova Receita</a></span>
    						<span><a  class="btn btn-danger" data-toggle="modal" href="#modal_lan" onclick="LimparLan();FormLan('despesa','','lancamento');";>Nova Despesa</a></span>
    						<span><a  class="btn" data-toggle="modal" href="#modal_transferencia" onclick="LimparTf();">Nova Transfer&ecirc;ncia</a></span>
    						<i title="Fa&ccedil;a transfer&ecirc;ncia entre suas contas banc&aacute;rias e caixa pequeno." id="tip_tf" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    					</span>
    				</span>
    			</div>
    			
    			<div class="da-panel-content">
    				<div class="da-panel-padding">
    					<div class="da-filter hidden-phone hidden-tablet">
    						<a id="btn_filtro" onclick="$('#entidade_filtro').focus();" class="accordion-toggle dsp_ib flt_rgt btn btn-inverse" data-toggle="collapse" title="Filtrar"  data-parent="#sanfona" href="#filtro">
    							<i id="classe_filtro" class="icon-filter icon-white"></i>Filtro
    						</a>
    						<div class="ws_nw hidden-phone hidden-tablet">
    							<a onclick="Exportar();" href="#" class="btn btn-mini"><i class="icon-download icon-black"></i> Exportar</a>
    						</div>
    						
    						<div class="accordion pr_0" id="sanfona"> <!-- Precisa de css inline / id="sanfona" -->
    							<div class="accordion-group pr_0 brd_none">
    								<div class="accordion-heading"></div>
    
    								<div id="filtro" class="accordion-body collapse closed">
    									<span class="accordion-toggle dsp_b btn btn-inverse disabled">
	    									&nbsp;
    									</span>
    
    									<div class="accordion-inner well">
    										<form id="form_busca" method="post">		
    											<fieldset>
    												<input type="hidden" id="aba" value="lancamentos">
    												<input type="hidden" id="tipo_listagem" name="tipo_listagem">
    												<input type="hidden" id="tipo_periodo" name="tipo_periodo">
    												<input type="hidden" id="valor_periodo" name="valor_periodo">
    												<input type="hidden" id="seta_form" name="seta">
    												<input type="hidden" id="status" name="status" value="">
    
    												<div class="control-group">
    													<label class="control-label">
    														Fornecedor / Cliente
    													</label>
    													<div class="controls">
    														<input type="text" style="height:25" name="entidade" id="entidade_filtro" class="input_full" value=""/>
    													</div>
    												</div>
    												<div class="control-group">
    													<label class="control-label">
    														Categoria / Subcategoria
    													</label>
    
    													<div class="controls">
    														<select id="categoria_filtro" class="input_full" name="categoria_filtro">
    															<option value="">Selecione</option>
    															<option value="7">Água</option>
																<option value="10001">&nbsp;&nbsp;&#8226;&nbsp;Sub Aguá</option>	
    															<option value="1">Ajuste de caixa</option>
    															<option value="2">Aluguel</option>
    															<option value="11">Aplicações financeiras</option>
    															<option value="12">Devolução de adiantamento</option>
    															<option value="3">Internet</option>
    															<option value="8">Luz</option>
    															<option value="4">Material de escritório</option>
    															<option value="5">Salários</option>
    															<option value="6">Taxas e tarifas</option>
    															<option value="9">Telefone</option>
    															<option value="10">Vendas</option>
															</select>
    													</div>
    												</div>
    												
    												<div class="control-group">
    													<label class="control-label">
    														Contas Banc&aacute;rias / Caixa Pequeno
    													</label>
    
    													<div class="controls">
    														<select id="conta_filtro" class="input_full" name="conta_filtro">
    															<option value="">Selecione</option>
																<option value="2">Teste Caixa</option>
																<option value="1">Teste Conta</option>
															</select>
    													</div>
    												</div>
    
    												<div class="control-group">
    													<label class="control-label">
    														Centro de Custo <img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/novidade-icon.png" alt="Novos Recursos"/>
    													</label>
    
    													<div class="controls">
    														<select id="centros_filtro" class="input_full" name="centros_filtro">
    															<option value="">Selecione</option>
																<option value="1">Informática</option>
															</select>
    													</div>
    												</div>
    												
    												<div class="control-group">
    													<label class="control-label">
    														Nosso n&uacute;mero (Boleto)
    														<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_nn" title="Digite pelo menos 3 caracteres que estejam contidos no Nosso n&uacute;mero"></i>
    													</label>
    
    													<div class="controls">
    														<input type="text" style="height:25" name="nn" id="nn_filtro" class="input_full" value=""/>
    													</div>
    												</div>
    										   
    												<div class="form-actions al_rgt">
    													<a  onclick="$('#entidade_filtro').val('');$('#categoria_filtro').val('');$('#conta_filtro').val('');$('#nn_filtro').val('');$('#centros_filtro').val('');;$('#entidade_filtro').focus();$('#btn_filtro').html('<i id=\'classe_filtro\' class=\'icon-filter icon-white\'></i>Filtro');" class="btn btn-success">
    														<i class="icon-remove icon-white"></i>
    															Limpar
    													</a>
    													<a  onclick="FiltrarGeral();$('#classe_filtro').removeClass('icon-filter icon-white');$('#btn_filtro').html('<img src=http://<?=$_SERVER['HTTP_HOST']?>/application/img/filter-red.png>Filtro');" class="btn btn-success" data-toggle="collapse" title="Filtrar"  data-parent="#sanfona" href="#filtro">
    														<i class="icon-search icon-white"></i>
    															Filtrar
    													</a>
    												</div>
    											</fieldset>
    										</form>
    									</div>
    								</div>
    							</div>
    						</div>
    					</div>
    					
    					<div class="tabbable">
    						<input type="hidden" id="periodo_lan" value="semana"/>
    						<input type="hidden" id="periodo_receitas" value="semana"/>
    						<input type="hidden" id="periodo_despesas" value="semana"/>
    						<input type="hidden" id="seta" value=""/>
    						
    						<ul class="nav nav-tabs">
    							<li class="active" onclick="$('#aba').val('lancamentos');ListarLancamentos();"><a href="#tab1" data-toggle="tab">Lan&ccedil;amentos</a></li>
    							<li onclick="$('#status').val('');$('#aba').val('receitas');ListarReceitas();"><a  href="#tab2" data-toggle="tab">Receitas</a></li>
    							<li onclick="$('#status').val('');$('#aba').val('despesas');ListarDespesas();"><a  href="#tab3" data-toggle="tab">Despesas</a></li>
    							<i title="Visualize todos os seus Lan&ccedil;amentos ou apenas as Receitas ou as Despesas." id="tip_abas" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    						</ul>
    						<div class="tab-content row-fluid">
    							<div class="tab-pane fade in active" id="tab1">	
    								<div class="da-panel-header">
    									<span class="da-panel-title row-fluid">
    										<span class="span6">	
    											<label id="lan_dia" onclick="$('#seta').val('');FiltraSeta(this.id,'lan');" class="btn dropdown-toggle">Dia</label>
    											<label id="lan_semana" onclick="$('#seta').val('');FiltraSeta(this.id,'lan');" class="btn btn-primary dropdown-toggle">Semana</label>
    											<label id="lan_mes" onclick="$('#seta').val('');FiltraSeta(this.id,'lan');" class="btn dropdown-toggle">M&ecirc;s</label>
    											<label id="lan_ano" onclick="$('#seta').val('');FiltraSeta(this.id,'lan');" class="btn dropdown-toggle">Ano</label>
    											<i title="Utilize esses bot&otilde;es para visualizar seus lan&ccedil;amentos por Dia, Semana, M&ecirc;s e Ano." id="tip_ano1" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    											<div>	
    												<a style="margin-top:-3px;"  class="btn btn-inverse" onclick="$('#seta').val('antes');ListarLancamentos();"><i class="icon-backward icon-white"></i></a>
    												<label class="checkbox inline">	
    													<input disabled id="lan_valor_periodo" type="text"  style="margin-left:-22px;text-align:center;margin-top: 1px;background-color:#fff" class="ui-autocomplete-input" autocomplete="off" value="<?=$inicio . " - " . $fim?>"/>
    												</label>	
    												<a style="margin-left:-5px;margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('depois');ListarLancamentos();"><i class="icon-forward icon-white"></i></a>
    											</div>
    										</span>
    										<span class="flt_rgt">	
    											<i title="Veja que lan&ccedil;amentos est&atilde;o Previstos, Atrasados ou Realizados" id="tip_botoes1" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    											<label class="btn dropdown-toggle" onclick="$('#seta').val('');FiltroStatus(this.id);" id="lan_previsto">Previsto</label>
    											<label class="btn dropdown-toggle" onclick="$('#seta').val('');FiltroStatus(this.id);" id="lan_atrasado">Atrasados (0)</label>
    											<label class="btn dropdown-toggle" onclick="$('#seta').val('');FiltroStatus(this.id);" id="lan_realizado">Realizados</label>
    										</span>
    									</span>
    								</div>
    								<div id="resp_lan"></div>
    							</div>
    							<div class="tab-pane fade" id="tab2">	
    								<div class="da-panel-header">
    									<span class="da-panel-title row-fluid">
    										<span class="span6">	
    											<label id="receitas_dia" onclick="$('#seta').val('');FiltraSeta(this.id,'receitas');" class="btn dropdown-toggle">Dia</label>
    											<label id="receitas_semana" onclick="$('#seta').val('');FiltraSeta(this.id,'receitas');" class="btn btn-primary dropdown-toggle">Semana</label>
    											<label id="receitas_mes" onclick="$('#seta').val('');FiltraSeta(this.id,'receitas');" class="btn dropdown-toggle">M&ecirc;s</label>
    											<label id="receitas_ano" onclick="$('#seta').val('');FiltraSeta(this.id,'receitas');" class="btn dropdown-toggle">Ano</label>
    											<i title="Utilize esses bot&otilde;es para visualizar seus lan&ccedil;amentos por Dia, Semana, M&ecirc;s e Ano." id="tip_ano2" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    											<div>	 
    												 <a title=""  style="margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('antes');ListarReceitas();"><i class="icon-backward icon-white"></i></a>
    												<label class="checkbox inline">	
    													<input type="text" disabled id="receitas_valor_periodo"  style="margin-left:-22px;text-align:center;background-color:#fff" class="ui-autocomplete-input" autocomplete="off" value="<?=$inicio . " - " . $fim?>"/>
    												</label>	
    												<a title="" style="margin-left:-5px;margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('depois');ListarReceitas();"><i class="icon-forward icon-white"></i></a>
    											</div>
    										</span>
    										<span class="flt_rgt">	
    											<label onclick="$('#seta').val('');FiltroStatus(this.id);" id="receitas_previsto" class="btn dropdown-toggle">Receber</label>
    											<label onclick="$('#seta').val('');FiltroStatus(this.id);" id="receitas_atrasado" class="btn dropdown-toggle">Atrasadas</label>
    											<label onclick="$('#seta').val('');FiltroStatus(this.id);" id="receitas_realizado" class="btn dropdown-toggle">Recebidas</label>
    										</span>
    									</span>
    								</div>
    								<div class="row-fluid" id="resp_receita" style="text-align:center;"></div>
    							</div>
    							<div class="tab-pane fade" id="tab3">	
    								<div class="da-panel-header">
    									<span class="da-panel-title row-fluid">
    										<span class="span6">	
    											<label id="despesas_dia" onclick="$('#seta').val('');FiltraSeta(this.id,'despesas');" class="btn dropdown-toggle">Dia</label>
    											<label id="despesas_semana" onclick="$('#seta').val('');FiltraSeta(this.id,'despesas');" class="btn btn-primary dropdown-toggle">Semana</label>
    											<label id="despesas_mes" onclick="$('#seta').val('');FiltraSeta(this.id,'despesas');" class="btn dropdown-toggle">M&ecirc;s</label>
    											<label id="despesas_ano" onclick="$('#seta').val('');FiltraSeta(this.id,'despesas');" class="btn dropdown-toggle">Ano</label>
    											<i title="Utilize esses bot&otilde;es para visualizar seus lan&ccedil;amentos por Dia, Semana, M&ecirc;s e Ano." id="tip_ano3" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
    											<div>	
    												<a title=""  style="margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('antes');ListarDespesas();"><i class="icon-backward icon-white"></i></a>
    													<label class="checkbox inline">	
    														<input type="text" disabled id="despesas_valor_periodo"  style="margin-left:-22px;text-align:center;background-color:#fff" class="ui-autocomplete-input" autocomplete="off" value="<?=$inicio . " - " . $fim?>"/>
    													</label>	
    												<a title="" style="margin-left:-5px;margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('depois');ListarDespesas();"><i class="icon-forward icon-white"></i></a>
    											</div>
    										</span>
    										<span class="flt_rgt">	
    											<label onclick="$('#seta').val('');FiltroStatus(this.id);" id="despesas_previsto" class="btn dropdown-toggle">Pagar</label>
    											<label onclick="$('#seta').val('');FiltroStatus(this.id);" id="despesas_atrasado" class="btn dropdown-toggle">Atrasadas</label>
    											<label onclick="$('#seta').val('');FiltroStatus(this.id);" id="despesas_realizado" class="btn dropdown-toggle">Pagas</label>
    										</span>
    									</span>
    								</div>
    								<div class="row-fluid" id="resp_despesa" style="text-align:center;"></div>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>	
    		</div>
    	</div>
    
    </article>
    <script type="text/javascript"><!--
    	$('#entidade_filtro').keydown(function(e) {
    		if (e.keyCode == 13) {
    			FiltrarGeral();
    			return false;
    		}
    	});
    //--></script>
</div>