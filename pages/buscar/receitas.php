<?php
    include("../../function.php");
    
        $mounths = array("janeiro" => 1, "fevereiro" => 2, "março" => 3, "abril" => 4, "maio" => 5, "junho" => 6, "julho" => 7, "agosto" => 8, "setembro" => 9, "outubro" => 10, "novembro" => 11, "dezembro" => 12);
    $mounths1 = array(1 => "janeiro", 2 => "fevereiro", 3 => "mar&ccedil;o", 4 => "abril", 5 => "maio", 6 => "junho", 7 => "julho", 8 => "agosto", 9 => "setembro", 10 => "outubro", 11 => "novembro", 12 => "dezembro");
    $result = "";
    $periodo = $_POST["valor_periodo"];
    $where = "";

    if($_POST["tipo_periodo"] == "semana") {
        $periodo = explode("-", $periodo);
        $start = date("Y-m-d", strtotime(str_replace("/", "-", $periodo[0])));
        $end = date("Y-m-d", strtotime(str_replace("/", "-", $periodo[1])));
        if($_POST["seta"] == "antes") {
            $start = date("Y-m-d", strtotime("$start -1 week"));
            $end = date("Y-m-d", strtotime("$end -1 week"));
        } elseif($_POST["seta"] == "depois") {
            $start = date("Y-m-d", strtotime("$start +1 week"));
            $end = date("Y-m-d", strtotime("$end +1 week"));
        }
        $result = date("d/m/Y", strtotime($start)) . " - " . date("d/m/Y", strtotime($end));
        $where = "BETWEEN '$start' AND '$end'";
    } else if($_POST["tipo_periodo"] == "dia") {
        $day = date("Y-m-d", strtotime(str_replace("/", "-", $periodo)));
        if($_POST["seta"] == "antes") {
            $day = date("Y-m-d", strtotime("$day -1 day"));
        } elseif($_POST["seta"] == "depois") {
            $day = date("Y-m-d", strtotime("$day +1 day"));
        }
        $result = date("d/m/Y", strtotime($day));
        $where = "= '$day'";
    } else if($_POST["tipo_periodo"] == "mes") {
        $periodo = explode("/", $periodo);
        $year = $periodo[1];
        $curMounth = $mounths[$periodo[0]];
        if($_POST["seta"] == "antes") {
            $curMounth = $mounths[$periodo[0]];
            if($curMounth == 1) {
                $curMounth = 12;
                $year = (int)$year - 1;
            } else {
                $curMounth--;
            }
        } elseif($_POST["seta"] == "depois") {
            $curMounth = $mounths[$periodo[0]];
            if($curMounth == 12) {
                $curMounth = 1;
                $year = (int)$year + 1;
            } else {
                $curMounth++;
            }
        }
        $result = "{$mounths1[$curMounth]}/$year";
        $start = date("$year-$curMounth-01");
        $end = date("$year-$curMounth-t");
        $where = "BETWEEN '$start' AND '$end'";
    } else if($_POST["tipo_periodo"] == "ano") {
        if($_POST["seta"] == "antes") {
            $periodo = (int)$periodo - 1;
        } elseif($_POST["seta"] == "depois") {
            $periodo = (int)$periodo + 1;
        }
        $start = date("Y-m-d", strtotime("$periodo-01-01"));
        $end = date("Y-m-d", strtotime("$periodo-12-31"));
        $result = $periodo;
        $where = "BETWEEN '$start' AND '$end'";
    }
    
    echo $result;
?>
~<div class="da-panel-header">
	<span class="da-panel-title">
		<strong class="tt_uc">&nbsp;</strong>
		<strong class="flt_rgt" style="margin-right:100px;"></strong>
	</span>
</div>
<div class="row-fluid" style="text-align:center;">
	<table class="da-table">
		<thead>
			<tr>
				<th width="150px">Data</th>
				<th>Categoria</th>
				<th>Lançamento</th>
				<th>Cliente</th>
				<th>Valor R$</th>
				<th>Saldo</th>
				<th width="100px">Ações</th>
			</tr>
		</thead>
		<tbody>
        <?php
            //$start = date("Y-m-d", strtotime(str_replace("/","-",$inicio)));
            //$end = date("Y-m-d", strtotime(str_replace("/","-",$fim)));
            $query = mysql_query("SELECT `l`.`lancamento_id`, `l`.`lancamento_vencimento`, `ca`.`categoria_nome`, `l`.`lancamento_descricao`, `l`.`pessoa_cliente`, `l`.`lancamento_valor`, `c`.`caixa_nome` FROM `lancamento` `l` LEFT JOIN `caixa` `c` ON `l`.`caixa_id` = `c`.`caixa_id` LEFT JOIN `conta_corrente` `cc` ON `c`.`caixa_id` = `cc`.`caixa_id` JOIN `categoria` `ca` ON `l`.`categoria_id` = `ca`.`categoria_id` WHERE `ca`.`categoria_tipo` IS TRUE AND `l`.`lancamento_vencimento` $where");
            if(mysql_num_rows($query) > 0):
                while($lanc = mysql_fetch_row($query)):
        ?>
			<tr title="Conta: <?=$lanc[6]?>">
				<td data-th="Data" class="al_rgt"><i class="icon-time icon-black" title="Previsto"></i> <?=date("d/m/Y", strtotime($lanc[1]))?></td>	
				<td data-th="Categoria"><span class="label label-info"><?=$lanc[2]?></span></td>
				<td data-th="Nome"><?=$lanc[3]?></td>
				<td data-th="Fornecedor/Cliente"><?=$lanc[4]?></td>
				<td data-th="Valor" class="al_rgt">
					<label class="text-info"><?=$lanc[5]?></label>
				</td>
				<td data-th="Saldo Anterior" class="al_rgt">
					<label class="text-info">210,00</label>
				</td>
				<td data-th="Ações" nowrap="" class="al_rgt">
					<a class="btn" title="Baixa" data-toggle="modal" onclick="FormBaixaLan('<?=$lanc[0]?>','lancamento');" href="#modal_baixa">
						<i class="icon-arrow-down icon-black"></i>
					</a>
					<a data-toggle="modal" href="#modal_lan" onclick="FormLan('receita','<?=$lanc[0]?>','lancamento');" class="btn btn-inverse" title="Editar">
						<i class="icon-pencil icon-white"></i>
					</a>
					<a onclick="AcaoDeletarLan('',<?=$lanc[0]?>,0,'lancamento');$('#fatura_id').val('')" class="btn btn-warning" title="Excluir">
						<i class="icon-remove-sign icon-black"></i>
					</a>
				</td>
			</tr>
            <?php 
                    endwhile;
                else: 
            ?>
            <tr style="background-color: #FCFCFC;">
				<td colspan="5" style="text-align:center;">Nenhum registro encontrado</td>	
			</tr>
        <?php endif; ?>
		</tbody>
	</table>		
</div>
<div class="da-panel-header">
	<span class="da-panel-title">
		<strong class="tt_uc">&nbsp;</strong>
		<strong class="flt_rgt" style="margin-right:100px;">Total: R$ 10,00</strong>
	</span>
</div>