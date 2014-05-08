function StatusVinculo(vinculo, status, contato,tipo)
{
	var url = dominio+diretorio()+"/contato/StatusVinculo";
	 
	$.post(url,{vinculo: vinculo,contato:contato,status:status}, function(data)
	{
		if(data==1)
		{	
			if(tipo=='contas')
			{	
				listaVinculoContatoConta(contato,'');
			}
			if(tipo=='contatos')
			{	
				listaVinculoContatoContato(contato,'');
			}
			if(tipo=='amizade')
			{	
				listaVinculoContatoAmizade(contato,'');
			}
			if(tipo=='familia')
			{	
				listaVinculoContatoFamilia(contato,'');
			}
		}
	}); 
 	
}

function ExcluiVinculo(jsIdVinculo, jsIdContato,tipo)
{
	var url = dominio+diretorio()+"/contato/ExcluiVinculo";
	 
	$.post(url,{jsIdVinculo:jsIdVinculo,jsIdContato:jsIdContato}, function(data)
	{
		if(data==1)
		{	
			if(tipo=='contas')
			{	
				listaVinculoContatoConta(jsIdContato,'');
			}
			if(tipo=='contatos')
			{	
				listaVinculoContatoContato(jsIdContato,'');
			}
			if(tipo=='amizade')
			{	
				listaVinculoContatoAmizade(jsIdContato,'');
			}
			if(tipo=='familia')
			{	
				listaVinculoContatoFamilia(jsIdContato,'');
			}
		}
	
	});

}


