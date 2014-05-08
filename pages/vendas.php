<?php
    include("function.php");
?>
<div id="da-content-area">
    <script>
    	$(document).ready(function () {
    		$("#venda_produto").maskMoney({allowNegative:true,showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#ipi").maskMoney({allowNegative:true,showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#comi").maskMoney({allowNegative:true,showSymbol:true, symbol:"", decimal:",", thousands:"."});
    		$("#custo_produto").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
    		$("#venda_servico").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
    		$("#custo_servico").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
    		$("#qtd_produto").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#cod_barra").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
    		$("#comissao_vendedor").maskMoney({allowNegative:true,showSymbol:true, symbol:"", decimal:",", thousands:"."});

    		ListarProdutos();
    		//ListarVendedores();
    	});
    	
    	$(function () {
    		$('#nome_vendedor').each(function () {
    			var url = dominio + diretorio() + "/home/AutoCompleteContato";
    			var autoCompelteElement = this;
    			var id = null;
    
    			$(this).autocomplete({
                    source:url,
    				select:function(event, ui) {
                        if((ui.item.id=="novo_contato")||(ui.item.id=="nova_conta"))
    					{
    						GravaVendedor(ui.item.id);
    					}
    					else
    					{
    						id = ui.item.id;
    
    						$("#cod_vendedor").val(id);	
    					}
    
    				   $(autoCompelteElement).val(ui.item.label);
    				}
    			});
    		});
    	 });
    	 
         //########### FORNECEDOR ###########
         $(function () {
    		$('#nome_fornec').each(function () {
    			var url = dominio + diretorio() + "/home/AutoCompleteFornecedor";
    			var autoCompelteElement = this;
    			var id = null;
    
    			$(this).autocomplete({
                    source:url,
    				select:function(event, ui) {
                        if((ui.item.id=="novo_contato")||(ui.item.id=="nova_conta")) {
    						GravaFornecedor(ui.item.id);
    					} else {
    						id = ui.item.id;
    						$("#cod_fornec").val(id);	
    					}

    				   $(autoCompelteElement).val(ui.item.label);
    				}
    			});
    		});
    	 });
         
         function GravaFornecedor(tipo) {
    		var url = dominio + diretorio();
    		
    		if(tipo=="novo_contato") {
    			url+="/home/contato/GravarContato";
    			tipo = "contato";
    		}
    	
    		if(tipo=="nova_conta") {
    			url+="/home/conta/GravarConta";
    			tipo = "conta";
    		}
    		
    		CarregandoAntes();
    		
    		$.post(url,{nome:$("#nome_vendedor").val()},function (data) {
    			CarregandoDurante();
    			
    			var resp = data.split("|")
    			
    			if(resp[0]==1) {
    				$("#msg_loading").html(resp[1]);
    				$("#cod_vendedor").val(resp[2]);

    				CarregandoDepois('',10000);
    			} else {
    				CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
    			}
    		});
        }
        //###############################
    	 
    	function GravaVendedor(tipo) {
    		var url = dominio + diretorio();
    		
    		if(tipo=="novo_contato")
    		{
    			url+="/home/contato/GravarContato";
    		
    			tipo = "contato";
    		}
    	
    		if(tipo=="nova_conta")
    		{
    			url+="/home/conta/GravarConta";
    			
    			tipo = "conta";
    		}
    		
    		CarregandoAntes();
    		
    		$.post(url,{nome:$("#nome_vendedor").val()},function (data) {
    			CarregandoDurante();
    			
    			var resp = data.split("|")
    			
    			if(resp[0]==1) {
    				$("#msg_loading").html(resp[1]);
    				$("#cod_vendedor").val(resp[2]);

    				CarregandoDepois('',10000);
    			} else {
    				CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
    			}
    		});
    	}
    	
    	function AddVendedor(tipo)
    	{
    		var url = dominio + diretorio() + "/vendas/AddVendedor";
    		
    		CarregandoAntes();
    		
    		$.post(url,{id:$("#cod_vendedor").val(),valor:$("#comissao_vendedor").val(),data_comissao:$("#data_comissao_vendedor").val()}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0]==1)
    			{
    				$("#nome_vendedor").val('');
    				$("#cod_vendedor").val('');
    				$("#data_comissao_vendedor").val('');
    				$("#comissao_vendedor").val('');
    				$("#modal_vendedor").modal('hide');
    
    				ListarVendedores();
    			}
    			
    			$("#msg_loading").html(resp[1]);
    			
    			CarregandoDepois('',3000);
    		});
    	}
    	
    	function DelVendedor(id)
    	{
    		if(confirm("Deseja realmente excluir?"))
    		{	
    			var url = dominio + diretorio() + "/vendas/DelVendedor";
    			
    			CarregandoAntes();
    			
    			$.post(url, {id:id}, function (data) {
    				resp = data.split("|");
    				
    				CarregandoDurante();
    				
    				if(resp[0]==1)
    				{
    					ListarVendedores();
    				}
    				
    				$("#msg_loading").html(resp[1]);
    				
    				CarregandoDepois('',3000);
    			});
    		}
    	}
    	
    	function ListarVendedores()
    	{
    		var url = dominio + diretorio() + "/home/vendedores/BuscarItens";
    
    		ajaxHTMLProgressBar('resp_vendedores', url, false, false);
    	}
    	
    	function EditarInfoVendedores(i)
    	{
    		var id ="#"+i;
    		var campo = id.split("_");
    		var idvinc = campo[1];
    		
    		campo = campo[0];
    		campo = campo.split("#");
    		campo = campo[1];
    		
    		if(campo=="comissao")
    		{
    			id_input = 'money';
    		}
    		
    		if(campo=="data")
    		{
    			id_input = 'numerico';
    		}
    		
    		$(id).editable(dominio+diretorio()+"/vendas/EditarInfoVendedor",{
    			name 		: 'valor',
    			data		: ' ',
    			id			: id_input,
    			width   	: 180,
    			height   	: 15,
    			submitdata  : {campo:campo,id:idvinc },
    			submit		: 'OK',
    			placeholder :"<span class='label label-info'>Adicionar+</span>",
    		});
    	}

        //########### PRODUTO ########### 
    	function LimparProduto() {
            $("#usuario_produto").attr("title","Cadastrado por <?=$_COOKIE['nome']?>");
            $("#texto_nome_produto").html('Novo Produto');
            $("#id_produto").val('');
            $("#cat").val('');
            $("#nome_produto").val('');
            $("#venda_produto").val('');
            $("#ref").val('');
            $("#cod_barra").val('');
            $("#ipi").val('');
            $("#desc").val('');
            $("#esp").val('');
            $("#cod_fornec").val('');
            $("#nome_fornec").val('');
            $("#unid").val('');
            $("#a").attr("checked",true);
    	}
    	
    	function ListarProdutos() {
    		var url = dominio + diretorio() + "/home/produto/BuscarItens";
    
    		ajaxHTMLProgressBar('resp_produtos', url, false, false);
    	}

    	function GravarProduto() {
    		var url = dominio + diretorio() + "/home/produto/GravarItem";
            var status = $("input[name='ativo']:checked").val();

    		CarregandoAntes();
            
            $.post(url,{id:$("#id_produto").val(),ref:$("#ref").val(),codb:$("#cod_barra").val(),nome:$("#nome_produto").val(),codf:$("#cod_fornec").val(),venda:$("#venda_produto").val(),ipi:$("#ipi").val(),ativo:status,comp:$("#desc").val(),cat:$("#cat").val(),unid:$("#unid").val(),espec:$("#esp").val()}, function (data) {

    			resp = data.split("|");

    			CarregandoDurante();

    			if(resp[0]==1) {
    				$("#texto_nome_produto").html('Novo Produto');
    				$("#modal_produto").modal('hide');

    				LimparProduto();
    				ListarProdutos();
                    
                    alert("entrou");
    			}

    			$("#msg_loading").html(resp[1]);

    			CarregandoDepois('',3000);
    		});
    	}
    
    	function EditarProduto(id) {
    		LimparProduto();
    		
    		var url = dominio + diretorio() + "/home/produto/EditarItem";
    		
    		CarregandoAntes();
    		
    		$.post(url, {id:id}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0] != 0) {
                    $("#usuario_produto").attr("title","Cadastrado por "+resp[1]);
    				$("#id_produto").val(resp[0]);
    				$("#cat select").val(resp[1]);
                    $("#nome_produto").val(resp[2]);
                    $("#venda_produto").val(resp[3].replace(".", ","));
                    $("#ref").val(resp[5]);
                    $("#cod_barra").val(resp[6]);
                    $("#ipi").val(resp[7].replace(".", ","));
                    $("#desc").val(resp[8]);
                    $("#esp").val(resp[9]);
                    $("#cod_fornec").val(resp[10]);
                    $("#unid select").val(resp[11]);
                    $("#nome_fornec").val(resp[15]);

                    if(resp[4] == 0) {
                        $("#i").attr("checked",true);
                    } else {
                        $("#a").attr("checked",true);
                    }
    			}

    			CarregandoDepois('',1000);
    		});
    	}
    
    	function DelProduto(id) {
    		if(confirm("Deseja realmente excluir?")) {	
    			var url = dominio + diretorio() + "/home/produto/DelItem";
    			
    			CarregandoAntes();
    			
    			$.post(url, {id:id}, function (data) {
    				resp = data.split("|");
    				
    				CarregandoDurante();
    				
    				if(resp[0]==1) {
    					ListarProdutos();
    				}
    				
    				$("#msg_loading").html(resp[1]);
    				
    				CarregandoDepois('',3000);
    			});
    		}
    	}
        //############################### 
    	
    	function LimparServico()
    	{
    		$("#usuario_servico").attr("title","Cadastrado por Carlos Oliveira");
    		$("#texto_nome_servico").html('Novo Servi&ccedil;o');
    		$("#id_servico").val('');
    		$("#nome_servico").val('');
    		$("#venda_servico").val('');
    		$("#custo_servico").val('');
    	}
    	
    	function ListarServicos()
    	{
    		var url = dominio + diretorio() + "/home/servico/BuscarItens";
    
    		ajaxHTMLProgressBar('resp_servicos', url, false, false);
    	}
    	
    	function GravarServico()
    	{
    		var url = dominio + diretorio() + "/vendas/GravarItem/servico";
    		
    		CarregandoAntes();
    		
    		$.post(url,{id:$("#id_servico").val(),nome:$("#nome_servico").val(),venda:$("#venda_servico").val(),custo:$("#custo_servico").val()}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0]==1)
    			{
    				$("#texto_nome_servico").html('Novo Servi&ccedil;o');
    				$("#id_servico").val('');
    				$("#nome_servico").val('');
    				$("#venda_servico").val('');
    				$("#custo_servico").val('');
    				$("#modal_servico").modal('hide');
    				
    				LimparServico();
    				ListarServicos();
    			}
    			
    			$("#msg_loading").html(resp[1]);
    			
    			CarregandoDepois('',3000);
    		});
    	}
    
    	function EditarServico(id)
    	{
    		LimparServico();
    		
    		var url = dominio + diretorio() + "/vendas/EditarItem/servico";
    		
    		CarregandoAntes();
    		
    		$.post(url, {id:id}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0]!=0)
    			{
    				$("#id_servico").val(resp[0]);
    				$("#usuario_servico").attr("title","Cadastrado por "+resp[1]);
    				$("#texto_nome_servico").html(resp[2]);
    				$("#nome_servico").val(resp[2]);
    				$("#venda_servico").val(resp[3]);
    				$("#custo_servico").val(resp[4]);
    			}

    			CarregandoDepois('',1000);
    		});
    	}
    
    	function DelServico(id)
    	{
    		if(confirm("Tem certeza que deseja excluir?"))
    		{	
    			var url = dominio + diretorio() + "/vendas/DelItem/servico";
    			
    			CarregandoAntes();
    			
    			$.post(url, {id:id}, function (data) {
    				resp = data.split("|");
    				
    				CarregandoDurante();
    				
    				if(resp[0]==1)
    				{
    					ListarProdutos();
    					ListarServicos();
    				}
    				
    				$("#msg_loading").html(resp[1]);
    				
    				CarregandoDepois('',3000);
    			});
    		}
    	}
    	
    	function GravarPersonalizacao()
    	{
    		var url = dominio + diretorio() + "/vendas/GravarPersonalizacao";
    			
    		CarregandoAntes();
    		
    		$.post(url, {personalizar:$("#personalizar_pedidos_oportunidades").val()}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0]==1)
    			{
    				$("#msg_erro").hide();
    				$("#msg_sucesso").show();
    				$("#msg_sucesso").html(resp[1]);
    			}
    			else
    			{
    				$("#msg_sucesso").hide();
    				$("#msg_erro").show();
    				$("#msg_erro").html(resp[1]);
    			}
    			
    			CarregandoDepois('',1000);
    		});
    	}
    </script>
    
    <article>
    	<!--div  class="modal fade hide hidden-phone" id="started_vendas">
    		<a href="#" class="p_abs" style="z-index: 9999; right: -40px; top: -10px;" data-dismiss="modal"><img  src="application/img/close_button.png" class="max_w"/> </a>
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" onclick="CancelaVideo('Vendas');">&#215;</button>
    			<h2 class="pr_5 mr_0" style="display:inline;">
    				V&iacute;deo Tutorial - M&oacute;dulo Vendas
    			</h2>
    			<i title="Acessando pela primeira vez? Este v&iacute;deo ir&aacute; te ajudar, para n&atilde;o visualiz&aacute;-lo mais selecione a op&ccedil;&atilde;o abaixo do v&iacute;deo e feche esta caixa. Para ver novamente basta clicar no icone ao lado da palavra vendas" id="tip_video_vendas" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);"></i>
    		</div>
    		<div class="modal-body">
    			<iframe width="530" height="315" src="http://www.youtube.com/embed/HestQhWssak" frameborder="0" allowfullscreen></iframe>
    			
    			<label class="checkbox inline">
    				<input type="checkbox" id="check_video" name="check_video"/>N&atilde;o exibir mais este v&iacute;deo automaticamente
    			</label>
    		</div>
    	</div-->
    				
    	
    	<div class="grid_4">
    		<div class="modal hide" id="modal_produto">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal">&#215;</button>
    				<h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_produto">Novo Produto</h2>
    				<i id="usuario_produto" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por <?=$_COOKIE['nome']?>"></i>
    			</div>
    			<div class="modal-body">
    				<div class="form-horizontal">
    					<form>
    						<fieldset>
    							<div class="control-group">
    								<input type="hidden" name="id_produto" id="id_produto"  value="" />

                                    <div class="control-group2">
                                        <label class="control-label">Referencia:</label>
    									<div class="controls">
    										<input type="text" name="ref" id="ref" value="" />
    									</div>
                                    </div>

                                    <div class="control-group2">
                                        <label class="control-label">C&oacute;d. Barras:</label>
    									<div class="controls">
    										<input type="text" name="cod_barra" id="cod_barra" value="" maxlength="13"/>
    									</div>
                                    </div>
                                    
    								<div class="control-group2">
    									<label class="control-label">*Nome do Produto:</label>
    									<div class="controls">
    										<input type="text" name="nome_produto" id="nome_produto" class="input_maior" value="" />
    									</div>
    								</div>

                                    <div class="control-group2">
    									<label class="control-label">*Categoria:</label>
    									<div class="controls">
    										<select name="cat" id="cat" style="width: 206px;">
                                                <?php
                                                    montarCategoria();
                                                ?>
    										</select>
    									</div>
								    </div>
                                    
                                    <div class="control-group2">
    									<label class="control-label">*Fornecedor:</label>
    									<div class="controls">
                                        
                                            <label class="btn-group">
	       										<input type="text" class="input-medium ui-autocomplete-input" id="nome_fornec" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
											</label>
                                            <input type="hidden" id="cod_fornec" value=""/>
    									</div>
								    </div>

    								<div class="control-group2">
    									<label class="control-label">Valor de Venda:</label>
    
    									<div class="controls">
    										<input type="text" name="venda_produto" id="venda_produto" class="input_menor" value="" />
    									</div>
    								</div>

                                    <div class="control-group2">
    									<label class="control-label">% IPI:</label>
    									<div class="controls">
    										<input type="text" name="ipi" id="ipi" value="" />
    									</div>
    								</div>
                                    
                                    <div class="control-group2">
    									<label class="control-label">*Unidade:</label>
    									<div class="controls">
    										<select name="unid" id="unid" style="width: 206px;">
                                                <?php
                                                    $unid = mysql_query("SELECT * FROM `unidade_medida`");
                                                    while($unidades = mysql_fetch_array($unid)) {
                                                        echo "<option  value='{$unidades["unidade_medida_id"]}'>{$unidades["unidade_medida_nome"]}</option>";
                                                    }
                                                ?>
    										</select>
    									</div>
								    </div>
                                    
                                    <div class="control-group2">
                                	    <label class="control-label">Situa&ccedil;&atilde;o:</label>
                                	
                                	    <div class="controls">
        									<div class="pr_5">
                                	        	<label class="radio inline">
                                	            	<input type="radio" name="ativo" value="1" id="a"/>Ativo
        										</label>
                                	            <label class="radio inline">
                                	            	<input type="radio" name="ativo" value="0" id="i"/>Inativo
                                	            </label>
        									</div>
        								</div>
                                	</div>
                                    
                                    <div class="control-group2">
    									<label class="control-label">Descri&ccedil;&atilde;o:</label>
    									<div class="controls">
    										<textarea class="input_full" name="desc" id="desc"></textarea>
    									</div>
    								</div>
                                    
                                    <div class="control-group2">
    									<label class="control-label">Especifica&ccedil;&otilde;es:</label>
    									<div class="controls">
    										<textarea class="input_full" name="esp" id="esp"></textarea>
    									</div>
    								</div>
                                    <div class="control-group">
    									<div class="controls al_rgt">
    										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    										<a class="btn btn-primary" onclick="GravarProduto();">Salvar</a>
    									</div>
								    </div>
    							</div>	
    						</fieldset>
    					</form>
    				</div>
    			</div>
    		</div>
    		<!--div class="modal hide" id="modal_servico">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal">&#215;</button>
    				<h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_servico">Novo Servi&ccedil;o</h2>
    				<i id="usuario_servico" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por Carlos Oliveira"></i>
    			</div>
    			<div class="modal-body">
    				<div class="form-horizontal">
    					<form>
    						<fieldset>
    							<div class="control-group">
    								<input type="hidden" name="id_servico" id="id_servico"  value="" />
    								
    								<div class="control-group">
    									<label class="control-label">*Servi&ccedil;o:</label>
    									
    									<div class="controls">
    										<input type="text" name="nome_servico" id="nome_servico" class="input_maior" value="" />
    									</div>
    								</div>
    								<div class="control-group">
    									<label class="control-label">*Valor de Venda:</label>
    
    									<div class="controls">
    										<input type="text" name="venda_servico" id="venda_servico" class="input_menor" value="" />
    									</div>
    								</div>
    								<div class="control-group">
    									<label class="control-label">*Valor de Custo:</label>
    									<div class="controls">
    										<input type="text" name="custo_servico" id="custo_servico" value="" />
    									</div>
    								</div>
    								<div class="control-group">
    									<div class="controls al_rgt">
    										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    										<a class="btn btn-primary" onclick="GravarServico();">Salvar</a>
    									</div>
    								</div>
    							</div>	
    						</fieldset>
    					</form>
    				</div>
    			</div>
    		</div-->
    		
    		<div class="modal hide" id="modal_vendedor">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal">&#215;</button>
    				<h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_vendedor"></h2>
    			</div>
    			<div class="modal-body">
    				<div class="form-horizontal">
    					<form>
    						<fieldset>
    							<div class="control-group">
    								<div class="control-group">
    									<label class="control-label">Comiss&atilde;o (%):</label>
    									
    									<div class="controls">
    										<input type="text" name="comissao_vendedor" id="comissao_vendedor" class="input_maior" value="" />
    									</div>
    								</div>
    								<div class="control-group">
    									<label class="control-label">Dia de pagamento:</label>
    
    									<div class="controls">
    										<input  maxlength="2" placeholder="dd" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);" type="text" name="data__vendedor" id="data_comissao_vendedor" class="input_menor" value="" />&nbsp;(dd)
    									</div>
    								</div>
    								<div class="control-group">
    									<div class="controls al_rgt">
    										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    										<a class="btn btn-primary" onclick="AddVendedor();">Salvar</a>
    									</div>
    								</div>
    							</div>	
    						</fieldset>
    					</form>
    				</div>
    			</div>
    		</div>
    		
    		<div class="da-panel">
    			<div class="da-panel-header">
    				<span class="da-panel-title">
    					<span class="label label-inverse pr_5"><i class="icon-user icon-white"></i></span>
    					<strong class="tt_uc">Vendas</strong>
						<!--a href="#started_vendas" data-toggle="modal"  title="Clique aqui para ver o v&iacute;deo tutorial">
							<i class="icon-facetime-video icon-black"></i>
						</a-->
    				</span>
    			</div>
    
    			<div class="da-panel-content">
    				<div class="da-panel-padding">
    					<div class="tabbable"> <!-- Only required for left/right tabs -->
    						<ul class="nav nav-tabs">
    							<li class="active"><a href="#tab0" data-toggle="tab">Personalizar</a></li>
    							<li><a href="#tab1" data-toggle="tab">Produtos</a></li>
    							<li><a href="#tab2" data-toggle="tab">Servi&ccedil;os</a></li>
    							<li><a href="#tab3" data-toggle="tab">Vendedores</a></li>
    						</ul>
    						<div class="tab-content">
    							<div class="tab-pane fade in active" id="tab0">	
    								<!--div class="da-panel-padding" align="center">
    									<div id="msg_sucesso" class="alert alert-success" style="display:none;"></div>
    									<div  id="msg_erro" class="alert alert-error" style="display:none;"></div>
    									<form class="form-horizontal">
    										<fieldset>
    											<div class="control-group">
    												<div>
    													Ao selecionar esta op&ccedil;&atilde;o, voc&ecirc; poder&aacute; gerar um pedido com mais agilidade na tela de oportunidades! Efetue a venda e envie direto para o financeiro! ;)
    													Veja mais detalhes <a href="http://<?=$_SERVER['HTTP_HOST']?>/application/img/pedido_oportunidade.jpg" target="_blank">aqui</a>
    												</div>
    												<br/><br/>
    												<div>	
    													<label style="width:600px;" class="control-label"> Permitir que usu&aacute;rios n&atilde;o administradores gerem e faturem pedidos direto em oportunidades?&nbsp;&nbsp;</label>
    													<div class="controls al_lft">
    														<select name="personalizar_pedidos_oportunidades" id = "personalizar_pedidos_oportunidades">
   																<option value="0" SELECTED>N&atilde;o</option>
   																<option value="1" >Sim</option>
    														</select>	
    													</div>
    												</div>
    											</div>
    										</fieldset>	
    								
    										<div class="form-actions al_rgt">
    											<label class="btn btn-inverse" onClick="JavaScript: window.history.back();return false;">
    												<i class="icon-remove icon-white"></i> Cancelar
    											</label>
    
    											<label href="javascript:void(0)" onclick="GravarPersonalizacao();" class="btn btn-success"><i
    													class="icon-ok icon-white"></i> Salvar
    											</label>
    										</div>
    									</form>
    								</div-->
    							</div>
    							<div class="tab-pane fade in" id="tab1">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Produtos
    											</strong>
    										</span>	
    										<span class="da-panel-btn">
    											<a class="btn btn-primary" data-toggle="modal" href="#modal_produto" onclick="LimparProduto();"><i  class="icon-plus icon-white"></i> Novo</a>
    										</span>
    									</span>		
    								</div>
    								<div class="row-fluid">
    									<span class="tt_uc"></span>	
    									<div id="resp_produtos">
    									</div>	
    								</div>
    							</div>
    							<div class="tab-pane fade in" id="tab2">
    								<!--div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Servi&ccedil;os
    											</strong>
    										</span>	
    										<span class="da-panel-btn">
    											<a class="btn btn-primary" data-toggle="modal" href="#modal_servico"><i  class="icon-plus icon-white"></i> Novo</a>
    										</span>
    									</span>		
    								</div>
    								<div class="row-fluid">
    									<span class="tt_uc"></span>	
    									<div id="resp_servicos"></div>
    								</div-->
    							</div>
    							<div class="tab-pane fade in" id="tab3">
    								<!--fieldset>
    									<div class="container-fluid da-additem">
    										<div class="row-fluid">
    											<div class="span12 al_ctr">
    												<h4 class="subtit_conteudo">
    													<strong>Vendedores</strong>
    													<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_abas" title="Para adicionar vendedores, digite o nome de um contato que j&aacute; exista ou crie um novo. Ap&oacute;s isso clique em 'adicionar vendedor'. Ao excluir o vendedor, o contato permanece no sistema sem a situa&ccedil;&atilde;o 'vendedor'."></i>
    												</h4>
                                                    <hr/>
    											</div>
    										</div>
    										<div class="row-fluid">
    											<div class="form-inline al_ctr">
    												<div class="form-inline al_ctr">
    													<label class="btn-group">
    														<input type="text" class="input-medium search-query" id="nome_vendedor"/>
    													</label>
    													
    													<input type="hidden" id="cod_vendedor"/>
    													
    													<a data-toggle="modal" href="#modal_vendedor" class="btn btn-inverse" onclick="$('#texto_nome_vendedor').html($('#nome_vendedor').val());$('#comissao_vendedor').val('');$('#data_comissao_vendedor').val('');">
    														<i class="icon-user icon-white"></i>Adicionar Vendedor
    													</a>
    												</div>
    											</div>
    										</div>
    										<div class="row-fluid" id="resp_vendedores" align="center"></div>
    									</div>
    								</fieldset-->
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="clear"></div>
    </article>
</div>