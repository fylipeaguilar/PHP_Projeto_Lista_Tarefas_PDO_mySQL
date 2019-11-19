<?php

	// ******** REGRAS DE NEGOCIO *********//

	// Fazendo os requires dos arquivos
	require "../../App_Udemy_private_files/Projeto_Lista_Tarefas/tarefa.model.php";
	require "../../App_Udemy_private_files/Projeto_Lista_Tarefas/tarefa.service.php";
	require "../../App_Udemy_private_files/Projeto_Lista_Tarefas/conexao.php";

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	// ******** REGRAS DE NEGOCIO *********//	
	// Regra de Negócio para incluir tarefa

	if ($acao == 'inserir') {
	 	// Criando uma instancia do objeto Tarefa()
		$tarefa = new Tarefa();
		$tarefa->__set('tarefa', $_POST['tarefa']);

		// Criando uma instancia de conexao com a base de dados
		$conexao = new Conexao();

		// Criando instancia de tarefa service
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->inserir();

		// O parâmetro "inclusao=1" irá ser usado na página "nova_tarefa.php"
		header('Location: nova_tarefa.php?inclusao=1');

	} 

	// Regra de Negócio para listar todas tarefas

	else if ($acao == 'recuperar') {
		
		// Instanciando "Tarefa", para o construtor que espera receber
		// esse parâmetro
		$tarefa = new Tarefa();

		// Instanciando "Conexão", para o construtor que espera receber
		// esse parâmetro
		$conexao = new Conexao();

		// Instaciando o objeto "TarefaService"
		$tarefaService = new TarefaService($conexao, $tarefa);
		$todas_tarefas = $tarefaService->recuperar();

	}

		// Regra de Negócio para listar todas tarefas

	else if ($acao == 'atualizar') {
		
		//echo "Estamos aqui!!!";

		// Instanciando "Tarefa", para o construtor que espera receber
		// esse parâmetro
		$tarefa = new Tarefa();
		//Selecionando o "id" da tarefa

		// ************** ANTES DO NOVO MODELO **********************//
		// $tarefa->__set('id', $_POST['id']);
		// $tarefa->__set('tarefa', $_POST['tarefa']);
		// *********************************************************//

		// ************** DEPOIS DO NOVO MODELO **********************//
		// Consultar o arquivo "tarefa.model.php"
		$tarefa->__set('id', $_POST['id'])->__set('tarefa', $_POST['tarefa']);
		// *********************************************************//

		// Instanciando "Conexão", para o construtor que espera receber
		// esse parâmetro
		$conexao = new Conexao();

		// Instaciando o objeto "TarefaService"
		$tarefaService = new TarefaService($conexao, $tarefa);
		if($tarefaService->atualizar()){
			if (isset($_GET['pagina']) && $_GET['pagina'] == 'index') {
			header('Location: index.php');
			} else {
				header('Location: todas_tarefas.php');
			}
		}

	}

	else if ($acao == 'remover') {

		//echo "Entrei aqui no delete";
		
		// Instanciando "Tarefa", para o construtor que espera receber
		// esse parâmetro
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		// Instanciando "Conexão", para o construtor que espera receber
		// esse parâmetro
		$conexao = new Conexao();

		// Instaciando o objeto "TarefaService"
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();
		
		if (isset($_GET['pagina']) && $_GET['pagina'] == 'index') {
			header('Location: index.php');
		} else {
			header('Location: todas_tarefas.php');
		}
		

	}

	else if ($acao == 'marcarRealizada') {

		//echo "Entrei aqui no marcarRealizada";
		
		// Instanciando "Tarefa", para o construtor que espera receber
		// esse parâmetro
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		// Instanciando "Conexão", para o construtor que espera receber
		// esse parâmetro
		$conexao = new Conexao();

		// Instaciando o objeto "TarefaService"
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->marcarRealizada();
		
		if (isset($_GET['pagina']) && $_GET['pagina'] == 'index') {
			header('Location: index.php');
		} else {
			header('Location: todas_tarefas.php');
		}
	}

	else if ($acao == 'recuperarTarefasPendentes') {
		
		// Instanciando "Tarefa", para o construtor que espera receber
		// esse parâmetro
		$tarefa = new Tarefa();
		// Para selecionar as tarefas pendentes
		$tarefa->__set('id_status', 1);


		// Instanciando "Conexão", para o construtor que espera receber
		// esse parâmetro
		$conexao = new Conexao();

		// Instaciando o objeto "TarefaService"
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas_pendentes = $tarefaService->recuperarTarefasPendentes();

	}



?>