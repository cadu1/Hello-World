
//Aba contas


function vincular_conta(conta1,conta2)
{	
	
	var url = dominio+diretorio()+"/contas/VincularConta";
	
	CarregandoAntes();
	
	$.post(url,{conta1: conta1,conta2:conta2,vinculo:$("#vinculo_contaconta").val()}, function(data)
	{
		CarregandoDurante();
		
		if(data==1)
		{	
			listaVinculoConta(conta1,'');
			$("#vconta").val('');
			$("#vconta").focus();
			$("#vcontahidden").val('');
			document.getElementById('vinculo_contaconta').selectedIndex = 0;
			$("#modal_vinculo_contaconta").modal('hide');
		}
		if(data==-1)
		{
			$("#msg_loading").html('Informe o v&iacute;nculo');
		}
		if(data==-2)
		{
			$("#msg_loading").html('Informe a conta');
		}
		if(data==-3)
		{
			$("#msg_loading").html('V&iacute;nculo repetido');
		}
		if(data==-4)
		{
			$("#msg_loading").html('Ocorreu um erro durante o processo');
		}
		
		CarregandoDepois('loading',2000);
		
	});
	
}

function StatusVinculoConta(vinculo, status, conta)
{
	var url = dominio+diretorio()+"/contas/StatusVinculo";
	 
	$.post(url,{vinculo: vinculo,conta:conta,status:status}, function(data)
	{
		listaVinculoConta(conta,'');
	}); 
 
	
	
}

function EditarVinculoConta(i)
{
	
	var id ="#"+i;
	
	var campo = id.split("_");
	
	var idvinc = campo[1];
	
	campo = campo[0];
	
	campo = campo.split("#");
	
	campo = campo[1];
	
	$(id).editable(dominio+diretorio()+"/contas/EditarVinculo",{
		name 		: 'valor',
		width   	: 180,
		height   	: 15,
		submitdata : {campo:campo,id:idvinc },
		submit		: 'OK',
		placeholder :"<span class='label label-info'>Adicionar +</span>"
	});

}

function listaVinculoConta(jsId,jsNome)
{
	
	if(jsNome==undefined)
	{
		var jsNome = "";
	
	}
	
	var url = dominio+diretorio()+"/contas/listaVinculoConta";
	
	$("#loading").show();
	
	$.post(url,{jsId:jsId,jsNome:jsNome}, function(data)
	{
		document.getElementById("divInfoConta").innerHTML = data;
		
		$("#loading").hide();
	
	});

}

function excluiVinculoConta(jsIdVinculo, jsIdConta)
{
	var url = dominio+diretorio()+"/contas/excluiVinculoConta";
	 
	$.post(url,{jsIdVinculo:jsIdVinculo,jsIdConta:jsIdConta}, function(data)
	{
		document.getElementById("divInfoConta").innerHTML = data;
		
		listaVinculoConta(jsIdConta,'');
		
		$("#loading").hide();
	
	});

}

function alterarVinculoContaConta(jsIdVinculo, jsIdRel, jsIdConta)
{

		$("#loading").show(); // ou slideUp()
				
		$.post(url = dominio+diretorio()+"/contas/alterarVinculoContaConta", {jsIdVinculo: jsIdVinculo, jsIdRel: jsIdRel, jsIdConta: jsIdConta}, function(data)
        {
            $('#vinculo'+jsIdVinculo).html(data)
			$("#loading").hide();
        });

}


function alterarVinculoContaContaControler(jsIdVinculo, jsIdRel, jsIdConta){
	
	$("#loading").show();
	
	$.post(url = dominio+diretorio()+"/contas/alterarVinculoContaContaControler", {jsIdVinculo: jsIdVinculo, jsIdRel: jsIdRel, jsIdConta: jsIdConta}, function(data)
	{
		$('#divInfoConta').html(data)
		$("#loading").hide(); // ou slideUp()
	});
}

// Aba contatos

function vincular_contato(conta,contato)
{	
	
	var url = dominio+diretorio()+"/contas/VincularContato";
	
	CarregandoAntes();
	
	$.post(url,{conta:conta,contato:contato,vinculo:$("#vinculo_contacontato").val(),cargo:$("#vcargo").val(),email:$("#vemail").val(),fone:$("#vfone").val(),ramal:$("#vramal").val()}, function(data)
	{
		CarregandoDurante();
		
		if(data==1)
		{	
			listaVinculoContato(conta,'');
			$("#vcontato").val('');
			$("#vcontato").focus();
			$("#vcontatohidden").val('');
			$("#vfone").val('');
			$("#vemail").val('');
			$("#vcargo").val('');
			$("#vramal").val('');
			$("#modal_vinculo_contacontato").modal('hide');
			document.getElementById('vinculo_contacontato').selectedIndex = 0;
		}
		if(data==-1)
		{
			$("#msg_loading").html('Informe o v&iacute;nculo');
		}
		if(data==-2)
		{
			$("#msg_loading").html('Informe o contato');
		}
		if(data==-3)
		{
			$("#msg_loading").html('V&iacute;nculo v&iacute;nculo');
		}
		if(data==-4)
		{
			$("#msg_loading").html('Ocorreu um erro durante o processo');
		}
		
		CarregandoDepois('loading',2000);
	
	});
	
}

function listaVinculoContato(conta,jsNome)
{
	if(jsNome==undefined)
	{
		var jsNome = "";
	
	}
	
	$("#loading").show();
	
	$.post(url = dominio+diretorio()+"/contas/listaVinculoContato", {conta: conta,jsNome:jsNome}, function(data)
	{
		$('#divInfoContato').html(data);
		
		$("#loading").hide();	
	});

	
}

