<?php

class Conexao {

	// Criando os atributos 
	private $host = 'localhost';
	private $dbname = 'php_com_pdo';
	private $user = 'root';
	private $pass = '';

	// Criando os métodos
	public function conectar(){
		try {
			$conexao = new PDO(
			// Precisamos parâmetros para o construtor (dsn, user e pass)

			"mysql:host=$this->host;dbname=$this->dbname",
			"$this->user",
			"$this->pass"
			);
			return $conexao;
		} 

		// Poderíamos customizar as mensagens de erro a ser exibida
		// Mas nesse momento não é necessário
		catch (PDOException $e) {
			echo '<p>'.$e->getMessage().'</p>';
		}

	}
}

?>