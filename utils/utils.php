<?php
function preencherFormulario($formulario, $dados){
  foreach ($dados as $chave => $valor)
    $formulario = str_replace('{'.$chave.'}',$valor,$formulario);
  return $formulario;
}

function criarConexao(){
  try{
    require_once('config/config.ini.php');
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
    $conexao = criarConexao();
    return $conexao->prepare($sql);
  }catch(Exception $e){
    print('Erro ao preparar comando.');
    die();
  }
}

function executaComando($comando){
  try {
    $comando->execute();
    return $comando;
  } catch (Exception $e) {
    print('Erro ao executar comando.'.$e->getMessage());
    die();
  }


}

?>
