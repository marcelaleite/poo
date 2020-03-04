<?php
require_once('config/config.ini.php');
$conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
if (!$conexao)
  die("Erro ao conectar com o banco de dados...");
$sql = 'SELECT * FROM veterinario';
$comando = $conexao->prepare($sql);
if (!$comando)
  die("Erro ao criar comando. Erro: ".$conexao->errorInfo());
$comando->execute();
if (!$comando)
  die("Erro ao criar comando. Erro: ".$conexao->errorInfo());
$itens = '';
while($linha = $comando->fetch(PDO::FETCH_ASSOC)){
  $item = file_get_contents('itensVeterinario.html');
  $item = str_replace('{id}',$linha['id'],$item);
  $item = str_replace('{nome}',$linha['nome'],$item);
  $item = str_replace('{crmv}',$linha['crmv'],$item);
  $item = str_replace('{telefone}',$linha['telefone'],$item);
  $itens .= $item;
}
$lista = file_get_contents('listaVeterinario.html');
$lista = str_replace('{itens}',$itens,$lista);
print($lista);


 ?>
