<?php
class Pessoa
{
  private static $conn;
  private static $tb_pessoa;

  public static function getConnection()
  {
    if (empty(self::$conn)) {
      $conexao = parse_ini_file('config/livro.ini');
      $host    = $conexao['host'];
      $name    = $conexao['name'];
      $user    = $conexao['user'];
      $pass    = $conexao['pass'];
      self::$tb_pessoa = $conexao['tb_pessoa'];
      self::$conn = new PDO("mysql:host={$host};port=3306;dbname={$name}", $user, $pass);
    }

    return self::$conn;
  }

  public static function save($pessoa)
  {
    $conn = self::getConnection();
        
    
    if (empty($pessoa['id'])) {
      $result = $conn->query("SELECT MAX(id) as next FROM " . self::$tb_pessoa);
      $row    = $result->fetch();
      $pessoa['id'] = (int) $row['next'] + 1;

      $sql = "INSERT INTO " . self::$tb_pessoa . " (id, nome, endereco, bairro, telefone, email, id_cidade)
                VALUE (:id, :nome, :endereco, :bairro, :telefone, :email, :id_cidade)";
    } else {
      $sql = "UPDATE " . self::$tb_pessoa . " SET nome      = :nome,
                                                  endereco  = :endereco,
                                                  bairro    = :bairro,
                                                  telefone  = :telefone,
                                                  email     = :email,
                                                  id_cidade = :id_cidade
                                                  WHERE id  = :id";
    }

    $result = $conn->prepare($sql);
    $result->execute([
      ':id'        => $pessoa['id'],
      ':nome'      => $pessoa['nome'],
      ':endereco'  => $pessoa['endereco'],
      ':bairro'    => $pessoa['bairro'],
      ':telefone'  => $pessoa['telefone'],
      ':email'     => $pessoa['email'],
      ':id_cidade' => $pessoa['id_cidade'],
    ]);

    return $result;
    
  }

  public static function find($id)
  {

    $conn   = self::getConnection();
    $sql    = "SELECT id, nome, endereco, bairro, telefone, email, id_cidade  FROM " . self::$tb_pessoa . " WHERE id = :id";
    $result = $conn->prepare($sql);
    $result->execute([':id' => $id]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }

  public static function all()
  {
    $conn   = self::getConnection();
    $sql    = "SELECT id, nome, endereco, bairro, telefone, email, id_cidade  FROM " . self::$tb_pessoa;
    $result = $conn->query($sql);
    return $result->fetchAll();
  }

  public static function remove($id)
  {
    $conn   = self::getConnection();
    $sql    = "DELETE FROM ".self::$tb_pessoa." WHERE id = :id";
    $result = $conn->prepare($sql);
    $result->execute(['id' => $id]);
    return $result;
  }
}
