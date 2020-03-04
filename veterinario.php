<?php
// Controle da Interface
require_once('utils/utils.php');

  if ($_SERVER['REQUEST_METHOD'] ==  'GET'){
    $formulario = file_get_contents('cadastroVeterinario.html');
    if (isset($_GET['id'])){
      $sql = 'SELECT * FROM veterinario WHERE id = :id';
      // prepara o comando para executar
      $comando = preparaComando($sql);
      $comando->bindParam(':id',$_GET['id']);
      // executar o $comando
      $veterinario = executaComando($comando)->fetch(); // pegando os dados do banco
      $formulario = preencherFormulario($formulario,$veterinario);
    }else{
      $formulario = str_replace('{nome}','',$formulario);
      $formulario = str_replace('{crmv}','',$formulario);
      $formulario = str_replace('{telefone}','',$formulario);
      $formulario = str_replace('{id}','',$formulario);
    }
    print($formulario);
  }else if ($_SERVER['REQUEST_METHOD'] ==  'POST'){
    if (isset($_POST['nome'])){
      //tratamento de dados para inserção
      $nome = $_POST['nome'];
      $crmv = $_POST['crmv'];
      $telefone = $_POST['telefone'];
      $id = $_POST['id'];
      if ($id > 0){
        // definir o comando que será executado no banco de dados
        $sql = 'UPDATE veterinario
                   SET nome = :nome, crmv = :crmv, telefone = :telefone
                 WHERE id = :id';
        // prepara o comando para executar
        $comando = preparaComando($sql);

        //vincular variáveis com os parâmetros do comando
        $comando->bindParam(':nome',$nome);
        $comando->bindParam(':crmv',$crmv);
        $comando->bindParam(':telefone',$telefone);
        $comando->bindParam(':id',$id);
        // executar o $comando
        executaComando($comando);
        echo "Cadastro atualizado com sucesso!";
      }else{
        // salvar cadastro no banco
        // definir o comando que será executado no banco de dados
        $sql = 'INSERT INTO veterinario (nome, crmv, telefone)
                     VALUES (:nome,:crmv,:telefone)';
        // prepara o comando para executar
        $comando = preparaComando($sql);

        //vincular variáveis com os parâmetros do comando
        $comando->bindParam(':nome',$nome);
        $comando->bindParam(':crmv',$crmv);
        $comando->bindParam(':telefone',$telefone);
        // executar o $comando
        executaComando($comando);
        echo "Cadastro efetuado com sucesso!";
      }
    }else{
      echo "Preencha todos os campos do formulário";
    }
  }
 ?>
