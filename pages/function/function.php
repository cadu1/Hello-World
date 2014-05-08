<?php
    include("../../lib/connection.php");

    function montarCategoria() {
		$refs = array();
		$list = array();
        
        $query = mysql_query("SELECT * FROM `categoria`");

        if(mysql_num_rows($query) > 0) {
            while ($data = mysql_fetch_array($query)) {
    			$thisref = &$refs[$data[0]];
    
    			$thisref['id'] = $data[0];
    			$thisref['nome'] = $data[2];
                $thisref['tipo'] = $data[3];
    
    			if ($data[1] == 0) {
    				$list[$data[0]] = &$thisref;
    			} else {
    				$refs[$data[1]]['filhos'][$data[0]] =
    					&$thisref;
    			}
    		}
    		monta($list);
        } else {
            echo "<tr><td colspan='3'>Nenhum registro encontrado</td></tr>";
        }
	}

	function monta($te, $filho = 0) {
		foreach ($te as $t) {
            echo "<tr>" .
        		"<td data-th='Nome' title='Categoria'>" . 
                ($filho ? "<li>{$t["nome"]}</li>" : "<strong>{$t["nome"]}</strong>") . 
                "</td>" .	
                "<td data-th='Tipo'>" .
                ($t["tipo"] ? "<span class='label label-info'>Receita</span>" : "<span class='label label-important'>Despesa</span></td>") .               
                "<td data-th='Ações' nowrap=''>" .
        			"<a class='btn btn-inverse' data-toggle='modal' href='#modal_categoria' title='Editar' onclick='EditarCategoria({$t['id']});'>" .
        				"<i class='icon-pencil icon-white'></i>" .
        			"</a>" .
        			"<a class='btn btn-warning' title='Excluir' onclick='DelCategoria({$t['id']});'>" .
        				"<i class='icon-remove-sign icon-black'></i>" .
        			"</a>" .
        		"</td>" .
        	"</tr>";

			if (isset($t['filhos'])) {
				monta($t['filhos'], 1);
			}
		}
	}
 ?>