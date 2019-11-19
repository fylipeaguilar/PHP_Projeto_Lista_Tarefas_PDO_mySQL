<?php

class Tarefa {

	// Criando os atributos privados
	private $id;
	private $id_status;
	private $tarefa;
	private $data_cadastro;

	// Criando os atributos publico
	// Criando o método "get magigo"
	public function __get($atributo) {
		return $this->$atributo;
	}

	// Criando o método "set magigo"
	public function __set($atributo, $valor){
		$this->$atributo = $valor;

		// ****** Inclusão de um outro modo de setar o objeto *****//
		return $this;
	}

}

?>