<div id="da-content-area">
	<script>
	    function configcampo(valor) {
	        if(valor=="0")
	        {
	            document.getElementById("dvcampo").innerHTML ="";
	        }
	
	        if(valor=="operacao")
	        {
	            document.getElementById("dvcampo").innerHTML ="<select id='slcampo' name='slcampo'></select>";
	
	            var obj = document.getElementById("slcampo");
	
	            objaux = document.getElementById("sloperacao");
	
	            for(var i=0;i<objaux.length;i++) {
	                obj.options[obj.length] = new Option(objaux.options[i].text,objaux.options[i].value);
	            }
	
	            obj.selectedIndex = objaux.selectedIndex;
	        }
	        if(valor=="tabela")
	        {
	            document.getElementById("dvcampo").innerHTML ="<select id='slcampo' name='slcampo'></select>";
	
	            var obj = document.getElementById("slcampo");
	
	            objaux = document.getElementById("sltabela");
	
	            for(var i=0;i<objaux.length;i++) {
	                obj.options[obj.length] = new Option(objaux.options[i].text,objaux.options[i].value);
	            }
	
	            obj.selectedIndex = objaux.selectedIndex;
	        }
	    }
	
	    //	CONFIGURA MASCARA
	
	    $(function() {
	        $("#hora_inicio").mask("99:99:99");
	        $("#hora_fim").mask("99:99:99");
	    })
	
	    $(function() {
	        $("#data_inicio").datepicker({
	            dateFormat: 'dd/mm/yy',
	            dayNames: [
	                'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'
	            ],
	            dayNamesMin: [
	                'D','S','T','Q','Q','S','S','D'
	            ],
	            dayNamesShort: [
	                'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'
	            ],
	            monthNames: [
	                'Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro',
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
	
	    $(function(){
	        $("#data_fim").datepicker({
	            dateFormat: 'dd/mm/yy',
	            dayNames: [
	                'Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'
	            ],
	            dayNamesMin: [
	                'D','S','T','Q','Q','S','S','D'
	            ],
	            dayNamesShort: [
	                'Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'
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
	</script>
	
	<!-- Highcharts Plugin -->
	<script src="http://<?=$_SERVER['HTTP_HOST']?>/application/js/highcharts.js"></script>
	<script src="http://<?=$_SERVER['HTTP_HOST']?>/application/js/modules/exporting.js"></script>
	
	<div class="grid_4">
	    <div class="da-panel">
	        <div class="da-panel-header">
	            <span class="da-panel-title">
	                <span class="label label-inverse pr_5"><i class="icon-briefcase icon-white"></i></span>
	                <strong id='titulo_graficos' class="tt_uc">Auditoria</strong>
				</span>
	        </div>
	
	        <div class="da-panel-content">
	            <div class="da-panel-padding">
	                <div class="container-fluid">
	                    <div class="row-fluid">
	                        <div class="span12">
								<div class="thumbnail">
									<div class="da-panel-header">
	                                    <span class="da-panel-title">
	                                        <strong class="tt_uc ws_nw al_ctr">Est&aacute;tisticas</strong>
	                                    </span>
	                                </div>
	
	                                <div class="row-fluid">
	                                    <div class="span4">
	                                        <div class="well al_ctr">
	                                            <span class="label label-inverse pr_5"><i><img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/16/user_comment.png"/></i></span>
	
	                                            <p class="tt_uc">
	                                            	<br>Leads
	                                            </p>
	                                            <div class="clr_both">
	                                                <strong class="badge badge-inverse f_16">1</strong>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="span4">
	                                        <div class="well al_ctr">
	                                            <span class="label label-inverse pr_5"><i><img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/16/apartment_building.png"/></i></span>
	
	                                            <p class="tt_uc">
	                                                <br/>
	                                                Contas
	                                            </p>
	                                            <div class="clr_both">
	                                                <strong class="badge badge-inverse f_16">1</strong>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="span4">
	                                        <div class="well al_ctr">
	                                            <span class="label label-inverse pr_5"><i><img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/32/address_book.png" width="16"></i></span>
	
	                                            <p class="tt_uc">
	                                                <br/>
	                                                Contatos
	                                            </p>
	                                            <div class="clr_both">
	                                                <strong class="badge badge-inverse f_16">3</strong>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="row-fluid">
	                                    <div class="span4">
	                                        <div class="well al_ctr">
	                                            <span class="label label-inverse pr_5"><img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/16/users.png" width="16"></span>
	
	                                            <p class="tt_uc">
	                                                <br/>
	                                                Atividades
	                                            </p>
	                                            <div class="clr_both">
	                                                <strong class="badge badge-inverse f_16">1</strong>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="span4">
	                                        <div class="well al_ctr">
	                                            <span class="label label-inverse pr_5"><img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/32/cur_dollar.png" width="16"></span>
	
	                                            <p class="tt_uc">
	                                                <br/>
	                                                Oportunidades
	                                            </p>
	                                            <div class="clr_both">
	                                                <strong class="badge badge-inverse f_16">7</strong>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="span4">
	                                        <div class="well al_ctr">
	                                            <span class="label label-inverse pr_5">
	                                            	<i class="icon-user icon-white"></i>
	                                            </span>
	
	                                            <p class="tt_uc">
	                                                <br/>
	                                                Usuários
	                                            </p>
	                                            <div class="clr_both">
	                                                <strong class="badge badge-inverse f_16">1</strong>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
							</div>
	                    </div>
	                    <p><hr /></p>
	                    <div class="row-fluid">
	                        <div class="span12">
                                <div class="thumbnail">
    	                			<label class="dsp_ib flt_rgt btn disabled">
    	                    			<b>72&nbsp;REGISTROS</b>
    	                    		</label>
    	                			<div class="da-filter hidden-phone">
    	                			    <a class="accordion-toggle dsp_ib flt_rgt btn btn-inverse" data-toggle="collapse" title="Filtrar" data-parent="#sanfona" href="#filtro">
    	                					<i class="icon-filter icon-white"></i> Filtro
										</a>

    	                				<div class="accordion pr_0" id="sanfona"> <!-- Precisa de css inline / id="sanfona" -->
    	                				    <div class="accordion-group pr_0 brd_none">
    	                				        <div class="accordion-heading"></div>
    	                				        <div id="filtro" class="accordion-body collapse closed">
    	                				            <span class="accordion-toggle dsp_b btn btn-inverse">
    	                				                &nbsp;
    	                				            </span>
    	                				            <div class="accordion-inner well">
    	                				                <form class="form-horizontal" name="fmbusca" method="post" id="fmbusca" action="http://bobsoftware.com.br/erp/logs/listar/1/Resultados/1">
    	                				                    <fieldset>
    	                				                        <div id="dvoperacao" class="control-group">
    	                				                            <label class="control-label">Opera&ccedil;&atilde;o</label>
    	                				                            <div class="controls">
    	                				                                <select class="input_full" id="sloperacao" name="sloperacao">
    															<option value="todas">Todas</option>
    	                				                                    <option  value="alterar">Alterar</option>
    	                				                                    <option value="converter" >Converter</option>
    															<option value="inserir" >Inserir</option>
    	                				                                    <option value="excluir" >Excluir</option>
    	                				                                </select>
    	                				                            </div>
    	                				                        </div>
    	                				                        <div id="dvtabela" class="control-group">
    	                				                            <label class="control-label">Tabela</label>
    	                				                            <div class="controls">
    	                				                                <select class="input_full" id="sltabela" name="sltabela">
    	                				                                    <option value="todas">Todas</option>
    	                				                                    <option value="contas">Contas</option>
    	                				                                    <option value="contatos">Contatos</option>
    	                				                                    <option value="interacoes"  >Atividades</option>
    	                				                                    <option value="leads"  >Leads</option>
    															<option   value="oportunidades">Oportunidades</option>
    	                				                                    <option value="usuarios">Usu&aacute;rios</option>
    	                				                                </select>
    	                				                            </div>
    	                				                        </div>
    	                				                        <div id="dvcampo" class="control-group">
    	                				                            <label class="control-label">Usu&aacute;rio</label>
    	                				                            <div class="controls">
    														<select class="input_full" id="nomeuser" name="nomeuser">
    															<option value="todos">Todos</option>
    															<option  value="1572">Carlos Oliveira</option>
    														</select>
    	                				                            </div>
    	                				                        </div>
    	                				
    	                				                        <div class="control-group">
    	                				                            <label class="control-label">
    	                				                                Per&iacute;odo
    	                				                            </label>
    	                				                            <div class="controls">
    	                				                                <div class="row-fluid">
    	                				                                    <div class="span5">
    	                				                                        <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" type="text" id="data_inicio" name="data_inicio" value=""/>
    	                				                                    </div>
    	                				                                    <div class="span1 lh_200 al_ctr">e</div>
    	                				                                    <div class="span5">
    	                				                                        <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" value="" type="text" id="data_fim" name="data_fim"/>
    	                				                                    </div>
    	                				                                </div>
    	                				                            </div>
    	                				                        </div>
    	                				
    	                				                        <div class="control-group">
    	                				                            <label class="control-label">Hor&aacute;rio</label>
    	                				
    	                				                            <div class="controls">
    	                				                                <div class="row-fluid">
    	                				                                    <div class="span5">
    	                				                                        <input class="input_full" type="text" id="hora_inicio" name="hora_inicio" value=""/>
    	                				                                    </div>
    	                				                                    <div class="span1 lh_200 al_ctr">e</div>
    	                				                                    <div class="span5">
    	                				                                        <input class="input_full" value="" type="text" id="hora_fim" name="hora_fim"/>
    	                				                                    </div>
    	                				                                </div>
    	                				                            </div>
    	                				                        </div>
    	                				
    	                				                        <div class="form-actions al_rgt">
    	                				                            <button type="submit" class="btn btn-success" id="btbusca" href="javascript:void(0)"  onclick="$('#fmbusca').submit();"  title="Buscar por Usu&aacute;rio">
    	                				                            	<i class="icon-search icon-white"></i> 
    	                				                            	Filtrar
    	                				                            </button>
    	                				                        </div>
    	                				                    </fieldset>
    	                				                </form>
    	                				            </div>
    	                				        </div>
    	                				    </div>
    	                				</div>
    	                			</div>
                	                <table class="da-table">
                	                    <thead>
                	                    	<tr>
                	                    	    <th>Usu&aacute;rio</th>
                	                    	    <th>Opera&ccedil;&atilde;o</th>
                	                    	    <th>Tabela</th>
                	                    	    <th>Data</th>
                	                    	    <th>Hora</th>
                	                    	</tr>
                	                    </thead>
                	                    <tbody onmouseover="mouse(this);" title="Visualizar">
											<tr>
                	                        	 <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                             <td data-th="Opera&ccedil;&atilde;o">Entrou no sistema</td>
                	                             <td data-th="Tabela">logs</td>
                	                             <td data-th="Data (dd/mm/aaaa)" class="al_rgt">21/01/2014</td>
                	                             <td data-th="Hora (hh:mm:ss)" class="al_rgt" >07:01:47</td>
											</tr>
                	                        <tr>
                	                        	<td data-th="Usu&aacute;rio">Carlos Oliveira</td>
           	                                    <td data-th="Opera&ccedil;&atilde;o">inserir</td>
          	                                    <td data-th="Tabela">lan&ccedil;amentos</td>
           	                                    <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
           	                                    <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:40:13</td>
                	                        </tr>
                	                        <tr>
                	                        	<td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">pedidos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:40:13</td>
											</tr>
											<tr>
                	                        	<td data-th="Usu&aacute;rio">Carlos Oliveira</td>
												<td data-th="Opera&ccedil;&atilde;o">alterar</td>
                	                            <td data-th="Tabela">itens_venda</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:40:12</td>
                	                        </tr>
                	                        <tr>
                	                        	<td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">lan&ccedil;amentos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:40:12</td>
                	                        </tr>
											<tr>
                	                        	<td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">lan&ccedil;amentos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:40:12</td>
                	                        </tr>
											<tr>
                	                        	<td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">oportunidades</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:40:11</td>
											</tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">alterar</td>
                	                            <td data-th="Tabela">itens_venda</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:35:53</td>
                	                        </tr>
                							<tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">lan&ccedil;amentos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:35:53</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">lan&ccedil;amentos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:35:53</td>
                	                        </tr>
                							<tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">alterar</td>
                	                            <td data-th="Tabela">pedidos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:35:53</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">pedidos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:34:29</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">oportunidades</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:34:28</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">contas_bancarias</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:24:44</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">alterar</td>
                	                            <td data-th="Tabela">contatos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:20:49</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">lan&ccedil;amentos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:19:01</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">alterar</td>
                	                            <td data-th="Tabela">pedidos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:19:01</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">alterar</td>
                	                            <td data-th="Tabela">itens_venda</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:19:00</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">oportunidades</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:17:45</td>
                	                        </tr>
                	                        <tr>
                	                            <td data-th="Usu&aacute;rio">Carlos Oliveira</td>
                	                            <td data-th="Opera&ccedil;&atilde;o">inserir</td>
                	                            <td data-th="Tabela">pedidos</td>
                	                            <td data-th="Data (dd/mm/aaaa)" class="al_rgt">20/01/2014</td>
                	                            <td data-th="Hora (hh:mm:ss)" class="al_rgt" >15:17:45</td>
                	                        </tr>
										</tbody>
                	                </table>
                                </div>
                    	        <div class="pagination">
                                    <ul>
                        		        <li class="disabled">
                        		        	<a href="#">&laquo;&nbsp;anterior</a>
                        		        </li>
                        				<li class="active"><a href="#">1</a></li>
                        				<li>
                        					<a href="http://bobsoftware.com.br/erp/logs/listar/2">2</a>
                        	            </li>
    									<li>
                        					<a href="http://bobsoftware.com.br/erp/logs/listar/3">3</a>
                        	            </li>
                        				<li>
                        					<a href="http://bobsoftware.com.br/erp/logs/listar/4">4</a>
                        	            </li>
                        				<li><a href="http://bobsoftware.com.br/erp/logs/listar/2">próximo&nbsp;&raquo;</a>
                                    </ul>
                                </div>
	                        </div>
	                    </div>
	                </div>

	                <script type="text/javascript">
    	                <!--
    	                $('#fmbusca input').keydown(function(e) {
    	                    if (e.keyCode == 13) {
    	                        $('#fmbusca').submit();
    	                    }
    	                });
    	                //-->
	                </script>
	            </div>
	        </div>
	    </div>
	</div>
</div>