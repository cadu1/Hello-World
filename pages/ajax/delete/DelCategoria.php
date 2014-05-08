<?php
    include("../../lib/connection.php");

    $id = $_POST['categoria'];

    if($id) {
        $query = mysql_query("SELECT * FROM `lancamento` WHERE `categoria_id` = $id LIMIT 1");

        if(mysql_num_rows($query) > 0) {
            echo '0|N&atilde;o foi poss&iacute;vel excluir, pois existem lan&ccedil;amentos associados a esta categoria';
        } else {
            $query = mysql_query("SELECT * FROM `categoria` WHERE `id_subcategoria` = $id LIMIT 1");

            if(mysql_num_rows($query) > 0) {
                echo '0|N&atilde;o foi poss&iacute;vel excluir, pois existem subcategorias associados a esta categoria';
            } else {
                $query = mysql_query("DELETE FROM `categoria` WHERE `categoria_id` = $id");
    
                if($query) {
                    echo '1|Categoria exclu&iacute;do com sucesso';
                } else {
                    echo '1|Ocorreu um erro, tente novamente';
                }
            }
        }
    }

    exit();
?>