<?php
class Cidade
{
  private static $conn;
  private static $tb_cidade;

  public static function getConnection()
  {
    if (empty(self::$conn)) {
      $conexao = parse_ini_file('config/livro.ini');
      $host    = $conexao['host'];
      $name    = $conexao['name'];
      $user    = $conexao['user'];
      $pass    = $conexao['pass'];
      
      self::$tb_cidade = $conexao['tb_cidade'];
      self::$conn = new PDO("mysql:host={$host};port=3306;dbname={$name}", $user, $pass); 
    }

    return self::$conn;
  }

  public static function lista_combo_cidades($id = null)
  {
    
    $conn   = self::getConnection();
    $sql    = "SELECT id, nome FROM ".self::$tb_cidade;
    $result = $conn->query($sql);
    $output = '';
    foreach ($result->fetchAll() as $cidade) {
      $check  = ($cidade['id'] == $id) ? 'selected=1' : '';
      $output .= "<option $check value='{$cidade['id']}'>{$cidade['nome']}</option>\n";
    }

    return $output;    
  }
}
