<?php
	ob_start();
	include('verificar.php');
	include('conexao.php');
	include('cabecalho_home.php');
?>
<div class="col-md-9">
    <div class="profile-content">
		<?php
			$select_atualizar='select *from usuario where id_usuario='.$_SESSION['id'].';';
			$resultado=mysqli_query($conexao,$select_atualizar);
			$cont=mysqli_fetch_array($resultado);
		?>
		<form action="#" method="POST" enctype="multipart/form-data" align="justify">
			<div class="fileUpload btn btn-primary">
				<span>Selecionar imagem</span>
					<input type="file" class="upload" name="imagem" />
	</div>
			<input  type="submit" name="atualizar_img" value="Atualizar"/>
			
		</form>
		<form action="#" method="POST" align="justify">
			<p> <label class="hora"> <b>Nome:</b> </label> <input  type="text" name="nome_alt" value="<?php echo($cont['nome']);?>" size=40" required=""/> </p>
			<p> <label class="hora">  <b>Sobrenome:</b> </label> <input  type="text" name="sobrenome_alt" value="<?php echo($cont['sobrenome']);?>" size=40" required=""/> </p>
			<p> <label class="hora"> <b>Senha atual:</b> </label> <input  type="password" name="senha" placeholder="Para atualizar os campos digite a senha atual" size=40" required=""/> </p>
			<p> <label class="hora"> <b>Senha nova:</b> </label> <input  type="password" name="senha_nova" placeholder="Nova senha" size="40"/> </p>
			<p> <label class="hora"> <b>Confirmar senha: </label> </b> <input  type="password" name="confirmar_senha" placeholder="Confirmar senha"/> </p>
			 <p> <label class="hora"> <b>Frase nova: </label> </b> <input  type="password" name="frase" placeholder="frase" size=40"/> 
			<input  type="submit" name="formulario_2" value="Atualizar dados"/>
		</form>
	</div>
