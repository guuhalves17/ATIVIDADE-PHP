<?php
	session_start();
	ob_start();
	require_once("cabecalho.php");
?>
<!-- Cadastro-->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Fazer login</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
            		<form name="cadastro" id="contactForm" action="#" method="POST">
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" placeholder="Email" id="email"  name="email" required="">
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" placeholder="Senha" id="password" name="senha" required="">
                            </div>
                        </div>
                        <div class="row control-group">
                        	<a href="recuperar.php">Esqueci minha senha</a>
                        </div>
                        <br/><br/>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <input type="submit" class="btn btn-success btn-lg" name="enviar" value="Entrar"/>
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
			$senha=sha1($_POST['senha']);
			$selecionar=('select*from USUARIO where email="'.$email.'";');
			$consulta=mysqli_query($conexao,$selecionar);
			$cont=mysqli_fetch_array($consulta);
			if($senha==$cont['senha']&&($email==$cont['email'])){
					$_SESSION['nome_usuario']=$cont['nome'];
					$_SESSION['id']=$cont['id_usuario'];
					$_SESSION['img']='img_perfil/usuario_'.md5($_SESSION['id']).'/'.$cont['img_perfil'];
                    $_SESSION['sobrenome_usuario']=$cont['sobrenome'];
					
					header('location:home.php');
				}
				else{
					echo('<script> window.alert("Usuarios ou senhas erradas"); </script>');	
				}
		}
	?>
<?php
	include('rodape.php');
?>