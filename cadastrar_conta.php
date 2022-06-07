<?php
	ob_start();
	include('verificar.php');
	include('conexao.php');
	include('cabecalho_home.php');
?>
		<div class="col-md-9">
            <div class="profile-content">
            		<h2>Nova conta</h2>
            		<form action="#" method="POST" class="form-horizontal">
            			<p> <label class="hora2" > <b> Nome da conta: </b> </label> <input type="text" name="nome" placeholder="Digite o nome da conta" required></p>

						<p> <label class="hora2" > <b>Email da conta: </b> </label> <input type="email" name="email" placeholder="Digite o email da conta" required> </p>
						
						<p> <label class="hora2" > <b>Senha da conta: </b> </label> <input type="password" name="senha" placeholder="Digite a senha da conta" required> </p>

							<input type="submit"  name="enviar" value="Enviar">
                 	</form>
            </div>
		</div>
	</div>
</div>
	<?php
			if(isset($_POST['enviar'])){
				$nome=ucfirst($_POST['nome']);
				$email=$_POST['email'];
				$senha=trim($_POST['senha']);
				$senha=base64_encode($senha);
				$inserir='insert into conta(nome,email,senha,fk_usuario,dt_criacao)values("'.$nome.'","'.$email.'","'.$senha.'",'.$_SESSION['id'].',curdate());';
				$resultado=mysqli_query($conexao,$inserir);
				if($resultado){
					echo('<script> window.alert("Conta cadastrada com sucesso");window.location="home.php";</script>');
					
				}
				else{
					echo('<script> window.alert("Erro na hora de cadastrar")window.location="cadastrar_conta.php";</script>');
					
				}
				
			}
		?>
<?php
	include('rodape.php');
?>