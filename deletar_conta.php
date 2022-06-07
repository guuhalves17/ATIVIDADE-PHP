<?php
	ob_start();
	include('verificar.php');
	include('conexao.php');
	include('cabecalho_home.php');
?>
		<div class="col-md-9">
            <div class="profile-content">
            	
            		<h2>Deletar conta</h2>
            		<form action="#" method="POST">
					
						<p> <label class="hora2"> <b>Digitar senha:</b> </label> <input type="password" id="fname" name="senha_digitada" placeholder="Digite sua senha"></p>

						<p> <label class="hora2"> <b>Confirmar Senha:</b> </label> <input type="password" id="lname" name="senha_confirmar" placeholder="Confirme sua senha"> </p>

							<input type="submit" name="apagar" value="Enviar">
                 	</form>
        
            </div>
		</div>
	</div>
</div>
<?php
	include('rodape.php');
?>
		<?php
			if(isset($_POST['apagar'])){
				$senha_digitada=sha1($_POST['senha_digitada']);
				$senha_confirmar=sha1($_POST['senha_confirmar']);
				$sql_sel='select id_usuario, senha, img_perfil from usuario where id_usuario='.$_SESSION['id'].';';
				$resultado=mysqli_query($conexao,$sql_sel);
				$controle=mysqli_fetch_array($resultado);
				// vendo se as senhas batem
				if($senha_digitada==$controle['senha']&&($senha_confirmar==$senha_digitada)){
					// se o arquivo que nao for a imagem padrao existir 
					// so vou ter certeza quando o usuario atualizar a foto dele ai vai criar 2 arquivos na pasta
					if(is_file($_SESSION['img'])&&($controle['img_perfil']!="imagem_padrao_3.jpg")){
							unlink($_SESSION['img']);
							
							rmdir('img_perfil/usuario_'.md5($controle['id_usuario']));
					}
					//senao, so existe a img padrao do usuario
					else{
						unlink('img_perfil/usuario_'.md5($controle['id_usuario']).'/imagem_padrao_3.jpg');
						//apagando diretorio 
						rmdir('img_perfil/usuario_'.md5($controle['id_usuario']));
					}
					$apagar_usuario='delete from usuario where id_usuario='.$_SESSION['id'].';';
					$resul[0]=mysqli_query($conexao,$apagar_usuario);
					// nem precisa validar se ele tem uma conta pq nao vai aparecer ou dar erro so vai mostrar no banco 0 rows afetadas 
					$apagar_conta='delete from conta where fk_usuario='.$_SESSION['id'].';';
					$resul[1]=mysqli_query($conexao,$apagar_conta);
					if($resul[0]&&($resul[1])){
						echo('<script> window.alert("Conta apagada com sucesso");window.location="destruir.php";</script>');

					}
				}
				else{
					echo('<script> window.alert("Senhas erradas");window.location="deletar_conta.php";</script>');
				}
			}
		?>