<?php
  if (isset($_GET['nome'])){ // dados enviados
    // salvar cadastro no banco
    require_once('config/config.ini.php');
    $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
    if (!$conexao)
      die("Erro ao conectar com o banco de dados...");
    $nome = $_GET['nome'];
    $crmv = $_GET['crmv'];
    $telefone = $_GET['telefone'];
    // definir o comando que será executado no banco de dados
    $sql = 'INSERT INTO veterinario (nome, crmv, telefone)
                 VALUES (:nome,:crmv,:telefone)';
    // prepara o comando para executar
    $comando = $conexao->prepare($sql);
    if (!$comando)
      die("Erro ao criar comando. Erro: ".$conexao->errorInfo());
    //vincular variáveis com os parâmetros do comando
    $comando->bindParam(':nome',$nome);
    $comando->bindParam(':crmv',$crmv);
    $comando->bindParam(':telefone',$telefone);
    // executar o $comando
    $comando->execute();
    if (!$comando)
      die("Erro ao criar comando. Erro: ".$conexao->errorInfo());

    echo "Cadastro efetuado com sucesso!";
  }else{
    echo "Preencha todos os campos do formulário";
  }
?>
