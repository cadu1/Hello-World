            <div id="da-content-area">
                <script>

    $(function () {

        $('#input_busca').each(function () {

            var url = dominio + diretorio() + "/interacoes/AutoCompleteBuscar?callback=?";

            var autoCompelteElement = this;

            $(this).autocomplete({source:url,


                select:function (event, ui) {

                    $(autoCompelteElement).val(ui.item.label);

                    fLink(dominio + diretorio() + '/interacoes/form/visualizar/' + ui.item.id);

                }

            });

        });
    });


</script>

	<div class="grid_4">
    <div class="da-panel">
    <div class="da-panel-header">

				<span class="da-panel-title">

					<span class="label label-inverse pr_5"><i><img
                            src="http://<?=$_SERVER['HTTP_HOST']?>/application/images/icons/white/16/users.png"></i></span>

					<strong class="tt_uc">Hist&oacute;ricos</b></strong>
					<span class="box_tools_space">
                        <div class="btn-group">
                            <input type="text" style="padding: 9px;" placeholder="Digite a conta ou contato..."
                                   id="input_busca">
                        </div>
                    </span>
					<span class="da-panel-btn">
						<a href="http://<?=$_SERVER['HTTP_HOST']?>/home/form/historico" class="btn btn-primary"><i
                                class="icon-plus icon-white"></i> Novo</a>
					</span>
				</span>

    </div>

    <div class="da-panel-content">

    <div class="da-panel-padding">

    
    
    <div class="container-fluid clr_both">
    <div class="row-fluid">

    <div class="span12">

    
        <label class="dsp_ib flt_rgt btn disabled">
        <b>1&nbsp;INTERA&Ccedil;&Atilde;O</b>    </label>

    <div class="da-filter hidden-phone hidden-tablet">
    <a class="accordion-toggle dsp_ib flt_rgt btn btn-inverse" data-toggle="collapse" title="Filtrar"
       data-parent="#sanfona" href="#filtro">
        <i class="icon-filter icon-white"></i> Filtro
    </a>

    <div class="accordion pr_0" id="sanfona"> <!-- Precisa de css inline / id="sanfona" -->

    <div class="accordion-group pr_0 brd_none">
    <div class="accordion-heading">

    </div>

    <div id="filtro" class="accordion-body collapse closed">
                                                <span class="accordion-toggle dsp_b btn btn-inverse disabled">
                                                    &nbsp;
                                                </span>

        <div class="accordion-inner well">

            <form class="form-horizontal" name="fmbusca" method="post" id="fmbusca"
                  action="http://bobsoftware.com.br/erp/interacoes/listar">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label">
                            Usu&aacute;rio
                        </label>

                        <div class="controls">
                            <select class="input_full" id="nomeuser" name="nomeuser">
                                <option value="todos">Todos</option>
                                <option  value="1572">Carlos Oliveira</option>                            </select>
                        </div>
                    </div>
                                        <div class="control-group">
                        <label class="control-label">
                            Relacionamento Comercial
                        </label>

                        <div class="controls">
                            <select class="input_full" id="slrelacionamento" name="slrelacionamento">
                                <option value="">Selecione</option>
                                <option  value="1">Suspeito</option><option  value="2">Em prospecção</option><option  value="3">Cliente</option><option  value="4">Ex-Cliente</option><option  value="31">Fornecedor</option><option  value="32">Concorrente</option><option  value="33">Parceiro</option><option  value="34">Colaborador</option><option  value="35">Vendedor</option>                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Conta
                        </label>

                        <div class="controls">
                            <input class="input_full" type="text" id="conta" name="conta"
                                   value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Contato
                        </label>

                        <div class="controls">
                            <input class="input_full" type="text" id="contato" name="contato"
                                   value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Tipo
                        </label>

                        <div class="controls">
                            <select class="input_full" name="tipo" id="tipo">
                                <option value="" SELECTED>Selecione</option>
                                <option  value=5>Chat Online</option><option  value=2>E-mail</option><option  value=6>Facebook</option><option  value=4>Reunião</option><option  value=3>Skype</option><option  value=1>Telefone</option>                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Per&iacute;odo
                        </label>

                        <div class="controls">
                            <div class="row-fluid">
                                <div class="span5">
                                    <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);"
                                           onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);" type="text"
                                           id="data_inicio" name="data_inicio"
                                           value="">
                                </div>
                                <div class="span1 lh_200 al_ctr">
                                    e
                                </div>
                                <div class="span5">
                                    <input class="input_full datepicker" maxlength="10" onkeydown="Mascara(this,Data);"
                                           onkeypress="Mascara(this,Data);" onkeyup="Mascara(this,Data);"
                                           value="" type="text"
                                           id="data_fim" name="data_fim">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions al_rgt">
                        <button href="javascript:void(0)" onclick="$('#fmbusca').submit();" class="btn btn-success"><i
                                class="icon-search icon-white"></i> Filtrar
                        </button>
                    </div>

                </fieldset>

            </form>

        </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <table class="da-table">
        <thead>
        <tr>
                        <th>
                Data
            </th>
            <th>
                Motivo
            </th>
            <th>
                Canal
            </th>
            <th>
                Usu&aacute;rio
            </th>
            <th>
                Conta
            </th>
            <th>
                Contatos
            </th>
            <th>
                A&ccedil;&otilde;es
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
                    <td data-th="Data" onmouseover="mouse(this);"
                onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/visualizar/1')">17/01/2014</td>
            <td data-th="Motivo" onmouseover="mouse(this);"
                onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/visualizar/1')">Prospec&ccedil;&atilde;o</td>
            <td data-th="Canal" onmouseover="mouse(this);"
                onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/visualizar/1')">Chat Online</td>
            <td data-th="Usu&aacute;rio" onmouseover="mouse(this);"
                onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/visualizar/1')">Carlos Oliveira</td>
            <td data-th="Contas" onmouseover="mouse(this);"
                onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/visualizar/1')"></td>
            <td data-th="Contatos" onmouseover="mouse(this);"
                onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/visualizar/1')"></td>
            <td data-th="A&ccedil;&otilde;es">
                                    <a title="Editar" id="editar"
                       onclick="fLink('http://bobsoftware.com.br/erp/interacoes/form/alterar/1')"
                       class="btn btn-inverse">

                        <i class="icon-pencil icon-white"></i>
                    </a>
                    <a title="Excluir" id="excluir"
                       onclick="fConfirm('Tem certeza que deseja excluir?', 'http://bobsoftware.com.br/erp/interacoes/excluir/1')"
                       class="btn btn-warning">

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

    </div>

    <div class="clear"></div>

    <script type="text/javascript"><!--
    $('#fmbusca input').keydown(function (e) {
        if (e.keyCode == 13) {
            $('#fmbusca').submit();
        }
    });
    //--></script>
</div>