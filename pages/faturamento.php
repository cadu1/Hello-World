<div id="da-content-area">
    <script>
    	$(document).ready(function () {
    		BuscarPedidos();
    	});
    	
    	function BuscarPedidos()
    	{
    		var url = dominio + diretorio() + "/home/pedido/BuscarPedidos";
    		ajaxHTMLProgressBar('resp_pedidos_gerados', url, false, false);
    	}
    	
    	function CancelarPedidos(pedido)
    	{
    		if(confirm("Deseja cancelar o pedido ?"))	
    		{	
    			var url = dominio + diretorio() + "/pedidos/cancelar/gerados/"+pedido;
                $.post(url, function (data) {
    
        			resp = data.split("|");
        				
        			if(resp[0]==1)
        			{
                        $("#msg_success").html(resp[1]);
        				$("#msg_success").show();
    
                        BuscarPedidos();
        			}
        			else
        			{
        				$("#msg_error").html(resp[1]);
        				$("#msg_error").show();
        			}
                });
    		}
    	}
    </script>
    
    <div class="grid_4">
    	<div class="da-panel">
    		<div class="da-panel-header">
    			<span class="da-panel-title">
                    <span class="label label-inverse pr_5">
    				    <i class="icon-list-alt icon-white"></i>
                    </span>
    				<strong class="tt_uc">
    				    &nbsp;Pr&eacute;-Faturamento 
    					<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_pedidos" title="Aqui s&atilde;o exibidos os pedidos de venda que vieram das oportunidades, nesta &aacute;rea &eacute; poss&iacute;vel faturar e lan&ccedil;ar estes pedidos em contas a pagar e a receber e tamb&eacute; dar baixa em seu estoque"></i>
                    </strong>
                </span>
    		</div>
    
    		<div class="da-panel-content">
    			<div class="da-panel-padding">
    			    <div class="alert">
    				    <button type="button" class="close" data-dismiss="alert">&times;</button>
    				    <strong>Aten&ccedil;&atilde;o!</strong> Ap&oacute;s faturar um pedido o estoque de produtos ser&aacute; atualizado. As comiss&otilde;es e parcelas tamb&eacute;m ser&atilde;o lan&ccedil;adas no financeiro.
    				</div>
    					
    				<div class="tabbable">
    					<div class="alert alert-error" style="display:none;" id="msg_error">
    						<a class="close" data-dismiss="alert" href="#">&times;</a>
						</div>

    					<div class="alert alert-success" style="display:none;" id="msg_success">
    						<a class="close" data-dismiss="alert" href="#">&times;</a>
                        </div>

    					<div class="tabbable"> <!-- Only required for left/right tabs -->
    						<br/>
                            <ul class="nav nav-tabs">
    							<li class="active">
    								<a href="#tab1" data-toggle="tab">Pedidos a Faturar</a>
    							</li>

    							<li>
    								<a href="#tab2" data-toggle="tab">Pedidos Faturados</a>
    							</li>
    						</ul>
    						<div class="tab-content">
    							<div class="tab-pane fade in active" id="tab1">
    								<div class="container-fluid clr_both">
    									<div class="row-fluid">
    										<table class="da-table">
    											<thead>
    												<tr>
    													<th>Data de fechamento</th>
    													<th>Oportunidade</th>
    													<th>Conta</th>
    													<th>Contato</th>
    													<th>Total (R$)</th>
    													<th>A&ccedil;&otilde;es</th>
    												</tr>
    											</thead>
    											<tbody>
    												<tr onmouseover="mouse(this);">
        												<td data-th="Data" class="al_rgt" onclick="fLink('http://bobsoftware.com.br/erp/pedidos/form/visualizar/1/faturamento')">20/01/2014</td>
        												<td data-th="Oportunidade" onclick="fLink('http://bobsoftware.com.br/erp/pedidos/form/visualizar/1/faturamento')">Teste Oportunidade Pedido</td>
        												<td data-th="Conta" onclick="fLink('http://bobsoftware.com.br/erp/pedidos/form/visualizar/1/faturamento')">Teste Conta</td>
        												<td data-th="Contato" onclick="fLink('http://bobsoftware.com.br/erp/pedidos/form/visualizar/1/faturamento')">te</td>
        												<td data-th="Total (R$)" class="al_rgt" onclick="fLink('http://bobsoftware.com.br/erp/pedidos/form/visualizar/1/faturamento')">10,00</td>
        												<td data-th="A&ccedil;&otilde;es">
        													<a title="Faturar Pedido" href="http://bobsoftware.com.br/erp/pedidos/form/alterar/1/faturamento" id="btn_faturar" class="btn btn-inverse">
        														<i><img width="16" src="http://<?=$_SERVER['HTTP_HOME']?>/application/images/icons/white/32/cur_dollar.png"/></i>
        													</a>
        													<a onclick="fConfirm('Tem certeza que deseja excluir o pedido? Ele voltara para pedidos a gerar.', 'http://bobsoftware.com.br/erp/pedidos/cancelar/faturamento/1');" title="Excluir Pedido - O pedido voltar&aacute; para 'Pedidos a Gerar'" id="excluir"  class="btn btn-warning">
        														<i class="icon-remove-sign icon-black"></i>
        													</a>
                                                        </td>
    												</tr>
    											</tbody>
    										</table>
    									</div>
    									<div class="pagination"></div>
    								</div>
    							</div>
    							<div class="tab-pane fade in " id="tab2">
    								<div class="container-fluid clr_both">
    									<div class="row-fluid" id="resp_pedidos_gerados"></div>
    								</div>
    							</div>
    						</div>
    					</div>		
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="clear"></div>
    </div>    
    	<script type="text/javascript"><!--
        $('#fmbusca input').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#fmbusca').attr('action', 'http://bobsoftware.com.br/erp/crm/listar/contas/1/Resultados/1')
                $('#fmbusca').submit();
            }
        });
        //--></script>
</div>