<?php

class TarefaService {

	// Essa classe precisa receber os parametros para executar os métodos listados
	private $conexao;
	private $tarefa;


	// Os métodos das operações de CRUD
	// Utilizamos o recuso de tipagem
	public function __construct(Conexao $conexao, Tarefa $tarefa){
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}

	public function inserir() { //create
		//Vamos usar o prepare para evitar violações do conteudo
		$query = 'insert into tb_tarefas(tarefa) values(:tarefa)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->execute();

	}

	public function recuperar() { //read
		//Vamos usar o prepare para evitar violações do conteudo
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			order by s.status, t.tarefa
		';

		// Criando a variável stmt para receber o PDO Statment
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function atualizar() { //update
		//Vamos usar o prepare para evitar violações do conteudo

		// **** ANTES DO NOVO MODELO DE USO DO PREPARE ****** //
		// $query = 'update tb_tarefas set tarefa = :tarefa where id = :id';
		// $stmt = $this->conexao->prepare($query);
		// $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		// $stmt->bindValue(':id', $this->tarefa->__get('id'));
		// ************************************************** //

		// **** DEPOIS DO NOVO MODELO DE USO DO PREPARE ****** //
		$query = 'update tb_tarefas set tarefa = ? where id = ?';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		// ************************************************** //
		
		// Quando um retorno de update é realizado com sucesso ele retorna 1
		return $stmt->execute();

	}

	public function remover() { //delete
		//Vamos usar o prepare para evitar violações do conteudo
		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update da tarefa realizada
		//Vamos usar o prepare para evitar violações do conteudo
		// **** DEPOIS DO NOVO MODELO DE USO DO PREPARE ****** //
		$query = 'update tb_tarefas set id_status = ? where id = ?';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		// ************************************************** //

		// Quando um retorno de update é realizado com sucesso ele retorna 1
		return $stmt->execute();
	}

	public function recuperarTarefasPendentes() { //read
		//Vamos usar o prepare para evitar violações do conteudo
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where t.id_status = :id_status
			order by s.status, t.tarefa
		';

		// Criando a variável stmt para receber o PDO Statment
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}	

}

?>