function vincular_conta(contato,conta)
{	
	
	var url = dominio+diretorio()+"/contato/VincularConta";
	
	CarregandoAntes();
	
	$.post(url,{conta:conta,contato:contato,vinculo:$("#vinculo_contacontato").val(),cargo:$("#vcargo").val(),email:$("#vemail").val(),fone:$("#vfone").val(),ramal:$("#vramal").val()}, function(data)
	{
		
		CarregandoDurante();
		
		if(data==1)
		{	
			listaVinculoContatoConta(contato,'');
			$("#vcontato").val('');
			$("#vcontato").focus();
			$("#vcontatohidden").val('');
			$("#vfone").val('');
			$("#vemail").val('');
			$("#vcargo").val('');
			$("#vramal").val('');
			document.getElementById('vinculo_contacontato').selectedIndex = 0;
			$("#modal_vinculo_contacontato").modal('hide');
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

function vincular_contato(contato1,contato2,tipo)
{	
	
	var url = dominio+diretorio()+"/contato/VincularContato";
	
	CarregandoAntes();
	
	var vinculo = null;
	
	if(tipo=='contatos')
	{	
		vinculo = $("#vinculo_contatocontato").val();
	}
	if(tipo=='amizade')
	{	
		vinculo = $("#vinculo_amizade").val();
	}
	if(tipo=='familia')
	{	
		vinculo = $("#vinculo_familia").val();
	}
	
	$.post(url,{contato1:contato1,contato2:contato2,tipo:tipo,vinculo:vinculo}, function(data)
	{
		CarregandoDurante();
		
		if(data==1)
		{	
			if(tipo=='contatos')
			{	
				document.getElementById('vinculo_contatocontato').selectedIndex = 0;
				
				$("#vcontato").val('');
				
				$("#vcontato").focus();
				
				$("#vcontatohidden").val('');
				
				$("#modal_vinculo_contatocontato").modal('hide');
				
				listaVinculoContatoContato(contato1,'');
			}
			if(tipo=='amizade')
			{	
				document.getElementById('vinculo_amizade').selectedIndex = 0;
				
				$("#vamizade").val('');
				
				$("#vamizade").focus();
				
				$("#vamizadehidden").val('');
				
				$("#modal_vinculo_amizade").modal('hide');
				
				listaVinculoContatoAmizade(contato1,'');
			}
			if(tipo=='familia')
			{	
				document.getElementById('vinculo_familia').selectedIndex = 0;
				
				$("#vfamilia").val('');
				
				$("#vfamilia").val('');
				
				$("#vfamiliahidden").val('');
				
				$("#modal_vinculo_familia").modal('hide');
				
				listaVinculoContatoFamilia(contato1,'');
			}
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
			$("#msg_loading").html('V&iacute;nculo repetido');
		}
		if(data==-4)
		{
			$("#msg_loading").html('Ocorreu um erro durante o processo');
		}
	
		CarregandoDepois('loading',2000);
		
	});
	
}

function EditarVinculo(i)
{
	
	var id ="#"+i;
	
	var campo = id.split("_");
	
	var idvinc = campo[1];
	
	campo = campo[0];
	
	campo = campo.split("#");
	
	campo = campo[1];
	
	$(id).editable(dominio+diretorio()+"/contato/EditarVinculo",{
		name 		: 'valor',
		width   	: 180,
		height   	: 15,
		submitdata : {campo:campo,id:idvinc },
		submit		: 'OK',
		placeholder :"<span class='label label-info'>Adicionar +</span>"
	});

}

function SelectVinculos(jsIdVinculo, jsIdRel, jsIdContato, tipo)
{
	$("#loading").show();
	
	$.post(url = dominio+diretorio()+"/contato/SelectVinculos", {jsIdVinculo: jsIdVinculo, jsIdRel: jsIdRel, jsIdContato: jsIdContato, tipo:tipo}, function(data)
	{
		$('#vinculo'+jsIdVinculo).html(data);
		
		$("#loading").hide();
	}); 
}

function UpdateSelect(vinculo,rel,contato,tipo)
{
	
	$("#loading").show( );
	
	$.post(url = dominio+diretorio()+"/contato/EditarSelectVinculo", {vinculo: vinculo, rel: rel, contato: contato,tipo:tipo}, function(data)
	{
		if(data==1)
		{	
			if(tipo=='contas')
			{	
				listaVinculoContatoConta(contato,'');
			}
			if(tipo=='contatos')
			{	
				listaVinculoContatoContato(contato,'');
			}
			if(tipo=='amizade')
			{	
				listaVinculoContatoAmizade(contato,'');
			}
			if(tipo=='familia')
			{	
				listaVinculoContatoFamilia(contato,'');
			}
		}
		
		$("#loading").hide();
	});
}

function listaVinculoContatoFamilia(jsId,jsNome)
{
	
	var url = dominio+diretorio()+"/contato/listaVinculoContatoFamilia";
	 
	$("#loading").show(); 
	
	$.post(url, {jsId: jsId, jsNome: jsNome}, function(data)
	{
		$('#divInfoContatoFamilia').html(data)
		$("#loading").hide(); 
	});
	
}

function listaVinculoContatoAmizade(jsId,jsNome)
{
	
	var url = dominio+diretorio()+"/contato/listaVinculoContatoAmizade";
	 
	$("#loading").show(); 

	
	$.post(url, {jsId: jsId, jsNome: jsNome}, function(data)
	{
		$('#divInfoContatoAmizade').html(data)
		$("#loading").hide(); 
	});
	
}

function listaVinculoContatoContato(jsId,jsNome)
{
	$("#loading").show(); 
	
	var url = dominio+diretorio()+"/contato/listaVinculoContatoContato";
	
	$.post(url, {jsId: jsId, jsNome: jsNome}, function(data)
	{
		$('#divInfoContatoContato').html(data)
		$("#loading").hide(); 
	});
	
}

function listaVinculoContatoConta(jsId,jsNome)
{
	$("#loading").show(); 
	
	var url = dominio+diretorio()+"/contato/listaVinculoContatoConta";
	
	$.post(url, {jsId: jsId, jsNome: jsNome}, function(data)
	{
		$('#divInfoContatoConta').html(data)
		$("#loading").hide(); 
	});
	
}
