<?php
    session_start();
?>
<!doctype html public "✰">
<!--[if lt IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br" class="no-js"><!--<![endif]-->

<head>

<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
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

<!-- jQuery JavaScript File 
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>-->
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/jquery-1.7.2.min.js"></script>

<!-- Modernizr JavaScript File 
<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js"></script>
<script>window.jQuery || document.write('<script src="js/modernizr-2.5.3.min.js"><\/script>')</script>-->
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/modernizr-2.5.3.min.js"></script>

<!-- LessCSS JavaScript File 
<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>
<script>window.jQuery || document.write('<script src="js/less-1.3.0.min.js"><\/script>')</script>-->
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/js/less-1.3.0.min.js"></script>

<!-- zclip -->
<script type="text/javascript" src="js/jquery.zclip.js"></script>

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

<script type="text/javascript" src="http://<?=$_SERVER["HTTP_HOST"]?>/jui/js/jquery.ui.touch-punch.min.js"></script>

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

				CarregandoDepois('loading',3000)
			});
		}
	}
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

<body class='login'>

<div id="da-wrapper" class="fluid">

<!--div class="modal box_getting fade hide hidden-phone" style="width: 940px; height: 400px;" id="bem_vindos">
    <a href="#" class="p_abs" style="z-index: 9999; right: -10px; top: -10px;" data-dismiss="modal"><img
            src="img/close_button.png" class="max_w"/></a>

    <div id="getting_started">
        <img src="img/1.jpg" class="max_w"/>
        <img src="img/2.jpg" class="max_w"/>
        <img src="img/3.jpg" class="max_w"/>
    </div>
</div-->

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

<div id="da-content-center">
    <script>
		function LembreteSenha()
		{
			var email = $("#da-login-username").val();

			if(email=="")
			{
				$("#success").hide();
				$("#error").html("Digite seu e-mail de login e clique em 'Esqueci minha senha' novamente");
				$("#error").show();
			}
			else
			{
				var url = dominio+diretorio()+"/login/LembreteSenha";
				
				CarregandoAntes();
				$.post(url,{email:email}, function (data) {
					resp = data.split("|");

					CarregandoDurante();

					if(resp[0]==1)
					{
						$("#error").hide();
						$("#success").html(resp[1]);
						$("#success").show();
					}
					else
					{
						$("#success").hide();
						$("#error").html(resp[1]);
						$("#error").show();
					}
					CarregandoDepois();
				});
			}
		}

		$(document).ready(function () {
		});
	</script>

	<div id="da-wrapper" class="fixed2">
		<div id="da-content">
			<div class="da-container clearfix">
				<div id="da-content-wrap" class="clearfix">
					<div id="da-content-area">
						<div id="da-login">
							<div id="da-login-box-wrapper">
										<!--div class="box_personagem1 hidden-phone">
											<div></div>
										</div-->
								<div id="da-login-top-shadow">
								</div>

								<div id="da-login-box" class="al_ctr">
									<!--div id="da-login-box-header">
												<img src="img/bob-software.png" height="65" alt="Bob Software" />
									</div-->

									<div id="da-login-box-content">
										<div class="alert alert-success" style="display:none;margin-left:-36px;width:222px;" id="success">
                                        </div>
                                        <?php
                                            if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
                                                echo "<div class='alert alert-error al_lft' style='display:inline;padding: 8px;' id='error'>"; 
                                                echo $_SESSION['msg'];
                                                echo "</div>";
                                                unset($_SESSION['msg']);
                                            }
                                        ?>

										<form id="da-login-form" style="margin-top: 20px;" method="post" action="http://<?=$_SERVER['HTTP_HOST']?>/valida/login" enctype="multipart/form-data">
											<div id="da-login-input-wrapper">
												<div class="da-login-input">
													<input type="text" name="email" id="da-login-username" placeholder="Login"/>
												</div>

												<div class="da-login-input">
													<input type="password" name="senha" id="da-login-password"  placeholder="Senha"/>
												</div>
											</div>

											<div id="da-login-button">
												<input type="submit" value="Entrar" id="da-login-submit"/>
											</div>
										</form>
									</div>

									<div id="da-login-box-footer">
										<a onclick="LembreteSenha();" onmouseover="mouse(this);">Esqueci minha senha</a>
									</div>

								</div>
								<div id="da-login-bottom-shadow">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		<!--
		$('#form input').keydown(function (e) {
			if (e.keyCode == 13) {
				$('#form').submit();
			}
		});
		//-->
	</script>
</div>
    
<!-- Rodapé -->
<!--div class="modal hide" id="modal-lembrete-template">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&#215;</button>
        <h2 class="pr_5 mr_0">
			Novo lembrete
			<i style="cursor: pointer;" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);" title="N&atilde;o se preocupe com o excesso de atividades, um e-mail ser&aacuaacute; enviado para voc&ecirc; sempre que um lembrete for salvo !"></i>
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
</div-->	

</body>
</html>