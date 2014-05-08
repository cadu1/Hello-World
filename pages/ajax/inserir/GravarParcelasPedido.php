<?php
    include("../../lib/connection.php");
    
    if ($_POST) {
        //echo "<pre>".var_dump($_POST)."</pre>";
        $data = $_POST["datas_parcelas"];
        $datas = explode("&", $data);
        $valor = $_POST["valores_parcelas"];
        $valores = explode("&", $valor);
        
        if(!empty($data) && !empty($valor)) {
            mysql_query("DELETE FROM `parcelas_temporario` WHERE `usuario_id` = {$_COOKIE['id']}");
            if(count($datas)==count($valores)) {
                $total = count($valores) - 1;

                for($i = 0; $i <= $total; $i++) {
                    $dt = date("Y-m-d", strtotime(str_replace("/","-", $datas[$i])));
                    $vl = str_replace(",", ".", $valores[$i]);
                    mysql_query("INSERT INTO `parcelas_temporario` VALUES({$_COOKIE['id']},$vl, '$dt')");
                }
                echo "1|Gravado com sucesso, por favor informe o restante dos dados";
            } else {
                echo "0|Verifique se todas as parcelas estão com suas dastas preenchidas";
            }
        } else {
            echo "0|Verifique se todas as parcelas e datas estão preenchidas";
        }
    } else {
        echo "0|Problemas ao tentar gravar os parcelas tente novamente";
    }
    
    exit();
?>