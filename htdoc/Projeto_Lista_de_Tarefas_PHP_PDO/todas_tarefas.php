<?php 
	
	// Vamos criar uma variável "ação" para passar como parametro para o "controller" da aplicação
	$acao = 'recuperar';

	// Temos que fazer o require do arquivo tarefa_controller
	require 'tarefa_controller.php';

	// Analisando o resultado do objeto de "todas as tarefas"
	// echo '<pre>';
	// 	print_r($todas_tarefas);
	// echo '</pre>';

?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<!-- Criando uma função para edicão da tarefa -->
		<script>
			function editar(id, txt_tarefa) {
				//alert('Estamos aqui');

				// Criar um form de edição
				let form = document.createElement('form');
				form.action = 'tarefa_controller.php?acao=atualizar';
				form.method = 'post';
				form.className = 'row'

				// Criar um input para entrada do texto
				let inputTarefa = document.createElement('input');
				inputTarefa.type = 'text';
				inputTarefa.name = 'tarefa';
				inputTarefa.className = 'col-9 form-control'
				inputTarefa.value = txt_tarefa;

				// Criar o input hidden para guardar o id da tarefa
				let inputId = document.createElement('input');
				inputId.type = 'hidden';
				inputId.name = 'id';
				inputId.value = id;


				// Criar um botão para envio do form
				let button = document.createElement('button');
				button.type = 'submit';
				button.className = 'col-3 btn btn-info';
				button.innerHTML = 'Atualizar';

				// Criando a árvores de elementos
				// incluir input tarefa no form
				form.appendChild(inputTarefa);

				// incluir inputID tarefa no form
				form.appendChild(inputId);	

				// incluir o "button" tarefa no form
				form.appendChild(button);

				// Teste Devel
				//console.log(form);
				//alert(id);


				// Selecionando a div tarefa
				let tarefa = document.getElementById('tarefa_'+id);

				// Limpar o conteudo interno da "div" para inclusão do form
				tarefa.innerHTML = '';

				// Agora vamos incluir o form na página
				// O método "insertBefore" é nativo da API do DOM
				// Esse método espera 2 parâmetros (arvore de elementos, "nó" da arvore)
				tarefa.insertBefore(form, tarefa[0])
			}

			function remover(id) {
				location.href = 'todas_tarefas.php?acao=remover&id='+id;
			}

			function marcarRealizada(id) {
				location.href = 'todas_tarefas.php?acao=marcarRealizada&id='+id;
			}

		</script>

	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<hr />

								<!-- Código para lista as tarefas de forma dinânimca -->

								<? foreach ($todas_tarefas as $indice => $tarefa) { ?>
								
								<div class="row mb-3 d-flex align-items-center tarefa">

									<!-- Incluindo as tarefas de forma dinâmica -->
									<!-- O "id" adicionado é para a função de editar o campo -->
									<div class="col-sm-9" id='tarefa_<?= $tarefa->id ?>'>
										<?= $tarefa->tarefa ?> (<?= $tarefa->status ?>)
									</div>

									<div class="col-sm-3 mt-2 d-flex justify-content-between">
										
										<!-- Habilitando a "lixeira" via "onclick" para apagar tarefa -->
										<i class="fas fa-trash-alt fa-lg text-danger icone" onclick="remover(<?= $tarefa->id ?>)"></i>
										

										<!-- Vamos exibir esse 2 botões apenas se o status for pendente -->

										<? if ($tarefa->status == 'pendente') { ?>
										
										<!-- Habilitando a edição da tarefa via "onclick" -->
										<!-- Foi necessa´rio encapsular com aspas simples o segundo parâmetro, pois esse valor é um texto -->
										<i class="fas fa-edit fa-lg text-info icone" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>

										<!-- Habilitando o ícone "check list" via "onclick" para apagar tarefa -->
										<i class="fas fa-check-square fa-lg text-success icone" onclick="marcarRealizada(<?= $tarefa->id ?>)"></i>

										<? } ?>

										
									</div>
								</div>


								<? }?>
											
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>