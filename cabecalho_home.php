<html>
	<head>	
	<meta charset="utf-8">
			<title>
				<?php
					echo('Bem vindo '.$_SESSION['nome_usuario']);
				?>
			</title>
		<link rel="icon" href="img/icone.png" type="image/x-icon"/>
		 <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" a href="css/home.css"/>
		<link rel="stylesheet" type="text/css" a href="css/form.css"/>
	</head>
		<body>
			<div class="container">
    	<div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<?php
					echo('<div class="profile-userpic">
					<img src="'.$_SESSION['img'].'" class="img-responsive" alt="'.$_SESSION['nome_usuario'].'" title="'.$_SESSION['nome_usuario'].' '. $_SESSION['sobrenome_usuario']. '">
				</div>');
				?>
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<?php
					echo('<div class="profile-usertitle-name">
						'.$_SESSION['nome_usuario'].'</div>');
					?>
				</div>
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="home.php">
							<i class="glyphicon glyphicon-home"></i>
							Pagina inicial </a>
						</li>
						<li>
							<a href="configurar_conta.php">
							<i class="glyphicon glyphicon-user"></i>
							Configurações da conta </a>
						</li>
						<li>
							<a href="deletar_conta.php">
							<i class="glyphicon glyphicon-trash"></i>
							Deletar conta </a>
						</li>
						<li>
							<a href="cadastrar_conta.php">
							<i class="glyphicon glyphicon-pencil"></i>
							Cadastrar conta </a>
						</li>
						<li>
							<a href="destruir.php">
							<i class="glyphicon glyphicon-log-in"></i>
							Sair </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>