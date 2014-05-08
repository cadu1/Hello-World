<!-- Início -->
<?php
    include("lib/connection.php");
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//exit();
    $id = "";
    $status = "";
    $nome = "";
    $email = "";
    $site = "";
    $conta = "";
    $fone = "";
    $fone2 = "";
    $origem = "";
    $uf = "";
    $cidade = "";
    $cep = "";
    $rua = "";
    $numero = "";
    $complemento = "";
    $bairro = "";
    $obs = "";
    $cod_usu = "";
    $nome_usu = "";
    $msg = "";
    $alert = true;
    
    if($_POST) {
        $id = $_POST["cod_lead"];
        $status = $_POST["status"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $site = $_POST["site"];
        $conta = $_POST["conta"];
        $fone = $_POST["fone"];
        $fone2 = $_POST["fone2"];
        $origem = empty($_POST["origem"]) ? "NULL" : $_POST["origem"];

        $uf = empty($_POST["uf"]) ? "NULL" : $_POST["uf"];
        $cidade = $_POST["cidade"];
        $cep = $_POST["cep"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $complemento = $_POST["complemento"];
        $bairro = $_POST["bairro"];
        $obs = $_POST["obs"];
        $cod_usu = $_POST["cod_usuario"];
        
        $endereco_id = "NULL";
        $informacao_id = "NULL";

        if(empty($nome) && (empty($email) || empty($fone))) {
            $alert = false;
            $msg = "<tr><td><b>Preencha todos os campos</b></td></tr><tr><td>Preencha Corretamente o campo Nome</td></tr><tr><td>Preencha Corretamente um dos campos: Telefone e/ou E-mail</td></tr>";
        } else {
            if(isset($_GET["action"]) && ($_GET["action"] == "insere" || $_GET["action"] == "novo") && empty($id)) {
                if(!empty($cidade) || !empty($cep) || !empty($rua) || !empty($numero) || !empty($complemento) || !empty($bairro)) {
                    mysql_query("INSERT INTO `endereco` VALUES (NULL, '$rua', '$numero', '$complemento', '$cep', '$bairro', $cidade)");
                    $endereco_id = mysql_insert_id();
                }
                $dt_atual = date("Y-m-d");
                mysql_query("INSERT INTO `informacao` VALUES (NULL, $origem, '$email', '$site', '$fone', '$fone2', '$obs', '$dt_atual')");
                $informacao_id = mysql_insert_id();

                $alert = mysql_query("INSERT INTO `lead` VALUES (NULL, $status, $endereco_id, $informacao_id, $cod_usu, '$nome', '$conta')");
                if($alert) {
                    $msg = "Cadastrado com sucesso";
                } else {
                    $msg = "<tr><td>Problemas ao cadastro o Lead, tente novamente!</td></tr>";
                }
            } elseif(isset($_GET["action"]) && ($_GET["action"] == "insere" || $_GET["action"] == "novo") && !empty($id)) {
                $query = mysql_query("SELECT `endereco_id`, `informacao_id` FROM `lead` WHERE `lead_id` = $id");
                $lead = mysql_fetch_array($query); 
                
                if(!empty($cidade) || !empty($cep) || !empty($rua) || !empty($numero) || !empty($complemento) || !empty($bairro)) {
                    if(empty($lead[0])) {
                        mysql_query("INSERT `endereco` VALUES (NULL, '$rua', '$numero', '$complemento', '$cep', '$bairro', $cidade)");
                        $endereco_id = mysql_insert_id();
                    } else {
                        $endereco_id = $lead[0];
                        mysql_query("UPDATE `endereco` SET endereco_logradouro = '$rua', endereco_numero = '$numero', endereco_complemento = '$complemento', endereco_cep = '$cep', endereco_bairro = '$bairro', endereco_cidade = $cidade WHERE endereco_id = $endereco_id");
                    }
                }
                if(empty($lead[1])) {
                    mysql_query("INSERT INTO `informacao` VALUES (NULL, $origem, '$email', '$site', '$fone', '$fone2', '$obs')");
                    $informacao_id = mysql_insert_id();
                } else {
                    $informacao_id = $lead[1];
                    mysql_query("UPDATE `informacao` SET informacao_origem = $origem, informacao_email = '$email', informacao_site = '$site', informacao_telefone = '$fone', informacao_telefone2 = '$fone2', informacao_obs = '$obs' WHERE `endereco_id` = $informacao_id");
                }
                $alert = mysql_query("UPDATE `lead` SET situacao_id = $status, endereco_id = $endereco_id, informacao_id = $informacao_id, lead_nome = '$nome', lead_conta = '$conta' WHERE `lead_id`= $id");
                if($alert) {
                    $msg = "Alterado com sucesso";
                } else {
                    $msg = "<tr><td>Problemas ao alterar o Lead, tente novamente!</td></tr>";
                }
            }
            if(isset($_GET["action"]) && $_GET["action"] == "novo") {
                if($alert) {
                    $id = "";
                    $status = "";
                    $nome = "";
                    $email = "";
                    $site = "";
                    $conta = "";
                    $fone = "";
                    $fone2 = "";
                    $origem = "";
                    $uf = "";
                    $cidade = "";
                    $cep = "";
                    $rua = "";
                    $numero = "";
                    $complemento = "";
                    $bairro = "";
                    $obs = "";
                    $cod_usu = "";
                }
            }
        }
        //$query = mysql_query("INSERT INTO ");
    } elseif (isset($_GET["action"]) && $_GET["action"] == "altera") {
        $id = $_GET["id"];
        $query = mysql_query("SELECT `l`.`situacao_id`, `l`.`lead_nome`, `i`.`informacao_email`, `i`.`informacao_site`, `l`.`lead_conta`, `i`.`informacao_telefone`, `i`.`informacao_telefone2`, `i`.`origem_id`, `c`.`cidade_id`, `c`.`estado_id`, `e`.`endereco_cep`, `e`.`endereco_logradouro`, `e`.`endereco_numero`, `e`.`endereco_complemento`, `e`.`endereco_bairro`, `i`.`informacao_obs`, `u`.`usuario_nome`, `l`.`usuario_id` FROM `lead` `l` JOIN `informacao` `i` ON `l`.`informacao_id` = `i`.`informacao_id` LEFT JOIN `endereco` `e` ON `l`.`endereco_id` = `e`.`endereco_id` LEFT JOIN `cidade` `c` ON `e`.`cidade_id` = `c`.`cidade_id` LEFT JOIN `estado` `uf` ON `c`.`estado_id` = `uf`.`estado_id` LEFT JOIN `origem` `o` ON `i`.`origem_id` = `o`.`origem_id` JOIN `situacao` `s` ON `l`.`situacao_id` = `s`.`situacao_id` JOIN `usuario` `u` ON `l`.`usuario_id` = `u`.`usuario_id` WHERE `l`.`lead_id` = $id");
        $lead = mysql_fetch_row($query);
        $status = $lead[0];
        $nome = $lead[1];
        $email = $lead[2];
        $site = $lead[3];
        $conta = $lead[4];
        $fone = $lead[5];
        $fone2 = $lead[6];
        $origem = $lead[7];
        $uf = $lead[8];
        $cidade = $lead[9];
        $cep = $lead[10];
        $rua = $lead[11];
        $numero = $lead[12];
        $complemento = $lead[13];
        $bairro = $lead[14];
        $obs = $lead[15];
        $nome_usu = $lead[16];
        $cod_usu = $lead[17];
    }
?>
<div id="da-content-area">
	<script>
		$(function () {
			MascaraFoneNova('fone');
			MascaraFoneNova('fone2');
		});

		function busca_cidades(estado) {
			var url = dominio + diretorio() + "/home/BuscaCidades/"+estado;

			ajaxHTMLProgressBar('resp_cidade', url, false, false);
		}

		function converter() {
			var url = dominio + diretorio() + "/leads/Converter/" + $("#cod_lead").val();
			var lead = $("#cod_lead").val();

			if (lead == "") {
				alert("Verifique o campo lead");

				return false;
			}

			var status = $("#status").val();
			var nome = $("#nome").val();
			var email = $("#email").val();
			var site = $("#site").val();
			var conta = $("#conta").val();
			var fone = $("#fone").val();
			var fone2 = $("#fone2").val();
			var origem = $("#origem").val();
			var uf = $("#uf").val();
			var cidade = $("#cidade").val();
			var cep = $("#cep").val();
			var rua = $('#rua').val();
			var numero = $("#numero").val();
			var complemento = $("#complemento").val();
			var bairro = $("#bairro").val();
			var obs = $("#obs").val();
		   
			// Exibe mensagem de carregamento
			CarregandoAntes();
		   
			$.post(url, {status:status, nome:nome, email:email, site:site, conta:conta, fone:fone,fone2:fone2, cidade:cidade, cep:cep, rua:rua, numero:numero, complemento:complemento, bairro:bairro,uf:uf,origem:origem,obs:obs}, function (resposta) {
				resposta = resposta.split("|");

				CarregandoDurante();
				
				if (resposta[0] == 1) {
					window.location = "http://bobsoftware.com.br/erp/crm/contatos_form/visualizar/"+resposta[1];
				} else {
					if (resposta[0] == -1) {
						$("#msg_loading").html('Lead J&aacute; existe');
					}
					if(resposta[0]==-2) {
						$("#msg_loading").html('Informe a conta');
					}
                    if(resposta[0]==-3) {
						$("#msg_loading").html('Informe a conta e o contato');
					} else {
						$("#msg_loading").html('Erro durante o processo');
					}
				}
				CarregandoDepois('loading',2000);
			});
		} //converter

        //############# Origem ############# 		
		function GravarOrigem() {
			CarregandoAntes();
			
			var url = dominio + diretorio() + "/home/GravarOrigem";
			
			$.post(url,{nome:$("#input_origem").val()}, function(data) {
				var resp = data.split("|");
				
				CarregandoDurante();
				
				if(resp[0]==1) {
					$("#input_origem").val('');
					
					BuscarOrigem();
					BuscarOrigemSelect();
					
					$("#msg_loading").html(resp[1]);
				} else {
					$("#msg_loading").html(resp[1]);
				}
				CarregandoDepois('loading',2000);
			});
		}

		function BuscarOrigem() {
			dominio =  "http://"+document.domain;
			var url = dominio + diretorio() + "/home/BuscarOrigem/"+$("#input_origem").val();

			ajaxHTMLProgressBar('resp_origem', url, false, false);
		}

		function BuscarOrigemSelect() {
			var url = dominio + diretorio() + "/home/BuscarOrigemSelect/"+$("#origem").val();

			ajaxHTMLProgressBar('resp_origem_select', url, false, false);
		}

		function EditarOrigem(i) {
			var id ="#"+i;
			var label = $(id).html();
			var campo = id.split("_");
			var idorigem = campo[1];
			
			$(id).editable(dominio+diretorio()+"/home/EditarOrigem",{
				name 		: 'nome',
				width   	: 180,
				height   	: 20,
				submitdata : {id:idorigem,label:label },
				submit		: 'OK',
			});

			BuscarOrigemSelect(id);
		}

		function DeletarOrigem(i) {
			CarregandoAntes();
			
			var url = dominio + diretorio() + "/home/DeletarOrigem";
			$.post(url,{id:i}, function(data)
			{
				BuscarOrigem();
				BuscarOrigemSelect();
				
				$("#loading").hide();
			});
		}
        //##################################
	</script>
	<article>
		<div class="modal hide" id="modal_origem" style="width:500px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&#215;</button>
				<h2 class="pr_5 mr_0">Origens</h2>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<fieldset>
						<div class="well control-group">
							<label style="display:inline;">Nova:</label>
							&nbsp;
							<div style="display:inline;">
								<input type="text" onkeyup="BuscarOrigem();" name="input_origem" id="input_origem" size="15" maxlength="50" value=""/>
								<a class="btn btn-primary" onclick="GravarOrigem();">Salvar</a>
								<div onmouseover="$('#tip_origem').tooltip();">
									&nbsp;
									<i onmouseover="mouse(this);$(this).tooltip();" id="tip_origem"  data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black flt_rgt" data-original-title="Digite o nome de uma origem existente.Para criar uma nova, clique em salvar.Para editar d&ecirc; um duplo clique sobre alguma origem existente.Para deletar clique no 'x' do lado direito da origem">
									</i>
								</div>
							</div>
						</div>

						<div id="resp_origem" align="center"></div>
					</fieldset>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
			</div>
		</div>

		<div class="grid_4">
			<div class="da-panel">
				<div class="da-panel-header">
					<span class="da-panel-title">
						<span class="label label-inverse pr_5">
							<i>
								<img src="http://<?=$_SERVER["HTTP_HOST"]?>/application/images/icons/white/16/user_comment.png"/>
							</i>
						</span>&nbsp;
						<strong class="tt_uc">Leads</strong>
						<span class="box_tools_space"></span>
					</span>
					<span class="da-panel-btn">
						<a href="http://<?=$_SERVER["HTTP_HOST"]?>/home/form/lead" class="btn btn-primary">
							<i class="icon-plus icon-white"></i>Novo
						</a>
					</span>
				</div>

				<div class="da-panel-content">
					<div class="da-panel-padding">
                        <?php if(strlen($msg) > 0): if($alert): ?>
                        <div id="alert1" class="alert alert-success"><?=$msg?></div>
                        <?php else: ?>
                        <div id="alert2" class="alert alert-error">
                            <table align="center">
                                <tbody><?=$msg?></tbody>
                            </table>
                        </div>
                        <?php endif; endif; ?>
						<form action="http://<?=$_SERVER["HTTP_HOST"]?>/home/form/lead/valida/inserir" method="post" enctype="multipart/form-data" name="form_leads" id="form_leads" class="form-horizontal">
							<fieldset>
								<input type="hidden" name="cod_lead" id="cod_lead" value="<?=$id?>"/>

								<span class="badge flt_rgt">Cadastrado por: <?=empty($cod_usu) ? $_COOKIE['nome'] : $nome_usu?>
									<input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=empty($cod_usu) ? $_COOKIE['id'] : $cod_usu?>"/>
								</span>

								<div class="control-group">
									<label class="control-label">* Situa&ccedil;&atilde;o</label>
									<div class="controls">
										<select name="status" id="status" class="span4">
                                        <?php
                                            $situacao = mysql_query("SELECT * FROM `situacao` WHERE `situacao_lead` IS TRUE");
                                            while($sit = mysql_fetch_array($situacao)):
                                        ?>
                                            <option  value='<?=$sit["situacao_id"]?>'<?=$sit["situacao_id"] == $status ? " checked='true'" : "" ?>><?=$sit["situacao_nome"]?></option>
                                        <?php endwhile; ?>
										</select>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">*Nome</label>
									<div class="controls">
										<input type="text" name="nome" id="nome" class="input_full" placeholder="Digite o nome"  value="<?=$nome?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">*E-mail</label>
									<div class="controls">
										<input type="text" name="email" id="email" class="input_full" placeholder="Digite o e-mail"  value="<?=$email?>"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Site</label>
									<div class="controls">
										<input type="text" name="site" id="site" class="input_full" placeholder="Digite o site"  value="<?=$site?>"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Conta</label>
									<div class="controls">
										<input type="text" name="conta" id="conta" class="input_full" placeholder="Digite a conta" value="<?=$conta?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">*Telefone</label>
									<div class="controls">
										<input type="text" placeholder="Digite o telefone" class="input_full" name="fone" id="fone" size="20"  maxlength="20" value="<?=$fone?>"/>
										<i title="Nono d&iacute;gito obrigat&oacute;rio para os ddd's de celulares de 11 at&eacute; 19" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left" id="tip_fone1"></i>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Telefone&nbsp;2:</label>
									<div class="controls">
										<input type="text" placeholder="Digite o telefone" class="input_full" name="fone2" id="fone2" size="20" maxlength="20" value="<?=$fone2?>"/>
										<i title="Nono d&iacute;gito obrigat&oacute;rio para os ddd's de celulares de 11 at&eacute; 19" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left" id="tip_fone2"></i>
									 </div>
								</div>

								<div class="control-group">
									<label class="control-label">Origem:</label>
									<div class="controls">
										<div id="resp_origem_select">
											<select name="origem" id="origem">
												<option value="">Selecione</option>
												<?php
                                                    $situacao = mysql_query("SELECT * FROM `origem`");
                                                    while($sit = mysql_fetch_array($situacao)):
                                                ?>
                                                    <option  value='<?=$sit["origem_id"]?>'<?=$sit["origem_id"] == $origem ? " checked='true'" : ""?>><?=$sit["origem_nome"]?></option>
                                                <?php endwhile; ?>
											</select>
											<a class="badge badge-inverse" href="#modal_origem" onclick="BuscarOrigem();" onmouseover="mouse(this);" data-toggle="modal" style="cursor: pointer;">Editar</a>
										</div>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Estado</label>
									<div class="controls">
										<input type="hidden" name="uf" id="uf" value=""/>
										<select name="uf" id="uf" onchange="busca_cidades(this.value);" >
                                            <option value="">Selecione</option>
                                            <?php
                                                $estado = mysql_query("SELECT * FROM `estado`");
                                                while($est = mysql_fetch_array($estado)):
                                            ?>
                                                <option value='<?=$est['estado_id']?>'<?=$est['estado_id'] == $estado ? " checked='true'" : ""?>><?=$est['estado_nome']?></option>
                                            <?php endwhile; ?>
										</select>
									</div>	
								</div>

                                <div class="control-group">
                                    <label class="control-label">Cidade:</label>
                                    <div class="controls">
                                        <input type="hidden" name="cidade" id="cidade" value=""/>
                                        <div id="resp_cidade">	
                                            <select name="cidade" id="cidade">
                                                <option value="">Selecione</option>
                                                <?php
                                                    if(!empty($estado)):
                                                        $query = mysql_query("SELECT * FROM `cidade` WHERE `estado_id` = $estado");
                                                    while($est = mysql_fetch_row($query)):
                                                ?>
                                                <option value="<?=$est[0]?>"<?=$est[2] == $estado ? " checked='true'" : ""?>><?=$est[1]?></option>
                                                <?php endwhile; endif; ?>
                                            </select>
                                        </div>	
                                    </div>
                                </div>

								<div class="control-group">
									<label class="control-label">CEP:</label>
									<div class="controls">
										<input class="input_bootstrap" placeholder="Digite o CEP" name="cep" id="cep" value="<?=$cep?>" size="9" onkeydown="Mascara(this,Cep);" onkeypress="Mascara(this,Cep);" onkeyup="Mascara(this,Cep);" maxlength="9"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Rua:</label>
									<div class="controls">
										<input class="input_bootstrap" placeholder="Digite a rua" name="rua" id="rua" value="<?=$rua?>" size="50"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">N&#176;</label>
									<div class="controls">
										<input class="input_bootstrap" placeholder="Digite o N&uacute;mero" name="numero" id="numero" value="<?=$numero?>" size="20"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Complemento</label>
									<div class="controls">
										<input name="complemento" class="input_bootstrap" placeholder="Digite o complemento" id="complemento" value="<?=$complemento?>" size="20"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Bairro:</label>
									<div class="controls">
										<input name="bairro" id="bairro" class="input_bootstrap" placeholder="Digite o bairro"  value="<?=$bairro?>" size="50"/>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">Observa&ccedil;&otilde;es:</label>
									<div class="controls">
										<textarea class="input_full" name="obs" id="obs"><?=$obs?></textarea>
									</div>
								</div>

								<div class="form-actions al_rgt">
									<button class="btn btn-inverse" onclick="window.location='<?=$_SERVER['HTTP_HOST']?>/home/listar/lead; return false;">
										<i class="icon-remove icon-white"></i> 
										Cancelar
									</button>
									<button href="javascript:void(0)" onclick="$('#form_leads').attr('action','http://<?=$_SERVER["HTTP_HOST"]?>/home/form/lead/valida/inserir');$('#form_leads').submit();" class="btn btn-success">
										<i class="icon-ok icon-white"></i> Salvar
									</button>
									<button href="javascript:void(0)" onclick="$('#form_leads').attr('action','http://<?=$_SERVER["HTTP_HOST"]?>/leads/valida/inserir/novo');$('#form_leads').submit();" class="btn btn-primary">
										<i class="icon-plus icon-white"></i> Salvar e novo
									</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal hide" id="modal-converter">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&#215;</button>
				<h2 class="pr_5 mr_0">Convers&atilde;o</h2>
			</div>
			<div class="modal-body">
				<h5>
					O processo de convers&atilde;o &eacute; irrevers&iacute;vel.<br/><br/>
					Ap&oacute;s ser convertido, o lead n&atilde;o ser&aacute; mais exibido.<br/><br/>
				</h5>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
				<a onclick="converter();" class="btn btn-primary">Converter Lead</a>
			</div>
		</div>

		<div class="clear"></div>
	</article>
</div>
<!-- Fim -->