	var req;//cria um objeto xml
	if(window.XMLHttpRequest) 
	{
		req = new XMLHttpRequest();
	}
	else if(window.ActiveXObject) 
	{
   		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	function validaContInt()
	{
		
		var jsContNome = document.getElementById('nomerel');
		var jsContUn = document.getElementById('un');
		 
		if (jsContNome.value == "")
		{
			alert ("Campo Motivo invalido");
			return false;
		}		
		if (jsContUn.value == "")
		{
			alert("Campo Unidade de negÃ³cio invalido");
			return false;
		}
		else
		{
			gravar('int_contatos1');
		}	
		
	}//Fim da validaçao dos Campos de ContatosIntereçoes
	
	
	var texto = 0;
	var sHors = 0;
	var sMins = 0;
	var sSecs =  0;
	
	function getSecs()
	{  		 
		alert(sSecs);
				
		sSecs++;
		if(sSecs==60)
		{
					sSecs=0;
					sMins++;
					if(sMins<=9)
					sMins="0"+sMins;
		}
		if(sMins==60)
		{
			sMins="0"+0;
			sHors++;
			if(sHors<=9)
				sHors="0"+ 	sHors;
		}
		if(sSecs<=9)
		sSecs="0"+sSecs;
							
		idCronoHora.value = sHors; 
		idCronoMin.value = sMins; 
		idCronoSeg.value = sSecs; 
		
		setTimeout('getSecs()',1000);
	}
		
		
	function cronometro() 
	{
		getSecs();
	}

	var req;//cria um objeto xml
	if(window.XMLHttpRequest) 
	{
		req = new XMLHttpRequest();
	}
	else if(window.ActiveXObject) 
	{
   		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	
	function cronometro(jsId, jsDuracao)
	{
			//pego as variaveis com os campos 
			var jsIdtxtCadNomeFan = document.getElementById('IdtxtCadNomeFan').value;
			alert(jsId);
			alert(jsDuracao);
			
			
			
			//esse parametro eu tenho que passar em todas as chamadas do arquivo funcaos.php pois é ele que chamara a funçao que eu solicito 
			//var jsFuncao = 'gravar'; //aqui passo o valor da funçao que eu quero chamar 
			
			
			// Criar algumas variáveis ??que precisamos enviar para o nosso arquivo PHP
			var url = "controllers/crono.php";
				
		
				
//			var parametros = "CadNomeFan="+jsIdtxtCadNomeFan+"&CadNomeRs="+jsIdtxtCadNomeRs+"&CadCnpj="+jsIdtxtCadCnpj+"&CadCep="+jsIdtxtCadCep+"&CadCid="+jsIdtxtCadCid+"&Cadrua="+jsIdtxtCadrua+"&CadEst="+jsIdtxtCadEst+"&CadNum="+jsIdtxtCadNum+"&CadComp="+jsIdtxtCadComp+"&CadTel="+jsIdtxtCadTel+"&CadCon="+jsIdtxtCadCon+"&CadMail="+jsIdtxtCadMail+"&CadSite="+jsIdtxtCadSite+"&executarAcao="+jsacao+"&funcao="+jsFuncao;
			var parametros = "idDuracao="+jsId+"&tempoDuracao="+jsDuracao;
				
			
			//var parametros = "CadNomeFan"+jsIdtxtCadNomeFan
			req.open("POST", url, true);
			
			// Conjunto de informações de cabeçalho tipo de conteúdo para o envio de variáveis ??de url codificado no pedido
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			// Acessar o evento onreadystatechange para o objeto XMLHttpRequest
			req.onreadystatechange = function() 
			{
				if(req.readyState == 4 && req.status == 200) 
				{
					var return_data = req.responseText;
					//document.getElementById("status").innerHTML = return_data;
					
				}
			}
			// Enviar os dados para PHP agora ... e aguardar resposta para atualizar o status de div
			req.send(parametros); // Realmente executar o pedido
			
			//document.getElementById("status").innerHTML = "processing...";
		
	}
