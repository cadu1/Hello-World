<div id="da-content-area">
    <script>
        $(document).ready(function () {
        });
        
        function FluxoCaixa()
        {
        	var url = dominio + diretorio() + "/fluxo/Fluxo";
        
        	CarregandoAntes();
        	
        	$.post(url, {tipo_periodo:$("#periodo").val(),valor_periodo:$("#valor_periodo").val(),seta:$("#seta").val(),conta:$("#conta_filtro").val()}, function (data) {
        		CarregandoDurante();
        		
        		var resp = data.split("|");
        		
        		$("#valor_periodo").val($.trim(resp[0]));
        		$("#resp_fluxo").html(resp[1]);
        		
        		CarregandoDepois('',100);
        	});
        }
        
        function FiltraSeta(id)
        {
        	var filtro = id;
        	var periodo = $("#periodo").val();
        	
        	id = "#"+id;
        	
        	if (filtro == "semana") 
        	{
                $(id).addClass('btn-primary');
        		$("#periodo").val('semana');
        		$("#mes").removeClass('btn-primary');
                $("#ano").removeClass('btn-primary');
        		$("#valor_periodo").val('20/01/2014 - 26/01/2014');
            }
        	
        	if (filtro == "mes") 
        	{
        		$(id).addClass('btn-primary');
        		$("#periodo").val('mes');
        		$("#semana").removeClass('btn-primary');
                $("#ano").removeClass('btn-primary');
        		$("#valor_periodo").val('January/2014');
            }
        	
        	if (filtro == "ano") 
        	{
                $(id).addClass('btn-primary');
        		$("#periodo").val('ano');
        		$("#mes").removeClass('btn-primary');
                $("#semana").removeClass('btn-primary');
        		$("#valor_periodo").val('2014');
            }
        	
        	FluxoCaixa();
        }
    </script>
    <article>
    	<div  class="modal fade hide hidden-phone" id="started_financeiro">
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" onclick="CancelaVideo('Financeiro');">&#215;</button>
    			<h2 class="pr_5 mr_0" style="display:inline;">
    				V&iacute;deo Tutorial - M&oacute;dulo Financeiro
    			</h2>
    			<i title="Acessando pela primeira vez? Este v&iacute;deo ir&aacute; te ajudar, para n&atilde;o visualiz&aacute;-lo mais selecione a op&ccedil;&atilde;o abaixo do v&iacute;deo e feche esta caixa. Para ver novamente basta clicar no icone ao lado da palavra financeiro" id="tip_video_vendas" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);"></i>
    		</div>
    		<div class="modal-body">
    			<iframe width="530" height="315" src="http://www.youtube.com/embed/DcR4hHlUrRQ" frameborder="0" allowfullscreen></iframe>
    			<label class="checkbox inline">
    				<input type="checkbox" id="check_video" name="check_video">N&atilde;o exibir mais este v&iacute;deo automaticamente
    			</label>
    		</div>
    	</div>
 
     	<div id="cat_receitas" style="display:none;">
    		<select>
    			<option value="">Selecione</option>
			</select>
    	</div>

    	<div id="cat_despesas" style="display:none;">
    		<select>
    			<option value="">Selecione</option>
			</select>
    	</div>
    	
    	<div class="grid_4">
    		<div class="da-panel">
    			<div class="da-panel-header">
    				<span class="da-panel-title">
    					<span class="label label-inverse pr_5">
                            <img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/32/graph.png" width="16"/></span>
    					<strong class="tt_uc">
                            Fluxo de caixa
                        </strong>
						<a href="#started_financeiro" data-toggle="modal"  title="Clique aqui para ver o v&iacute;deo tutorial"><i class="icon-facetime-video icon-black"></i></a>
    				</span>
    			</div>
    			
    			<div class="da-panel-content">
    				<div class="da-panel-padding">
    					<input type="hidden" id="periodo" value="semana"></hidden>
    					<input type="hidden" id="seta" value=""></hidden>
    					
    					<div class="da-panel-header">
    						<span class="da-panel-title">
    							<span>	
    								<label id="semana" onclick="$('#seta').val('');FiltraSeta(this.id);" class="btn btn-primary dropdown-toggle">Semana</label>
    								<label id="mes" onclick="$('#seta').val('');FiltraSeta(this.id);" class="btn dropdown-toggle">M&ecirc;s</label>
    								<label id="ano" onclick="$('#seta').val('');FiltraSeta(this.id);" class="btn dropdown-toggle">Ano</label>
    							</span>
    							<span>
    								<a title=""  style="margin-left:20px;margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('antes');FluxoCaixa();"><i class="icon-backward icon-white"></i></a>
    								<label class="checkbox inline">	
    									<input id="valor_periodo" disabled type="text"  style="margin-left:-22px;text-align:center;background-color:#fff" class="ui-autocomplete-input" autocomplete="off" value="20/01/2014 - 26/01/2014">
    								</label>	
    								<a title="" style="margin-left:-5px;margin-top:-3px;" class="btn btn-inverse" onclick="$('#seta').val('depois');FluxoCaixa();"><i class="icon-forward icon-white"></i></a>
    							</span>
    							
    							<span>
    								<select id="conta_filtro" name="conta_filtro" style='width:400px;margin-top:4px' onchange='FluxoCaixa();'>
    									<option value="">Todas as Contas Banc&aacute;rias / Caixa Pequeno</option>
    									<option value="2">Teste Caixa</option>
    									<option value="1">Teste Conta</option>
									</select>
    							</span>
    						</span>
    					</div>
    					<div id="resp_fluxo" style="overflow:auto;">	
    						<div class="row-fluid"  style="text-align:center;">
    							<table class="da-table">
    								<thead>
    									<tr>
    										<th>&nbsp;</th>
    										<th>Seg - 20</th><th>Ter - 21</th><th>Quar - 22</th><th>Qui - 23</th><th>Sex - 24</th><th>S&aacute;b - 25</th><th>Dom - 26</th>	
    									</tr>
    								</thead>	
    								<tbody>	
    									<tr>
    										<td data-th="Saldo Inicial" class="al_rgt"><strong>Saldo inicial</strong></td>
    										<td data-th='Seg' style='text-align:center;text-align:center;background-color:#FAFAD2;background-image:none;'><label class='text-info'>200,00</label></td><td data-th='Ter' style='text-align:center;'><label class='text-info'>200,00</label></td><td data-th='Quar' style='text-align:center;'><label class='text-info'>200,00</label></td><td data-th='Qui' style='text-align:center;'><label class='text-info'>200,00</label></td><td data-th='Sex' style='text-align:center;'><label class='text-info'>200,00</label></td><td data-th='S&aacute;b' style='text-align:center;'><label class='text-info'>200,00</label></td><td data-th='Dom' style='text-align:center;'><label class='text-info'>200,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Situa&ccedil;&atilde;o" >&nbsp;</td>	
    										<td data-th='Seg' style='text-align:center;background-color:#FAFAD2;background-image:none;'><strong><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td style='text-align:center;' width='50%'><strong>Realizado</strong></td><td style='text-align:center;'><strong>Previsto</strong></td></tr></table></strong></td><td data-th='Ter' style='text-align:center;'><strong>Previsto</strong></td><td data-th='Quar' style='text-align:center;'><strong>Previsto</strong></td><td data-th='Qui' style='text-align:center;'><strong>Previsto</strong></td><td data-th='Sex' style='text-align:center;'><strong>Previsto</strong></td><td data-th='S&aacute;b' style='text-align:center;'><strong>Previsto</strong></td><td data-th='Dom' style='text-align:center;'><strong>Previsto</strong></td>	
    									</tr>
    								</tbody>
    								<thead>
    									<tr>
    										<th colspan="8"  style="background-color:#49AFCD;background-image:none;">Receitas</th>
    									</tr>
    								</thead>
    								<tbody>
    									<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-info">Ajuste de caixa</span></td>		
	    									<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>10,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
    									</tr>
										<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-info">Aplicações financeiras</span></td>		
	    									<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
										</tr>
										<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-info">Devolução de adiantamento</span></td>		
	    									<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
    									</tr>
										<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-info">Saldo Inicial</span></td>		
	    									<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
    									</tr>
										<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-info">Transferência</span></td>		
	    									<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-info">Vendas</span></td>		
    										<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>10,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td class="al_rgt"><strong>Total de receitas</strong></td>
    										<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>20,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info'>0,00</label></td>	
    									</tr>
    								</tbody>
    								<thead>
    									<tr>
    										<th colspan="8" style="background-color:#DA4F49;background-image:none;">Despesas</th>
    									</tr>
    								</thead>
    								<tbody>
										<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-important">Água</span></td>		
	    									<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>-10,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Aluguel</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Internet</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
										</tr>
										<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-important">Luz</span></td>		
		   									<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Material de escritório</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Salários</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Saldo Inicial</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
										</tr>
										<tr>
											<td data-th="Categoria" class="al_rgt"><span class="label label-important">Taxas e tarifas</span></td>		
	    									<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Telefone</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Categoria" class="al_rgt"><span class="label label-important">Transferência</span></td>		
    										<td data-th='Total' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</label></td><td class='al_rgt'><label class='text-error'>0,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    									<tr>
    										<td class="al_rgt"><strong>Total de despesas</strong></td>
    										<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-error'>0,00</p></td><td class='al_rgt'><label class='text-error'>-10,00</p></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-error'>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-error'>0,00</label></td>	
    									</tr>
    								</tbody>
    								<thead>
    									<tr>
    										<th colspan="8"></td>
    									</tr>
    								</thead>
    								<tbody>	
    									<tr>
    										<td class="al_rgt"><strong>Saldo final do per&iacute;odo</strong></td>
    										<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>0,00</label></td><td class='al_rgt'><label class='text-info'>10,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info''>0,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info''>0,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info''>0,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info''>0,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info''>0,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info''>0,00</label></td>	
    									</tr>
    									<tr>
    										<td data-th="Saldo Total" class="al_rgt"><strong>Saldo final</strong></td>
    										<td data-th='Seg' style='text-align:right;text-align:center;background-color:#FAFAD2;background-image:none;'><table class='da-table' width='100%' style='margin-bottom:-5px;'><tr style='background-color:#FAFAD2;background-image:none;'><td width='50%' class='al_rgt'><label class='text-info'>200,00</label></td><td class='al_rgt'><label class='text-info'>210,00</label></td></tr></table></td><td data-th='Ter' style='text-align:right;'><label class='text-info''>200,00</label></td><td data-th='Quar' style='text-align:right;'><label class='text-info''>200,00</label></td><td data-th='Qui' style='text-align:right;'><label class='text-info''>200,00</label></td><td data-th='Sex' style='text-align:right;'><label class='text-info''>200,00</label></td><td data-th='S&aacute;b' style='text-align:right;'><label class='text-info''>200,00</label></td><td data-th='Dom' style='text-align:right;'><label class='text-info''>200,00</label></td>	
    									</tr>
    								</tbody>
    							</table>
    						</div>
    					</div>
    				</div>	
    			</div>
    		</div>
    	</div>
    </article>
</div>