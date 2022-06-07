<?php
	$conexao=mysqli_connect('localhost','root','','quick_acess')or die ('Falha na conex? com banco de dados'.mysqli_error());
	// comandos para o banco aceitar caracter especial
	mysqli_query($conexao,"SET NAMES 'utf8'");
	mysqli_query($conexao,'SET character_set_connection=utf8');
	mysqli_query($conexao,'SET character_set_client=utf8');
	mysqli_query($conexao,'SET character_set_results=utf8');
?>