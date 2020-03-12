<?php
require_once('../utils/utils.php');
$cabecalho = criaCabecalho('Listagem de Veterinários');
$navegacao = criaMenu();
$sql = 'SELECT * FROM veterinario';
$comando = executaComando($sql);
$itens = '';
while($linha = $comando->fetch(PDO::FETCH_ASSOC)){
  $item = file_get_contents('itensVeterinario.html');
  $item = preencherFormulario($item,$linha);
  $itens .= $item;
}
$lista = file_get_contents('listaVeterinario.html');
$lista = str_replace('{itens}',$itens,$lista);
$lista = str_replace('{cabecalho}',$cabecalho,$lista);
$lista = str_replace('{nav}',$navegacao,$lista);

print($lista);


 ?>
