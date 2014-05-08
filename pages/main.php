<div id="da-content-area">
	<!-- Highcharts Plugin -->
	<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/highcharts.js"></script>
	<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/modules/exporting.js"></script>

	<script>
		var chart; // global para graficos

		function Graficos(div, tipo, rotina, d1, d2) // periodo
		{
			var url = dominio + diretorio() + "/dashboard/" + rotina;

			if(div=="graf_saldo")
			{
				label = false;
			}
			else
			{
				label = true;
			}
			
			if (tipo != 'pie') {
				var options = {
					chart:{
						renderTo:div,
						type:tipo,
						plotBackgroundColor:null
					},
					title:{
						text:''
					},
					 colors: [
					],
					lang:{
						downloadJPEG:"Download em JPEG",
						downloadPDF:"Download em PDF",
						downloadPNG:"Download em PNG",
						downloadSVG:null,
						exportButtonTitle:"Exportar para outros formatos",
						loading:"Carregando...",
						printButtonTitle:"Imprimir"
					},
					yAxis:{
						title:{
							text:''
						},
					},
					xAxis:{
						categories:[]
					},
					tooltip: {
					   formatter: function() {
							if((div=='graf_saldo')||(div=='graf_fluxo'))
							{
								return '<b>'+ this.series.name +'</b>: '+this.x +': '+ Highcharts.numberFormat(this.y, 2, ',', '.');
							}
							else
							{
								 return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y;
							}	
					   }
					},

					legend: {
						enabled: label
					},
					series:[]
				};
			}
			else {
				if(div=="graf_relacionamentos")
				{
					url += "/" + $('#filtro_inte option:selected').val();
				}
				else
				{
					url += "/" + $('#filtro_cat option:selected').val();
				}
				
				var options = {
					chart:{
						renderTo:div,
						type:tipo
					},
					lang:{
						downloadJPEG:"Download em JPEG",
						downloadPDF:"Download em PDF",
						downloadPNG:"Download em PNG",
						downloadSVG:null,
						exportButtonTitle:"Exportar para outros formatos",
						loading:"Carregando...",
						printButtonTitle:"Imprimir"
					},
					tooltip:{
						formatter:function () {
							valueDecimals : 2;

							var porcentagem = this.percentage.toFixed(2);
							var valor = ((porcentagem * this.total) / 100).toFixed(0);

							return '<b>' + this.point.name + '</b>: ' + porcentagem + ' % (' + valor + ')';
						}
					},
					plotOptions:{
						pie:{
							allowPointSelect:true,
							cursor:'pointer',
							dataLabels:{
								enabled:false
							},
							showInLegend:true
						}
					},
					title:{
						text:''
					},
					series:[]
				};
			}
			$.ajax({
				url:url,
				data:{ d1:d1, d2:d2 },
				success:function (data) {
					data = data + "";
					if (tipo != 'pie') {
						if((div=='graf_saldo')||(div=='graf_fluxo'))
						{
							var lines = data.split('|');
						}
						else
						{
							var lines = data.split('-');
						}
						// Iterate over the lines and add categories or series
						$.each(lines, function (lineNo, line) {
								var items = line.split(',');
								// header line containes categories
								if (lineNo == 0) {
									$.each(items, function (itemNo, item) {
										if ((itemNo > 0) && (tipo != 'pie')) {
											options.xAxis.categories.push(item);
										}
									});
								}
							// the rest of the lines contain data with their name in the first position
							else 
							{
								if(div!='graf_fluxo')
								{	
									var series = {
										data:[],
									};

									$.each(items, function (itemNo, item) {
										var data = {};

										if (itemNo == 0) {
											series.name = item;
										} 
										else 
										{
											data.y = parseFloat(item);	
											if ((item <= 0) && (div == 'graf_saldo'))
											{
												data.color ='#C35F5C';
											}
											else
											{
												if(div == 'graf_saldo')
												{
													data.color ='#4572A7';
												}
											}
											series.data.push(data);
										}
									});
								}
								else
								{
									var series = {
										name: null,
										data: [],
										color:null
									};
									var cont = 0;
									var aux = new Array();

									$.each(items, function (itemNo, item) {
										if (itemNo == 0) {
											series.name = item;
											if(item=="Saldo")
											{
												series.type="column";
												series.color ='#327C90';
											}
											else
											{
												if((item=="Receita Realizada")||(item=="Receita Prevista"))
												{
													series.color ='#5E8BC0';	

													if(item=="Receita Prevista")
													{	
														series.dashStyle = 'shortdot';
													}
												}
												if((item=="Despesa Prevista")||(item=="Despesa Realizada"))
												{
													series.color ='#AA4643';	

													if(item=="Despesa Prevista")
													{	
														series.dashStyle = 'shortdot';
													}
												}
												series.type="line";
											}
										} 
										else 
										{
											if(item=='null')
											{
												item = null;
											}
											else
											{
												item = parseFloat(item);
											}
											series.data.push(item);
										}
									});
								}
								options.series.push(series);
							}
						});
					}
					else {
						var lines = data.split('\n');
						var series = {
							type:'pie',
							name:'Relacionamentos',
							data:[]
						};

						$.each(lines, function (indice, valor) {
							if (valor != "") {
								v = valor.split(',');
								v = new Array(v[0], parseFloat(v[1]));
								series.data.push(v);
							}
						});
						options.series.push(series);
					}
					var chart = new Highcharts.Chart(options)
				},
				cache:false
			});
		}

		function Dias(id, d1, d2) {
			var html = "";
			var grafico = "";
			var tipo = "";
			var div = "";
			var input = "";

			if (id == 'titulo_oportunidades') {
				grafico = 'graf_oportunidades';
				tipo = 'spline';
				div = 'GrafOportunidades';
				input = 'opt';
			}

			if (id == 'titulo_relacionamentos') {
				grafico = 'graf_relacionamentos';
				tipo = 'pie';
				div = 'GrafRelacionamentos';
				input = 'rel';
			}

			if (id == 'titulo_contascontatos') {
				grafico = 'graf_contas_contatos';
				tipo = 'spline';
				div = 'GrafContasContatos';
				input = 'cli';
			}
			
			 if (id == 'titulo_categoria') {
				grafico = 'graf_categorias';
				tipo = 'pie';
				div = 'GrafCategorias';
				input = 'cat';
			}
			
			 if (id == 'titulo_fluxo') {
				grafico = 'graf_fluxo';
				tipo = 'line';
				div = 'GrafFluxo';
				input = 'fluxo';
			}
			
			if (id == 'titulo_saldo') {
				grafico = 'graf_saldo';
				tipo = 'column';
				div = 'GrafSaldos';
				input = 'saldo';
			}
			Graficos(grafico, tipo, div, d1, d2);
		}

		$(document).ready(function () {
			// Graficos('graf_contas_contatos', 'column', 'GrafContasContatos', '', '');
			Graficos('graf_contas_contatos', 'spline', 'GrafContasContatos', '', '');
			Graficos('graf_oportunidades', 'spline', 'GrafOportunidades', '', '');
			Graficos('graf_relacionamentos', 'pie', 'GrafRelacionamentos', '', '');
			Graficos('graf_fluxo', 'line', 'GrafFluxo', '', '');
			Graficos('graf_categorias', 'pie', 'GrafCategorias', '', '');
			Graficos('graf_saldo', 'column', 'GrafSaldos', '', '');
		});

		var statusAbaProsp = 2;

		function ativaAba()//essa funçao escode e mostra a aba de prospecçao e chama a funçao para mostrar as informaçoes sobre as prospeçoes chama somente quando a aba for ativada
		{
		}//fim da funçao ativaAba

		$(document).ready(function () {
			painel_admin('mostrar');
		});

		function painel_individual(usuario, controle) {
			var url = dominio + diretorio() + "/dashboard/UsuariosComerciais";
			var display = document.getElementById('corpo_atendimento').style.display;

			if (controle == "manter") {
				ajaxHTMLProgressBar('corpo_atendimento', url, false, false);
			}

			if (display == 'none') {
				ajaxHTMLProgressBar('corpo_atendimento', url, false, false);
				$('#corpo_atendimento').show('fast');
			}
			else {
				if (controle != 'manter') {
					$('#corpo_atendimento').hide('fast');
				}
			}
		}

		function painel_admin(controle) {
			var url = dominio + diretorio() + "/dashboard/UsuariosComerciais";
			var display = document.getElementById('corpo_atendimento').style.display;

			if (controle == "manter") {
				ajaxHTMLProgressBar('corpo_atendimento', url, false, false);
			}

			if (display == 'none') {
				ajaxHTMLProgressBar('corpo_atendimento', url, false, false);
				$('#corpo_atendimento').show('fast');
			}
			else 
			{
				if (controle != 'manter')
				{
					$('#corpo_atendimento').hide('fast');
				}
			}
		}

		function painel_financeiro() {
			var url = dominio + diretorio() + "/dashboard/financeiro";
			var display = document.getElementById('corpo_financeiro').style.display;

			ajaxHTMLProgressBar('corpo_financeiro', url, false, false);

			if (display == 'none') {
				ajaxHTMLProgressBar('corpo_financeiro', url, false, false);
				$('#corpo_financeiro').show('fast');
			}
			else 
			{
				$('#corpo_financeiro').hide('fast');
			}
		}
	</script>

	<div class="clear"></div>

	<div class="grid_4">
		<div class="da-panel">
			<div class="da-panel-header">
				<span class="da-panel-title">
					<span class="label label-inverse pr_5"><i class="icon-signal icon-white"></i></span>
					<strong id='titulo_graficos' class="tt_uc">Estatísticas</strong>
				</span>
			</div>

			<div class="da-panel-content">
				<div class="da-panel-padding">
					<div class="container-fluid">
						<div class="row-fluid">
							<ul class="thumbnails caixa_graficos">
								<li class="span4">
									<div class="thumbnail">
										<div class="da-panel-header">
											<span class="da-panel-title">
												<strong class="tt_uc ws_nw al_ctr">Oportunidades</strong>
												<a class="accordion-toggle dsp_ib p_abs mr_5 top_0 rgt_0 btn btn-inverse flt_rgt"  title="Filtrar" data-toggle="collapse" data-parent="#sanfona_1"  href="#filtro_oportunidade">
													<i class="icon-filter icon-white"></i>
												</a>
											</span>
										</div>
										<div class="da-filter">
											<div class="accordion pr_0 mr_0" id="sanfona_1">
												<!-- Precisa de css inline / id="sanfona" onclick="Dias('titulo_oportunidades');" -->
												<div class="accordion-group pr_0 brd_none">
													<div id="filtro_oportunidade" class="accordion-body collapse closed">
														<div class="accordion-inner well">
															<div class="control-group">
																<h4>Filtrar por per&iacute;odo</h4>
																<div class="row-fluid">
																	<div class="span12">
																		<input id="opt_d1" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																	</div>
																</div>
																<div class="row-fluid">
																	<div class="span12 al_ctr lh_150">
																		<strong> At&eacute; </strong>
																	</div>
																</div>
																<div class="row-fluid">
																	<div class="span12">
																		<input id="opt_d2" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																	</div>
																</div>
																<div class="control-group al_rgt">
																	<button onmouseover="mouse(this);"
																			onclick="Dias('titulo_oportunidades',$('#opt_d1').val(),$('#opt_d2').val());return false;"
																			type="button" class="btn btn-success">
																		<i class="icon-filter icon-white"></i> 
																		Filtrar
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div id="graf_oportunidades" style="width: 100%; height: 300px;"></div>
									</div>
								</li>

								<li class="span4">
									<div class="thumbnail">
										<div class="da-panel-header">
											<span class="da-panel-title">
												<strong id="titulo_relacionamentos" class="tt_uc ws_nw al_ctr">Hist&oacute;ricos</strong>

												<a class="accordion-toggle dsp_ib p_abs mr_5 top_0 rgt_0 btn btn-inverse flt_rgt"
												   title="Filtrar" data-toggle="collapse" data-parent="#sanfona_2"
												   href="#filtro_relacionamento">
													<i class="icon-filter icon-white"></i>
												</a>
											</span>
										</div>
										<div class="da-filter">
											<div class="accordion pr_0 mr_0" id="sanfona_2">
												<!-- Precisa de css inline / id="sanfona" -->
												<div class="accordion-group pr_0 brd_none">
													<div id="filtro_relacionamento" class="accordion-body collapse closed">
														<div class="accordion-inner well">
															<h4>Filtrar por intera&ccedil;&atilde;o</h4>
															<div class="row-fluid">
																<div class="span12">
																	<select id="filtro_inte" class="input_full">
																		<option value="motivo">Motivo</option>
																		<option value="canal">Canal</option>
																		<option value="tipo">Tipo</option>
																	</select>
																</div>
															</div>
															<h4>Filtrar por per&iacute;odo</h4>

															<div class="row-fluid">
																<div class="span12">
																	<input id="inte_d1" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																</div>
															</div>
															<div class="row-fluid">
																<div class="span12 al_ctr lh_150">
																	<strong> At&eacute; </strong>
																</div>
															</div>
															<div class="row-fluid">
																<div class="span12">
																	<input id="inte_d2" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																</div>
															</div>
															<div class="control-group al_rgt">
																<button onmouseover="mouse(this);"
																		onclick="Dias('titulo_relacionamentos',$('#inte_d1').val(),$('#inte_d2').val());"
																		type="button" class="btn btn-success">
																	<i class="icon-filter icon-white"></i> 
																	Filtrar
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="graf_relacionamentos" style="width: 100%; height: 300px;"></div>
									</div>
								</li>

								<li class="span4">
									<div class="thumbnail">
										<div class="da-panel-header">
											<span class="da-panel-title">
												<strong class="tt_uc ws_nw al_ctr">Contas e Contatos</strong>

												<a class="accordion-toggle dsp_ib p_abs mr_5 top_0 rgt_0 btn btn-inverse flt_rgt"
												   title="Filtrar" data-toggle="collapse" data-parent="#sanfona_3"
												   href="#filtro_contascontatos">
													<i class="icon-filter icon-white"></i>
												</a>
											</span>
										</div>
										<div class="da-filter">
											<div class="accordion pr_0 mr_0" id="sanfona_3">
												<!-- Precisa de css inline / id="sanfona" -->
												<div class="accordion-group pr_0 brd_none">
													<div id="filtro_contascontatos" class="accordion-body collapse closed">
														<div class="accordion-inner well">
															<div class="control-group">
																<h4>Filtrar por per&iacute;odo</h4>
																<div class="row-fluid">
																	<div class="span12">
																		<input id="cli_d1" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																	</div>
																</div>
																<div class="row-fluid">
																	<div class="span12 al_ctr lh_150">
																		<strong> At&eacute; </strong>
																	</div>
																</div>
																<div class="row-fluid">
																	<div class="span12">
																		<input id="cli_d2" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																	</div>
																</div>
																<div class="control-group al_rgt">
																	<button onmouseover="mouse(this);" type="button"
																			onclick="Dias('titulo_contascontatos',$('#cli_d1').val(),$('#cli_d2').val());"
																			class="btn btn-success">
																		<i class="icon-filter icon-white"></i> 
																		Filtrar
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div id="graf_contas_contatos" style="width: 100%; height: 300px;"></div>
									</div>
								</li>
							</ul>

							<ul class="thumbnails caixa_graficos">
								<li class="span4">
									<div class="thumbnail">
										<div class="da-panel-header">
											<span class="da-panel-title">
												<strong id="titulo_fluxo" class="tt_uc ws_nw al_ctr">Fluxo de caixa</strong>

												<a class="accordion-toggle dsp_ib p_abs mr_5 top_0 rgt_0 btn btn-inverse flt_rgt"
												   title="Filtrar" data-toggle="collapse" data-parent="#sanfona_4"
												   href="#filtro_fluxo">
													<i class="icon-filter icon-white"></i>
												</a>
											</span>
										</div>
										<div class="da-filter">
											<div class="accordion pr_0 mr_0" id="sanfona_4">
												<!-- Precisa de css inline / id="sanfona" onclick="Dias('titulo_oportunidades');" -->
												<div class="accordion-group pr_0 brd_none">
													<div id="filtro_fluxo" class="accordion-body collapse closed">
														<div class="accordion-inner well">
															<div class="control-group">
																<h4>Filtrar por semana  
																	<i title="Mostra o fluxo de caixa relativo a uma semana espec&iacute;fica" onmouseover="mouse(this);" class="hidden-phone hidden-tablet icon-question-sign icon-black" style="cursor: pointer;"></i>
																</h4>

																<div class="row-fluid">
																	<div class="span12">
																		<input id="fluxo_d1" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																	</div>
																</div>
																<div class="row-fluid">
																	<div class="span12 al_ctr lh_150">
																		<strong> At&eacute; </strong>
																	</div>
																</div>
																<div class="row-fluid">
																	<div class="span12">
																		<input id="fluxo_d2" type="text" class="input_full datepicker"
																			   placeholder="dd/mm/aaaa">
																	</div>
																</div>
																<div class="control-group al_rgt">
																	<button onmouseover="mouse(this);"
																			onclick="Dias('titulo_fluxo',$('#fluxo_d1').val(),$('#fluxo_d2').val());return false;"
																			type="button" class="btn btn-success">
																			<i class="icon-filter icon-white"></i> 
																			Filtrar
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div id="graf_fluxo" style="width: 100%; height: 300px;"></div>
									</div>
								</li>

								<li class="span4">
									<div class="thumbnail">
										<div class="da-panel-header">
											<span class="da-panel-title">
												<strong id="titulo_categoria" class="tt_uc ws_nw al_ctr">Categorias</strong>
												<a class="accordion-toggle dsp_ib p_abs mr_5 top_0 rgt_0 btn btn-inverse flt_rgt"  title="Filtrar" data-toggle="collapse" data-parent="#sanfona_5" href="#filtro_categoria">
													<i class="icon-filter icon-white"></i>
												</a>
											</span>
										</div>
										<div class="da-filter">
											<div class="accordion pr_0 mr_0" id="sanfona_5">
												<!-- Precisa de css inline / id="sanfona" -->
												<div class="accordion-group pr_0 brd_none">
													<div id="filtro_categoria" class="accordion-body collapse closed">
														<div class="accordion-inner well">
															<h4>Filtrar por tipo</h4>
															<div class="row-fluid">
																<div class="span12">
																	<select id="filtro_cat" class="input_full">
																		<option value="">Selecione</option>
																		<option value="receita">Receitas</option>
																		<option value="despesa">Despesas</option>
																	</select>
																</div>
															</div>

															<h4>Filtrar por per&iacute;odo</h4>
															<div class="row-fluid">
																<div class="span12">
																	<input id="cat_d1" type="text" class="input_full datepicker" placeholder="dd/mm/aaaa">
																</div>
															</div>

															<div class="row-fluid">
																<div class="span12 al_ctr lh_150">
																	<strong> At&eacute; </strong>
																</div>
															</div>

															<div class="row-fluid">
																<div class="span12">
																	<input id="cat_d2" type="text" class="input_full datepicker"  placeholder="dd/mm/aaaa">
																</div>
															</div>

															<div class="control-group al_rgt">
																<button onmouseover="mouse(this);" onclick="Dias('titulo_categoria',$('#cat_d1').val(),$('#cat_d2').val());" type="button" class="btn btn-success">
																	<i class="icon-filter icon-white"></i>Filtrar
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div id="graf_categorias" style="width: 100%; height: 300px;"></div>
									</div>
								</li>

								<li class="span4">
									<div class="thumbnail">
										<div class="da-panel-header">
											<span class="da-panel-title">
												<strong class="tt_uc ws_nw al_ctr" id="titulo_saldo">Saldos</strong>
											</span>
										</div>
										<div id="graf_saldo" style="width: 100%; height: 300px;"></div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="grid_4">
		<div class="da-panel">
			<div class="da-panel-header" onmouseover="mouse(this);" onclick="painel_individual();">
				<span class="da-panel-title">
					<span class="label label-inverse pr_5"><i class="icon-user icon-white"></i></span>
					<strong class="tt_uc">Atividades  recentes </strong>
				</span>
			</div>

			<div class="da-panel-content box_atividades" align="center">
				<div class="da-padding" id="corpo_atendimento" style="display:none;"></div>
				<!--<div id="setas" >
						   <a class="carousel-control left" style="right:3px;left:3px" href="#box_usuarios" data-slide="prev">&lsaquo;</a>
						<a class="carousel-control right" style="right:3px;" href="#box_usuarios" data-slide="next">&rsaquo;</a>
					</div>-->
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>