<?php
	include ("pages/lib/connection.php");
	/**
	 * Função para salvar mensagens de LOG no MySQL
	 *
	 * @param string $mensagem - A mensagem a ser salva
	 * @param string $id_item - id do item que sofreu mudança (default: null)
	 * @param string $tabela - nome da tabela que houve mudança
	 *
	 * @return bool - Se a mensagem foi salva ou não (true/false)
	 */
	function salvaLog($mensagem, $id_item = null, $tabela) {
		$ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
		$hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
		$id_usu = $_COOKIE['id'];

		$item = (is_null($id_item) ? $id : $id_item);

		// Usamos o mysql_escape_string() para poder inserir a mensagem no banco
		//   sem ter problemas com aspas e outros caracteres
		$mensagem = mysql_escape_string($mensagem);

		// Monta a query para inserir o log no sistema
		$sql = "INSERT INTO `logs` VALUES (NULL, $id_usu, '$mensagem', '$tabela', '$ip','$hora', '$item')";

		if (mysql_query($sql)) {
			return true;
		} else {
			return false;
		}
	}

	function montarCategoria() {
		$refs = array();
		$list = array();

        $sql = "SELECT categoria_produto_id, categoria_produto_pai_id, categoria_produto_nome FROM categoria_produto ORDER BY categoria_produto_nome";
		$result = mysql_query($sql);
        
		while ($data = @mysql_fetch_assoc($result)) {
			$thisref = &$refs[$data['categoria_produto_id']];

			$thisref['id'] = $data['categoria_produto_id'];
			$thisref['nome'] = $data['categoria_produto_nome'];

			if ($data['categoria_produto_pai_id'] == 0) {
				$list[$data['categoria_produto_id']] = &$thisref;
			} else {
				$refs[$data['categoria_produto_pai_id']]['filhos'][$data['categoria_produto_id']] =
					&$thisref;
			}
		}
		monta($list);
	}

	function monta($te, $filho = 0) {
		foreach ($te as $t) {
			echo "<option  value='{$t['id']}'>" . ($filho ? "- " : "") . "{$t['nome']}</option>";
			if (isset($t['filhos'])) {
				monta($t['filhos'], 1);
			}
		}
	}
?>