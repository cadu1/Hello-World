try{
    xmlhttp = new XMLHttpRequest();
}catch(ee){
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp = false;
        }
    }
}

fila = [];
ifila = 0;
erro_ajaxRunReturnText = 0;

function ajaxHTMLNoLoading(id,url,keep,display){
	
	if(!keep)
		document.getElementById(id).innerHTML = "";

    fila[fila.length] = [id,url,keep,display];

    if((ifila+1)==fila.length) ajaxRun();
}

function ajaxHTMLProgressBar(id,url,keep,display){
    
	if(!keep)
		document.getElementById(id).innerHTML = '<img src="' + base_url + '/application/img/ajax-loader-progress-bar.gif" />';
    
    fila[fila.length] = [id,url,keep,display];
    
    if((ifila+1)==fila.length) ajaxRun();
}

function ajaxHTML(id,url,keep,display){
    
	if(!keep)
		document.getElementById(id).innerHTML = '<img src="' + base_url + '/application/img/loading.gif" />';
    
    fila[fila.length] = [id,url,keep,display];
    
    if((ifila+1)==fila.length) ajaxRun();
}

function ajaxRun(){

    xmlhttp.open("GET",fila[ifila][1],true);

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4){

            retorno = unescape(xmlhttp.responseText.replace(/\+/g," "));
			
			if(fila[ifila][3]) {
			
				if(retorno == 'none')
					document.getElementById(fila[ifila][0]).style.display = 'none';
					
				if(retorno == 'block')
					document.getElementById(fila[ifila][0]).style.display = 'block';					
					
			}
			else {
			
				if(fila[ifila][2])
					document.getElementById(fila[ifila][0]).innerHTML = retorno + document.getElementById(fila[ifila][0]).innerHTML;
				else
					document.getElementById(fila[ifila][0]).innerHTML = retorno;
					
			}
				
            ifila++;
            
			if(ifila<fila.length) setTimeout("ajaxRun()",20);
        }
    }
    
    xmlhttp.send(null);
}

function ajaxRunReturnText(id,url){

	document.getElementById(id).innerHTML = '<img src="' + base_url + '/application/img/ajax-loader.gif" />';
	
	fila[fila.length] = [id,url,false,false];
	
	document.getElementById(fila[ifila][0]).style.display = 'block';
    
	if((ifila+1)==fila.length)
	{
		
		xmlhttp.open("GET",fila[ifila][1],true);

		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

				retorno = unescape(xmlhttp.responseText.replace(/\+/g," "));
			
				if(fila[ifila][3]) {
			
					if(retorno == 'none')
						document.getElementById(fila[ifila][0]).style.display = 'none';
					
					if(retorno == 'block')
						document.getElementById(fila[ifila][0]).style.display = 'block';					
					
				}
				else {
			
					if(fila[ifila][2])
					{
						document.getElementById(fila[ifila][0]).innerHTML = retorno + document.getElementById(fila[ifila][0]).innerHTML;
					}
					else
					{
						if(retorno != "-1")
						{
							document.getElementById(fila[ifila][0]).innerHTML = retorno;
							erro_ajaxRunReturnText = 1;
						} else {
							document.getElementById(fila[ifila][0]).style.display = 'none';
							document.getElementById(fila[ifila][0]).innerHTML = "";
							erro_ajaxRunReturnText = 0;
						}
					}	
				}
				
				ifila++;
				
				if(ifila<fila.length) setTimeout("ajaxRunReturnText()",2000);
				
			}
		
		}
	
		xmlhttp.send(null);
		
		return erro_ajaxRunReturnText;
	}
}