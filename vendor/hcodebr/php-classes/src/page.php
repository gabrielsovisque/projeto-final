<?php

// indicando o name space da classe que vou criar (que é o nome que substitui o caminho todo
// mais o caminho que não ta la no arquivo composer.json
// até o arquivo da classe(que está definido no composer.json na parte do psr-4))
namespace Hcode;

// usando o sistema de autoload do composer para bibliotecas, projetos e classes e sub classes
use Rain\Tpl;

class Page {

    private $tpl;
    private $options;
    // é aqui que vamos definir as chaves que vão difir todos os sub arrays que o atributo optons
    // vai ter
    private $defaults = [
        "data"=>[]
    ];

    # a classe recebe já pronto os dados pra inserir na pagina
    public function __construct($opts = array()){

        # array_merge mescla os dois arrays e cria um novo array e ai esse novo array vai para
        # dentro do atributo options, como um sub array
        $this -> options = array_merge($this->defaults, $opts);

        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false,
        );

        Tpl::configure( $config );

        $this -> tpl =  new Tpl();
        
        # cada nome da variavel e seu valor que vão ser inseridos na pagina, vão passar por aqui
        # ou seja cada chave vai la no html como 
        $this -> setData($this-> options["data"]);
        $this -> tpl -> draw("header");

        

    } 

    private function setData( $data){
        foreach ($data as $key => $value) {
            $this -> tpl->assing($key, $value);

            # code...
        }      
    }

    public function setTpl($name, $data = array(), $returnHTML = false) {
        $this -> setData($data);
        return $this -> tpl -> draw($name, $returnHTML);
        
    }

    public function __destruct() {
        $this -> tpl -> draw("footer");
    }


}

?>