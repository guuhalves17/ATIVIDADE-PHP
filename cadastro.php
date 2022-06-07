<?php
	include('cabecalho.php');
?>
 <!-- Cadastro-->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Cadastro</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                
                    <form name="cadastro" id="contactForm" action="#" method="POST">
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="name">Nome</label>
                                <input type="text" class="form-control" name="nome" placeholder="Nome" id="name" required="">
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="name">Sobrenome</label>
                                <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome" id="name" required="">
                            </div>
                            
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" id="email" required="">
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" name="senha" placeholder="Senha" id="password" required="">
                            </div>
                        </div>
                       <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="password">Frase</label>
                                <input type="password" class="form-control" name="frase" placeholder="Frase para recuperação de senha" id="password" required="">
                            </div>
                        </div>
                        <br /><br />
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <input type="submit" class="btn btn-success btn-lg" name="enviar" value="Enviar"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
	<?php
			include('conexao.php');
			if(isset($_POST['enviar'])){
				$email=$_POST['email'];
				$nome=ucfirst($_POST['nome']);
				$sobrenome=ucfirst($_POST['sobrenome']);
				$senha=sha1($_POST['senha']);
				$sql_selecionar='select*from usuario where email="'.$email.'";';
				$resultado=mysqli_query($conexao,$sql_selecionar);
                $frase=strtolower(trim($_POST['frase']));// DEIXANDO EM MINUSCULO PRO USUARIO NAO TER PROBLEMAS CASO DIGITE ERRADO
                $frase=$frase;
                $frase=sha1($frase);
				$linha=mysqli_num_rows($resultado);
				if($linha){
					echo('<script> alert("Esse email ja existe");</script>');
				}
				else{
					$extensao_img=substr('imagem_padrao.jpg',-4);
					$novo_nome=('imagem_padrao_3').$extensao_img;
					$inserir='insert into USUARIO(nome,sobrenome,email,senha,img_perfil,frase)values("'.$nome.'","'.$sobrenome.'","'.$email.'","'.$senha.'","'.$novo_nome.'","'.$frase.'");';
					$resultado=mysqli_query($conexao,$inserir);
					if($resultado){
						$resultado=mysqli_query($conexao,$sql_selecionar);
						$sql_selecionar='select*from usuario where email="'.$email.'";';
						$controle=mysqli_fetch_array($resultado);
						$pasta_usuario='img_perfil/usuario_'.md5($controle['id_usuario']);
						$caminho='img_perfil/usuario_'.md5($controle['id_usuario']).'/'.$controle['img_perfil'];
						mkdir($pasta_usuario,0600);
						copy("img_perfil/imagem_padrao.jpg",$caminho);

						echo('<script> window.alert("Cadastrado com sucesso");window.location="login.php"</script>');
					}
					else{
						echo('<script> window.alert("Falha na hora de cadastrar");window.location="cadastro.php" </script>');
					}
					
				}
			}
			
		?>
<?php
	include_once('rodape.php');
?>
