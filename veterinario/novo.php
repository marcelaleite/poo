<?php
// Controle da Interface

require_once('../utils/utils.php');

$cabecalho = criaCabecalho('Cadastro de Veterinário');
$navegacao = criaMenu();
if ($_SERVER['REQUEST_METHOD'] ==  'GET'){ // apresenta formulário
  $formulario = file_get_contents('veterinario.html');
  if (isset($_GET['id'])){ // apresenta para edição
    $sql = 'SELECT * FROM veterinario WHERE id = :id';
    $dados = array(':id'=>$_GET['id']);
    $veterinario = executaComando($sql,$dados)->fetch(); // pegando os dados do banco
  }else{ // apresenta para inserção
    $veterinario = array('nome'=>'','crmv'=>'','telefone'=>'','id'=>'');
  }
  $formulario = str_replace('{cabecalho}',$cabecalho,$formulario);
  $formulario = str_replace('{nav}',$navegacao,$formulario);
  $formulario = preencherFormulario($formulario,$veterinario);
  print($formulario);
}else if ($_SERVER['REQUEST_METHOD'] ==  'POST'){ // salva dados após submeter formulário
  if (isset($_POST['nome'])){ // validar se o formulário foi preenchido - informações que são obrigatórias
    //tratamento de dados para inserção
    $nome = $_POST['nome'];
    $crmv = $_POST['crmv'];
    $telefone = $_POST['telefone'];
    $id = $_POST['id'];
    if ($id > 0){  // atualização de cadastro
      // definir o comando que será executado no banco de dados
      $sql = 'UPDATE veterinario
                 SET nome = :nome, crmv = :crmv, telefone = :telefone
               WHERE id = :id';
      //vincular variáveis com os parâmetros do comando
      $dados = array(':nome'=>$nome,':crmv'=>$crmv,':telefone'=>$telefone,':id'=>$id);
      // executar o $comando
      executaComando($sql,$dados);
      echo "Cadastro atualizado com sucesso!";
    }else{ // salvar novo cadastro
      $destino = '../fotos/'.$_FILES['foto']['name'];
      move_uploaded_file($_FILES['foto']['tmp_name'],$destino);

      $sql = 'INSERT INTO veterinario (nome, crmv, telefone, foto)
                   VALUES (:nome,:crmv,:telefone,:foto)';
      $dados = array(':nome'=>$nome,':crmv'=>$crmv,':telefone'=>$telefone,':foto'=>$destino);
      executaComando($sql,$dados);
      echo "Cadastro efetuado com sucesso!";
    }
  }else{
    echo "Preencha todos os campos do formulário";
  }
}
 ?>
