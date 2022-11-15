<?php
class Conexao {
    private static $conn;
    private static $tb_pessoa;
    private static $tb_cidade;

    public static function getConnection():object {
      if (empty(self::$conn)) {
        $config  = parse_ini_file(dirname(__DIR__)."/config/livro.ini");
        $host    = $config['host'];
        $name    = $config['name'];
        $user    = $config['user'];
        $pass    = $config['pass'];
        
        self::$conn = new PDO("mysql:host={$host};port=3306;dbname={$name}", $user, $pass);
       }
  
       return self::$conn;
    }

    public static function getTbPessoa():string {
        if (empty(self::$tb_pessoa)) {
            $config  = parse_ini_file(dirname(__DIR__)."/config/livro.ini");
            self::$tb_pessoa = $config['tb_pessoa'];
        }

        return self::$tb_pessoa;
    }

    public static function getTbCidade():string {
        if (empty(self::$tb_cidade)) {
            $config  = parse_ini_file(dirname(__DIR__)."/config/livro.ini");
            self::$tb_cidade = $config['tb_cidade'];
        }

        return self::$tb_cidade;
    }
}