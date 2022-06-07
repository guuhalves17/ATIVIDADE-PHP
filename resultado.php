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
				if(isset($_POST['pesquisar'])){
					$pesquisa=ucfirst(trim($_POST['pesquisa']));
					if(empty($pesquisa)){// se a pesquisa estiver vazia manda pra home 
					header('location:home.php');
					}
					else{ // se nao
					//select*from conta where  nome LIKE '%facebook2%'   and fk_usuario=1;
					//like '%".$busca."%' "
						$sql_pesquisa_conta=('select*from conta where nome like "'.$pesquisa.'%"  and fk_usuario='.$_SESSION['id'].';');
						$resultado_pesquisa=mysqli_query($conexao,$sql_pesquisa_conta);
						$linha=mysqli_num_rows($resultado_pesquisa);
						if($linha){
							echo('<table class="table"> <tr> <td> Nome da conta </td> <td> Email da conta </td> <td> Senha da conta </td> <td> Criado(a) em </td>   </tr>');
							while($controle_pesquisa=mysqli_fetch_array($resultado_pesquisa)){
								$data=implode('/',array_reverse(explode("-",$controle_pesquisa['dt_criacao'])));
								echo('<tr> <td>'.$controle_pesquisa['nome'].'</td>  <td>'.$controle_pesquisa['email'].'</td> <td>'.base64_decode($controle_pesquisa['senha']).'</td> <td>'.$data.'</td> </tr>');
							}
							echo('</table>');
						}
						else{
							echo('Pesquisa não encontrada');
						}
					}
				}
				else{
					header('location:home.php');
				}
		?>
			</div>
		</div>
	</div>
</div>
<?php
	include('rodape.php');
?>
