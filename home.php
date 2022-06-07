<?php
	ob_start();
	include('verificar.php');
	include('conexao.php');
	include('cabecalho_home.php');
?>
		<div class="col-md-9">
            <div class="profile-content">
				<?php
						include('pesquisar.html');
				?>
				<?php
					$selecionar=('select* from conta where fk_usuario='.$_SESSION['id'].' order by nome;');
					$resul_conta=mysqli_query($conexao,$selecionar);
					$linha=mysqli_num_rows($resul_conta);
					
					// se nao existir contas/linkas
					if(!$linha){
						echo('Nenhuma conta cadastrada');
					}
					else{
						echo('<table class="table"> <tr> <td> Número de contas</td> <td> Nome da conta </td> <td> Email da conta </td> <td> Senha da conta </td> <td> Criado(a) em </td> <td> Apagar </td> <td> Alterar conta </td>  </tr>');
						echo('<form action="#" method="POST">');
						$soma=0;
						while($controle_conta=mysqli_fetch_array($resul_conta)){
							$v=1;
							$soma=$soma+$v;// para mostrar o numero de contas
							$data=implode('/',array_reverse(explode("-",$controle_conta['dt_criacao'])));
							echo('<tr> <td>'.$soma. '</td> <td>'.$controle_conta['nome'].'</td> <td>'.$controle_conta['email'].'</td> <td>'.base64_decode($controle_conta['senha']).'</td> <td>'.$data.'</td> <td> <input type="checkbox" name="deletar[]" value="'.$controle_conta['id_conta'].'"> </td> <td>  <a href="alterar.php?alt='.base64_encode($controle_conta['id_conta']).'"> Alterar </a> </td> </tr>');
							//criptografando o id da conta com base 64
						}
						echo('</table>');
						echo('<input type="submit" name="apagar" value="Apagar contas">');
						echo('</form>');
					}
				?>
				<?php 
				// apagando conta 
				if(isset($_POST['apagar'])){
					@$preenchidos=$_POST['deletar'];
					if(empty($preenchidos)){
						echo('<script> window.alert("Prencha no minimo um checkbox para apagar uma conta");window.location="home.php"; </script>');
					}
					else{
						$ids="";
						foreach($preenchidos as $item){
							$ids.=$item.",";
						}
						$ids=trim(trim($ids,','));
						// apagandos contas
						$deletar='delete from conta where id_conta IN('.$ids.');';
						$deletar_conta=mysqli_query($conexao,$deletar); 
						if($deletar_conta){
							echo('<script> window.alert("Contas apagadas");window.location="home.php";</script>');
							
						}
						else{
							echo('<script> window.alert("Falha na hora de deletar contas");window.location="home.php";</script>');
							
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