</div>
		<?php
			if(isset($_POST['atualizar_img'])){
				// SE A SENHA ESTIVER CORRETA E SE A VARIAVEL IMAGEM EXISTIR
				if(empty($_FILES['imagem'] ['name'])){
					echo ('<script> window.alert("Para atualizar sua imagem preencha o campo imagem");window.location="configurar_conta.php";</script>');
				}
					$caminho_temporario=$_FILES['imagem'] ['tmp_name']; // arquivo temporario da img (onde ta no pc)
					$img=$_FILES['imagem']; 	// nome da img
					$extensao=explode('.',$img['name']);// pegando  extensao
					$extensao_nova=strtolower($extensao[1]);// transformando a extensao em minuscula
					$nome_novo_img=md5(time($extensao[1])).'.'.$extensao_nova;// criptografando  so o nome da img e juntando com a extensao
					$tamanho_maximo=1024 * 1024 * 2;// 2 mb tamanho maximo para o php de imagens
					// caminho final que manda pro servidor
					
					$caminho_final='img_perfil/usuario_'.md5($_SESSION['id']).'/'.$nome_novo_img;
					
					// se extensao nao for jpg ou png ou gif
					if($extensao_nova!="jpg" &&($extensao_nova!="png")){
						echo('<script> window.alert("Escolha uma imagem jpg ou png");window.location="configurar_conta.php";</script>');
					}
					else{
						// VALIDANDO TAMANHO MAXIMO DA IMAGEM
						if($img['size']>$tamanho_maximo){
							echo ('<script> window.alert("A imagem deve ter menos de 2 mb");window.location="configurar_conta.php";</script>');
						}
						// SE A IMG FOR MENOR QUE 2 MB
						else{
							// movendo img/ mandando pro servidor
							move_uploaded_file($caminho_temporario,$caminho_final);
							// substituindo(apagando ) a imagem anterior  que esta no banco 
								unlink($_SESSION['img']);
							// update da img no banco
							$atualizar_img='update usuario set img_perfil="'.$nome_novo_img.'" where id_usuario='.$_SESSION['id'].';';
							$resultado_img=mysqli_query($conexao,$atualizar_img);
							$_SESSION['img']='img_perfil/usuario_'.md5($_SESSION['id']).'/'.$nome_novo_img; 	// atualizando variavel de sessao da img
							if($resultado_img){
								echo('<script> window.alert("Imagem atualizada com sucesso");window.location="home.php";</script>');
							}
							else{
								echo('<script> window.alert("Falha na atualização da imagem");window.location="configurar_conta.php";</script>');
							}

						}
					}
				
				
				//$caminho_final='img_perfil/usuario_'.md5($_SESSION['id']).'/'// caminho para mandar pro servidor
				}
		?>
		
		<?php
			// se o usuario clicar em atualizar dados nome sobrenome ,etc
			if(isset($_POST['formulario_2'])){
				$nome_novo=ucfirst(trim($_POST['nome_alt']));
				$sobrenome_novo=ucfirst(trim($_POST['sobrenome_alt']));;
				$sobrenome_novo=$_POST['sobrenome_alt'];
				//$email_novo=$_POST['email_alt'];
				$senha_atual=trim(sha1($_POST['senha']));
				$senha_nova=$_POST['senha_nova'];
				$confirmar_senha=$_POST['confirmar_senha'];
				// frase para recuperacao de senha
				$frase=strtolower(trim($_POST['frase']));
				$frase=$frase;
                $frase=sha1($frase);
				// SE OS CAMPOS SENHA NOVA E CONFIRMAR SENHA NAO FOREM PREENCHIDOS
				if(empty($senha_nova)||(empty($confirmar_senha))){
					if($senha_atual!=$cont['senha']){ // SE A SENHA PARA ATUALIZAR NAO BATER COM A DO BANCO
						echo('<script> window.alert("Forneça a senha correta para atualizar seus dados");window.location="configurar_conta.php";</script>');
					}
					
					else{// se a senha digitada for igual ao do banco
						if(empty($frase)){ // so atualiza os campos nome sobrenome 
							$sql_atualizar='update usuario set nome="'.$nome_novo.'", sobrenome="'.$sobrenome_novo.'"  where id_usuario='.$_SESSION['id'].';';
							$resul_atualizar=mysqli_query($conexao,$sql_atualizar);
							if($resul_atualizar){
								// atualizando variavel de sessao
								$_SESSION['nome_usuario']=$nome_novo;
								$_SESSION['sobrenome_usuario']=$sobrenome_novo;
								echo('<script> window.alert("Dados atualizados com sucesso");window.location="home.php";</script>');
							}
							else{
								echo('<script> window.alert("Falha na hora de atualizar os dados");window.location="configurar_conta.php";</script>');
								}
						}
						else{
							$sql_atualizar='update usuario set nome="'.$nome_novo.'", sobrenome="'.$sobrenome_novo.'", frase="'.$frase.'" where id_usuario='.$_SESSION['id'].';';
							$resul_atualizar=mysqli_query($conexao,$sql_atualizar);
							if($resul_atualizar){
								// atualizando variavel de sessao
								$_SESSION['nome_usuario']=$nome_novo;
								$_SESSION['sobrenome_usuario']=$sobrenome_novo;
							echo('<script> window.alert("Dados atualizados com sucesso");window.location="home.php";</script>');
							}
							else{
								echo('<script> window.alert("Falha na hora de atualizar os dados");window.location="configurar_conta.php";</script>');
								}	
						}	
					}
					
					
				}
				//SE FOREM PREENCHIDOS
				else{
					$senha_nova=sha1(trim($senha_nova));
					$confirmar_senha=sha1(trim($confirmar_senha));
					// 	SE A  A SENHA ATUAL ESTIVER ERRADA
					if($senha_atual!=$cont['senha']){
						echo('<script> window.alert("Forneça a senha correta para atualizar seus dados ");window.location="configurar_conta.php";</script>');
					}
					else{ //SENAO  
						if($senha_nova!=$confirmar_senha){ // se  confirmar senha for diferente de senha nova
							echo('<script> window.alert("As senhas dos campos confirmar senha e senha nova não batem");window.location="configurar_conta.php";</script>');
						}
						else{ // se forem iguais
							//BOTAR AQUI  CODIGO DA FRASE
							if($senha_nova==$cont['senha']){ // se os campo senha nova for igual a senha atual
									echo('<script> window.alert("A senha nova é igual a senha atual ");window.location="configurar_conta.php";</script>');
							}
							else{// se o campo senha nova for diferente da senha atual atualiza
								if(empty($frase)){
									$sql_atualizar='update usuario set nome="'.$nome_novo.'", sobrenome="'.$sobrenome_novo.'",senha="'.$senha_nova.'" where id_usuario='.$_SESSION['id'].';';
									$resul_atualizar=mysqli_query($conexao,$sql_atualizar);
									if($resul_atualizar){
										// atualizando variavel de sessao
										$_SESSION['nome_usuario']=$nome_novo;
										$_SESSION['sobrenome_usuario']=$sobrenome_novo;
										echo('<script> window.alert("Dados atualizados com sucesso");window.location="configurar_conta.php";</script>');
												}
									else{
										echo('<script> window.alert("Falha na hora de atualizar os dados");window.location="configurar_conta.php";</script>');
										}
								}
								else{// se o campo frase for preenchido
									$sql_atualizar='update usuario set nome="'.$nome_novo.'", sobrenome="'.$sobrenome_novo.'",senha="'.$senha_nova.'", frase="'.$frase.'" where id_usuario='.$_SESSION['id'].';';
									$resul_atualizar=mysqli_query($conexao,$sql_atualizar);
									if($resul_atualizar){
										// atualizando variavel de sessao
										$_SESSION['nome_usuario']=$nome_novo;
										$_SESSION['sobrenome_usuario']=$sobrenome_novo;
										echo('<script> window.alert("Dados atualizados com sucesso");window.location="configurar_conta.php";</script>');
												}
									else{
										echo('<script> window.alert("Falha na hora de atualizar os dados");window.location="configurar_conta.php";</script>');
										}
								}	
							}
						}
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