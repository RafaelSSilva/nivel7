<?php
class Cidade {
  
  public static function lista_combo_cidades(string $id = null):string
  {
    $conn   = Conexao::getConnection();
    $tabela = Conexao::getTbCidade();
    $sql    = "SELECT id, nome FROM {$tabela}";
    $result = $conn->query($sql);
    $output = '';
    
    foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $cidade) {
      $output .= "<option value='{$cidade['id']}'>{$cidade['nome']}</option>\n";

    }

    return $output;    
  }
}
