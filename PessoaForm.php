<?php
    require_once 'classes/Pessoa.php';
    require_once 'classes/Cidade.php';

    class PessoaForm {
        private $html;
        private $data;

        public function __construct(){
            $this->html = file_get_contents('html/form.html');            
            $this->data = [ 'id'        => null,
                            'nome'      => null,
                            'endereco'  => null,
                            'bairro'    => null,                   
                            'telefone'  => null,
                            'email'     => null,
                            'id_cidade' => null    
                        ];  
           
            $this->html = str_replace('{cidades}', Cidade::lista_combo_cidades(), $this->html);            
           
        }

        
        public function edit($param) {
            try {
                $id = (int) $param['id'];
                $this->data = Pessoa::find($id);
            } catch (Exception $e) {
                print $e->getMessage();
                exit;
            }
        }

        public function save($param) {
            try {
                Pessoa::save($param);
                $this->data = $param;
                print "pessoa salva com sucesso.";
            } catch (Exception $e){
                print $e->getMessage();
                exit;
            }
        }
        
        public function show() {
            $this->html = str_replace('{id}', $this->data['id'], $this->html);
            $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
            $this->html = str_replace('{endereco}', $this->data['endereco'], $this->html);
            $this->html = str_replace('{bairro}', $this->data['bairro'], $this->html);
            $this->html = str_replace('{telefone}', $this->data['telefone'], $this->html);
            $this->html = str_replace('{email}', $this->data['email'], $this->html);
            $this->html = str_replace('{cidades}', Cidade::lista_combo_cidades($this->data['id_cidade']), $this->html); 
            
            print $this->html;
        }

        
    }