<!DOCTYPE html>
<?php
	require_once("cabecalho.php");
?>
		<section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Redefinir senha</h2>
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
                        <br/><br/>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <input type="submit" class="btn btn-success btn-lg" name="recuperar" value="enviar"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
		<?php
			include('conexao.php');
			if(isset($_POST['recuperar'])){
				$email=$_POST['email'];
				$sql_email='select id_usuario,frase,senha,email from usuario where email ="'.$email.'";';
				$resul=mysqli_query($conexao,$sql_email);
				$controle=mysqli_fetch_array($resul);
				$linha=mysqli_num_rows($resul);
				if(!$linha){
					echo('<script> window.alert("Esse email não existe");</script>');
				}
				else{// se existir aparece os campos para redefinicao da senha do  usuario
					echo('<section id="contact">');
						echo(' <div class="container">');
							echo('<div class="row">');
								echo('<div class="col-lg-8 col-lg-offset-2">');
									echo('<form name="cadastro" id="contactForm" action="#" method="POST">');
										echo('<div class="row control-group">');
											echo('<div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="email">Frase</label>
                                <input type="password" class="form-control" placeholder="Frase" id="email"  name="frase" required="">
                            </div>');
										echo('</div>'); // fim do input
										echo('<div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="email">Senha Nova </label>
                                <input type="password" class="form-control" placeholder="Senha nova " id="email"  name="senha_nova" required="">
                            </div>
                        </div>');
									echo('<div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label for="password">Confirmar senha</label>
                                <input type="password" class="form-control" name="senha_confirmar" placeholder="Confirmar senha" id="password" required="">
                            </div>
                        </div>');
						echo('<input type="hidden" name="id" value="'.$controle['id_usuario'].'">'); // id do banco
						echo('<input type="hidden" name="frase_bd" value="'.$controle['frase'].'">'); // frase do banco
						echo('<div class="row">
                            <div class="form-group col-xs-12">
                                <input type="submit" class="btn btn-success btn-lg" name="atualizar" value="Redefinir"/>
                            </div>
                        </div>');
							// valores do bd 
							
									echo('</form>');
								echo('</div>');
							echo('</div>');
						
						echo('</div>');
					echo('</section>');
				}
			}
		?>
		
		<?php
		
			if(isset($_POST['atualizar'])){
				$frase=strtolower(trim($_POST['frase']));// deixando em minusculo pra facilitar pro usuario
                $frase=$frase;
                $frase=sha1($frase);
				$senha_nova=sha1(trim($_POST['senha_nova']));
				$senha_confirmar=sha1(trim($_POST['senha_confirmar']));
				$id=$_POST['id'];
				$bd_frase=$_POST['frase_bd'];
				// se a frase digitada não bater com a frase que ta no banco
                if($frase!=$bd_frase){
                    echo('<script> window.alert("A frase está errada");</script>');
                }
                else{
                   // se as senhas nao baterem 
                   if($senha_nova!=$senha_confirmar){
                        echo('<script> window.alert("As senhas não batem ");</script>');
                    }
                    else{
                        $atualizar='update usuario set senha="'.$senha_nova.'" where id_usuario='.$id.';';
                        $resul_atualizar=mysqli_query($conexao,$atualizar);
                        if($resul_atualizar){
                            echo('<script> window.alert("Senha redefinida com sucesso"); window.location="login.php";</script>');
                        }
                        else{
                            echo('<script> window.alert("Falha na redefinição da senha"); </script>');
                        }
                    }
                }
               
			}
		?>
<?php
	include('rodape.php');
?>