<?php
class PessoaList {
    private string $html;
    
    public function __construct() {
        $this->html = file_get_contents('html/list.html');
    }

    public function delete(Array $param):void {
        try {
            $id = (int) $param['id'];
            Pessoa::remove($id);
        } catch (Exception $e) {
            print $e->getMessage();
            exit;
        }
        
    }

    public function load():void{
        try {

            $pessoas = Pessoa::all();
            $items   = '';
            foreach($pessoas as $pessoa){
                $item   = file_get_contents('html/item.html');
                $item   = str_replace('{id}', $pessoa['id'], $item);
                $item   = str_replace('{nome}', $pessoa['nome'], $item);
                $item   = str_replace('{endereco}', $pessoa['endereco'], $item);
                $item   = str_replace('{bairro}', $pessoa['bairro'], $item);
                $item   = str_replace('{telefone}', $pessoa['telefone'], $item);
                $items .= $item;
            }
            
            $this->html = str_replace('{items}', $items, $this->html);       
        } catch (Exception $e) {
            print $e->getMessage();
            exit;
        }
    }

    public function show():void {
        try {
            $this->load();
            print $this->html;
        } catch (Exception $e) {
            print $e->getMessage();
            exit;
        }        
    }
}