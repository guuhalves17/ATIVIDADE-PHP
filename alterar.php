<?php
	ob_start();
	include('verificar.php');
	include('conexao.php');
	include('cabecalho_home.php');
?>
	<div class="col-md-9">
            <div class="profile-content">
		<?php
			// select da senha do usuario
			$sql_senha='select senha from usuario where id_usuario='.$_SESSION['id'].';';
			$resul_senha=mysqli_query($conexao,$sql_senha);
			$cont_senha=mysqli_fetch_array($resul_senha);
			if(isset($_GET['alt'])){
				$id_conta=base64_decode($_GET['alt']);// descriptografando o id da conta
				// se o id existir(se o usuario clicou no link alterar)
					$sql_sel_conta='select* from conta where fk_usuario='.$_SESSION['id'].' and id_conta='.$id_conta.';';
					$sql_resul=mysqli_query($conexao,$sql_sel_conta);
					$cont_conta=mysqli_fetch_array($sql_resul);
				}
		?>
		<?php 
			if($id_conta){ // se a variavel id existir significa que o usuario acessou o alterar.php pelo link
				echo('');
			}
			else{ // senao foi pela url colocando so alterar.php
				header('location:home.php');
			}
		?>
		<h1 align="center"> Valores originais </h1>
		<form action="#" method="POST">
			<p> <label class="hora1"> <b> Nome: </b> </label> <input  name="nome_alt" type="text" value="<?php echo($cont_conta['nome']); ?>"/> </p>
			<p> <label class="hora1"> <b> Email: </b> </label> <input  name="email_alt" type="email" value="<?php echo($cont_conta['email']); ?>"/> </p>
			<p> <label class="hora1"> <b> Senha:</b> </label> <input  name="senha_alt" type="text" value="<?php echo(base64_decode($cont_conta['senha'])); ?>"/> </p>
			<p> <label class="hora1"> <b> Confirmação:</b> </label> <input  type="password" name="senha_usuario" placeholder="Senha do usuario para atualização" size="40" required/></p>
			<input  type="submit" name="atualizar_conta" value="Atualizar"/>
		</form>
		
		<?php
		
			if(isset($_POST['atualizar_conta'])){
				$nome_novo_conta=ucfirst(trim($_POST['nome_alt']));
				$email_novo_conta=$_POST['email_alt'];
				$senha_nova_conta=base64_encode($_POST['senha_alt']);
				$senha_usuario=sha1(trim($_POST['senha_usuario']));
				// se a senha do usuario nao estiver certa
				if ($senha_usuario!=$cont_senha['senha']) {
					echo('<script> window.alert("Digite a senha do usuario corretamente");</script>');
				}
				else{// senao
					$sql_atualizar_conta='update conta set nome="'.$nome_novo_conta.'", email="'.$email_novo_conta.'",senha="'.$senha_nova_conta.'" where id_conta='.$id_conta.' and fk_usuario='.$_SESSION['id'].';';
					$resul_atualizar=mysqli_query($conexao,$sql_atualizar_conta)or die('falha'.mysqli_error());
					if($resul_atualizar){
						echo('<script> window.alert("Dados da conta atualizados com sucesso"); window.location="home.php"</script>');
					}
				}
			}

		?>
			</div>
		</div>
	</div>
</div>
<?php
	include('rodape.php');
?>