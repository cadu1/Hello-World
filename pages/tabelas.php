<?php
    include("lib/connection.php");
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
    		$("#comissao_vendedor").maskMoney({allowNegative:true,showSymbol:true, symbol:"", decimal:",", thousands:"."});
    		$("#cod_vendedor").val('');
    		$("#nome_vendedor").val('');
    		
            AtualizaCategoria();
            ListarCategoria();
            ListarUnidade();
    		//ListarServicos();
    		//ListarVendedores();
    	});
    	
    	$(function () {
            $('#unid_sigla').keyup(function() {
                this.value = this.value.toUpperCase();
            });

    		$('#nome_vendedor').each(function () {
    		  //var url = dominio + diretorio() + "/vendas/AutoCompleteContato?callback=?";
    			var url = dominio + diretorio() + "/vendas/AutoCompleteContato/";
    			var autoCompelteElement = this;
    			var id = null;
    
    			$(this).autocomplete({source:url,
    				select:function (event, ui) {
    
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
    	 
    	 
    	function GravaVendedor(tipo)
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
    		
    		CarregandoAntes();
    		
    		$.post(url,{nome:$("#nome_vendedor").val()},function (data) 
    		{
    			CarregandoDurante();
    			
    			var resp = data.split("|")
    			
    			if(resp[0]==1)
    			{
    				$("#msg_loading").html(resp[1]);
    				$("#cod_vendedor").val(resp[2]);
    				
    				CarregandoDepois('',10000);	
    			}
    			else
    			{
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
        // ########## Categoria ##########
    	function LimparCategoria() {
    		$("#usuario_categoria").attr("title","Cadastrado por <?=$_COOKIE['nome']?>");
    		$("#texto_nome_categoria").html('Nova Categoria');
    		$("#id_cat").val('');
    		$("#nome_cat").val('');
    		$("#ipi").val('');
    		$("#categorias select").val('');
    	}

    	function ListarCategoria() {
    		var url = dominio + diretorio() + "/home/categoria/BuscarItens";
    
    		ajaxHTMLProgressBar('resp_categorias', url, false, false);
    	}

    	function GravarCategoria() {
    		var url = dominio + diretorio() + "/home/categoria/GravarItem";

    		CarregandoAntes();
            
            $.post(url,{id:$("#id_cat").val(),nome:$("#nome_cat").val(),ipi:$("#ipi").val(),pai:$("#categorias .categoria").val()}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0]==1)
    			{
    				$("#texto_nome_categoria").html('Nova Categoria');
    				$("#categorias select").val('');
    				$("#nome_cat").val('');
    				$("#ipi").val('');
    				$("#modal_categoria").modal('hide');

    				ListarCategoria();
                    LimparCategoria();
                    AtualizaCategoria();
    			}
    			
    			$("#msg_loading").html(resp[1]);
    			
    			CarregandoDepois('',3000);
    		});
    	}

    	function EditarCategoria(id) {
    		LimparCategoria();
    		
    		var url = dominio + diretorio() + "/home/categoria/EditarItem";
    		
    		CarregandoAntes();
    		
    		$.post(url, {id:id}, function (data) {

    			resp = data.split("|");

    			CarregandoDurante();
    			
    			if(resp[0]!=0)
    			{
    				$("#id_cat").val(resp[0]);
    				$("#usuario_categoria").attr("title","Cadastrado por "+resp[4]);
    				$("#nome_cat").val(resp[1]);
    				$("#ipi").val(resp[2]);
                    $("#categorias").html($("#cat_produto").html());
                    $("#categorias select").val(resp[3]);
    			}
                AtualizaCategoria();
                
                CarregandoDepois('',1000);
    		});
    	}

    	function DelCategoria(id) {
    		if(confirm("Deseja realmente excluir?"))
    		{	
    			var url = dominio + diretorio() + "/home/categoria/DelItem";
    			
    			CarregandoAntes();
    			
    			$.post(url, {id:id}, function (data) {
    				resp = data.split("|");
    				
    				CarregandoDurante();
    				
    				if(resp[0]==1)
    				{
    					ListarCategoria();
                        AtualizaCategoria();
    					//ListarServicos();
    				}
    				
    				$("#msg_loading").html(resp[1]);
    				
    				CarregandoDepois('',3000);
    			});
    		}
    	}
        
        function AtualizaCategoria() {
            var url = dominio + diretorio() + "/home/categoria/produto/BuscarItens";
            
            $.post(url, function(dataReturn) {
                $("#cat_produto #cat_produto_select").html('');
                $("#cat_produto #cat_produto_select").html(dataReturn);
                $("#categorias").html($("#cat_produto").html());
            });
            
            $("#categorias").html($("#cat_produto").html());
        }
        // ###############################

        // ########### Unidade ###########
    	function LimparUnidade() {
    		$("#usuario_unidade").attr("title","Cadastrado por <?=$_COOKIE['nome']?>");
    		$("#texto_nome_unidade").html('Nova Unidade');
    		$("#id_unid").val('');
    		$("#unid_sigla").val('');
    		$("#unid_nome").val('');
    	}
        
        function ListarUnidade() {
    		var url = dominio + diretorio() + "/home/unidade/BuscarItens";
    
    		ajaxHTMLProgressBar('resp_unidades', url, false, false);
    	}
        
        function GravarUnidade() {
    		var url = dominio + diretorio() + "/home/unidade/GravarItem";

    		CarregandoAntes();
            
            $.post(url,{id:$("#id_unid").val(),nome:$("#unid_nome").val(),sigla:$("#unid_sigla").val()}, function (data) {
    			resp = data.split("|");
    			
    			CarregandoDurante();
    			
    			if(resp[0]==1) {
    				$("#texto_nome_unidade").html('Nova Unidade');
    				$("#unid_nome").val('');
    				$("#unid_sigla").val('');
    				$("#modal_unidade").modal('hide');

    				ListarUnidade();
                    LimparUnidade();
    			}
    			
    			$("#msg_loading").html(resp[1]);
    			
    			CarregandoDepois('',3000);
    		});
    	}

    	function EditarUnidade(id) {
    		LimparUnidade();
    		
    		var url = dominio + diretorio() + "/home/unidade/EditarItem";
    		
    		CarregandoAntes();
    		
    		$.post(url, {id:id}, function (data) {

    			resp = data.split("|");

    			CarregandoDurante();
    			
    			if(resp[0]!=0)
    			{
    				$("#id_unid").val(resp[0]);
    				$("#usuario_categoria").attr("title","Cadastrado por "+resp[4]);
    				$("#unid_nome").val(resp[1]);
    				$("#unid_sigla").val(resp[2]);
    			}
                CarregandoDepois('',1000);
    		});
    	}

    	function DelUnidade(id) {
    		if(confirm("Deseja realmente excluir?"))
    		{	
    			var url = dominio + diretorio() + "/home/unidade/DelItem";

    			CarregandoAntes();
    			
    			$.post(url, {id:id}, function (data) {
    				resp = data.split("|");
    				
    				CarregandoDurante();
    				
    				if(resp[0]==1)
    				{
    					ListarUnidade();
    				}
    				
    				$("#msg_loading").html(resp[1]);
    				
    				CarregandoDepois('',3000);
    			});
    		}
    	}
        // #############################
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
    
    <div id="cat_produto" style="display:none">
		<select id="cat_produto_select" class="categoria">
		</select>
   	</div>
    
    <article>
    	<div class="grid_4">
    		<div class="modal hide" id="modal_categoria">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal">&#215;</button>
    				<h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_categoria">Nova Categoria</h2>
    				<i id="usuario_categoria" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por <?=$_COOKIE['nome']?>"></i></i>
    			</div>
    			<div class="modal-body">
    				<div class="form-horizontal">
    					<form>
    						<fieldset>
    							<div class="control-group">
    								<input type="hidden" name="id_cat" id="id_cat"  value="" />
                                    <div class="control-group2">
                                        <label class="control-label">Nome:</label>
    									<div class="controls">
    										<input type="text" name="nome_cat" id="nome_cat" value="" />
    									</div>
                                    </div>
                                    <div class="control-group2">
    									<label class="control-label">IPI (%):</label>
    									<div class="controls">
    										<input type="text" name="ipi" id="ipi" value="" />
    									</div>
    								</div>
                                    <div class="control-group">
										<label class="control-label"> *Categoria / Subcategoria</label>

										<div class="controls" id="categorias">
											<select name="categoria_pro" id="categoria_pro" style="width: 150px;">
											</select>
										</div>
				                    </div>
                                    <div class="control-group">
    									<div class="controls al_rgt">
    										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    										<a class="btn btn-primary" onclick="GravarCategoria();">Salvar</a>
    									</div>
    								</div>
    							</div>	
    						</fieldset>
    					</form>
    				</div>
    			</div>
    		</div>
            <div class="modal hide" id="modal_unidade">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal">&#215;</button>
    				<h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_unidade">Nova Unidade</h2>
    				<i id="usuario_unidade" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por <?=$_COOKIE['nome']?>"></i></i>
    			</div>
    			<div class="modal-body">
    				<div class="form-horizontal">
    					<form>
    						<fieldset>
    							<div class="control-group">
    								<input type="hidden" name="id_unid" id="id_unid"  value="" />
                                    <div class="control-group2">
                                        <label class="control-label">Sigla:</label>
    									<div class="controls">
    										<input type="text" name="unid_sigla" id="unid_sigla" value="" maxlength="3"/>
    									</div>
                                    </div>
                                    <div class="control-group2">
    									<label class="control-label">Nome:</label>
    									<div class="controls">
    										<input type="text" name="unid_nome" id="unid_nome" value="" />
    									</div>
    								</div>
                                    <div class="control-group">
    									<div class="controls al_rgt">
    										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    										<a class="btn btn-primary" onclick="GravarUnidade();">Salvar</a>
    									</div>
    								</div>
    							</div>	
    						</fieldset>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="modal hide" id="modal_servico">
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
    		</div>
    		
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
    					<strong class="tt_uc">Tabelas</strong>
    				</span>
    			</div>
    
    			<div class="da-panel-content">
    				<div class="da-panel-padding">
    					<div class="tabbable"> <!-- Only required for left/right tabs -->
    						<ul class="nav nav-tabs">
    							<li class="active"><a href="#tab1" data-toggle="tab">Categorias</a></li>
                                <li><a href="#tab2" data-toggle="tab">Condi&ccedil;&otilde;es de Pgto</a></li>
                                <li><a href="#tab3" data-toggle="tab">Formas Pgto</a></li>
                                <li><a href="#tab4" data-toggle="tab">Ocupa&ccedil;&otilde;es</a></li>
                                <li><a href="#tab5" data-toggle="tab">Ramos de Atividade</a></li>
                                <li><a href="#tab6" data-toggle="tab">Grupos</a></li>
                                <li><a href="#tab7" data-toggle="tab">Regi&otilde;es</a></li>
                                <li><a href="#tab8" data-toggle="tab">Grades</a></li>
                                <li><a href="#tab9" data-toggle="tab">Atributos</a></li>
                                <li><a href="#tab10" data-toggle="tab">Tipos de Embalagens</a></li>
                                <li><a href="#tab11" data-toggle="tab">Unidades</a></li>
    						</ul>
    						<div class="tab-content">
    							<div class="tab-pane in active" id="tab1">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Categorias
    											</strong>
    										</span>	
    										<span class="da-panel-btn">
    											<a class="btn btn-primary" data-toggle="modal" href="#modal_categoria" onclick="LimparCategoria();"><i  class="icon-plus icon-white"></i> Novo</a>
    										</span>
    									</span>		
    								</div>
    								<div class="row-fluid">
    									<span class="tt_uc"></span>	
    									<div id="resp_categorias">	
    									</div>	
    								</div>
    							</div>
    							<div class="tab-pane fade in" id="tab2">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Condi&ccedil;&otilde;es de Pgto
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
    								</div>
    							</div>
    							<div class="tab-pane fade in" id="tab3">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Formas Pgto
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab4">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Ocupa&ccedil;&otilde;es
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab5">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Ramos de Atividade
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab6">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Grupos
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab7">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Regi&otilde;es
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab8">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Grades
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab9">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Atributos
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab10">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Tipos de Embalagens
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
    								</div>
    							</div>
                                <div class="tab-pane fade in" id="tab11">
    								<div class="da-panel-header">
    									<span class="da-panel-title">
    										<span class="tt_uc">
    											<strong class="tt_uc">
    											   Unidades
    											</strong>
    										</span>	
    										<span class="da-panel-btn">
    											<a class="btn btn-primary" data-toggle="modal" href="#modal_unidade"><i  class="icon-plus icon-white"></i> Novo</a>
    										</span>
    									</span>		
    								</div>
    								<div class="row-fluid">
    									<span class="tt_uc"></span>	
    									<div id="resp_unidades"></div>
    								</div>
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