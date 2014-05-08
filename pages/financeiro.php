<?php
    include("lib/connection.php");
?>
<div id="da-content-area">
    <script>
        $(document).ready(function () {
            $("#saldo_conta").maskMoney({allowNegative:true,showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#limite_cartao").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#limite_conta").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#saldo_caixap").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
            $("#custo_boleto_conta").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});

            ListarCaixap();
            ListarCategorias();
            ListarCentros();
            ListarCartoes();
            ListarContas();
        });

        //########## ContaCorrente ##########
        function GravarConta() {
            var url = dominio + diretorio() + "/financeiro/GravarConta";
            
            CarregandoAntes();
            
            var tipo_saldo = $("input[name='tipo_saldo']:checked").val();
            
            if(tipo_saldo==undefined) {
                alert('Ocorreu um erro durante o processo');
                return false;
            }
            
            $.post(url,{conta:$("#id_conta").val(),nome:$("#nome_conta").val(),data:$("#data_conta").val(),saldo:$("#saldo_conta").val(),limite:$("#limite_conta").val(),banco:$("#banco_conta").val(),agencia:$('#agencia_conta').val(),numero:$("#numero_conta").val(),carteira:$("#carteira_boleto_conta").val(),custo:$("#custo_boleto_conta").val(),linha1:$("#linha1_boleto_conta").val(),linha2:$("#linha2_boleto_conta").val(),linha3:$("#linha3_boleto_conta").val(),convenio:$("#convenio_boleto_conta").val(),tipo_saldo:tipo_saldo,dv_conta:$("#dv_conta").val(),dv_agencia:$("#dv_agencia").val(),dv_cedente:$("#dv_cedente").val()}, function (data) {
            
                resp = data.split("|");
                CarregandoDurante();
                
                if(resp[0]==1) {
                    LimparContas();
                    $("#modal_conta").modal('hide');
                    ListarContas();
                }
                
                $("#msg_loading").html(resp[1]);
                CarregandoDepois('',7000);
            });
        }

        function EditarConta(id) {
            var url = dominio + diretorio() + "/financeiro/EditarConta";
            
            $.post(url, {conta:id}, function (data) {
            
                resp = data.split("|");
                
                if(resp[0]!=0) {
                    $("#texto_nome_conta").html(resp[2]);
                    $("#id_conta").val($.trim(resp[0]));
                    $("#data_conta").val(resp[1]);
                    $("#nome_conta").val(resp[2]);
                    $("#saldo_conta").val(resp[3]);
                    $("#limite_conta").val(resp[4]);
                    $("#banco_conta").val(resp[5]);
                
                    if((resp[5]==53)||(resp[5]==32)||(resp[5]==16)||(resp[5]==92)||(resp[5]==72)) {
                        document.getElementById("label_configurar_boleto").style.display = "inline";
                    } else {
                        document.getElementById("label_configurar_boleto").style.display = "none";
                        document.getElementById("div_campos_boleto").style.display = "none";
                    }
                    
                    $("#agencia_conta").val(resp[6]);
                    $("#numero_conta").val(resp[7]);
                    $("#usuario_conta").attr("title","Cadastrado por "+resp[8]);
                    $("#carteira_boleto_conta").val(resp[9]);
                    $("#custo_boleto_conta").val(resp[10]);
                    $("#linha1_boleto_conta").val(resp[11]);
                    $("#linha2_boleto_conta").val(resp[12]);
                    $("#linha3_boleto_conta").val(resp[13]);
                    $("#convenio_boleto_conta").val(resp[14]);
                    
                    if(resp[15]=="positivo") {
                        document.getElementById('saldo_positivo').checked = true;
                        document.getElementById('saldo_negativo').checked = false;
                    }
                    if(resp[15]=="negativo") {
                        document.getElementById('saldo_negativo').checked = true;
                        document.getElementById('saldo_positivo').checked = false;
                    }
                    
                    $("#dv_conta").val(resp[16]);
                    $("#dv_agencia").val(resp[17]);
                    $("#dv_cedente").val(resp[18]);
                    $("#modal_conta").modal('show');
                }
            });
            
            ConfigBoleto();
        }

        function DelConta(id) {
            if(confirm("Tem certeza que deseja excluir ? Todos os lan\u00E7amentos ser\u00E3o perdidos")) {	
                var url = dominio + diretorio() + "/financeiro/DelConta";

                CarregandoAntes();

                $.post(url, {conta:id}, function (data) {
                    resp = data.split("|");

                    CarregandoDurante();

                    if(resp[0]==1) {
                        ListarContas();
                    }

                    $("#msg_loading").html(resp[1]);

                    CarregandoDepois('',3000);
                });
            }
        }
        
        function LimparContas() {
            $("#usuario_conta").attr("title","Cadastrado por <?=$_COOKIE['nome']?>");
            $("#texto_nome_conta").html('Nova Conta');
            $("#id_conta").val('');
            $("#data_conta").val('<?=date("d/m/Y")?>');
            $("#nome_conta").val('');
            $("#saldo_conta").val('');
            
            document.getElementById('saldo_positivo').checked = true;
            document.getElementById('saldo_negativo').checked = false;
            
            $("#limite_conta").val('');
            $("#banco_conta").val('');
            $("#agencia_conta").val('');
            $("#numero_conta").val('');
            $("#dv_conta").val('');
            
            $("#label_configurar_boleto").html('Configurar Boleto <i class="icon-arrow-down"></i><i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black flt_rgt" id="tip_boleto" title="Dispon&iacute;vel apenas para os Bancos: Ita&uacute;,Bradesco,Santander,CEF e Banco do Brasil"></i>');
            
            document.getElementById("div_campos_boleto").style.display = "none";
            document.getElementById("label_configurar_boleto").style.display = "none";
            
            $("#carteira_boleto_conta").val('');
            $("#custo_boleto_conta").val('');
            $("#linha1_boleto_conta").val('');
            $("#linha2_boleto_conta").val('');
            $("#linha3_boleto_conta").val('');
            $("#convenio_boleto_conta").val('');
        }
        
        function ListarContas() {
            var url = dominio + diretorio() + "/financeiro/BuscarContas";
            ajaxHTMLProgressBar('resp_contas', url, false, false);
        }
        //###################################

        //########## Caixa ##################
        function GravarCaixap() {
            var url = dominio + diretorio() + "/financeiro/GravarCaixap";

            CarregandoAntes();

            $.post(url,{conta:$("#id_caixap").val(),nome:$("#nome_caixap").val(),data:$("#data_caixap").val(),saldo:$("#saldo_caixap").val()}, function (data) {
                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]==1) {
                    $("#texto_nome_caixap").html('Novo Caixa Pequeno');
                    $("#data_caixap").val(resp[2]);
                    $("#id_caixap").val('');
                    $("#nome_caixap").val('');
                    $("#saldo_caixap").val('');
                    $("#modal_caixapequeno").modal('hide');

                    ListarCaixap();
                }

                $("#msg_loading").html(resp[1]);

                CarregandoDepois('',7000);
            });
        }
        
        function EditarCaixap(id) {
            var url = dominio + diretorio() + "/financeiro/EditarCaixap";

            $.post(url, {conta:id}, function (data) {

                resp = data.split("|");

                if(resp[0]!=0) {
                    $("#texto_nome_caixap").html(resp[2]);
                    $("#id_caixap").val($.trim(resp[0]));
                    $("#data_caixap").val(resp[1]);
                    $("#nome_caixap").val(resp[2]);
                    $("#saldo_caixap").val(resp[3]);
                    $("#usuario_caixap").attr("title","Cadastrado por "+resp[4]);
                }
            });
        }
        
        function DelCaixap(id) {
            if(confirm("Tem certeza que deseja excluir ? Todos os lan\u00E7amentos ser\u00E3o perdidos")) {	
                var url = dominio + diretorio() + "/financeiro/DelCaixap";

                CarregandoAntes();

                $.post(url, {conta:id}, function (data) {
                    resp = data.split("|");

                    CarregandoDurante();

                    if(resp[0]==1) {
                        ListarCaixap();
                    }

                    $("#msg_loading").html(resp[1]);

                    CarregandoDepois('',3000);
                });
            }
        }
        
        function LimparCaixap() {
            $("#usuario_caixap").attr("title","Cadastrado por <?=$_COOKIE['nome']?>");
            $("#texto_nome_caixap").html('Novo Caixa Pequeno');
            $("#id_caixap").val('');
            $("#nome_caixap").val('');
            $("#saldo_caixap").val('');
            $("#data_caixap").val('<?=date("d/m/Y")?>');
        }
        
        function ListarCaixap() {
            var url = dominio + diretorio() + "/financeiro/BuscarCaixap";
            ajaxHTMLProgressBar('resp_caixap', url, false, false);
        }
        //###################################

        //########## Cartão #################
        function GravarCartao() {
            var url = dominio + diretorio() + "/financeiro/GravarCartao";

            CarregandoAntes();

            $.post(url,{id:$("#id_cartao").val(),nome:$("#nome_cartao").val(),mes:$("#mes_cartao").val(),ano:$("#ano_cartao").val(),dia_vencimento:$("#dia_vencimento_cartao").val(),limite:$("#limite_cartao").val(),dia_limite:$("#dia_limite_cartao").val(),mes_inicio_fatura:$("#mes_inicio_fatura").val(),ano_inicio_fatura:$("#ano_inicio_fatura").val(),numero_cartao:$("#numero_cartao").val(),conta_cartao:$("#conta_cartao").val()}, function (data) {
                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]==1) {
                    LimparCartao();
                    $("#modal_cartao").modal('hide');
                    ListarCartoes();
                }
                $("#msg_loading").html(resp[1]);

                CarregandoDepois('',3000);
            });
        }
        
        function LimparCartao() {
            $("#texto_nome_cartao").html('Novo Cart&atilde;o de cr&eacute;dito');
            $("#id_cartao").val('');
            $("#numero_cartao").val('');
            $("#nome_cartao").val('');
            $("#mes_cartao").val('');
            $("#ano_cartao").val('');
            $("#dia_vencimento_cartao").val('');
            $("#limite_cartao").val('');
            $("#dia_limite_cartao").val('');
        }
        
        function EditarCartao(id) {
            var url = dominio + diretorio() + "/financeiro/EditarCartao";

            $('#div_aviso_cartao').show();
            $('#div_inicio_faturas').hide();
            $('#div_conta_cartao').hide();

            $.post(url, {id:id}, function (data) {
                resp = data.split("~");

                if(resp[0]!=0) {
                    $("#id_cartao").val($.trim(resp[0]));
                    $("#usuario_cartao").attr("title","Cadastrado por "+resp[1]);
                    $("#texto_nome_cartao").html(resp[2]);
                    $("#nome_cartao").val(resp[2]);
                    $("#limite_cartao").val(resp[7]);
                    $("#mes_cartao").val(resp[3]);
                    $("#ano_cartao").val(resp[4]);
                    $("#dia_vencimento_cartao").val(resp[5]);
                    $("#dia_limite_cartao").val(resp[6]);
                    $("#numero_cartao").val(resp[8]);
                }
            });
        }
        
        function DelCartao(id) {
            if(confirm("Tem certeza que deseja excluir ? TODOS os lan\u00E7amentos ser\u00E3o PERDIDOS!")) {
                var url = dominio + diretorio() + "/financeiro/DelCartao";

                CarregandoAntes();

                $.post(url, {id:id}, function (data) {
                    resp = data.split("|");

                    CarregandoDurante();

                    if(resp[0]==1) {
                        ListarCartoes();
                    }

                    $("#msg_loading").html(resp[1]);

                    CarregandoDepois('',3000);
                });
            }
        }
        
        function ListarCartoes() {
            var url = dominio + diretorio() + "/financeiro/BuscarCartoes";
            ajaxHTMLProgressBar('resp_cartoes', url, false, false);
        }
        //###################################

        //########## Categoria ##############
        function GravarCategoria() {
            var url = dominio + diretorio() + "/financeiro/GravarCategoria";
            
            CarregandoAntes();
            
            $.post(url,{categoria:$("#id_categoria").val(),nome:$("#nome_categoria").val(),tipo:$("#tipo_categoria").val(),pai:$("#div_categorias_pai select").val()}, function (data) {
                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]==1) {
                    $("#modal_categoria").modal('hide');

                    ListarCategorias();
                    LimparCategoria();
                }

                $("#msg_loading").html(resp[1]);

                CarregandoDepois('',7000);
            });
        }
        
        function EditarCategoria(id) {
            var url = dominio + diretorio() + "/financeiro/EditarCategoria";

            $.post(url, {categoria:id}, function (data) {
                resp = data.split("|");

                if(resp[0]!=0) {
                    $("#texto_nome_categoria").html(resp[1]);
                    $("#id_categoria").val($.trim(resp[0]));
                    $("#nome_categoria").val(resp[1]);
                    $("#tipo_categoria").val(resp[2]);
                    $("#usuario_categoria").attr("title","Cadastrado por "+resp[4]);
                    $("#modal_categoria").modal('show');
                    $("#div_categorias_pai").html($("#div_categorias").html());
                    $("#div_categorias_pai select").val($.trim(resp[3]));
                    
                    ControleCategorias();
                    
                    if($("#div_categorias_pai select").val()!="") {
                        document.getElementById('tipo_categoria').disabled = true;
                    } else {
                        document.getElementById('tipo_categoria').disabled = false;
                    }
                }
            });
        }
        
        function DelCategoria(id) {
            if(confirm("Tem certeza que deseja excluir a categoria ? N\u00E3o deve existir nenhum lan\u00E7amento nela")) {	
                var url = dominio + diretorio() + "/financeiro/DelCategoria";

                CarregandoAntes();

                $.post(url, {categoria:id}, function (data) {
                    resp = data.split("|");

                    CarregandoDurante();

                    if(resp[0]==1) {
                        ListarCategorias();
                    }

                    $("#msg_loading").html(resp[1]);

                    CarregandoDepois('',3000);
                });
            }
        
        }
        
        function LimparCategoria() {
            $("#texto_nome_categoria").html('Nova Categoria');
            $("#usuario_categoria").attr("title","Cadastrado por <?=$_COOKIE['nome']?>"); 
            $("#id_categoria").val('');
            $("#nome_categoria").val('');
            $("#tipo_categoria").val('');
            $("#div_categorias_pai").html($("#div_categorias").html());
            
            document.getElementById('tipo_categoria').disabled = false;
        }

        function ListarCategorias() {
            var url = dominio + diretorio() + "/financeiro/BuscarCategorias";
            ajaxHTMLProgressBar('resp_categorias', url, false, false);
        }
        
        function ControleCategorias() {
            var categoria = $("#id_categoria").val();
            var pai = $("#div_categorias_pai select").val();

            if(categoria=="") categoria =0; 

            var id = "pai_categoria_"+categoria;
            var combo = document.getElementById('pai_categoria');

            for(var i = 0;i<combo.length;i++) {
                combo.options[i].style.display = "block";
            }

            if((categoria!=0)&&(pai=="")) {
                document.getElementById(id).style.display = "none";
            }
        }
        //###################################

        //########## CentroCusto ############
        function GravarCentro() {
            var url = dominio + diretorio() + "/financeiro/GravarCentro";

            CarregandoAntes();

            $.post(url,{centro:$("#id_centro").val(),nome:$("#nome_centro").val()}, function (data) {
                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]==1) {
                    $("#texto_nome_centro").html('Novo Centro de custo');
                    $("#usuario_centro").attr("title","Cadastrado por <?=$_COOKIE['nome']?>");
                    $("#id_centro").val('');
                    $("#nome_centro").val('');
                    $("#modal_centro").modal('hide');

                    ListarCentros();
                }

                $("#msg_loading").html(resp[1]);

                CarregandoDepois('',7000);
            });
        }

        function EditarCentro(id) {
            var url = dominio + diretorio() + "/financeiro/EditarCentro";

            $.post(url, {centro:id}, function (data) {
                resp = data.split("|");

                if(resp[0]!=0) {
                    $("#texto_nome_centro").html(resp[1]);
                    $("#id_centro").val($.trim(resp[0]));
                    $("#nome_centro").val(resp[1]);
                    $("#usuario_centro").attr("title","Cadastrado por "+resp[2]);
                    $("#modal_centro").modal('show');
                }
            });
        }

        function DelCentro(id) {
            if(confirm("Tem certeza que deseja excluir ?")) {	
                var url = dominio + diretorio() + "/financeiro/DelCentro";
                
                CarregandoAntes();
                
                $.post(url, {centro:id}, function (data) {
                    resp = data.split("|");

                    CarregandoDurante();

                    if(resp[0]==1) {
                        ListarCentros();
                    }

                    $("#msg_loading").html(resp[1]);

                    CarregandoDepois('',3000);
                });
            }
        }
        
        function LimparCentro() {
            $("#texto_nome_centro").html('Novo Centro de custo');
            $("#usuario_centro").attr("title","Cadastrado por <?=$_COOKIE['nome']?>"); 
            $("#id_centro").val('');
            $("#nome_centro").val('');
        }

        function ListarCentros() {
            var url = dominio + diretorio() + "/financeiro/BuscarCentros";
            ajaxHTMLProgressBar('resp_centros', url, false, false);
        }
        //###################################
        
        
        function CamposBoleto()
        {
            var display = document.getElementById("div_campos_boleto").style.display;
            
            if(display=="none")
            {
                document.getElementById("div_campos_boleto").style.display = "inline";
                
                $("#label_configurar_boleto").html('Configurar Boleto <i class="icon-arrow-up"></i><i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black flt_rgt" id="tip_boleto" title="Dispon&iacute;vel apenas para os Bancos: Ita&uacute;,Bradesco,Santander,CEF e Banco do Brasil"></i>');
            }
            else
            {
                document.getElementById("div_campos_boleto").style.display = "none";
                
                $("#label_configurar_boleto").html('Configurar Boleto <i class="icon-arrow-down"></i><i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black flt_rgt" id="tip_boleto" title="Dispon&iacute;vel apenas para os Bancos: Ita&uacute;,Bradesco,Santander,CEF e Banco do Brasil"></i>');
            }
        }
        
        function ConfigBoleto()
        {
            if(($("#banco_conta").val()==53)||($("#banco_conta").val()==32)||($("#banco_conta").val()==16)||($("#banco_conta").val()==92)||($("#banco_conta").val()==72))
            {
                document.getElementById("label_configurar_boleto").style.display = "inline";
            }
            else
            {
                document.getElementById("div_campos_boleto").style.display = "none";
                document.getElementById("label_configurar_boleto").style.display = "none";
                
                $("#carteira_boleto_conta").val('');
                $("#custo_boleto_conta").val('');
                $("#linha1_boleto_conta").val('');
                $("#linha2_boleto_conta").val('');
                $("#linha3_boleto_conta").val('');
                $("#convenio_boleto_conta").val('');
            }
        }
        
        
        function GravarDadosEmpresa() {
            var url = dominio + diretorio() + "/financeiro/GravarDadosEmpresa";
            
            CarregandoAntes();
            
            $.post(url, {razao:$("#razao_social").val(),cnpj:$("#cnpj").val()}, function (data) {
                resp = data.split("|");
                
                CarregandoDurante();
                
                if(resp[0]==1) {
                    $("#msg_erro_tab0").hide();
                    $("#msg_sucesso_tab0").show();
                    $("#msg_sucesso_tab0").html(resp[1]);
                } else {
                    $("#msg_sucesso_tab0").hide();
                    $("#msg_erro_tab0").show();
                    $("#msg_erro_tab0").html(resp[1]);
                }
                
                CarregandoDepois('',1000);
            
            });
        }
        
        function GravarRecorrencia() {
            var url = dominio + diretorio() + "/financeiro/GravarRecorrencia";
            var envio_dia = 0;

            if($('#rec_envio_dia').is(':checked')==true) {
                envio_dia = 1;	
            }

            CarregandoAntes();

            $.post(url, {id:$("#rec_id").val(),nome_remetente:$("#rec_nome_remetente").val(),email_remetente:$("#rec_email_remetente").val(),email_aviso:$("#rec_copia").val(),reenvio_atraso:$("#rec_reenvio_atrasado").val(),intervalo_atraso:$("#rec_intervalo_atraso").val(),dias_antes:$("#rec_envio_dias").val(),dia:envio_dia}, function (data) {

                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]!=0) {
                    $("#rec_id").val($.trim(resp[0]));
                    $("#msg_erro_tab5").hide();
                    $("#msg_sucesso_tab5").show();
                    $("#msg_sucesso_tab5").html(resp[1]);
                } else {
                    $("#msg_sucesso_tab5").hide();
                    $("#msg_erro_tab5").show();
                    $("#msg_erro_tab5").html(resp[1]);
                }
                
                CarregandoDepois('',1000);
            });
        }

        function GravarAviso() {
            var url = dominio + diretorio() + "/financeiro/GravarAviso";
            var dias_semana = new Array();

            $(".chk_dias:checked").each(function() {
                dias_semana.push($(this).val());
            });

            dias_semana = JSON.stringify(dias_semana);

            var usuarios_aviso = new Array();

            $(".chk_users:checked").each(function() {
                usuarios_aviso.push($(this).val());
            });

            usuarios_aviso = JSON.stringify(usuarios_aviso);

            CarregandoAntes();

            $.post(url, {id:$("#aviso_id").val(),aviso_periodo:$("#aviso_periodo").val(),dias_semana:dias_semana,usuarios_aviso:usuarios_aviso}, function (data) {
                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]!=0) {
                    $("#aviso_id").val($.trim(resp[0]));
                    $("#msg_erro_tab6").hide();
                    $("#msg_sucesso_tab6").show();
                    $("#msg_sucesso_tab6").html(resp[1]);
                } else {
                    $("#msg_sucesso_tab6").hide();
                    $("#msg_erro_tab6").show();
                    $("#msg_erro_tab6").html(resp[1]);
                }

                CarregandoDepois('',1000);
            });
        }
        
        function ConfigTipo() {
            var url = dominio + diretorio() + "/financeiro/ConfigTipo";

            CarregandoAntes();

            $.post(url, {pai:$("#div_categorias_pai select").val()}, function (data) {
                resp = data.split("|");

                CarregandoDurante();

                if(resp[0]==1) {
                    $("#tipo_categoria").val(resp[1]);
                    document.getElementById('tipo_categoria').disabled = true;
                } else {
                    $("#tipo_categoria").val("1");
                    document.getElementById('tipo_categoria').disabled = false;
                }

                CarregandoDepois('',1000);
            });
        }
        
        function ConfigDiasAtraso(atraso) {
            if(atraso==1) {
                $('#label_intervalo_atraso').show();
            } else {
                $('#label_intervalo_atraso').hide();
            }
        }
    </script>
    <article>
        <!--div  class="modal fade hide hidden-phone" id="started_financeiro">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="CancelaVideo('Financeiro');">&#215;</button>
                <h2 class="pr_5 mr_0" style="display:inline;">
                V&iacute;deo Tutorial - M&oacute;dulo Financeiro
                </h2>
                <i title="Acessando pela primeira vez? Este v&iacute;deo ir&aacute; te ajudar, para n&atilde;o visualiz&aacute;-lo mais selecione a op&ccedil;&atilde;o abaixo do v&iacute;deo e feche esta caixa. Para ver novamente basta clicar no icone ao lado da palavra financeiro" id="tip_video" class="hidden-phone hidden-tablet icon-question-sign icon-black" onmouseover="mouse(this);"></i>
            </div>
            <div class="modal-body">
                <iframe width="530" height="315" src="https://www.youtube.com/embed/DcR4hHlUrRQ" frameborder="0" allowfullscreen></iframe>
                <label class="checkbox inline">
                <input type="checkbox" id="check_video" name="check_video">N&atilde;o exibir mais este v&iacute;deo automaticamente
                </label>
            </div>
        </div-->
        <div class="grid_4">
            <div class="da-panel">
                <div class="modal hide" id="modal_conta">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&#215;</button>
                        <h2 id="texto_nome_conta" style="display:inline;" class="pr_5 mr_0">Nova Conta Banc&aacute;ria</h2>
                        <i id="usuario_conta" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por"></i>
                    </div>
                    <div class="modal-body" style="overflow:auto;">
                        <div class="form-horizontal">
                            <form>
                                <fieldset>
                                    <div class="control-group">
                                        <input type="hidden" name="id_conta" id="id_conta"  value="" />
                                        <div class="control-group">
                                            <label class="control-label">*Nome:</label>
                                            <div class="controls">
                                                <input type="text" name="nome_conta" id="nome_conta" class="input_maior" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label"> *Saldo inicial:</label>
                                            <div class="controls">
                                                <input type="text" name="saldo_conta" id="saldo_conta" class="input_menor" value="" />
                                                <div>
                                                    <br/>
                                                    <input style="margin-bottom:3px;" name="tipo_saldo" checked id="saldo_positivo" type="radio" value="positivo"/>&nbsp;
                                                    <span class="label label-info">Positivo</span>&nbsp;&nbsp;
                                                    <input style="margin-bottom:3px;" type="radio" name="tipo_saldo" id="saldo_negativo" value="negativo"/>&nbsp;
                                                    <span class="label label-important">Negativo</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Data do saldo:</label>
                                            <div class="controls">
                                                <input type="text" name="data_conta" id="data_conta" class="datepicker" value="17/03/2014" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label"> Limite:</label>
                                            <div class="controls">
                                                <input type="text" name="limite_conta" id="limite_conta" class="input_menor" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Banco:</label>
                                            <div class="controls">
                                                <select onchange="ConfigBoleto();" name="banco_conta" id="banco_conta">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                        $bancos = mysql_query("SELECT * FROM `banco`");
                                                        while($banco = mysql_fetch_array($bancos)):
                                                    ?>
                                                    <option value="<?=$banco[0]?>"><?=$banco[1]?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Ag&ecirc;ncia:</label>
                                            <div class="controls">
                                                <input onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" type="text" name="agencia_conta" id="agencia_conta" class="input_menor" value="" />
                                                <label class=" checkbox inline">Dv:</label>
                                                <input onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" maxlength="1" style="width:30px;" type="text" value="" name="dv_agencia" id="dv_agencia" />
                                                <i title="Caso n&atilde;o possua, preencha com o n&uacute;mero 0" id="tip_dv_cedente" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*N&uacute;mero:</label>
                                            <div class="controls">
                                                <input onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);"  type="text" style="width:80px;" name="numero_conta" id="numero_conta" class="input_menor" value="" />
                                                <label class=" checkbox inline"> *Dv:</label>
                                                <input onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" maxlength="1" style="width:30px;" type="text" value="" name="dv_conta" id="dv_conta" />
                                                <i title="Para o banco Bradesco preencha obrigatoriamente este campo" id="tip_dv_cedente" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
                                            </div>
                                        </div>	
                                        <div class="control-group">
                                            <div class="controls">
                                                <label id="label_configurar_boleto" style="display:none;" onclick="CamposBoleto()"; class="control-label" onmouseover="mouse(this);">Configurar Boleto <i class="icon-arrow-down"></i><i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black flt_rgt" id="tip_boleto" title="Dispon&iacute;vel apenas para os Bancos: Ita&uacute;,Bradesco,Santander,CEF e Banco do Brasil"></i></label>
                                            </div>
                                        </div>
                                        <div id="div_campos_boleto" style="display:none;">
                                            <div class="control-group">
                                                <label class="control-label">Carteira</label>
                                                <div class="controls">
                                                    <input  onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" type="text" name="carteira_boleto_conta" id="carteira_boleto_conta" class="input_menor" value="" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Custo por boleto</label>
                                                <div class="controls">
                                                    <input type="text" class="input_menor"  id="custo_boleto_conta" name="custo_boleto_conta" value="" />
                                                    <i title="Esta taxa ser&aacute; adicionada ao valor do boleto emitido" id="tip_custo" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Conv&ecirc;nio com o banco (c&oacute;digo do cedente):</label>
                                                <div class="controls">
                                                    <input  onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" type="text" name="convenio_boleto_conta" id="convenio_boleto_conta" class="input_menor" value="" />
                                                    <i title="Para o Banco: Ita&uacute; este n&uacute;mero &eacute; o n&uacute;mero da conta, sem o digito verificador" id="tip_taxa" class="hidden-phone hidden-tablet icon-question-sign icon-black" rel="tooltip" data-placement="left"></i>
                                                    <label class=" checkbox inline">Dv:</label>
                                                    <input onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" maxlength="1" style="width:30px;" type="text" value="" name="dv_cedente" id="dv_cedente" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <label class="control-label">Instru&ccedil;&otilde;es do boleto</label>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Linha 1</label>
                                                <div class="controls">
                                                    <input type="text" class="input_menor"  id="linha1_boleto_conta" name="linha1_boleto_conta" value="" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Linha 2</label>
                                                <div class="controls">
                                                    <input type="text" class="input_menor"  id="linha2_boleto_conta" name="linha2_boleto_conta" value="" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Linha 3</label>
                                                <div class="controls">
                                                    <input type="text" class="input_menor"  id="linha3_boleto_conta" name="linha3_boleto_conta" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls al_rgt">
                                                <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
                                                <a class="btn btn-primary" onclick="GravarConta();">Salvar</a>
                                            </div>
                                        </div>
                                    </div>	
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal hide" id="modal_caixapequeno">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&#215;</button>
                        <h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_caixap">Novo Caixa Pequeno</h2>
                        <i id="usuario_caixap" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por Carlos"></i>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <form>
                                <fieldset>
                                    <div class="control-group">
                                        <input type="hidden" name="id_caixap" id="id_caixap"  value="" />
                                        <div class="control-group">
                                            <label class="control-label">*Nome:</label>
                                            <div class="controls">
                                                <input type="text" name="nome_caixap" id="nome_caixap" class="input_maior" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Saldo inicial:</label>
                                            <div class="controls">
                                                <input type="text" name="saldo_caixap" id="saldo_caixap" class="input_menor" value="" />                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Data do saldo:</label>
                                            <div class="controls">
                                                <input type="text" name="data_caixap" id="data_caixap" class="datepicker" value="17/03/2014" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls al_rgt">
                                                <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
                                                <a class="btn btn-primary" onclick="GravarCaixap();">Salvar</a>
                                            </div>
                                        </div>
                                    </div>	
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal hide" id="modal_cartao">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&#215;</button>
                        <h2 class="pr_5 mr_0" style="display:inline;" id="texto_nome_cartao">Novo Cart&atilde;o de cr&eacute;dito</h2>
                        <i id="usuario_cartao" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por <?=$_COOKIE['nome']?>"></i>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info" id="div_aviso_cartao">
                            <button type="button" class="close" data-dismiss="alert">&times</button>
                        ATEN&Ccedil;&Atilde;O ao alterar as datas de vencimento, os lan&ccedil;amentos podem mudar da fatura ou mesmo ser deletados de faturas inexistentes
                        </div>
                        <!--<br/>-->
                        <div class="form-horizontal">
                            <form>
                                <fieldset>
                                    <div class="control-group">
                                        <input type="hidden" name="id_cartao" id="id_cartao"  value="" />
                                        <div class="control-group">
                                            <label class="control-label">*Cart&atilde;o:</label>
                                            <div class="controls">
                                                <input style="width:100px;" type="text" name="nome_cartao" id="nome_cartao" class="input_maior" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">N&uacute;mero:</label>
                                            <div class="controls">
                                                <input placeholder="" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);" size="19" type="text" name="numero_cartao" id="numero_cartao" class="input_maior" value="" maxlength="19" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Limite:</label>
                                            <div class="controls">
                                                <input style="width:100px;" type="text" name="limite_cartao" id="limite_cartao" class="input_menor" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Vale at&eacute; o m&ecirc;s:</label>
                                            
                                            <div class="controls">
                                                <input placeholder="mm" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);"  style="width:50px;" type="text" maxlength="2" name="mes_cartao" id="mes_cartao" class="input_maior" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Vale at&eacute; o ano:</label>
                                            <div class="controls">
                                                <input placeholder="aaaaa" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);" style="width:50px;" type="text" maxlength="4" name="ano_cartao" id="ano_cartao" class="input_maior" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Vence no dia:</label>
                                            <div class="controls">
                                                <input placeholder="dd" maxlength="2" style="width:50px;"  type="text" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);" name="dia_vencimento_cartao" id="dia_vencimento_cartao" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Dia limite da compra <i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_melhor_dia" title="Se a compra for feita at&e esta data, cair&aacute; na fatura atual"></i></label>
                                            <div class="controls">
                                                <input placeholder="dd" type="text" maxlength="2" style="width:50px;" name="dia_limite_cartao" id="dia_limite_cartao" onkeyup="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeydown="Mascara(this,Integer);" class="input_menor" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group" id="div_inicio_faturas">
                                            <label class="control-label">*In&iacute;cio das faturas</label>
                                            <div class="controls">
                                                <select id="mes_inicio_fatura" style="width:180px;">
                                                    <option value='1'<?=date("n") == 1 ? " selected='true'" : ""?>>Janeiro</option>
                                                    <option value='2'<?=date("n") == 2 ? " selected='true'" : ""?>>Fevereiro</option>
                                                    <option value='3'<?=date("n") == 3 ? " selected='true'" : ""?>>Mar&ccedil;o</option>
                                                    <option value='4'<?=date("n") == 4 ? " selected='true'" : ""?>>Abril</option>
                                                    <option value='5'<?=date("n") == 5 ? " selected='true'" : ""?>>Maio</option>
                                                    <option value='6'<?=date("n") == 6 ? " selected='true'" : ""?>>Junho</option>
                                                    <option value='7'<?=date("n") == 7 ? " selected='true'" : ""?>>Julho</option>
                                                    <option value='8'<?=date("n") == 8 ? " selected='true'" : ""?>>Agosto</option>
                                                    <option value='9'<?=date("n") == 9 ? " selected='true'" : ""?>>Setembro</option>
                                                    <option value='10'<?=date("n") == 10 ? " selected='true'" : ""?>>Outubro</option>
                                                    <option value='11'<?=date("n") == 11 ? " selected='true'" : ""?>>Novembro</option>
                                                    <option value='12'<?=date("n") == 12 ? " selected='true'" : ""?>>Dezembro</option>
                                                </select>
                                                <select id="ano_inicio_fatura" style="width:80px;">
                                                    <?php
                                                        $ano = (int) date("Y");
                                                        for($i = ($ano - 10), $j = ($ano + 20);$i <= $j; $i++) :
                                                    ?>
                                                    <option  value='<?=$i?>'<?=($i == (int)date("Y")) ? " selected='true'" : ""?>><?=$i?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group" id="div_conta_cartao">
                                            <label class="control-label">Lan&ccedil;ar na conta</label>
                                            <div class="controls">
                                                <select id="conta_cartao" name="conta_cartao" style="width:180px;">
                                                    <option value="" >Selecione</option>
                                                    <?php
                                                        $contas = mysql_query("SELECT `c`.`caixa_id`, `c`.`caixa_nome` FROM `caixa` `c` JOIN `conta_corrente` `cc` ON `c`.`caixa_id` = `cc`.`caixa_id`");
                                                        while($conta = mysql_fetch_array($contas)):
                                                    ?>
                                                    <option value='<?=$conta[0]?>'><?=$conta[1]?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls al_rgt">
                                                <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
                                                <a class="btn btn-primary" onclick="GravarCartao();">Salvar</a>
                                            </div>
                                        </div>
                                    </div>	
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal hide" id="modal_categoria">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&#215;</button>
                        <h2 id="texto_nome_categoria" class="pr_5 mr_0" style="display:inline;">Nova Categoria</h2>
                        <i id="usuario_categoria" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por <?=$_COOKIE['nome']?>"></i>
                    </div>
                    <div class="modal-body" style="max-height:420px;">
                        <div class="form-horizontal">
                            <form>
                                <fieldset>
                                    <input type="hidden" name="id_categoria" id="id_categoria" class="input_menor" value="" />
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="control-label">Categoria:</label>
                                            <div class="controls">
                                                <input type="text" name="nome_categoria" id="nome_categoria" class="input_menor" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Categoria pai:</label>
                                            <div class="controls" id="div_categorias_pai">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label"> Tipo:</label>
                                            <div class="controls">
                                                <select name="tipo_categoria" id="tipo_categoria">
                                                    <option value="1">Receita</option>
                                                    <option value="2">Despesa</option>
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
                <div class="modal hide" id="modal_centro">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&#215;</button>
                        <h2 id="texto_nome_centro" class="pr_5 mr_0" style="display:inline;">
                        Novo Centro de custos
                        </h2>
                        <i id="usuario_centro" class="hidden-phone hidden-tablet icon-plus-sign icon-black" onmouseover="mouse(this);" title="Cadastrado por <?=$_COOKIE['nome']?>"></i>
                    </div>
                    <div class="modal-body" style="max-height:420px;">
                        <div class="form-horizontal">
                            <form>
                                <fieldset>
                                    <input type="hidden" name="id_centro" id="id_centro" class="input_menor" value="" />
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="control-label">Nome:</label>
                                            <div class="controls">
                                                <input type="text" name="nome_centro" id="nome_centro" class="input_menor" value="" />
                                                <i title="Fa&ccedil;a a apura&ccedil;&atilde;o por &aacute;rea de suas receitas e despesas atrav&eacute;s dos centros de custo" onmouseover="mouse(this);" class="hidden-phone hidden-tablet icon-question-sign icon-black" style="cursor: pointer;"></i>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls al_rgt">
                                                <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
                                                <a class="btn btn-primary" onclick="GravarCentro();">Salvar</a>
                                            </div>
                                        </div>
                                    </div>	
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="da-panel-header">
                    <span class="da-panel-title">
                        <span class="label label-inverse pr_5">
                            <i><img width="16px" alt="FINANCEIRO" src="https://bobsoftware.com.br/erp/application/images/icons/white/32/cur_dollar.png"/></i>
                        </span>
                        <strong class="tt_uc">Financeiro</strong>
                        <a href="#started_financeiro" data-toggle="modal"  title="Clique aqui para ver o v&iacute;deo tutorial"><i class="icon-facetime-video icon-black"></i></a>
                    </span>
                </div>
                <div class="da-panel-content">
                    <div class="da-panel-padding">
                        <div class="tabbable">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab0" data-toggle="tab">Dados da empresa</a></li>
                                <li><a href="#tab1" data-toggle="tab">Contas banc&aacute;rias</a></li>
                                <li><a href="#tab2" data-toggle="tab">Caixa pequeno</a></li>
                                <li><a href="#tab7" data-toggle="tab">Cart&otilde;es de cr&eacute;dito <img src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/novidade-icon.png" alt="Novos Recursos"/></a></li>
                                <li><a href="#tab3" data-toggle="tab">Categorias e Subcategorias</a></li>
                                <li><a href="#tab4" data-toggle="tab">Centros de custo</a></li>
                                <li><a href="#tab5" data-toggle="tab">Envio de Boletos</a></li>
                                <li><a href="#tab6" data-toggle="tab">Envio de avisos por e-mail</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab0">	
                                    <div class="da-panel-padding" align="center">
                                        <div id="msg_sucesso_tab0" class="alert alert-success" style="display:none;"></div>
                                        <div  id="msg_erro_tab0" class="alert alert-error" style="display:none;"></div>
                                        <form class="form-horizontal">
                                            <fieldset>
                                                <?php
                                                    $query = mysql_query("SELECT * FROM `config_financ`");
                                                    $config = mysql_fetch_array($query);
                                                ?>
                                                <div class="control-group">
                                                    <label class="control-label"> *Raz&atilde;o Social:</label>
                                                    <div class="controls">
                                                        <input type="text" class="input_full" name="razao_social" id="razao_social" value="<?=$config[1]?>" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="control-group">
                                                        <label class="control-label"> *CNPJ:</label>
                                                        <div class="controls">
                                                            <input value="<?=$config[2]?>" maxlength="18" onkeydown="Mascara(this,Cnpj);" onkeypress="Mascara(this,Cnpj);" onkeyup="Mascara(this,Cnpj);" class="input_full" type="text" name="cnpj" id="cnpj" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>	
                                            <div class="form-actions al_rgt">
                                                <label class="btn btn-inverse" onClick="JavaScript: window.history.back();return false;">
                                                    <i class="icon-remove icon-white"></i> Cancelar
                                                </label>
                                                <label href="javascript:void(0)" onclick="GravarDadosEmpresa();" class="btn btn-success">
                                                    <i class="icon-ok icon-white"></i> Salvar
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab1">	
                                    <div class="da-panel-header">
                                        <span class="da-panel-title">
                                            <strong class="tt_uc">Contas banc&aacute;rias</strong>
                                            <span class="da-panel-btn">
                                                <a onclick="LimparContas();" class="btn btn-primary" data-toggle="modal" href="#modal_conta"><i  class="icon-plus icon-white"></i> Nova</a>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="row-fluid" id="resp_contas" align="center">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <div class="row-fluid">
                                        <div class="da-panel-header">
                                            <span class="da-panel-title">
                                                <span class="tt_uc">
                                                    <strong class="tt_uc">Caixa Pequeno</strong>
                                                </span>	
                                                <span class="da-panel-btn">
                                                    <a onclick="LimparCaixap();" class="btn btn-primary" data-toggle="modal" href="#modal_caixapequeno">
                                                        <i  class="icon-plus icon-white"></i> Novo
                                                    </a>
                                                </span>
                                            </span>		
                                        </div>	
                                        <div id="resp_caixap">
                                        </div>	
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab7">
                                    <div class="row-fluid">
                                        <div class="da-panel-header">
                                            <span class="da-panel-title">
                                                <span class="tt_uc">
                                                    <strong class="tt_uc">Cart&otilde;es de cr&eacute;dito</strong>
                                                </span>
                                                <span class="da-panel-btn">
                                                    <a onclick="$('#div_inicio_faturas').show();$('#div_conta_cartao').show();$('#div_aviso_cartao').hide();LimparCartao();" class="btn btn-primary" data-toggle="modal" href="#modal_cartao">
                                                        <i  class="icon-plus icon-white"></i> Novo
                                                    </a>
                                                </span>
                                            </span>		
                                        </div>	
                                        <div id="resp_cartoes">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab3">	
                                    <div class="da-panel-header">
                                        <span class="da-panel-title">
                                            <span class="tt_uc">
                                                <strong class="tt_uc">Categorias e Subcategorias</strong>
                                            </span>	
                                            <span class="da-panel-btn">
                                                <a onclick="LimparCategoria();" class="btn btn-primary" data-toggle="modal" href="#modal_categoria">
                                                    <i  class="icon-plus icon-white"></i> Nova
                                                </a>
                                            </span>
                                        </span>		
                                    </div>
                                    <div class="row-fluid">
                                        <span class="tt_uc"></span>	
                                        <div id="resp_categorias">
                                        </div>	
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab4">	
                                    <div class="da-panel-header">
                                        <span class="da-panel-title">
                                            <span class="tt_uc">
                                                <strong class="tt_uc">Centros de custo</strong>
                                            </span>	
                                            <span class="da-panel-btn">
                                                <a onclick="LimparCentro();" class="btn btn-primary" data-toggle="modal" href="#modal_centro">
                                                    <i  class="icon-plus icon-white"></i> Novo
                                                </a>
                                            </span>
                                        </span>		
                                    </div>
                                    <div class="row-fluid">
                                        <span class="tt_uc"></span>	
                                        <div id="resp_centros">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab5">
                                    <div class="da-panel-padding" align="center">
                                        <div id="msg_sucesso_tab5" class="alert alert-success" style="display:none;"></div>
                                        <div  id="msg_erro_tab5" class="alert alert-error" style="display:none;"></div>
                                        <?php
                                            $sql = mysql_query("SELECT * FROM `config_email`");
                                            $conf = mysql_fetch_row($sql);
                                        ?>
                                        <form class="form-horizontal">
                                            <fieldset>
                                                <input type="hidden" name="rec_id" id="rec_id" value="<?=$conf[0]?>" />
                                                <div class="control-group">
                                                    <label class="control-label"> *Nome do remetente:</label>
                                                    <div class="controls al_lft">
                                                        <input type="text" class="input_full" name="rec_nome_remetente" id="rec_nome_remetente" value="<?=$conf[1]?>" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> *Email do remetente:</label>
                                                    <div class="controls al_lft">
                                                        <input type="text" class="input_full" name="rec_email_remetente" id="rec_email_remetente" value="<?=$conf[2]?>" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="control-group">
                                                        <label class="control-label"> *Com aviso para:</label>
                                                        <div class="controls al_lft">
                                                            <input value="<?=$conf[3]?>" class="input_full" type="text" name="rec_copia" id="rec_copia" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="control-group">
                                                        <label class="control-label"> *Enviar:</label>
                                                        <div class="controls al_lft">&nbsp;
                                                            <input id="rec_envio_dias" name="rec_envio_dias" style="width:100px;" placeholder="X" value="<?=$conf[4]?>" maxlength="18" onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" type="text" />
                                                            <label class="checkbox inline">&nbsp;dias antes</label>
                                                            <label class="checkbox inline">&nbsp;e 
                                                                <input id="rec_envio_dia" type="checkbox" <?=empty($conf[6]) ? "" : "checked='true'"?>/>tamb&eacute;m no dia
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="control-group">
                                                        <label class="control-label">
                                                            Reenviar atrasados? <i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_reenvio_baixa" title="Marque esta op&ccedil;&atilde;o se deseja que seu cliente receba um aviso mesmo ap&oacute;s o vencimento. Entre em contato com ele para gerar uma segunda via"></i>
                                                        </label>
                                                        <div class="controls al_lft">
                                                            <select id="rec_reenvio_atrasado" onchange="ConfigDiasAtraso(this.value);">
                                                                <option selected="true" value="0">N&atilde;o</option>
                                                                <option value="1"<?=$conf[5] ? " selected='true'" : ""?>>Sim</option>
                                                            </select>														
                                                            <label class="checkbox inline al_lft" id="label_intervalo_atraso" style="display:<?=$conf[5] ? "show" : "none"?>">
                                                                a cada&nbsp;&nbsp;<input id="rec_intervalo_atraso" name="rec_intervalo_atraso" style="width:50px;" placeholder="X" value="" maxlength="4" onkeydown="Mascara(this,Integer);" onkeypress="Mascara(this,Integer);" onkeyup="Mascara(this,Integer);" type="text"/>&nbsp;&nbsp;dia(s)<i data-placement="left" rel="tooltip" class="hidden-phone hidden-tablet icon-question-sign icon-black" id="tip_reenvio_baixa2" title="O aviso ser&aacute; enviado a cada 'x' dias ap&oacute;s o vencimento."></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>	
                                            <div class="form-actions al_rgt">
                                                <label class="btn btn-inverse" onClick="JavaScript: window.history.back();return false;">
                                                    <i class="icon-remove icon-white"></i> Cancelar
                                                </label>
                                                <label href="javascript:void(0)" onclick="GravarRecorrencia();" class="btn btn-success">
                                                    <i class="icon-ok icon-white"></i> Salvar
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab6">	
                                    <div class="da-panel-padding" align="center">
                                        <div id="msg_sucesso_tab6" class="alert alert-success" style="display:none;"></div>
                                        <div  id="msg_erro_tab6" class="alert alert-error" style="display:none;"></div>
                                        <?php
                                            $query = mysql_query("SELECT * FROM `config_notifica`");
                                            $config = mysql_fetch_array($query);
                                        ?>
                                        <form class="form-horizontal">
                                            <fieldset>
                                                <input type="hidden" value="<?=$config[0] ? $config[0]: ""?>" name="aviso_id" id="aviso_id"/>
                                                <div class="control-group">
                                                    <label class="control-label"> O que deve ser enviado no aviso?</label>
                                                    <div class="controls al_lft">
                                                        <label class="checkbox inline">Contas a pagar e a receber</label>
                                                        <select id="aviso_periodo">
                                                            <option value="dia"<?=($config[1]=="dia" ? " selected='true'": "")?>>Do dia</option>
                                                            <option value="semana"<?=($config[1]!="dia" ? " selected='true'": "")?>>Da semana</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> Quando enviar?</label>
                                                    <div class="controls al_lft">
                                                    <?php
                                                        $notifica_semana = array();
                                                        if($config[0]) {
                                                            $not_sem = mysql_query("SELECT `semana_id` FROM `notifica_semana`");
                                                            if(mysql_num_rows($not_sem) > 0) {
                                                                while($ns =  mysql_fetch_row($not_sem))
                                                                    $notifica_semana[] = $ns[0];
                                                            }
                                                        }
                                                        $sem = mysql_query("SELECT * FROM `semana`");
                                                        while($semana = mysql_fetch_row($sem)):
                                                    ?>
                                                        <label class="checkbox inline">
                                                            <input class="chk_dias" value="<?=$semana[0]?>" name="aviso_dias" id="aviso_<?=$semana[0]?>" type="checkbox"<?=!empty($notifica_semana) ? in_array($semana[0], $notifica_semana) ? " checked='true'" : "" : ""?>/>&nbsp;<?=$semana[1]?>
                                                        </label>
                                                    <?php endwhile; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> Para quem enviar?</label>
                                                    <table align="center" class="table table-bordered table-striped" align="center" style="background: #fff;width:80%">
                                                    <?php
                                                        $notifica_usuario = array();
                                                        if($config[0]) {
                                                            $not_usu = mysql_query("SELECT `usuario_id` FROM `notifica_usuario`");
                                                            if(mysql_num_rows($not_usu) > 0) {
                                                                while($nu =  mysql_fetch_row($not_usu))
                                                                    $notifica_usuario[] = $nu[0];
                                                            }
                                                        }
                                                        $usu = mysql_query("SELECT * FROM `usuario` WHERE `usuario_ativo` IS TRUE");
                                                        $i = 0;
                                                        while($usuario = mysql_fetch_array($usu)):
                                                    ?>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input value="<?=$usuario[0]?>" class="chk_users" id="aviso_user_<?=++$i?>" type="checkbox"<?=!empty($notifica_usuario) ? in_array($usuario[0], $notifica_usuario) ? " checked='true'" : "" : ""?>/>&nbsp;<?=$usuario[1]?></label></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                    </table>
                                                </div>
                                            </fieldset>	
                                            <div class="form-actions al_rgt">
                                                <label class="btn btn-inverse" onClick="JavaScript: window.history.back();return false;">
                                                    <i class="icon-remove icon-white"></i> Cancelar
                                                </label>
                                                <label href="javascript:void(0)" onclick="GravarAviso();" class="btn btn-success">
                                                    <i class="icon-ok icon-white"></i>Salvar
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </article>
    <script type="text/javascript">
        <!--
        $('#fbusca_contas').keydown(function(e) {
            if (e.keyCode == 13) {
                BuscaContasBox('lancamentos',1);
                return false;
            }
        });
        $('#fbusca_contatos').keydown(function(e) {
            if (e.keyCode == 13) {
                BuscaContatosBox('lancamentos',1);
                return false;
            }
        });
        //-->
    </script>
</div>