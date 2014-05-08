<?php
    if(!isset($_COOKIE['time']) && (time() - $_COOKIE['time'] > 900)) {
        header("Location: http://{$_SERVER["HTTP_HOST"]}/logout/login");
        exit();
    }
    $_COOKIE["time"] = time() + 60;
?>
<!--[if lt IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js"><!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta name="robots" content="nofollow"/>

		<!-- Viewport metatags -->
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

		<!-- iOS webapp metatags -->
		<link rel="shortcut icon" type="image/x-icon" href="http://<?=$_SERVER["HTTP_HOST"]?>/img/favicon.ico"/>
			
		<!-- Bootstrap Reset -->
		<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/bootstrap.min.css"  media="screen"/>
		<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/bootstrap-modal.css"  media="screen"/>

		<!-- CSS Reset -->
		<link rel="stylesheet" type="text/less" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/reset.less" media="screen"/>

		<!--  Fluid Grid System -->
		<link rel="stylesheet" type="text/less" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/fluid.less" media="screen"/>

		<!-- Theme Stylesheet -->
		<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER["HTTP_HOST"]?>/tema/estrutura.tema.css" media="screen"/>

		<!--  Main Stylesheet -->
		<link rel="stylesheet" type="text/less" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/estrutura.less" media="screen"/>

		<!-- Multifilter -->
		<link rel="stylesheet" type="text/less" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/jquery.multiselect.css" media="screen"/>

		<!-- jQuery JavaScript File -->
		<!--script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script-->
		<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery-1.7.2.min.js"></script>

		<!--script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script-->

		<!-- Modernizr JavaScript File -->
		<!--script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js"></script-->
		<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/modernizr-2.5.3.min.js"></script>
		<!--script>window.jQuery || document.write('<script src="js/modernizr-2.5.3.min.js"><\/script>')</script-->

		<!-- LessCSS JavaScript File -->
		<!--script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script-->
		<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/less-1.3.0.min.js"></script>
		<!--script>window.jQuery || document.write('<script src="js/less-1.3.0.min.js"><\/script>')</script-->

		<!-- zclip -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.zclip.js"></script>

		<!-- bootstrap Plugins -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-alert.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-tab.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-dropdown.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-collapse.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-transition.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-typeahead.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-button.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-carousel.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-tooltip.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-modalmanager.js"></script> 
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/bootstrap-modal.js"></script>

		<!-- Stepy -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.stepy.min.js"></script>

		<!-- jQuery-UI JavaScript Files -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/jui/js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/jui/js/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/jui/js/jquery-ui-1.8.20.min.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/jui/js/jquery.ui.timepicker.min.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/jui/js/jquery.ui.touch-punch.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER["HTTP_HOST"]?>/jui/css/jquery.ui.all.css"  media="screen"/>

		<!-- Multiselect -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.multiselect.js"></script> 

		<!-- Plugin Files -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.orbit-1.2.3.min.js"></script>

		<!--[if IE]>
		<style type="text/css">
			.timer {
				display: none !important;
			}

			div.caption {
				background: transparent;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = #99000000, endColorstr = #99000000);
				zoom: 1;
			}
		</style>
		<![endif]-->

		<!-- Run the plugin -->
		<script type="text/javascript">
			$(window).load(function () {
				$('#getting_started').orbit({
					animation:'fade', // fade, horizontal-slide, vertical-slide, horizontal-push
					animationSpeed:800, // how fast animations are
					timer:true, // true or false to have the timer
					advanceSpeed:10000, // if timer is enabled, time between transitions
					pauseOnHover:false, // if you hover pauses the slider
					startClockOnMouseOut:false, // if clock should start on MouseOut
					startClockOnMouseOutAfter:1000, // how long after MouseOut should the timer start again
					directionalNav:true, // manual advancing directional navs
					captions:true, // do you want captions?
					captionAnimation:'fade', // fade, slideOpen, none
					captionAnimationSpeed:800, // if so how quickly should they animate in
					bullets:false, // true or false to activate the bullet navigation
					bulletThumbs:false, // thumbnails for the bullets
					bulletThumbLocation:'', // location from this file where thumbs will be
					afterSlideChange:function () {
					}   // empty function
				});
			});
			
			function CancelaVideo(tipo) 
			{
				var url = dominio + diretorio() + "/usuario/CancelaVideo/"+tipo;
				
				if($("#check_video").is(":checked"))
				{
					CarregandoAntes();
					
					$.post(url, function(data)
					{
						var resp = data.split("|");
						
						CarregandoDurante();
						
						$("#msg_loading").html(resp[1]);
						
						CarregandoDepois('loading',3000);
					
					});
				}
			}
		</script>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-34278888-1']);
			_gaq.push(['_trackPageview']);

			(function () {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();
		</script>

		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.datepick.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.datepick-pt-BR.js"></script>
		<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER["HTTP_HOST"]?>/css/jquery.datepick.css"/>

		<script type="text/javascript">
			$(function () {
				$('.datepicker').datepick();
			});
		</script>

		<!-- Placeholder Plugin -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.placeholder.js"></script>

		<!-- Mousewheel Plugin -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.mousewheel.min.js"></script>

		<!-- Scrollbar Plugin -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.tinyscrollbar.min.js"></script>

		<!-- Core JavaScript Files -->
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/core/tomfrmk.core.js"></script>

		<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery/datepicker/jquery.ui.all.css" media="screen" />

		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery/superfish/js/superfish.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery/jquery.rsv.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery/jquery-ui-1.8.2.custom.min.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/functions.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/valida.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/mascara.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.jeditable.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/maskmoney.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/ajaxutil.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery.mask.js"></script>

		<title>eBoss! Commerce</title>

		<script>
			$(function () {
				$(".datepicker").datepicker();
				$("#hora_lembrete_template").mask("99:99");
			});
		</script>
	</head>

	<body>
		<div id="da-wrapper" class="fluid">
			<div class="modal box_getting fade hide hidden-phone" style="width: 940px; height: 400px;" id="bem_vindos">
				<a href="#" class="p_abs" style="z-index: 9999; right: -10px; top: -10px;" data-dismiss="modal">
					<img src="http://<?=$_SERVER["HTTP_HOST"]?>/img/close_button.png" class="max_w"/>
				</a>

				<div id="getting_started">
					<img src="http://<?=$_SERVER["HTTP_HOST"]?>/img/1.jpg" class="max_w"/>
					<img src="http://<?=$_SERVER["HTTP_HOST"]?>/img/2.jpg" class="max_w"/>
					<img src="http://<?=$_SERVER["HTTP_HOST"]?>/img/3.jpg" class="max_w"/>
				</div>
			</div>

			<div id="loading" style="display:none;">
				<div class="carregando row-fluid" style="margin-left: -8.248%;margin-top: -15%;">
					<div class="span4"></div>
					<div class="span4 offset4 al_ctr well glow">
						<div id="progress_bar" class="progress progress-striped active">
							<div class="bar" style="width: 100%;"></div>
						</div>
						<a href="#" class="close" id="close" style="display:none;" onclick="$('#loading').hide();">×</a>
						<strong id="msg_loading"><i class="icon-time icon-black"></i> Carregando...</strong>
					</div>
				</div>

				<!--
				<div class="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h3>Warning!</h3> Best check yo self, you're not looking too good.
				</div>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h3>Warning!</h3> Best check yo self, you're not looking too good.
				</div>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h3>Warning!</h3> Best check yo self, you're not looking too good.
				</div>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h3>Warning!</h3> Best check yo self, you're not looking too good.
				</div>
				-->
			</div>

			<div id="fundo_cobre" class="fundo" style="display:none;"></div>

			<!-- Geral -->
			<!-- Topo apos o login -->
			<div id="da-header">
				<div id="da-header-top">
					<!--div class="alert">
						<strong>Aten&ccedil;&atilde;o!</strong> seu per&iacute;odo de testes se encerra em 26/01/2014 
						<a href="http://bobsoftware.com.br/erp/planos">aqui</a> para contratar
					</div-->	

					<div class="da-container clearfix">
						<!-- Logo -->
						<div id="da-logo-wrap">
							<div id="da-logo">
								<div id="da-logo-img">
									<a href="http://<?=$_SERVER["HTTP_HOST"]?>/home">
										<img src="http://<?=$_SERVER["HTTP_HOST"]?>/img/logo.png" alt="BMC Studio Web"/>  
									</a>
								</div>
							</div>
						</div>
						<!-- Logo # Fim -->
					
						<!-- Toolbar -->
						<div id="da-header-toolbar" class="clearfix">
							<div id="da-user-profile">
								<div id="da-user-avatar" class="hidden-phone">
								</div>

								<div id="da-user-info">
									<?php echo $_COOKIE['nome']?>
									<span class="da-user-title"><?php echo $_COOKIE['login']?></span>
								</div>

								<ul class="da-header-dropdown">
									<li class="da-dropdown-caret">
										<span class="caret-outer"></span>
										<span class="caret-inner"></span>
									</li>

									<li>
										<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/usuario/conta">
											<i class="icon-bookmark icon-black"></i> 
											Meus dados
										</a>
									</li>

									<li>
										<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/usuario/senha">
											<i class="icon-lock icon-black"></i>
											Alterar senha
										</a>
									</li>
								</ul>

							</div>

							<script type="text/javascript">
								var uvOptions = {};
								(function () {
									var uv = document.createElement('script');
									uv.type = 'text/javascript';
									uv.async = true;
									uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/UJuompPAFFRUJf1Wz6jQ.js';
									var s = document.getElementsByTagName('script')[0];
									s.parentNode.insertBefore(uv, s);
								})();
							</script>

							<div id="da-header-button-container">
								<ul>
									<li class="da-header-button al_ctr hidden-phone" onclick="$('#bem_vindos').modal('show')">
										<i class="icon-star icon-white mr_10" title="Comece Aqui"></i>
									</li>

									<!--li class="da-header-button al_ctr hidden-phone" style="cursor: pointer;" onclick="window.location.href='http://bobsoftware.com.br/erp/indicacoes';">
										<i class="icon-gift icon-white mr_10" title="Indique e Ganhe"></i>
									</li-->

									<li class="da-header-button config">
										<a href="#" title="Configurações">Configurações</a>
										<ul class="da-header-dropdown">
											<li class="da-dropdown-caret">
												<span class="caret-outer"></span>
												<span class="caret-inner"></span>
											</li>
											<li class="al_ctr tt_uc"><strong>Configurações</strong></li>
												<li class="da-dropdown-divider"></li>
													<li><a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/usuario"><i class="icon-user icon-black"></i>&nbsp;Usuários</a></li>
													<li><a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/auditoria"><i class="icon-search icon-black"></i>&nbsp;Auditoria</a></li>
													<!--li><a href="http://bobsoftware.com.br/erp/backup"><i class="icon-wrench icon-black"></i>&nbsp;Backup</a></li-->
													<li><a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/financeiro"><img width="16px" src="http://<?=$_SERVER['HTTP_HOST']?>/images/icons/black/32/cur_dollar.png" alt="FINANCEIRO"/>&nbsp;Financeiro <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/novidade-icon.png" alt="Novos Recursos"/></a></li>	
													<li><a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/vendas"><i class="icon-briefcase icon-black"></i>&nbsp;Vendas <img src="http://<?=$_SERVER['HTTP_HOST']?>/images/novidade-icon.png" alt="Novos Recursos"/></a></li>	
													<!--li class="da-dropdown-divider"></li>
													<li><a href="http://bobsoftware.com.br/erp/planos"><i class="icon-tags icon-black"></i> Planos e Pre&ccedil;os</a></li-->
                                                    <li><a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/tabelas"><i class="icon-list-alt hidden-tablet"></i>&nbsp;Tabelas</a></li>
										</ul>
									</li>

									<li class="da-header-button logout">
										<a href="http://<?=$_SERVER['HTTP_HOST']?>/logout/login" title="Sair do Sistema">Sair do Sistema</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- Toolbar # Fim -->
					</div>
				</div>

				<div id="da-header-bottom">
					<div class="da-container clearfix">
						<!-- Breadcrumbs -->
						<div id="da-breadcrumb">
							<ul>
								<li class="active">
								<img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/16/home.png"
										 alt="Página Inicial"/>Página Inicial
								</li>
							</ul>
   						</div>
						<!-- Breadcrumbs # Fim -->
					</div>
				</div>
			</div>

			<!-- Topo # Fim -->
			<div id="da-content">
				<!-- Frame Conteúdo -->
				<div class="da-container clearfix">
					<!-- Separador -->
					<div id="da-sidebar-separator"></div>

					<!-- Barra Lateral -->
					<div id="da-sidebar">

						<!-- Navegação Central -->
						<nav id="da-main-nav" class="da-button-container">
							<ul>
								<li class='active'>
									<a href="http://<?=$_SERVER["HTTP_HOST"]?>/home">
										<span class="da-nav-icon">
											<img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/32/home.png" alt="Página Inicial"/>
									   </span>
										Página Inicial
										<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_menu" title="D&uacute;vida sobre algum dos itens do menu? Passe o mouse sobre o t&iacute;tulo e veja uma breve descri&ccedil;&atilde;o"></i>
									</a>
								</li>

								<li>
									<a href="#" onclick="return false" title="Gerencie aqui seu relacionamento com pessoas e instiui&ccedil;&otilde;es">
										<span class="da-nav-icon">
											<img  src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/32/table_1.png" alt="CRM"/>
										</span>
										CRM
									</a>

									<ul>
										<li>
											<a title="Aqui você cadastra todos os contatos que vieram através de um site, um contato rápido em um evento ou uma indicação fria, mas ainda não os qualificou." 
												href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/lead">
												<i class="hidden-tablet">
													<img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/16/user_comment.png">
												</i> Leads
											</a>
										</li>

										<li>
											<a title="Aqui você cadastra as empresas ou entidades que podem contratar seus serviços e produtos, seus parceiros, concorrentes e clientes"  href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/conta"><i class="hidden-tablet"><img  src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/16/apartment_building.png"/></i>Contas</a>
										</li>

										<li>
											<a title="Aqui você cadastra todas as pessoas ligadas às suas Contas e que você precisa rastrear de forma rápida e prática. Ou mesmo as pessoas que podem contratar seus serviços e produtos, seus parceiros e concorrentes." href="http://<?=$_SERVER['HTTP_HOST']?>/home/listar/contato"><i class="hidden-tablet"><img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/32/address_book.png" width="16"/></i> Contatos</a>
										</li>

										<li>
											<a title="Aqui você registra todas as atividades de um relacionamento comercial que fizer com suas Contas e Contatos, e assim tem um histórico detalhado." href="http://<?=$_SERVER['HTTP_HOST']?>/home/listar/historico"><i class="hidden-tablet"><img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/16/users.png"/></i>Hist&oacute;ricos</a>
										</li>

										<li>
											<a title="Aqui você cadastra as suas propostas comerciais e acompanha o andamento delas." href="http://<?=$_SERVER['HTTP_HOST']?>/home/listar/oportunidade"><i class="icon-briefcase icon-black"></i>&nbsp;Oportunidades</a>
										</li>
									</ul>
								</li>

								<li>
									<a href="#" onclick="return false" title="Gerencie aqui seu fluxo de caixa e suas contas a pagar e receber">
										<span class="da-nav-icon">
											<img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/32/cur_dollar.png" alt="FINANCEIRO"/>
										</span>
										FINANCEIRO
									</a>

									<ul>
										<li >
											<a title="Aqui Registre suas contas a receber, a pagar e os atrasados." href="http://<?=$_SERVER['HTTP_HOST']?>/home/lancamento">
												<i class="hidden-tablet"><img  src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/16/money.png"  width="16"/> </i>
												Lan&ccedil;amentos
											</a>
										</li>

										<li>
											<a title="Acompanhe de perto as finanças de sua empresa." href="http://<?=$_SERVER["HTTP_HOST"]?>/home/fluxo">
												<i class="hidden-tablet"><img  src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/32/graph.png"  width="16"/> </i>
												Fluxo de caixa
											</a>
										</li>

										<li>
											<a title="Confirme seus pedidos de venda gerados e lance-os em suas contas a pagar e receber" href="http://<?=$_SERVER["HTTP_HOST"]?>/home/faturamento">
												<i class="icon-tasks  hidden-tablet"></i>
												Pr&eacute;-faturamento
											</a>
										</li>

										<li>
											<a title="Acompanhe aqui os boletos enviado e suas cobran&ccedil;as" href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/boletos">
												<i class="icon-barcode icon-black"></i>
												Cobran&ccedil;a
											</a>
										</li>
									</ul>
								</li>

								<li>
									<a href="#" onclick="return false" title="Gerencie aqui seu pedidos de venda e comiss&otilde;es">
										<span class="da-nav-icon">
											<img src="http://<?=$_SERVER["HTTP_HOST"]?>/images/icons/black/32/maleta.png" alt="VENDAS"/>
										</span>
										VENDAS
									</a>

									<ul>
										<li>
											<a title="Acompanhe aqui quanto seus vendedores est&atilde;o recebendo por suas vendas" href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/comissoes">
												<i class="hidden-tablet"><img src="http://<?=$_SERVER["HTTP_HOST"]?>/img/ico_porcentagem.png" alt="VENDAS"/></i>
												Comiss&otilde;es
											</a>
										</li>
										<li>
											<a title="Transforme suas propostas em vendas e envia para o financeiro" href="http://<?=$_SERVER["HTTP_HOST"]?>/home/listar/pedidos">
												<i class=" icon-list-alt hidden-tablet"></i>
												  Pedidos de venda
											</a>
										</li>
									</ul>
								</li>

								<!--li>
									<a href="http://bobsoftware.com.br/erp/projetos/listar" title="Gerencie aqui seus projetos">
										<i class="hidden-tablet"><img style="height: 20px;width: 15px;margin-left: -30px;margin-right: 10px;" src="http://<?=$_SERVER["HTTP_HOST"]?>/img/ico_projeto.png" alt="Projetos"/></i>
										PROJETOS
									</a>
								</li-->

								<li class="bg_none">
									&nbsp;
								</li>
							</ul>
						</nav>
						<!-- Navegação Central # Fim -->

						<!-- Publicidade -->
						<!--aside id="da-publicidade" onmouseover="mouse(this);" onclick="fLink('http://bobsoftware.com.br/erp/planos');">
							<div class="">
								<img src="img/banner.jpg" alt=""/>
							</div>
							<div class="clear"></div>
						</aside-->
						<!-- Publicidade # Fim -->
					</div>
					<!-- Barra Lateral # Fim -->
					<!-- Área de Conteúdo -->
					<a class="p_abs top_0 lft_0 hidden-phone" style="margin: 70px 0 0 2%; z-index:199;" href="javascript:window.history.back();" title="Voltar">« Voltar</a>
					
					<script>
						function GravarLembreteTemplate(id) 
						{
							var url = dominio + diretorio() + "/interacoes/GravarLembrete";

							CarregandoAntes();
							
							$.post(url, {data:$("#data_lembrete_template").val(),hora:$("#hora_lembrete_template").val(),obs:$("#desc_lembrete_template").val()}, function (data) 
							{
								var resp = data.split("|");	
								
								CarregandoDurante();
								
								if (resp[0] == 1) 
								{
									$("#data_lembrete_template").val('16/01/2014');
									$("#hora_lembrete_template").val('');
									$("#desc_lembrete_template").val('');
									$("#modal-lembrete-template").modal('hide');
								}

								$("#msg_loading").html(resp[1]);

								CarregandoDepois('',3000);
							});
						}
					</script>

					<a id="label_lembretes" class="p_abs top_0 lft_0 hidden-phone" style="margin: 70px 0 0 5%; z-index:199;" onmouseover="mouse(this);" title="N&atilde;o perca seus compromissos"  href="#modal-lembrete-template" data-toggle="modal">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="label label-inverse">&#43; Novo Lembrete</span> <!-- 70px -->
					</a>
					<!-- Conteúdo -->
					<div id="da-content-wrap" class="clearfix p_rel">
						<a class="btn btn-large p_abs top_0 lft_0 visible-phone" style="margin: -52px 0 0 0; z-index:198;" href="javascript: history.back;" title="Voltar"><i class="icon-chevron-left icon-black"></i> Voltar</a>

						<!-- Início -->
						<?php 
							/*$url = strrchr($_SERVER["REQUEST_URI"], "?");
							$url = str_replace($url, "", $_SERVER["REQUEST_URI"]);
							$url = explode("/", $url);
							array_shift($url);
							echo "<pre>";
							print_r ($_SERVER);
							echo "</pre>";
							//print_r($_SERVER['REQUEST_URI']);
							echo file_exists("/pages".$_SERVER["REQUEST_URI"].".php");
							
							/*if(!empty($url[0])) {
								if(file_exists("/pages/{$url[0]}.php")) {
									include("/pages/{$url[0]}.php");
								} else {
									include("/pages/main.php");
								}
							} else {*/
                            set_include_path("pages"); //funcionava com este
							/*if(isset($_GET["pg"])) {
								include($_GET["pg"]);
							} else {
                                echo $_GET["pg"];
								include("/pages/main.php");
							}*/
							//echo $_GET["pg"];
                            include($_GET["pg"].".php"); //funcionava com este
							/*$page = "main";
							if (isset($_POST['page'])) {
								$page = $_POST['page'];
							} else { 
								if(isset($_GET['page'])) {
									$page = $_GET['page'];
								}
							}*/
							/*include_once("pages/" . $page . ".php"); */
						?>
						<!-- Fim -->
					</div>
					<!-- Área de Conteúdo # Fim -->
				</div>
				<!-- Frame Conteúdo # Fim -->
			</div>

			<!-- Rodapé -->
			<div id="da-footer"   >
				<div class="da-container clearfix">
					<p>Copyright <?= date('Y')?> | eBoss! Commerce | Todos os direitos reservados.</p>
				</div>
			</div>

			<div class="modal hide" id="modal-lembrete-template">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&#215;</button>
					<h2 class="pr_5 mr_0">
						Novo lembrete
						<i style="cursor: pointer;" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);" title="N&atilde;o se preocupe com o excesso de atividades, um e-mail ser&aacute; enviado para voc&ecirc; sempre que um lembrete for salvo !"></i>
					</h2>
				</div>
				<div class="modal-body" style="height:285px;overflow:hidden;">
				   <div class="form-horizontal">
						<form>
							<fieldset>
								<div class="control-group">
									<input type="hidden" name="id_tf" id="id_tf" class="input_maior" value="" />

									<div class="control-group">
										<label class="control-label">*Enviar em:</label>

										<div class="controls">
											<input type="text" name="data_lembrete_template" id="data_lembrete_template" class="datepicker" value="16/01/2014"/>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">*Hor&aacute;rio do compromisso:</label>

										<div class="controls">
											<input type="text" name="hora_lembrete_template" id="hora_lembrete_template" value=""/>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label"> *Descri&ccedil;&atilde;o:</label>

										<div class="controls">
											<textarea id="desc_lembrete_template" name="desc_lembrete_template" rows="5" cols="40"></textarea>
										</div>
									</div>

									<div class="control-group">
										<div class="controls al_rgt">
											<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
											<a class="btn btn-primary" onclick="GravarLembreteTemplate();">Salvar</a>
										</div>
									</div>
								</div>	
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
        <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible">
        </div>
        <!--ul class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" role="listbox" aria-activedescendant="ui-active-menuitem" style="z-index: 1; top: 0px; left: 0px; display: none;">
        </ul-->
	</body>
</html>