<?php
    class PessoaForm {
        private string $html;
        private array $data;

        public function __construct() {
            try {
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
            } catch (Exception $e) {
                $e->getMessage();
                exit;
            }          
        }
       
        public function edit(array $param):void {
            try {
                $id = (int) $param['id'];
                $this->data = Pessoa::find($id);
            } catch (Exception $e) {
                print $e->getMessage();
                exit;
            }
        }

        public function save(array $param):void {
            try {
                Pessoa::save($param);
                $this->data = $param;
                print "pessoa salva com sucesso.";
            } catch (Exception $e){
                print $e->getMessage();
                exit;
            }
        }
        
        public function show():void {
            $this->html = str_replace('{id}', $this->data['id'], $this->html);
            $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
            $this->html = str_replace('{endereco}', $this->data['endereco'], $this->html);
            $this->html = str_replace('{bairro}', $this->data['bairro'], $this->html);
            $this->html = str_replace('{telefone}', $this->data['telefone'], $this->html);
            $this->html = str_replace('{email}', $this->data['email'], $this->html);
            $this->html = str_replace("option value='{$this->data['id_cidade']}'", "option value='{$this->data['id_cidade']}' selected=1", $this->html); 
            print $this->html;
        }       
    }