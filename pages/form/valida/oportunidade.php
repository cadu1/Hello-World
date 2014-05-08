<?php
//    header("Location: http://{$_SERVER['HTTP_HOST']}/home/listar/pedidos/gerar/1");
//    exit();
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
/*	exit();*/
	include("../../lib/connection.php");

	$gerar_pedido = "";
	$cod_opt = "";
	$cod_grupo = "";
	$cod_versao = "";
	$hpedido_acao = "";
	$hrepetir_data_parcelas = ""; 
	$hdata_comissoes_pedido = "";
	$hconta_comissoes_pedido = "";
	$hcategoria_comissoes_pedido = ""; 
	$hdata_parcelas_pedido = "";
	$hconta_parcelas_pedido = "";
	$hcategoria_parcelas_pedido = ""; 
	$cod_usuario = "";
	$data = "";
	$nome = "";
	$descricao = "";
	$servico = "";
	$tipo_parcela = "";
	$parcela_servico = ""; 
	$negociacao = "";
	$qtd_parcelas = "";
	$prospect = "";
	$nomeconta = "";
	$codconta = "";
	$nomecontato = "";
	$codcontato = "";
	$fechamento = "";
	$situacao = "";
	$chance = "";
	$nomecon = "";
	$codcon = "";
	$tipocon = "";
	$codvendedor = "";
	$vendedor = "";
	$erro = "";
    $msg = "";
	
	if($_POST) {
		$gerar_pedido = $_POST['gerar_pedido'];
		$cod_opt = $_POST['cod_opt'];
		//$cod_grupo = $_POST['cod_grupo'];
		//$cod_versao = $_POST['cod_versao'];
		$hpedido_acao = $_POST['hpedido_acao'];
		$hrepetir_data_parcelas = $_POST['hrepetir_data_parcelas']; 

		$hconta_comissoes_pedido = $_POST['hconta_comissoes_pedido'];
		$hcategoria_comissoes_pedido = $_POST['hcategoria_comissoes_pedido']; 
		$hconta_parcelas_pedido = $_POST['hconta_parcelas_pedido'];
		$hcategoria_parcelas_pedido = $_POST['hcategoria_parcelas_pedido']; 
		$cod_usuario = $_POST['cod_usuario'];
		$nome = $_POST['nome'];
		$descricao = $_POST['descricao'];
		$tipo_parcela = $_POST['tipo_parcela'];
		$parcela_servico = $_POST['parcela_servico']; 
		$negociacao = isset($_POST['negociacao']) ? $_POST['negociacao'] : "";
		$qtd_parcelas = $_POST['qtd_parcelas'];
		$prospect = isset($_POST['prospect']) ? $_POST['prospect'] : "";
		$nomeconta = $_POST['nomeconta'];
		$nomecontato = $_POST['nomecontato'];
		$situacao = $_POST['situacao'];
		$nomecon = $_POST['nomecon'];
		$tipocon = $_POST['tipocon'];
		$codvendedor = $_POST['codvendedor'];
		$vendedor = empty($_POST['vendedor']) ? "NULL" : $_POST['vendedor'];

		$codcontato = empty($_POST['codcontato']) ? "NULL" : $_POST['codcontato'];
		$codconta = empty($_POST['codconta']) ? "NULL" :$_POST['codconta'];
		$codcon = empty($_POST['codcon']) ? "NULL" : $_POST['codcon'];
		$fechamento = $_POST['fechamento'];
		$fecha = date("Y-m-d", strtotime(str_replace("/", "-", $fechamento)));
		$hdata_comissoes_pedido = $_POST['hdata_comissoes_pedido'];
		$dt_comissao = date("Y-m-d", strtotime(str_replace("/", "-", $hdata_comissoes_pedido)));
		$data = $_POST['data'];
		$dt = date("Y-m-d", strtotime(str_replace("/", "-", $data)));
		$chance = $_POST['chance'];
		$servico = $_POST['servico'];
		$serv = str_replace(",", ".", $servico);
		$hdata_parcelas_pedido = $_POST['hdata_parcelas_pedido'];
		$dt_parcela  = date("Y-m-d", strtotime(str_replace("/", "-", $hdata_parcelas_pedido)));

		if(empty($fechamento)) {
			$erro .= "<tr><td>Informe a data de fechamento</td></tr>";
		}
		if(empty($nome)) {
			$erro .= "<tr><td>Informe um nome para a oportunidade</td></tr>";
		}
		if(empty($situacao)) {
			$erro .= "<tr><td>Selecione a situação da oportunidade</td></tr>";
		}
		if(empty($chance)) {
			$erro .= "<tr><td>Informe a chance de sucesso</td></tr>";
		}
		if(empty($codcontato)) {
			$erro .= "<tr><td>Selecione o contato desta oportunidade</td></tr>";
		}
		if(empty($prospect)) {
			$erro .= "<tr><td>Informe quem é o prospect</td></tr>";
			if($prospect == "conta" && empty($codconta)) {
				$erro .= "<tr><td>Selecione a conta desta oportunidade</td></tr>";
			}
		}
		if(!empty($gerar_pedido)) {
			if(empty($situacao) || (int)$situacao != 1) {
				$erro .= "<tr><td>Para gerar o pedido é necessário que a oportunidade esteja <strong>ganha</strong></td></tr>";
			}
			if(empty($hdata_parcelas_pedido)) {
				$erro .= "<tr><td>Informe a(s) data(s) de pagamento para gerar o pedido</td></tr>";
			}
			if(empty($servico)) {
				$erro .= "<tr><td>Para gerar um pedido adicione pelo menos um produto</td></tr>";
			}
			if(!empty($vendedor) && empty($dt_comissao)) {
				$erro .= "<tr><td>Este vendedor possui comissão, por favor informe a data de pagamento</tr></td>";
			}
			
			if($hpedido_acao == "faturar") {
				if(empty($hconta_parcelas_pedido)) {
					$erro .= "<tr><td>a conta (parcela) para faturar o pedido</tr></td>";
				}
				if(empty($hcategoria_parcelas_pedido)) {
					$erro .= "<tr><td>Informe a categoria (parcela) para faturar o pedido</tr></td>";
				}
				if(!empty($vendedor)) {
					if(empty($hdata_comissoes_pedido)){
						$erro .= "<tr><td>Informe a conta (comissões) para faturar o pedido</tr></td>";
					}
					if(empty($hconta_comissoes_pedido)){
						$erro .= "<tr><td>Informe a categoria (comissões) para faturar o pedido</tr></td>";
					}
				}
			}
		}
		if(strlen($erro) == 0) {
            if(empty($cod_opt)) {
    			if(!empty($gerar_pedido)) {
    				if($hpedido_acao == "gerar"){
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`, `oportunidade_pedido`, `pessoa_vendedor`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1, $codvendedor)");
    					if($oport) {
    						$oportunidade_id = mysql_insert_id();
    						if(empty($_POST['qtd_parcelas'])) {
    							mysql_query("INSERT INTO `parcelas` VALUES (NULL, $oportunidade_id, $serv, '$dt_parcela', 1)");
    						} else {
    							if(!empty($hrepetir_data_parcelas)) {
    								$dt_parc = $dt_parcela;
    								for($i = 1; $i <= $qtd_parcelas; $i++) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $oportunidade_id, " . str_replace(",", ".", $_POST["parcela_$i"]) . ", '$dt_parc', $i)");
    									$dt_parc = date("Y-m-d", strtotime($dt_parc . "+$i month"));
    								}
    							} else {
    								$parcelas = mysql_query("SELECT `parcelas_temporario_vl`, `parcelas_temporario_dt` FROM `parcelas_temporario` WHERE `usuario_id` = $cod_usuario ORDER BY 2");
    								$val = 1;
    								while($parc = mysql_fetch_row($parcelas)) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $oportunidade_id, {$parc[0]}, '{$parc[1]}', $val)");
    									$val++;
    								}
    								unset($val);
    							}
    						}
                            if(!empty($codvendedor)) {
                                mysql_query("INSERT INTO `comissao` VALUES (NULL, $oportunidade_id, $codvendedor, NULL, $dt_comissao)");
                            }
                            
                            header("Location: http://{$_SERVER['HTTP_HOST']}/listar/pedidos/gerar/1");
                            exit();
    					} else {
    						$erro = "Houve algum problema ao gravar esta oportunidade!";
    					}
    				} elseif($hpedido_acao == "faturar") {
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`,`oportunidade_faturado`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1)");
    					if($oport) {
    						$oportunidade_id = mysql_insert_id();
    						$cliente = $prospect == "conta" ? $codconta : $codcontato;
    
    						if(empty($_POST['qtd_parcelas'])) {
    							mysql_query("INSERT INTO `parcelas` VALUES (NULL, $oportunidade_id, $serv, '$hdata_parcelas_pedido', 1)");
    							mysql_query("INSERT INTO `lancamento`(`lancamento_id`, `pessoa_cliente`, `categoria_id`, `caixa_id`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_descricao`) VALUES (NULL, $cliente, $hcategoria_parcelas_pedido, $hconta_parcelas_pedido, $serv, '$hdata_parcelas_pedido', 'Pedido: $nome')");
    						} else {
    							if(!empty($hrepetir_data_parcelas)) {
    								$dt_parc = $dt_parcela;
    								for($i = 1; $i <= $qtd_parcelas; $i++) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $oportunidade_id, " . str_replace(",", ".",$_POST["parcela_$i"]) . ", '$dt_parc', 1)");
    									$dt_parc = date("Y-m-d", strtotime($dt_parc . "+$i month"));
    								}
    							} else {
    								$parcelas = mysql_query("SELECT `parcelas_temporario_vl`, `parcelas_temporario_dt` FROM `parcelas_temporario` WHERE `usuario_id` = $cod_usuario ORDER BY 2");
    								$val = 1;
    								while($parc = mysql_fetch_row($parcelas)) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $oportunidade_id, {$parc[0]}, '{$parc[1]}', $val)");
    									mysql_query("INSERT INTO `lancamento`(`lancamento_id`, `pessoa_cliente`, `categoria_id`, `caixa_id`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_descricao`) VALUES (NULL, $cliente, $hcategoria_parcelas_pedido, $hconta_parcelas_pedido, {$parc[0]}, '{$parc[1]}', 'Pedido: $nome - $val')");
    									$val++;
    								}
    								unset($val);
    							}
    						}
    						if($vendedor) {
    							$vend = mysql_query("SELECT `vendedor_id`, `vendedor_comissao` FROM `vendedor` WHERE `pessoa_id` = $codvendedor");
    							$vl_comissao = mysql_fetch_row($vend);
    							$calc_comissao = ((float)$serv / (float)$vl_comissao[1]);
    							mysql_query("INSERT INTO `lancamento`(`lancamento_id`, `pessoa_cliente`, `categoria_id`, `caixa_id`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_descricao`) VALUES (NULL, $codvendedor, $hcategoria_comissoes_pedido, $hconta_comissoes_pedido, $calc_comissao, '$dt_comissao', 'Pedido: $nome')");
    							$lancamento_id = mysql_insert_id();
    							mysql_query("INSERT INTO `comissao` VALUES (NULL, $oportunidade_id, {$vl_comissao[0]}, $lancamento_id)");
    						}
                            $msg = "Gravado com sucesso";
    					} else {
    						$erro = "Houve algum problema ao gravar esta oportunidade!";
    					}
    				}
    			} else {
    				if($negociacao == "parcelada" && !empty($hdata_parcelas_pedido) && $hrepetir_data_parcelas) {
    					$dt_parc = date("Y-m-d", strtotime(str_replace("/", "-", $hdata_parcelas_pedido)));
    					mysql_query("INSERT `parcelas_temporario` VALUES ({$_COOKIE['id']}, " . str_replace(",", ".", $_POST["parcela_1"]) . ", '$dt_parc')");
    					for($i = 1, $j = 2; $i < (int)$qtd_parcelas; $i++) {
    						$dt_parc = date("Y-m-d", strtotime($dt_parc . "+$i month"));
    						mysql_query("INSERT `parcelas_temporario` VALUES ({$_COOKIE['id']}, " . str_replace(",", ".", $_POST["parcela_".$j]) . ", '$dt_parc')");
    						$j++;
    					}
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`,`oportunidade_pedido`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1)");
    					if($oport) {
    						$id = mysql_insert_id();
    						$temp_parc = mysql_query("SELECT * FROM `parcelas_temporario` WHERE `usuario_id` = " . $_COOKIE['id']);
    						$i = 1;
    						while($parc = mysql_fetch_array($temp_parc)) {
    							mysql_query("INSERT INTO `parcelas` VALUES (NULL, $id, {$parc[1]}, '{$parc[2]}', $i)");
    							$i++;
    						}
    						$temp_prod = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` =" . $_COOKIE['id']);
    						while($prod = mysql_fetch_array($temp_prod)) {
    							mysql_query("INSERT INTO `produto_oportunidade` VALUES (NULL, $id, {$prod[1]}, {$prod[2]}, {$prod[3]})");
    						}
                            $msg = "Gravado com sucesso";
    					}
    				} else if ($negociacao == "parcelada" && !empty($hdata_parcelas_pedido) && !$hrepetir_data_parcelas) {
    					$temp_parc = mysql_query("SELECT * FROM `parcelas_temporario` WHERE `usuario_id` = " . $_COOKIE['id']);
    					if(mysql_num_rows($temp_parc) > 0) {
    						$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    						$tp = mysql_fetch_array($sql);
    						$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`,`oportunidade_pedido`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1)");
    						if($oport) {
    							$id = mysql_insert_id();
    							$temp_parc = mysql_query("SELECT * FROM `parcelas_temporario` WHERE `usuario_id` = " . $_COOKIE['id']);
    							$i = 1;
    							while($parc = mysql_fetch_array($temp_parc)) {
    								mysql_query("INSERT INTO `parcelas` VALUES (NULL, $id, {$parc[1]}, '{$parc[2]}', $i)");
    								$i++;
    							}
    							$temp_prod = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` =" . $_COOKIE['id']);
    							while($prod = mysql_fetch_array($temp_prod)) {
    								mysql_query("INSERT INTO `produto_oportunidade` VALUES (NULL, $id, {$prod[1]}, {$prod[2]}, {$prod[3]})");
    							}
    						}
                            $msg = "Gravado com sucesso";
    					} else {
    						$erro .= "<tr><td>Informe a(s) data(s) de pagamento para gerar o pedido, ou marque a op&ccedil;&atilde;o: \"Repita este dia ...\"</td></tr>";
    					}
    				} else if ($negociacao == "vista" && !empty($hdata_parcelas_pedido)) {
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`,`oportunidade_pedido`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1)");
    					$id = mysql_insert_id();
    					mysql_query("INSERT INTO `parcelas` VALUES (NULL, $id, $serv, '$dt_parcela', 1)");
    					$temp_prod = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` =" . $_COOKIE['id']);
    					while($prod = mysql_fetch_array($temp_prod)) {
    						mysql_query("INSERT INTO `produto_oportunidade` VALUES (NULL, $id, {$prod[1]}, {$prod[2]}, {$prod[3]})");
    					}
                        $msg = "Gravado com sucesso";
    				}
    			}
            } else {
                //SE HOUVER VALOR NO CAMPO cod_opt ---------------------------------------------------------
                if(!empty($gerar_pedido)) {
    				if($hpedido_acao == "gerar"){
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("UPDATE `oportunidade` SET `tipo_parcela_id` = {$tp[0]},`pessoa_contato` = $codcontato,`pessoa_conta` = $codconta,`pessoa_concorrente` = $codcon,`status_oportunidade_id` = $situacao,`usuario_id` = $cod_usuario,`oportunidade_data` = '$dt',`oportunidade_nome` = '$nome',`oportunidade_descricao` = '$descricao',`oportunidade_neg_vl` = $serv,`oportunidade_dt_fec` = '$fecha,`oportunidade_chance_suc` = $chance, `oportunidade_pedido` = 1, `pessoa_vendedor` = $codvendedor WHERE `oportunidade_id` = $cod_opt"); 
    					if($oport) {
    						mysql_query("DELETE FROM `parcelas` WHERE `oportunidade_id` = $cod_opt");
                            if(empty($_POST['qtd_parcelas'])) {
    							mysql_query("INSERT INTO `parcelas` VALUES (NULL, $cod_opt, $serv, '$dt_parcela', 1)");
    						} else {
    							if(!empty($hrepetir_data_parcelas)) {
    								$dt_parc = $dt_parcela;
    								for($i = 1; $i <= $qtd_parcelas; $i++) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $cod_opt, " . str_replace(",", ".", $_POST["parcela_$i"]) . ", '$dt_parc', $i)");
    									$dt_parc = date("Y-m-d", strtotime($dt_parc . "+$i month"));
    								}
    							} else {
    								$parcelas = mysql_query("SELECT `parcelas_temporario_vl`, `parcelas_temporario_dt` FROM `parcelas_temporario` WHERE `usuario_id` = $cod_usuario ORDER BY 2");
    								$val = 1;
    								while($parc = mysql_fetch_row($parcelas)) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $cod_opt, {$parc[0]}, '{$parc[1]}', $val)");
    									$val++;
    								}
    								unset($val);
    							}
    						}
                            if(!empty($codvendedor)) {
                                mysql_query("UPDATE `comissao` SET `vendedor_id` = $codvendedor, `comissao_data` = $dt_comissao WHERE `oportunidade_id` = $cod_opt");
                            }
                            $msg = "Alterado com sucesso";
    					} else {
    						$erro = "Houve algum problema ao gravar esta oportunidade!";
    					}
    				} elseif($hpedido_acao == "faturar") {
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("UPDATE `oportunidade` SET `tipo_parcela_id` = {$tp[0]},`pessoa_contato` = $codcontato,`pessoa_conta` = $codconta,`pessoa_concorrente` = $codcon,`status_oportunidade_id` = $situacao,`usuario_id` = $cod_usuario,`oportunidade_data` = '$dt',`oportunidade_nome` = '$nome',`oportunidade_descricao` = '$descricao',`oportunidade_neg_vl` = $serv,`oportunidade_dt_fec` = '$fecha',`oportunidade_chance_suc` = $chance,`oportunidade_faturado` = 1 WHERE `oportunidade_id` = $cod_opt");
    					if($oport) {
                            mysql_query("DELETE FROM `parcelas` WHERE `oportunidade_id` = $cod_opt");
    						$cliente = $prospect == "conta" ? $codconta : $codcontato;

    						if(empty($_POST['qtd_parcelas'])) {
    							mysql_query("INSERT INTO `parcelas` VALUES (NULL, $cod_opt, $serv, '$hdata_parcelas_pedido', 1)");
    							mysql_query("INSERT INTO `lancamento`(`lancamento_id`, `pessoa_cliente`, `categoria_id`, `caixa_id`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_descricao`) VALUES (NULL, $cliente, $hcategoria_parcelas_pedido, $hconta_parcelas_pedido, $serv, '$hdata_parcelas_pedido', 'Pedido: $nome')");
    						} else {
    							if(!empty($hrepetir_data_parcelas)) {
    								$dt_parc = $dt_parcela;
    								for($i = 1; $i <= $qtd_parcelas; $i++) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $cod_opt, " . str_replace(",", ".",$_POST["parcela_$i"]) . ", '$dt_parc', 1)");
    									$dt_parc = date("Y-m-d", strtotime($dt_parc . "+$i month"));
    								}
    							} else {
    								$parcelas = mysql_query("SELECT `parcelas_temporario_vl`, `parcelas_temporario_dt` FROM `parcelas_temporario` WHERE `usuario_id` = $cod_usuario ORDER BY 2");
    								$val = 1;
    								while($parc = mysql_fetch_row($parcelas)) {
    									mysql_query("INSERT INTO `parcelas` VALUES (NULL, $cod_opt, {$parc[0]}, '{$parc[1]}', $val)");
    									mysql_query("INSERT INTO `lancamento`(`lancamento_id`, `pessoa_cliente`, `categoria_id`, `caixa_id`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_descricao`) VALUES (NULL, $cliente, $hcategoria_parcelas_pedido, $hconta_parcelas_pedido, {$parc[0]}, '{$parc[1]}', 'Pedido: $nome - $val')");
    									$val++;
    								}

    								unset($val);
    							}
    						}
    						if($vendedor) {
    							$vend = mysql_query("SELECT `vendedor_id`, `vendedor_comissao` FROM `vendedor` WHERE `pessoa_id` = $codvendedor");
    							$vl_comissao = mysql_fetch_row($vend);
    							$calc_comissao = ((float)$serv / (float)$vl_comissao[1]);
    							mysql_query("INSERT INTO `lancamento`(`lancamento_id`, `pessoa_cliente`, `categoria_id`, `caixa_id`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_descricao`) VALUES (NULL, $codvendedor, $hcategoria_comissoes_pedido, $hconta_comissoes_pedido, $calc_comissao, '$dt_comissao', 'Pedido: $nome')");
    							$lancamento_id = mysql_insert_id();
                                $query = mysql_query("SELECT * FROM `comissao` WHERE `oportunidade` = $cod_opt");
                                $num_com = mysql_num_rows($query);
                                
    							mysql_query("INSERT INTO `comissao` VALUES (NULL, $oportunidade_id, {$vl_comissao[0]}, $lancamento_id)");
    						}
                            $msg = "Alterado com sucesso";
    					} else {
    						$erro = "Houve algum problema ao gravar esta oportunidade!";
    					}
    				}
    			} else {
    				if($negociacao == "parcelada" && !empty($hdata_parcelas_pedido) && $hrepetir_data_parcelas) {
    					$dt_parc = date("Y-m-d", strtotime(str_replace("/", "-", $hdata_parcelas_pedido)));
    					mysql_query("INSERT `parcelas_temporario` VALUES ({$_COOKIE['id']}, " . str_replace(",", ".", $_POST["parcela_1"]) . ", '$dt_parc')");
    					for($i = 1, $j = 2; $i < (int)$qtd_parcelas; $i++) {
    						$dt_parc = date("Y-m-d", strtotime($dt_parc . "+$i month"));
    						mysql_query("INSERT `parcelas_temporario` VALUES ({$_COOKIE['id']}, " . str_replace(",", ".", $_POST["parcela_".$j]) . ", '$dt_parc')");
    						$j++;
    					}
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`,`oportunidade_pedido`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1)");
    					if($oport) {
    						$id = mysql_insert_id();
    						$temp_parc = mysql_query("SELECT * FROM `parcelas_temporario` WHERE `usuario_id` = " . $_COOKIE['id']);
    						$i = 1;
    						while($parc = mysql_fetch_array($temp_parc)) {
    							mysql_query("INSERT INTO `parcelas` VALUES (NULL, $id, {$parc[1]}, '{$parc[2]}', $i)");
    							$i++;
    						}
    						$temp_prod = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` =" . $_COOKIE['id']);
    						while($prod = mysql_fetch_array($temp_prod)) {
    							mysql_query("INSERT INTO `produto_oportunidade` VALUES (NULL, $id, {$prod[1]}, {$prod[2]}, {$prod[3]})");
    						}
                            $msg = "Alterado com sucesso";
    					}
    				} else if ($negociacao == "parcelada" && !empty($hdata_parcelas_pedido) && !$hrepetir_data_parcelas) {
    					$temp_parc = mysql_query("SELECT * FROM `parcelas_temporario` WHERE `usuario_id` = " . $_COOKIE['id']);
    					if(mysql_num_rows($temp_parc) > 0) {
    						$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    						$tp = mysql_fetch_array($sql);
    						$oport = mysql_query("INSERT INTO `oportunidade` (`oportunidade_id`,`tipo_parcela_id`,`pessoa_contato`,`pessoa_conta`,`pessoa_concorrente`,`status_oportunidade_id`,`usuario_id`,`oportunidade_data`,`oportunidade_nome`,`oportunidade_descricao`,`oportunidade_neg_vl`,`oportunidade_dt_fec`,`oportunidade_chance_suc`,`oportunidade_pedido`) VALUES (NULL, {$tp[0]}, $codcontato, $codconta, $codcon, $situacao, $cod_usuario, '$dt', '$nome', '$descricao', $serv, '$fecha', $chance, 1)");
    						if($oport) {
    							$id = mysql_insert_id();
    							$temp_parc = mysql_query("SELECT * FROM `parcelas_temporario` WHERE `usuario_id` = " . $_COOKIE['id']);
    							$i = 1;
    							while($parc = mysql_fetch_array($temp_parc)) {
    								mysql_query("INSERT INTO `parcelas` VALUES (NULL, $id, {$parc[1]}, '{$parc[2]}', $i)");
    								$i++;
    							}
    							$temp_prod = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` =" . $_COOKIE['id']);
    							while($prod = mysql_fetch_array($temp_prod)) {
    								mysql_query("INSERT INTO `produto_oportunidade` VALUES (NULL, $id, {$prod[1]}, {$prod[2]}, {$prod[3]})");
    							}
                                $msg = "Alterado com sucesso";
    						}
    					} else {
    						$erro .= "<tr><td>Informe a(s) data(s) de pagamento para gerar o pedido, ou marque a op&ccedil;&atilde;o: \"Repita este dia ...\"</td></tr>";
    					}
    				} else if ($negociacao == "vista" && !empty($hdata_parcelas_pedido)) {
    					$sql = mysql_query("SELECT `tipo_parcela_id` FROM `tipo_parcela` WHERE `tipo_parcela_sigla` = '$tipo_parcela'");
    					$tp = mysql_fetch_array($sql);
    					$oport = mysql_query("UPDATE `oportunidade` SET `tipo_parcela_id` = {$tp[0]},`pessoa_contato` = $codcontato,`pessoa_conta` = $codconta,`pessoa_concorrente` = $codcon,`status_oportunidade_id` = $situacao,`usuario_id` = $cod_usuario,`oportunidade_data` = '$dt',`oportunidade_nome` = '$nome',`oportunidade_descricao` = '$descricao',`oportunidade_neg_vl` = $serv,`oportunidade_dt_fec` = '$fecha',`oportunidade_chance_suc` = $chance WHERE `oportunidade_id` = $cod_opt");
                        echo "UPDATE `oportunidade` SET `tipo_parcela_id` = {$tp[0]},`pessoa_contato` = $codcontato,`pessoa_conta` = $codconta,`pessoa_concorrente` = $codcon,`status_oportunidade_id` = $situacao,`usuario_id` = $cod_usuario,`oportunidade_data` = '$dt',`oportunidade_nome` = '$nome',`oportunidade_descricao` = '$descricao',`oportunidade_neg_vl` = $serv,`oportunidade_dt_fec` = '$fecha',`oportunidade_chance_suc` = $chance WHERE `oportunidade_id` = $cod_opt";
                        if($oport) {
                            mysql_query("UPDATE `parcelas` VALUES `pacelas_valor` = $serv, `parcelas_data` = '$dt_parcela' WHERE `oportunidade_id` = $cod_opt");
                            mysql_query("DELETE FROM `produto_oportunidade` WHERE `oportunidade_id` = $cod_opt");
        					$temp_prod = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` =" . $_COOKIE['id']);
        					while($prod = mysql_fetch_array($temp_prod)) {
        						mysql_query("INSERT INTO `produto_oportunidade` VALUES (NULL, $cod_opt, {$prod[1]}, {$prod[2]}, {$prod[3]})");
        					}
                            $msg = "Alterado com sucesso";
                        } else {
                            $erro = "Houve algum problema ao alterar esta oportunidade!";
                        }
    				}
    			}
            }
		}
	}
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
			
			function CancelaVideo(tipo) {
				var url = dominio + diretorio() + "/usuario/CancelaVideo/"+tipo;
				
				if($("#check_video").is(":checked")) {
					CarregandoAntes();
					
					$.post(url, function(data) {
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
										 alt="Página Inicial"/>P&aacute;gina Inicial
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
						function GravarLembreteTemplate(id)  {
							var url = dominio + diretorio() + "/interacoes/GravarLembrete";

							CarregandoAntes();

							$.post(url, {data:$("#data_lembrete_template").val(),hora:$("#hora_lembrete_template").val(),obs:$("#desc_lembrete_template").val()}, function (data) {
								var resp = data.split("|");	

								CarregandoDurante();

								if (resp[0] == 1) {
									$("#data_lembrete_template").val('<?=date("d/m/Y")?>');
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
					<div id="da-content-area">
						<script>
							$(function () {
								function GravaEntidade(tipo) {
									var url = dominio + diretorio();
									
									if(tipo=="novo_contato") {
										url+="/crm/GravarContato";
										tipo = "contato";
									}
									
									if(tipo=="nova_conta") {
										url+="/crm/GravarConta";
										tipo = "conta";
									}
									
									var nome = $("#"+tipo).val();
									
									CarregandoAntes();
									
									$.post(url,{nome:nome},function (data) {
										CarregandoDurante();
										
										var resp = data.split("|")
										
										if(resp[0]==1) {
											$("#msg_loading").html(resp[1]);
											
											if(tipo=="conta") {
												$("#codconta").val(resp[2]);
											}
											if(tipo=="contato") {
												$("#codcontato").val(resp[2]);
											}
											
											CarregandoDepois('',10000);	
										} else {
											CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
										}
									});
								}

								$('#vendedor').each(function () {
									var url = dominio + diretorio() + "/oportunidades/AutoCompleteVendedor";
									var autoCompelteElement = this;
							
									$(this).autocomplete({source:url,
										select:function (event, ui) {
							
											$(autoCompelteElement).val(ui.item.label);
							
											var contato = ui.item.value,
													div = $("<div>").addClass("pr_5"),
													div2 = $("<div>").text(contato),
													a = $("<label>").addClass("close flt_lft").attr({
														title:"Remover " + contato
													}).text(" x ");
											a.click(function () {
												div2.html('');
												$("#codvendedor").val('');
												$("#vendedor").val('');
												$("#vendedor").show();
											});
											a.appendTo(div2),
											div2.appendTo(div),
											div.insertAfter("#vendedor");
											$("#vendedor").hide();
											$("#codvendedor").val(ui.item.id);
										}
									});
								 });
					   
								$('#conta').each(function () {
									var url = dominio + diretorio() + "/home/AutoCompleteConta";
									var autoCompelteElement = this;
								
									$(this).autocomplete({source:url,
										select:function (event, ui) {
								
											if(ui.item.id=="nova_conta") {
												GravaEntidade(ui.item.id);
											}
								
											$(autoCompelteElement).val(ui.item.label);
								
											var conta = ui.item.value,
													div = $("<div>").addClass("pr_5"),
													div2 = $("<div>").text(conta),
													a = $("<label>").addClass("close flt_lft").attr({
														title:"Remover " + conta
													}).text(" x ");
											a.click(function () {
												div2.html('');
												$("#nomeconta").val('');
												$("#codconta").val('');
												$("#conta").val('');
												$("#conta").show();
											});
											a.appendTo(div2),
													div2.appendTo(div),
													div.insertAfter("#conta");
											$("#conta").hide();
											$("#nomeconta").val(conta);
											$("#codconta").val(ui.item.id);
										}
									});
								});
								
								$('#contato').each(function () {
									var url = dominio + diretorio() + "/home/AutoCompleteContato";
									var autoCompelteElement = this;
								
									$(this).autocomplete({source:url,
										select:function (event, ui) {
								
											if(ui.item.id=="novo_contato") {
												GravaEntidade(ui.item.id);
											}
								
											$(autoCompelteElement).val(ui.item.label);
								
											var contato = ui.item.value,
													div = $("<div>").addClass("pr_5"),
													div2 = $("<div>").text(contato),
													a = $("<label>").addClass("close flt_lft").attr({
														title:"Remover " + contato
													}).text(" x ");
											a.click(function () {
												div2.html('');
												$("#nomecontato").val('');
												$("#codcontato").val('');
												$("#contato").val('');
												$("#contato").show();
											});
											a.appendTo(div2),
													div2.appendTo(div),
													div.insertAfter("#contato");
											$("#contato").hide();
											$("#nomecontato").val(contato);
								
											if(ui.item.id!="novo_contato") {
												$("#codcontato").val(ui.item.id);
											}	
										}
									});
								});
						
								$('#item_venda').each(function () {
									var autoCompelteElement = this;
									var url = dominio + diretorio() + "/home/AutoCompleteItens";
									
									$(this).autocomplete({source:url,
										select:function (event, ui) {
											$(autoCompelteElement).val(ui.item.value);
											var item = ui.item.value;
											var tipo = ui.item.label.split("-");
											var aux = false;
											
											for(i=0;i<tipo.length;i++) {
												if(($.trim(tipo[i])=="produto")||($.trim(tipo[i])=="serviço")) {
													aux = tipo[i];
													if($.trim(tipo[i])!="produto") aux = "servico";
													break;
												}
											}
											
											tipo = $.trim(aux);
											$("#tipo_item").val(tipo);
											$("#cod_item").val(ui.item.id);
										}
									});
								});

								$('#concorrente').each(function () {
									var url = dominio + diretorio() + "/oportunidades/AutoCompleteContaContato";
									var autoCompelteElement = this;
									
									$(this).autocomplete({source:url, 
										select:function (event, ui) {
											$(autoCompelteElement).val(ui.item.value);
											
											var con = ui.item.value,
											div = $("<div>").addClass("pr_5"),
											div2 = $("<div>").text(con),
											a = $("<label>").addClass("close flt_lft").attr({
												title:"Remover " + con
											}).text(" x ");
											a.click(function () {
												div2.html('');
												$("#nomecon").val('');
												$("#codcon").val('');
												$("#concorrente").val('');
												$("#tipocon").val('');
												$("#concorrente").show();
											});
											a.appendTo(div2),
											div2.appendTo(div),
											div.insertAfter("#concorrente");
											$("#concorrente").hide();
											$("#nomecon").val(con);
											$("#codcon").val(ui.item.id);
											var tipo = ui.item.label.split("-");
											tipo = $.trim(tipo[1]);
											$("#tipocon").val(tipo);
										}
									});
								});
						
						 $('#int_contato').each(function () {
						
									var url = dominio + diretorio() + "/crm/AutoCompleteContato?callback=?";

									var url2 = dominio + diretorio() + "/interacoes/AddContato/inserir";

									var url3 = dominio + diretorio() + "/interacoes/DelContato/inserir";
									var autoCompelteElement = this;
									var formElementName = $(this).attr('name');
									var hiddenElementID = formElementName + '_autocomplete_hidden';
									$(this).attr('name', formElementName + '_autocomplete_label');
									/* create new hidden input with name of orig input */
									$(this).after("<input type=\"hidden\" name=\"" + formElementName + "\" id=\"" + hiddenElementID + "\" />");

									$(this).autocomplete({source:url,

										select:function (event, ui) {

											if(ui.item.id=="novo_contato")
											{
												var url4 = dominio + diretorio();
								
												url4+="/crm/GravarContato";
											
												var nome = $("#int_contato").val();
												
												CarregandoAntes();
												
												$.post(url4,{nome:nome},function (data) 
												{
													CarregandoDurante();
													
													var resp = data.split("|")
													
													if(resp[0]==1)
													{
														$("#msg_loading").html(resp[1]);
														
														id = resp[2];
														
														CarregandoDepois('',10000);	
														
														$.post(url2, {contato:id}, function (data) {

															if (data != -1) {

																$(autoCompelteElement).val(ui.item.label);

																var conta = ui.item.value,
																		div = $("<div>").addClass("pr_5"),
																		div2 = $("<div>").text(conta),
																		a = $("<label>").addClass("close flt_lft").attr({
																			title:"Remover " + conta
																		}).text(" x ");
																a.click(function () {
																	div2.html('');
																	$.post(url3, {contato:ui.item.id}, function (data) {
																	});
																});
																a.appendTo(div2),
																		div2.appendTo(div),
																		div.insertAfter("#resposta_int_contatos");
																$("#int_contato").val('');
															}
															else {
																return false;
															}

														});
													
													}
													else
													{
														CarregandoDepois('Ocorreu um erro no servidor, por favor atualize a p\U00E1gina',3000);
													
													}
												});
											
											}
											else
											{
												id = ui.item.id;
												
												$.post(url2, {contato:id}, function (data) {

													if (data != -1) {

														$(autoCompelteElement).val(ui.item.label);

														var conta = ui.item.value,
																div = $("<div>").addClass("pr_5"),
																div2 = $("<div>").text(conta),
																a = $("<label>").addClass("close flt_lft").attr({
																	title:"Remover " + conta
																}).text(" x ");
														a.click(function () {
															div2.html('');
															$.post(url3, {contato:ui.item.id}, function (data) {
															});
														});
														a.appendTo(div2),
																div2.appendTo(div),
																div.insertAfter("#resposta_int_contatos");
														$("#int_contato").val('');
													}
													else {
														return false;
													}

												});
											
											}
											
										}

									});

						});
					});

								$(document).ready(function () {
									$('.texto').tooltip();
									$("#servico").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
									$("#qtd_item").maskMoney({showSymbol:true, symbol:"", decimal:"", thousands:"", precision:0});
									$("#valor_item").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
									BuscarItens();
								});

					function ShowParcela(tipo) {

						if (tipo != 'fixo') {

							if (tipo == "hora") {
								
								$("#parcela_servico").val(1);
								
								$("#tipo_parcelas").html('<strong>Horas</strong>');

							}

							if (tipo == "mes") {
								$("#tipo_parcelas").html('<strong>Meses</strong>');

							}

							if (tipo == "ano") {
								$("#tipo_parcelas").html('<strong>Anos</strong>');

							}

							$("#tipo_parcelas").show();

							$("#tipo_parcelas").css('display', 'inline');

							$("#div_parcelas").show();

							$("#div_parcelas").css('display', 'inline');

						}
						else {

							$("#tipo_parcelas").html('');

							$("#tipo_parcelas").hide();

							$("#div_parcelas").hide();

						}


					}

								function Situacao(id) {
									if (id == "ganhamos") {
										$("#ganhamos").addClass('btn-success');
										$("#perdemos").removeClass('btn-danger');
										$("#andamento").removeClass('btn-warning');
										$("#situacao").val(1)
									}
									if (id == "perdemos") {
										$("#perdemos").addClass('btn-danger');
										$("#andamento").removeClass('btn-warning');
										$("#ganhamos").removeClass('btn-success');
										$("#situacao").val(0)
									}
									if (id == "andamento") {
										$("#andamento").addClass('btn-warning');
										$("#ganhamos").removeClass('btn-success');
										$("#perdemos").removeClass('btn-danger');
										$("#situacao").val(2)
									}
								}

					function limpa_oportunidade() {
						var url = dominio + diretorio() + "/oportunidades/LimpaOportunidades";
						// Exibe mensagem de carregamento
						$("#loading").css('height', '40px');
						$("#loading").show();
						$("#loading").html("Carregando...");
						$.post(url, function (resposta) {
							var dados = resposta.split("|");

							document.getElementById('loading').style.display = 'none';
						});

					}


					function DelInteracoes(id)
					{
						var url = dominio + diretorio() + "/interacoes/excluir/"+id+"/ajax";

						if(confirm('Tem certeza que deseja excluir?'))
						{
						
							CarregandoAntes();
							
							$.post(url, function (data) {
								var resp = data.split("|");	
									
								CarregandoDurante();
								
								$("#msg_loading").html(resp[1]);
									
								CarregandoDepois('',2000);
								
								if (resp[0] == 1) 
								{
									ListarInteracoes();
								}
								
							});
						}	

					}

					function GravarInteracao()
					{
						var url = dominio + diretorio() + "/oportunidades/GravarInteracao";
						
						CarregandoAntes();
						
						$.post(url, {oportunidade:$("#cod_opt").val(),data:$("#int_data").val(),hora:$("#int_hora").val(),motivo:$("#int_motivo").val(),canal:$("#int_canal").val(),tipo:$('input:radio[name=int_tipo]:checked').val(),obs:$("#int_obs").val()}, function (data) {
							
							resp = data.split("|");
							
							CarregandoDurante();
							
							if(resp[0]==1)
							{
								$("#int_hora").val(resp[2]);
								
								$("#int_data").val(resp[3]);
								
								$("#int_tipo1").attr("checked",false);
								
								$("#int_tipo2").attr("checked",false);
								
								$("#int_motivo").attr("checked",false);
								
								$("#int_motivo2").attr("checked",false);
								
								$("#int_obs").val('');
								
								$("#int_canal").val('');
								
								$("#div_motivos").html('');
								
								$("#div_mae_contatos").html('<div id="resposta_int_contatos" name="resposta_int_contatos"></div>');
								
								$("#int_conta").val('');
								
								$("#modal_interacoes").modal('hide');
									
								ListarInteracoes();
								
							}
							
							$("#msg_loading").html(resp[1]);
							
							CarregandoDepois();
						
						});


					}

					function ListarInteracoes()
					{

						var url = dominio + diretorio() + "/oportunidades/BuscaInteracoes/";

						ajaxHTMLProgressBar('historico_interacoes', url, false, false);

					}

					function ConfigProspect(valor)
					{
						
						if(valor=="contato")
						{
							$("#div_contato").show();
							
							$("#div_conta").hide();
							
							$("#conta").val('');
							
							$("#nomeconta").val('');
							
							$("#codconta").val('');
						}
						if(valor=="conta")
						{
							$("#div_conta").show();
							$("#div_contato").show();
						}
						



					}

							function FormItens() {
								$('#nome_item').val('Adicionar produtos/servi&ccedil;os');
								$('#qtd_item').val('1');
								$('#valor_item').val('');

								var url = dominio + diretorio() + "/oportunidades/FormItem";

								CarregandoAntes();

								$.post(url,{item:$("#cod_item").val()}, function(data) {
									var resp = data.split("|");

									CarregandoDurante();

									if(resp[0] == 1) {
										$("#nome_item").html(resp[1]);
										$('#valor_item').val(resp[2]);

										if(resp[3]=="produto") {
											$("#div_qtd").show();
											$("#ipi").html(resp[4]);
										} else {
											$("#div_qtd").hide();
											$("#ipi").html('');	
										}

										$("#modal_itens").modal('show');
									} else {
										$("#msg_loading").html(resp[1]);
									}

									CarregandoDepois('loading',3000);
								});
							}

							function AddItem() {
								CarregandoAntes();
								
								var url = dominio + diretorio() + "/oportunidades/AddItem";
								
								$.post(url,{item:$("#cod_item").val(),qtd:$("#qtd_item").val(),valor:$("#valor_item").val()}, function(data) {
									var resp = data.split("|");
									
									CarregandoDurante();
									
									if(resp[0]==1) {
										$("#item_venda").val('');
										$("#cod_item").val('');
										$("#qtd_venda").val('');
										$("#valor_item").val('');
										
										BuscarItens();
										
										$("#msg_loading").html(resp[1]);
										$("#servico").val(resp[2]);
										$("#modal_itens").modal('hide');
										
										CalculaTotal();
									} else {
										$("#msg_loading").html(resp[1]);
									}
									
									CarregandoDepois('loading',4000);
								});
							}
						
					function BuscarParcelas()
					{
						var url = dominio + diretorio() + "/oportunidades/BuscarParcelas//inserir";

						$.post(url,function(data)
						{
							var resp = data.split("|");
							
							CarregandoDurante();
							
							if(resp[0]==1)
							{
								$("#div_parcelamento").html(resp[1]);
							
								$("#negociacao_parcelada").attr("checked",true);
							
								$("#div_qtd_parcelas").show();
							
								$("#qtd_parcelas").val(resp[2]);
							}
							else
							{
													$("#negociacao_vista").attr("checked",true);	
								
										
							}
						
						});
						
						
					}	
						
								function BuscarItens() {
									var url = dominio + diretorio() + "/BuscarItens/cadastro";
									ajaxHTMLProgressBar('resp_itens', url, false, false);
								}

								function BuscarItensVersao(id) 
								{
									var url = dominio + diretorio() + "/oportunidades/BuscarItensVersao/"+id;
									ajaxHTMLProgressBar('div_box_item_'+id, url, false, false);
								}

								function DelItem(i) {
									if(confirm("Deseja realmente excluir ?")) {	

										CarregandoAntes();

										var url = dominio + diretorio() + "/oportunidades/DelItem";
										$.post(url,{id:i}, function(data) {
											var resp = data.split("|");
											
											CarregandoDurante();
											
											if(resp[0]==1) {
												BuscarItens();
												
												$("#servico").val(resp[2]);
												
												CalculaTotal();
											}
											$("#msg_loading").html(resp[1]);
								
											CarregandoDepois('loading',5000);
										});
									}
								}

								function CheckNegociacao(valor) {
									if(valor=="parcelada") {
										$("#div_qtd_parcelas").show();
									} else {
										$('#div_parcelamento').html('');
										$("#qtd_parcelas").val('');
										$("#div_qtd_parcelas").hide();
									}
								}

								function ConfigFormPedido(flag) {
									if(flag=='error') {
										$("#data_comissoes").val($("#hdata_comissoes_pedido").val());
										$("#conta_comissoes").val($("#hconta_comissoes_pedido").val());
										$("#categoria_comissoes").val($("#hcategoria_comissoes_pedido").val());
										$("#data_parcelas").val($("#hdata_parcelas_pedido").val());
										$("#conta_parcelas").val($("#hconta_parcelas_pedido").val());
										$("#categoria_parcelas").val($("#hcategoria_parcelas_pedido").val());
										$("#pedido_acao").val($("#hpedido_acao").val());
										$("#repetir_data_parcelas").val($("#hrepetir_data_parcelas").val());
										
										ConfigDivsPedido()
									} else {
									   $("#gerar_pedido").val("");
									}
									
									var qtd = $('#qtd_parcelas').val();
									
									if(qtd==0) {
										qtd=1;
									}
								
									if(qtd==1) {
										$("#div_tipo_parcela").html('');
									} else {	
										var html;
										
										html='<div id="txt_conta_lan">';
										html+='<label class="checkbox inline"> <input name="repetir" type="checkbox" onclick="ConfigRepetir();" id="repetir_data_parcelas" value="1"> Repita este dia para os demais meses ou informe as datas <a data-toggle="modal" href="#modal_parcelas" onclick="CriarInputsPedido();">aqui</a></label>';
										html+='</div>';
										
										$("#div_tipo_parcela").html(html);
										
										if($("#hrepetir_data_parcelas").val()==1) {
											$('#repetir_data_parcelas').attr('checked', true);
										} else {
											$('#repetir_data_parcelas').attr('checked', false);
										}
									}
									
									ConfigDivsPedido();
									
									var url = dominio+diretorio()+"/oportunidades/VerificaComissao";
									
									CarregandoAntes();
									
									$.post(url,{vendedor:$("#codvendedor").val()},function(data) {
										var resp = data.split("|");
										
										CarregandoDurante();
										
										if(resp[1]==1) {
											$("#div_comissao").show();
										} else {
											$("#div_comissao").hide();	
										}
										$("#msg_loading").html(resp[2]);
									
										CarregandoDepois('',100);
										
										$('#modal_pedido').modal('show');
									});
								}

					function ConfigRepetir()
					{
						if($("#repetir_data_parcelas").is(":checked"))
						{
							$("#hrepetir_data_parcelas").val(1);
							
							//$('#repetir_data_parcelas').attr('checked', false);
						
						}
						else
						{
							$("#hrepetir_data_parcelas").val(0);
						
						}
						

					}

					function ConfigDivsPedido()
					{

						if($("#pedido_acao").val()=="faturar")
						{
							$("#div_conta_parcela").show();
							
							$("#div_categoria_parcela").show();
							
							$("#div_conta_comissao").show();
							
							$("#div_categoria_comissao").show();
						
						}
						else
						{
							$("#div_conta_parcela").hide();
							
							$("#div_categoria_parcela").hide();
							
							$("#div_conta_comissao").hide();
							
							$("#div_categoria_comissao").hide();
						}

					}


					function ConfigPedido()
					{
						
						$("#hdata_comissoes_pedido").val($("#data_comissoes").val());
						
						$("#hconta_comissoes_pedido").val($("#conta_comissoes").val());
						
						$("#hcategoria_comissoes_pedido").val($("#categoria_comissoes").val());
						
						$("#hdata_parcelas_pedido").val($("#data_parcelas").val());
						
						$("#hconta_parcelas_pedido").val($("#conta_parcelas").val());
						
						$("#hcategoria_parcelas_pedido").val($("#categoria_parcelas").val());
						
						//$("#hrepetir_data_parcelas").val($("#repetir_data_parcelas").val());
						
						if($("#repetir_data_parcelas").is(":checked"))
						{
							$("#hrepetir_data_parcelas").val(1);
							
							//$('#repetir_data_parcelas').attr('checked', false);
						
						}
						else
						{
							$("#hrepetir_data_parcelas").val(0);
						
						}
						
						$("#hpedido_acao").val($("#pedido_acao").val());
						
						$('#gerar_pedido').val(1);
						
						$('#form_opt').submit();


					}

							function CriarInputsPedido() {
								var qtd = $('#qtd_parcelas').val();
								
								$('#div_datas').html('');
								
								if(qtd==0) {
									qtd=1;
								}
								
								for(var i=1;i<=qtd;i++) {
									var id = "data_"+i;
									var string = i+"/"+qtd+"&nbsp;&nbsp;";
									
									$('#div_datas').append('<br/>'+string);
									$('<input>').attr({ type: 'text', id: id, value:'',name:id}).addClass('datepicker span2').appendTo('#div_datas');
									$('#'+id).datepick();
									$('#div_datas').append('<br/>');
								}
								
								$('#data_1').val($('#data_parcelas').val());
							}

							function GravarParcelasPedido() {
								var qtd = $('#qtd_parcelas').val();
								
								$("#data_parcelas").val($("#data_1").val()); // Iguala a data personalizada e a padrao
								
								if(qtd==0) {
									qtd=1;
								}
								
								var url = dominio+diretorio()+"/oportunidades/GravarParcelasPedido";
								var string = "";
								var string2 = "";
								
								for(var i=1;i<=qtd;i++) {
									var id="#data_"+i;
									
									if($(id).val()!="") {	
										string+=$(id).val();
										if(qtd!=i) string+="&"
									}
									
									id = "#parcela_"+i;
									
									if($(id).val()!="") {	
										string2+=$(id).val();
										if(qtd!=i) string2+="&"
									}
								}
								
								CarregandoAntes();
								
								$.post(url,{datas_parcelas:string,valores_parcelas:string2},function(data) {
									var resp = data.split("|");
									
									CarregandoDurante();
									
									if(resp[0]==1) {
										$("#modal_parcelas").modal('hide');
									}
									
									$("#msg_loading").html(resp[1]);
									
									CarregandoDepois('',5000);
								});
							}


					function CriarInputs(qtd)
					{
						$('#div_parcelamento').html('');
						
						var total = $("#servico").val();
						
						if(total=="")
						{

							total = 0;
						}
						else
						{
							total = total.replace('.',"");

							total = parseFloat(total.replace(',',"."));

						}

						var periodo = $("#parcela_servico").val();
						
						if((periodo=="")||($("#tipo_parcela").val()=="fixo"))
						{
							periodo = 1;
						}
						else
						{
							periodo = periodo.replace('.',"");

							periodo = parseFloat(periodo.replace(',',"."));

						}

						var parcela_acumulada = 0;
						
						var parcela = (total*periodo)/qtd;
						
						parcela = moeda(parcela, 2, ",", "."); // Arredondamento monetario

						aux_parcela = parcela.replace('.',"");

						aux_parcela = parseFloat(aux_parcela.replace(',',".")); // valor arredondado, sem estar formatado

						if(qtd>1)
						{	
							
							for(var i=1;i<=qtd;i++)
							{
								var id = "parcela_"+i;
								
								var string = "&nbsp;&nbsp;";
								
								if(i<10)
								{
									string = "&nbsp;&nbsp;&nbsp;";
								}
								
								$('#div_parcelamento').append('<br/>'+i+'/'+qtd+string);
								
								$('<input>').attr({ type: 'text', id: id, value:parcela,name:id}).addClass('span1').appendTo('#div_parcelamento');
								
								$('#'+id).maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
								
								$('#'+id).val(parcela);
								
								$('#div_parcelamento').append('&nbsp;&nbsp;');
								
								$('#div_parcelamento').append('<br/>');
								
								parcela_acumulada=parcela_acumulada+aux_parcela;

							}
						
							if(parcela_acumulada<(total*periodo))
							{
								parcela = aux_parcela+((total*periodo)-parcela_acumulada);

								parcela = moeda(parcela, 2, ",", "."); // Arredondamento monetario

								$('#'+id).val(parcela);
							}
							if(parcela_acumulada>((total*periodo)*periodo))
							{

								parcela = aux_parcela-((total*periodo)-parcela_acumulada);

								parcela = moeda(parcela, 2, ",", "."); // Arredondamento monetario

								$('#'+id).val(parcela);
							}

							$("#parcela_1").focus();
							
							

						}
						else
						{
							$("#negociacao_vista").attr("checked",true);
							
							$("#qtd_parcelas").val('');
							
							$("#div_qtd_parcelas").hide();
						
						}


					}

					function CalculaTotal()
					{
						var total = 0;
						
						var servico = 0;
						
						var parcelas = 0;
						
						if($("#servico").val()!="")
						{
							servico = $("#servico").val();
							
							servico = servico.replace('.',"");
							
							servico = servico.replace(',',".");
							
							servico = parseFloat(servico);
							
						}
						
						if($("#parcela_servico").val()!="")
						{
						
							parcelas = parseInt($("#parcela_servico").val());
						
						}
						
						if((servico!="")&&(parcelas!=""))
						{
							total = servico*parcelas;
						}
						
						total = numberFormat(total.toFixed(2));// + "";

						$("#strong_total").show();
						
						$("#strong_total").html(" = R$&nbsp;"+total);

						CriarInputs($('#qtd_parcelas').val());	
						
					}

					function numberFormat(n) 
					{
						var parts=n.toString().split(".");
						return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (parts[1] ? "," + parts[1] : "");
					}

							<?php if(strlen($erro) > 0 && $gerar_pedido): ?>
							$(document).ready(function () {
								ConfigFormPedido('error');
							});
							<?php endif; ?>


					function GravarPrivacidade()
					{
						var url = dominio + diretorio() + "/oportunidades/GravarPrivacidade";

						var usuarios = new Array();
							$(".chk_users:checked").each(function() {
							   usuarios.push($(this).val());
						});

						usuarios = JSON.stringify(usuarios);

						CarregandoAntes();
						
						$.post(url, {oportunidade:$("#cod_opt").val(),usuarios:usuarios}, function (data) {
							
							resp = data.split("|");
							
							CarregandoDurante();
							
							$("#msg_privacidade").removeClass();
							
							if(resp[0]!=0)
							{
								$("#msg_privacidade").addClass('alert alert-success'); 
							}
							else
							{
								$("#msg_privacidade").addClass('alert alert-danger');
							}
							
							$("#msg_privacidade").html(resp[1]);
							
							CarregandoDepois('',1000);
						
						});
					}
						</script>
						<article>
							<div class="grid_4">
								<div class="da-panel">
									<!-- Modais -->
									<div class="modal hide" id="modal_itens">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&#215;</button>
											<h2 class="pr_5 mr_0" style="display:inline;" id="nome_item">Adicionar Produto/Servi&ccedil;o</h2>
										</div>
										<div class="modal-body">
											<div class="form-horizontal">
												<form>
													<fieldset>
														<div class="control-group">
															<input type="hidden" name="id_item" id="id_item"  value="" />
															
															<div class="control-group">
																<label class="control-label">*Quantidade:</label>
																<div class="controls">
																	<input style="width:50px;" type="text" name="qtd_item" id="qtd_item" class="input_menor" value="" />
																</div>
															</div>
															<div class="control-group">
																<label class="control-label">*Valor:</label>
																<div class="controls">
																	<input style="width:100px;" type="text" name="valor_item" id="valor_item" class="input_menor" value="" />
																</div>
															</div>
															<div class="control-group" id="div_qtd">
																<label class="control-label">% IPI</label>
																<label class="checkbox inline" id="ipi"></label>
															</div>
															<div class="control-group">
																<div class="controls al_rgt">
																	<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
																	<a class="btn btn-primary" onclick="AddItem();">Salvar</a>
																</div>
															</div>
														</div>	
													</fieldset>
												</form>
											</div>
										</div>
									</div>
									<div class="modal hide" id="modal_interacoes">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&#215;</button>
											<h2 class="pr_5 mr_0">Nova Atividade</h2>
										</div>
										<div class="modal-body" style="max-height:420px;">
											<div class="form-horizontal">
												<form>
													<fieldset>
														<div class="control-group">
															<label class="control-label">* Data:</label>
															<div class="controls">
																<input class="datepicker" type="text" maxlength="10" name="int_data" id="int_data" class="input_menor"  value="<?=date("d/m/Y")?>"/>
															 </div>
														</div>
														<div class="control-group">
															<label class="control-label">* Hora:</label>
															<div class="controls">
																<input type="text" id="int_hora" name="int_hora" value="<?=date("H:i")?>"/>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Conta:</label>
															<div class="controls">
																<strong class="dsp_b pr_5" id="int_conta"></strong>	
																<input type="hidden" name="int_nomeconta" id="int_nomeconta" value=""/>
																<input type="hidden" name="int_codconta" id="int_codconta" value=""/>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Contatos:</label>
															<div class="controls">
																<input class="input_full" id="int_contato" type="text" placeholder="Buscar"/>
																<strong class="dsp_b pr_5"></strong>	
																<div id="div_mae_contatos">	
																	<div id="resposta_int_contatos" name="resposta_int_contatos"></div>
																</div>	
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">* Motivo - <strong>Venda</strong></label>
															<div class="controls">	
																<select name="int_motivo" id="int_motivo">
																	<option value="">Selecione</option>
																	<?php
																		$sql = mysql_query("SELECT * FROM `motivo`");
																		while($mot = mysql_fetch_array($sql)):
																	?>
																	<option value="<?=$mot[0]?>"><?=$mot[1]?></option>
																	<?php endwhile; ?>
																</select>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">* Canal</label>
															<div class="controls">
																<select name="int_canal" id="int_canal">
																	<option value="">Selecione</option>
																	<?php
																		$sql = mysql_query("SELECT * FROM `canal`");
																		while($can = mysql_fetch_array($sql)):
																	?>
																   <option value="<?=$can[0]?>"><?=$can[1]?></option>
																   <?php endwhile; ?>
																</select>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">* Tipo</label>
															<div class="controls">
																<div class="dsp_pr_5">
																	<?php
																		$sql = mysql_query("SELECT * FROM `tipo`");
																		while($tip = mysql_fetch_array($sql)):
																	?>
																	<label class="radio inline">
																		<input type="radio" name="int_tipo" value="<?=$tip[0]?>" id="int_tipo<?=$tip[0]?>"/> <?=$tip[1]?>
																	</label>
																	<?php endwhile; ?>
																</div>
															</div>
														</div>
														<div class="control-group">
															<div class="control-group">
																<label class="control-label"> * Descri&ccedil;&atilde;o:</label>
																<div class="controls">
																	<textarea class="input_full" style="height: 50px;" name="int_obs" id="int_obs"></textarea>
																</div>
															</div>
															<div class="control-group">
																<div class="controls al_rgt">
																	<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
																	<a class="btn btn-primary" onclick="GravarInteracao();">Salvar</a>
																</div>
															</div>
														</div>	
													</fieldset>
												</form>
									
											</div>
										</div>
									</div>
									<div class="modal hide" id="modal_parcelas">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&#215;</button>
											<h2 class="pr_5 mr_0" style="display:inline;" id="nome_item">Informe as datas das parcelas</h2>
										</div>
										<div class="modal-body">
											<div class="form-horizontal">
												<form>
													<fieldset>
														<div class="control-group" id="div_datas"></div>
														<div class="control-group">
															<div class="controls al_rgt">
																<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
																<a class="btn btn-primary" onclick="GravarParcelasPedido();">Ok</a>
															</div>
														</div>					
													</fieldset>
												</form>
											</div>
										</div>
									</div>
									<div class="modal hide"  id="modal_pedido">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&#215;</button>
											<h2 class="pr_5 mr_0">Criar Pedido</h2>
										</div>
										<div class="modal-body" style="max-height:420px;">
											<div class="form-horizontal">
												<form>
													<fieldset>
														<?php if(strlen($erro) > 0):?>
														<div class="alert alert-error">
															<table align='center'>
																<?=$erro?>
															</table>
														</div>
														<?php endif; ?>
														<div class="control-group">
															<label class="control-label">* A&ccedil;&atilde;o:</label>
															<div class="controls">
																<select name="pedido_acao" id="pedido_acao" onchange="ConfigDivsPedido();">
																	<option value="gerar">Gerar Pedido</option>
																	<option value="faturar">Faturar Pedido</option>
																</select>	
															</div>
														</div>
														<div class="padding well">	
															<h2>Parcelas</h2>
															<label class="control-label al_lft" style="width:50px;">Data:</label>
															<input style="width:100px;" class="datepicker" type="text" maxlength="10" name="data_parcelas" id="data_parcelas" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);"/>
															<div class="control-group" id="div_tipo_parcela"></div>
															<div class="control-group" id="div_conta_parcela" style="display:none;">
																<label id="txt_conta_lan"> Lan&ccedil;ar na conta:</label>
																<div>
																	<select id="conta_parcelas" class="input_full" name="conta_parcelas">
																		<option value="">Selecione</option>
																	</select>
																</div>
															</div>
															<div class="control-group" id="div_categoria_parcela" style="display:none;">
																<label id="txt_conta_lan"> Categoria:</label>
																<div>
																	<select id="categoria_parcelas" class="input_full" name="categoria_parcelas">
																		<option value="">Selecione</option>
																		<?php
																			$sql = mysql_query("SELECT * FROM `categoria`");
																			while($cat = mysql_fetch_array($sql)):
																		?>
																			<option value="<?=$cat[0]?>"><?=$cat[1]?></option>
																		<?php endwhile; ?>
																	</select>
																</div>
															</div>
														</div>
														<div class="padding well" id="div_comissao" style="display:none;">	
															<div class="control-group">
																<h2>Comiss&atilde;o</h2>
																<label class="control-label al_lft" style="width:50px;">Data:</label>
																<input style="width:80px;"  class="datepicker" type="text" maxlength="10" name="data_comissoes" id="data_comissoes" class="input_menor"  onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);"  />
															</div>
															<div class="control-group" id="div_conta_comissao" style="display:none;">
																<label id="txt_conta_lan"> Lan&ccedil;ar na conta:</label>
																<div>
																	<select id="conta_comissoes" class="input_full" name="conta_comissoes">
																		<option value="">Selecione</option>
																	<?php
																		$sql = mysql_query("SELECT `caixa_id` AS id, `caixa_nome` AS nome FROM `caixa`");
																		while($cont = mysql_fetch_array($sql)):
																	?>
																		<option value="<?=$cont[0]?>"><?=$cont[1]?></option>
																	<?php endwhile; ?>
																	</select>
																</div>
															</div>
															<div class="control-group" id="div_categoria_comissao" style="display:none;">
																<label id="txt_conta_lan"> Categoria:</label>
																<div>
																	<select id="categoria_comissoes" class="input_full" name="categoria_comissoes">
																		<option value="">Selecione</option>
																		<?php
																			$sql = mysql_query("SELECT * FROM `categoria`");
																			while($cat = mysql_fetch_array($sql)):
																		?>
																		<option value="<?=$cat[0]?>"><?=$cat[1]?></option>
																		<?php endwhile; ?>
																	</select>
																</div>
															</div>
														</div>
														<div class="control-group">
															<div class="controls al_rgt">
																<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
																<a id="btn_gerar_pedido" onclick="ConfigPedido();" class="btn btn-success"><i class="icon-ok icon-white"></i> Salvar </a>
															</div>
														</div>
													</fieldset>
												</form>
											</div>
										</div>
									</div>
									<!-- Header -->
									<div class="da-panel-header">
										<span class="da-panel-title">
											<span class="label label-inverse pr_5">
												<span class="label label-inverse pr_5">
													<i class="icon-briefcase icon-white"></i>
												</span>
											</span>
											<strong class="tt_uc">Oportunidades</strong>
										</span>
										<span class="da-panel-btn">
											<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/oportunidade" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova</a>
										</span>
									</div>
									<div class="da-panel-content">
										<div class="da-panel-padding">
											<div class="tabbable"> <!-- Only required for left/right tabs -->
												<ul class="nav nav-tabs">
													<li class="active">
														<a href="#tab1" data-toggle="tab"><?=empty($cod_opt) ? "[Nova Oportunidade]" : "$nome"?></a>
													</li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab1">
														<?php if(strlen($erro) > 0):?>
														<div class="alert alert-error">
															<table align='center'>
																<?=$erro?>
															</table>
														</div>
														<?php endif; ?>
														<?php if(isset($oport) && $oport): ?>
														<div class="alert alert-success"><?=$msg?></div>
														<?php endif; ?>
														<form class="form-horizontal" action="http://<?=$_SERVER['HTTP_HOST']?>/home/oportunidades/valida/inserir" id="form_opt" method="post" enctype="multipart/form-data" name="form_opt">
															<fieldset>
																<input type="hidden" name="gerar_pedido" id="gerar_pedido" value="" />
																<input type="hidden" name="cod_opt" id="cod_opt" value="<?=$cod_opt?>"/>
																<input type="hidden" name="cod_grupo" id="cod_grupo" value="<?=$cod_grupo?>"/>
																<input type="hidden" name="cod_versao" id="cod_versao" value="1.0"/>
																
																<!-- campos pedido -->
																<input type="hidden" name="hpedido_acao" id="hpedido_acao" value="<?=$hpedido_acao?>" />
																<input type="hidden" name="hrepetir_data_parcelas" id="hrepetir_data_parcelas" value="<?=$hrepetir_data_parcelas?>" />
																<input type="hidden" name="hdata_comissoes_pedido" id="hdata_comissoes_pedido" value="<?=$hdata_comissoes_pedido?>" />
																<input type="hidden" name="hconta_comissoes_pedido" id="hconta_comissoes_pedido" value="<?=$hconta_comissoes_pedido?>" />
																<input type="hidden" name="hcategoria_comissoes_pedido" id="hcategoria_comissoes_pedido" value="<?=$hcategoria_comissoes_pedido?>" />
																<input type="hidden" name="hdata_parcelas_pedido" id="hdata_parcelas_pedido" value="<?=$hdata_parcelas_pedido?>" />
																<input type="hidden" name="hconta_parcelas_pedido" id="hconta_parcelas_pedido" value="<?=$hconta_parcelas_pedido?>" />
																<input type="hidden" name="hcategoria_parcelas_pedido" id="hcategoria_parcelas_pedido" value="<?=$hcategoria_parcelas_pedido?>" />
																<!-- end   -->
																<span class="badge flt_rgt">Cadastrado por:
																	<?php if($cod_usuario):?>
																		<?php 
																			$sql = mysql_query("SELECT `usuario_nome` FROM `usuario` WHERE `usuario_id` = $cod_usuario");
																			$usuario = mysql_fetch_array($sql);
																			echo $usuario[0];
																		?>
																		<input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=$cod_usuario?>"/>
																	<?php else: ?>
																		<?=$_COOKIE['nome']?>
																		<input type="hidden" name="cod_usuario" id="cod_usuario" value="<?=$_COOKIE['id']?>"/>
																	<?php endif; ?>
																</span>
																<div class="control-group">
																	<label class="control-label">* Data:</label>
																	<div class="controls">
																		<input class="datepicker" type="text" maxlength="10" name="data" id="data" class="input_menor" value="<?=$data?>"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">* Oportunidade:</label>
																	<div class="controls">
																		<input type="text" name="nome" id="nome" class="input_full" value="<?=$nome?>"/>
																	</div>
																</div>
																<div id="div_vendedor" class="control-group">
																	<label class="control-label">Vendedor:</label>
																	<div class="controls">
																		<input class="input_full ui-autocomplete-input" type="text" id="vendedor" name="vendedor" placeholder="Buscar" value="<?=$vendedor == "NULL" ? "" : $vendedor?>" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
																		<input type="hidden" name="codvendedor" id="codvendedor" value="<?=$codvendedor?>"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">Descri&ccedil;&atilde;o:</label>
																	<div class="controls">
																		<textarea class="input_full" name="descricao" id="descricao"><?=$descricao?></textarea>
																	</div>
																</div>
																<div>  
																	<label class="control-label">Produtos e Servi&ccedil;os:&nbsp;
																		<i title="Agora voc&ecirc; pode adicionar produtos e servi&ccedil;os &agrave; suas oportunidades, basta digitar o nome do produto ou servi&ccedil;o que o sistema encontr&aacute;-lo. Ap&oacute;s isso, clique no bot&atilde;o +" id="tip_itens" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
																	</label>
																	<div class="form-inline al_ctr">
																		<label class="btn-group">
																			<input type="text" id="item_venda" class="input-medium search-query ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
																		</label>
																		<input type="hidden" id="cod_item"/>
																		<input type="hidden" id="tipo_item"/>
																		<a title="Adicionar" class="btn btn-inverse" data-toggle="modal" onclick="FormItens();"><i class="icon-plus icon-white"></i></a>
																	</div>
																	<br/>
																	<div class="control-group">
																		<div class="controls well" align="center" id="resp_itens"></div>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">Valor negociado:</label>
																	<div class="controls  ">
																		<input type="text" placeholder="R$" class="span1" size="8px"  name="servico" id="servico" value="<?=$servico?>" onblur="CalculaTotal();CriarInputs($('#qtd_parcelas').val());"/>
																		<select class="span2" name="tipo_parcela" onchange="ShowParcela(this.value);CalculaTotal();CriarInputs($('#qtd_parcelas').val())" id="tipo_parcela">
																		<?php
																			$tp_parc = mysql_query("SELECT * FROM `tipo_parcela`");
																			while($parc = mysql_fetch_array($tp_parc)): 
																		?>
																				<option value="<?=$parc[1]?>"><?=$parc[2]?></option>
																		<?php endwhile; ?>
																		</select>
																		<span id="div_parcelas" style='display:none;'>
																			<b class="">Durante</b>
																			<input class="span1" type="text" name="parcela_servico" id="parcela_servico"  value="1" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);"  onblur="CalculaTotal();CriarInputs($('#qtd_parcelas').val())"/>
																			<span id="tipo_parcelas" style='display:none;'>
																				<strong></strong>
																			</span>
																			<strong id='strong_total' style='display:none;'></strong>
																		</span>
																	</div>
																</div>
																<div>  
																	<label class="control-label">Negocia&ccedil;&atilde;o:&nbsp;</label>
																	<div class="control-group">
																		<div class="controls well" id="div_negociacao">
																			<label class="radio inline">
																				<input type="radio" name="negociacao" value="vista" id="negociacao_vista" onclick="CheckNegociacao(this.value);" <?=$negociacao == "vista" ? "checked='true'" : ""?>/>&Agrave; vista
																			</label>
																			<br/>
																			<label class="radio inline">
																				<input type="radio" name="negociacao" value="parcelada" id="negociacao_parcelada" onclick="CheckNegociacao(this.value);" <?=($negociacao == "parcelada") ? "checked='true'" : ""?>/>Parcelada em
																			</label>
																			<label class="radio inline" id="div_qtd_parcelas" style='<?=$qtd_parcelas > 1 ? "" : "display:none;"?>'>
																				<input type="text" value="<?=$qtd_parcelas?>" id="qtd_parcelas" name="qtd_parcelas" size="8px" class="span1" placeholder="X" align="center" onblur="CriarInputs(this.value);"/>&nbsp;&nbsp;Vezes
																			</label>
																			<div id="div_parcelamento">
																				<?php 
																					if((int) $qtd_parcelas > 1):
																						for($i = 1; $i <= $qtd_parcelas; $i++):
																				?>
																				<br /><?=$i?>/<?=$qtd_parcelas?>&nbsp;&nbsp;&nbsp;
																				<input type="text" class="span1" id="parcela_<?=$i?>" name="parcela_<?=$i?>" value="<?=$_POST["parcela_" . $i]?>"/>&nbsp;&nbsp;&nbsp;<br />
																				<script>
																					$('#parcela_<?=$i?>').maskMoney({showSymbol:true, symbol:'', decimal:',', thousands:'.'})
																				</script>
																				<?php
																						endfor; 
																					endif; 
																				?>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">* Quem est&aacute; em prospec&ccedil;&atilde;o ?</label>
																	<div class="controls">
																		<div class="pr_5">
																			<label class="radio inline">
																				<input type="radio" onclick="ConfigProspect(this.value);" name="prospect" value="conta" id="prospect_conta" <?=($prospect == "conta") ? "checked='true'" : ""?>/>Conta
																			</label>
																			<label class="radio inline">
																				<input type="radio" onclick="ConfigProspect(this.value);" name="prospect" value="contato" id="prospect_contato" <?=($prospect == "contato") ? "checked='true'" : ""?>/>Contato
																			</label>
																			&nbsp;
																			<i title="Marque aqui para quem voc&ecirc; est&aacute; vendendo. Para uma pessoa f&iacute;sica escolha 'Contato', Para uma pessoa jur&iacute;dica escolha 'Conta'" id="tip_prospect" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
																		</div>
																	</div>
																</div>
																<div id="div_conta" style='<?=$prospect == "conta" ? "" : "display:none;"?>'  class="control-group">
																	<label class="control-label">Conta:</label>
																	<div class="controls">
																		<input class="input_full" type="text" id="conta" placeholder="Buscar" value="<?=$nomeconta?>"/>
																		<input type="hidden" name="nomeconta" id="nomeconta" value="<?=$nomeconta?>"/>
																		<input type="hidden" name="codconta" id="codconta" value="<?=$codconta?>"/>
																	</div>
																</div>
																<div id="div_contato"  style='<?=($prospect == "conta" || $prospect == "contato") ? "" : "display:none;"?>' class="control-group">
																	<label class="control-label">Contato:</label>
																	<div class="controls">
																		<input class="input_full" type="text" id="contato" placeholder="Buscar" value="<?=$nomecontato?>"/>
																		<input type="hidden" name="nomecontato" id="nomecontato" value="<?=$nomecontato?>"/>
																		<input type="hidden" name="codcontato" id="codcontato" value="<?=$codcontato?>"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">* Fechamento prov&aacute;vel:</label>
																	<div class="controls">
																		<input type="text" class="span2 datepicker" placeholder="" maxlength="10" onkeydown="Mascara(this,Data);" onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" name="fechamento" id="fechamento" class="input_menor" value="<?=$fechamento?>"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">Situa&ccedil;&atilde;o:</label>
																	<div class="controls">
																		<div class="btn-group flt_lft">
																			<label onclick="Situacao(this.id);" id="andamento" class='btn dropdown-toggle<?=$situacao == "2" ? " btn-warning" : ""?>' href="#">Andamento</label>
																		</div>
																		<div class="btn-group flt_lft">
																			<label onclick="Situacao(this.id);" id="ganhamos" class='btn dropdown-toggle<?=$situacao == "1" ? " btn-success" : ""?>' href="#">Ganhamos</label>
																		</div>
																		<div class="btn-group flt_lft">
																			<label onclick="Situacao(this.id);" id="perdemos" class='btn dropdown-toggle'<?=$situacao == "0" ? " btn-danger" : ""?> href="#">Perdemos</label>
																		</div>&nbsp;
																		<i title="Quando criar ou versionar uma oportunidade, a situa&ccedil;&atilde;o da Conta ou Contato mudar&aacute; de status automaticamente seguindo este modelo:  Em Andamento muda para - Em Prospec&ccedil&atilde;o. Ganhamos muda para - Cliente. Perdemos muda para - Suspeito"  id="tip_status" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
																		<input type="hidden" id="situacao" name="situacao" value="<?=$situacao?>"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">Chance de sucesso:</label>
																	<div class="controls">
																		<input class="alinhaDireita" type="text" size="2px" maxlength="100" name="chance" id="chance" class="input_menor" onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" value="<?=$chance?>"/>&nbsp;<b>%</b>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">Concorrente:</label>
																	<div class="controls">
																		<input class="input_full" type="text" id="concorrente" placeholder="Buscar" value=""/>
																		<input type="hidden" name="nomecon" id="nomecon" value="<?=$nomecon?>"/>
																		<input type="hidden" name="codcon" id="codcon" value="<?=$codcon?>"/>
																		<input type="hidden" name="tipocon" id="tipocon" value="<?=$tipocon?>"/>
																	</div>
																</div>
																<div class="form-actions al_rgt">
																	<a href="JavaScript: window.history.back(-1);" class="btn btn-inverse"><i class="icon-remove icon-white"></i> Cancelar  </a>
																	<a  href="#da-header-toolbar" class="btn btn-primary" onclick="ConfigFormPedido();"> <i class="icon-list-alt icon-white"></i> Criar Pedido </a>
																	<button  class="btn btn-success"><i class="icon-ok icon-white"></i> Salvar </button>
																</div>
															</fieldset>
														</form>
													</div>
													<div class="tab-pane fade in" id="tab2">
														<div class="accordion" id="versoes_anteriores">
														</div>
													</div>
													<div class="tab-pane fade in" id="tab3">
														<div class="da-panel-header">
															<span class="da-panel-title">
																<span class="label label-inverse pr_5"><i><img
																		src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/16/users.png"/></i></span>
																<strong class="tt_uc ws_nw al_ctr">Atividades</strong>
															</span>
															<span class="da-panel-btn">
																<a class="btn btn-inverse" data-toggle="modal" href="#modal_interacoes"><i class="icon-plus icon-white"></i> Nova</a>
															</span>
														</div>
														<div class="da-padding">
															<div class="accordion" id="historico_interacoes"> </div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<input type="hidden" name="abativa" id="abativa" value=""/>
									</div>
								</div>
							</div>
						</article>
						<script>
							$('#fbusca_contas').keydown(function (e) {
								if (e.keyCode == 13) {
									busca_contas(auxdiv);
									return false;
								}
							});
							$('#fbusca_contatos').keydown(function (e) {
								if (e.keyCode == 13) {
									busca_contatos_contas();
									return false;
								}
							});
						</script>
					</div>
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