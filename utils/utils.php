<?php
function preencherFormulario($formulario, $dados){
  // preenche os campos da página HTML que estiverem entre chaves '{}'
  // com as informações contidas no array dados
  foreach ($dados as $chave => $valor)
    $formulario = str_replace('{'.$chave.'}',$valor,$formulario);
  return $formulario;
}

function criarConexao(){
  // cria a conexão com o banco de dados usando PDO
  try{
    require_once('../config/config.ini.php'); // carrega informações da conexão
    $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
    return $conexao;
  }catch(PDOException $e){
    print('Erro ao conectar com o banco de dados. Favor verificar parâmetros.');
    die();
  }catch(Exception $e){
      print('Erro genérico. Entre em contato com o adm do site!');
      die();
  }
}
function preparaComando($sql){
  try{
    // prepara o comando SQL para ser executado - valida caracteres especiais e SQLInjection
    $conexao = criarConexao();
    return $conexao->prepare($sql);
  }catch(Exception $e){
    print('Erro ao preparar comando.');
    die();
  }
}

function executaComando($sql,$dados=array()){
  try {
    // prepara o comando para executar
    $comando = preparaComando($sql);
    // vincula parâmetros com o comando sql
    $comando = bindParametros($comando,$dados);
    // executa o comando
    $comando->execute();
    return $comando;
  } catch (Exception $e) {
    print('Erro ao executar comando.'.$e->getMessage());
    die();
  }
}

function bindParametros($comando, $dados){
  // vincula os valores que estão no array dados com os parâmetros da consulta SQL
  foreach ($dados as $chave => &$valor) {
    $comando->bindParam($chave,$valor);
  }
  return $comando;
}

function criaCabecalho($titulo){
  // cria o cabeçalho da página <head>
  $cabecalho = file_get_contents('cabecalho.html');
  $titulo = array('titulo'=>$titulo);
  $cabecalho = preencherFormulario($cabecalho,$titulo);
  return $cabecalho;
}

function criaMenu(){
  // cria barra de navegação
  $navegacao = file_get_contents('navegacao-geral.html');
  return $navegacao;
}
?>
