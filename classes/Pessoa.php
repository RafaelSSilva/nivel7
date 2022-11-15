<?php
class Pessoa
{

  public static function save(array $pessoa):object {
    $conn   = Conexao::getConnection();
    $tabela = Conexao::getTbPessoa();

    if (empty($pessoa['id'])) {
      $result = $conn->query("SELECT MAX(id) as next FROM {$tabela}");
      $row    = $result->fetch();
      $pessoa['id'] = (int) $row['next'] + 1;

      $sql = "INSERT INTO {$tabela} (id, nome, endereco, bairro, telefone, email, id_cidade)
                VALUE (:id, :nome, :endereco, :bairro, :telefone, :email, :id_cidade)";
    } else {
      $sql = "UPDATE {$tabela} SET nome      = :nome,
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
  
  public static function find(string $id):array {    
    $conn   = Conexao::getConnection();
    $tabela = Conexao::getTbPessoa();
    $sql    = "SELECT id, nome, endereco, bairro, telefone, email, id_cidade  FROM {$tabela} WHERE id = :id";
    $result = $conn->prepare($sql);
    $result->execute([':id' => $id]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }

  public static function all():array {
    $conn   = Conexao::getConnection();
    $tabela = Conexao::getTbPessoa();
    $sql    = "SELECT id, nome, endereco, bairro, telefone, email, id_cidade  FROM {$tabela}";
    $result = $conn->query($sql);
    return $result->fetchAll();
  }

  
  public static function remove(string $id):object {
    $conn   = Conexao::getConnection();
    $tabela = Conexao::getTbPessoa();
    $sql    = "DELETE FROM {$tabela} WHERE id = :id";
    $result = $conn->prepare($sql);
    $result->execute(['id' => $id]);
    return $result;
  }
  
}