function alterarVinculoContaContato(jsIdVinculo, jsIdRel,jsIdConta)
{

	$("#loading").show();
			
	$.post(url = dominio+diretorio()+"/contas/alterarVinculoContaContato", {jsIdVinculo: jsIdVinculo, jsIdRel: jsIdRel,jsIdConta: jsIdConta}, function(data)
	{
		$('#vinculo'+jsIdVinculo).html(data)
		$("#loading").hide(); 
	}); 



}

function alterarVinculoContaContatoControler(jsIdVinculo, jsIdRel, jsIdConta)
{
	$("#loading").show( );
	
	$.post(url = dominio+diretorio()+"/contas/alterarVinculoContaContatoControler", {jsIdVinculo: jsIdVinculo, jsIdRel: jsIdRel, jsIdConta: jsIdConta}, function(data)
	{
		$('#divInfoContato').html(data)
		$("#loading").hide();
	});
}

function excluiVinculoContato(jsId, jsCliente)
{
	 
	var url = dominio+diretorio()+"/contas/excluiVinculoConta";
	 
	$("#loading").show( );
	
	$.post(url,{jsIdVinculo:jsId,jsIdConta:jsCliente}, function(data)
	{
		
		listaVinculoContato(jsCliente,'');
		
		$("#loading").hide();
	
	});

	
}

function StatusVinculoContato(vinculo, status, conta)
{
	var url = dominio+diretorio()+"/contas/StatusVinculo";
	 
	$.post(url,{vinculo: vinculo,conta:conta,status:status}, function(data)
	{
		listaVinculoContato(conta,'');
	}); 
 	
}

function controlecampos(valor)
{
	if((valor!="r")&&(document.getElementById('rural').checked==true))
	{
		alert("Desmarque o campo rural");
			
		return false;
	}
	if((valor!="o")&&(document.getElementById('ong').checked==true))
	{
		alert("Desmarque o campo ONG");
		return false;		
	
	}		
	switch(valor)
	{
		case "r": document.getElementById('industria').checked = false;document.getElementById('comercio').checked = false;document.getElementById('servico').checked = false;document.getElementById('ong').checked = false;break;
		case "o": document.getElementById('industria').checked = false;document.getElementById('comercio').checked = false;document.getElementById('servico').checked = false;document.getElementById('rural').checked = false;break;
	
	
	}

	return true;

}


$(function()
{  
	$("#data").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Tera','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','Sb','Dom'  
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

$(function()
{  
	$("#data_followup").datepicker({  
		dateFormat: 'dd/mm/yy',  
		dayNames: [  
		'Domingo','Segunda','Tera','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'  
		],  
		dayNamesMin: [  
		'D','S','T','Q','Q','S','S','D'  
		],  
		dayNamesShort: [  
		'Dom','Seg','Ter','Qua','Qui','Sex','Sb','Dom'  
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

function busca_cidades(estado)
{
	var url = dominio+diretorio()+"/crm/BuscaCidades";
		
	if(estado) 
	{
		$('#resp_cidade').html("<img src='"+dominio+diretorio()+"/application/img/ajax-loader-progress-bar.gif"+"'>");
		$.post(url,{cod_estados: estado}, function(data){
			$('#resp_cidade').html(data);
		});
	}

}

function AddEndereco()
{
	var url = dominio+diretorio()+"/crm/AddEndereco/conta";
	
	var conta = $("#cod_conta").val();
	
	var cep = $("#cep").val();
	
	var rua = $("#rua").val();
	
	var num = $("#numero").val();
	
	var comp = $("#complemento").val();
	
	var bairro = $("#bairro").val();
	
	var cidade = $("#cidade").val();
	
	$("#loading").show();


	$.post(url,{conta:conta,cep:cep,rua:rua,num:num,comp:comp,bairro:bairro,cidade:cidade},function(data)
	{
		var resp = data.split("|");
		
		
		if(resp[0]!="0")
		{
			BuscaEnderecos();
		}
		
		
		$("#loading").html(resp[1]);
	
	});

}

function BuscaEnderecos()
{
	var url = dominio+diretorio()+"/crm/BuscaEndereco/<?php echo $form_data['action'] ?>/conta/<?php echo $form_data['cod_conta']; ?>";
	ajaxHTMLProgressBar('resp_enderecos',url,false,false);
}

function RemoverEndereco(endereco)
{
	var url = dominio+diretorio()+"/crm/RemoverEndereco/conta";
	
	$("#loading").show();
	
	
	$.post(url,{endereco:endereco}, function(data)
	{
		var resp = data.split("|");
		
		
		if(resp[0]!="0")
		{
			BuscaEnderecos();
		}
		
		
		$("#loading").html(resp[1]);
		
	});// Fim do POST


}

$('#frmendereco').keydown(function(e) 
{
	if (e.keyCode == 13) {
		AddEndereco();
		return false;
	}
});


function EditarEnderecos(i)
{
	
	var id ="#"+i;
	
	var campo = id.split("_");
	
	var idend = campo[1];
	
	campo = campo[0];
	
	campo = campo.split("#");
	
	campo = campo[1];
	
	$(id).editable(dominio+diretorio()+"/crm/EditarEndereco/conta",{
		name 		: 'valor',
		width   	: 180,
		height   	: 15,
		tooltip 	: 'Clique para editar',
		submitdata : {campo:campo,id:idend },
		submit		: 'OK',
	});


}
