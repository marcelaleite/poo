<?php
require_once('utils/utils.php');

$sql = 'SELECT * FROM veterinario';
$comando = preparaComando($sql);
$comando = executaComando($comando);
$itens = '';
while($linha = $comando->fetch(PDO::FETCH_ASSOC)){
  $item = file_get_contents('itensVeterinario.html');
  $item = preencherFormulario($item,$linha);
  $itens .= $item;
}
$lista = file_get_contents('listaVeterinario.html');
$lista = str_replace('{itens}',$itens,$lista);
print($lista);


 ?>
