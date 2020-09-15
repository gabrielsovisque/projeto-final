<?php

namespace Hcode;

class Model{

    //atributo universal que da suporte aos gets e sets de todas as classes modal
    private $values = [];

    //método magico que é instanciado antesde qualquer método desta class ou de classes 
    // filhas forem instanciadas
    // ele recebe como parâmetros, o nome do método, e o parâmetro passado por ele

    public function __call($name, $arguments)
    {
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));
        


        // se for get, ele retorn algum valor no atributo values que é um array e se for
        // set, ele envia para dentro da atributo $values só que com uma chave e um values.

        switch ($method) {
            case "get":
                 $this -> values[$fieldName];
                break;
            
            case "set":
                $this -> values[$fieldName] = $arguments[0];
                break;
        }

        

    }


    // primeiro ao instanciar o método setData, o switch case'set' vai adicionar todos os 
    // no atributo array, de forma que todos eles vão estar em um subarray chamado data, que vai
    // sobre escrito conforme as instancias feitas com o prefixo set,

    // segundo, o método setData, que vai ser executado depois do método magico __call, vai 
    // esse parâmetro que vai ter como valor um array, e pra cada chave dentro desse array 
    // o método setData vai criar um subarray dentro do atributo values, que vai ficar lado a 
    // lado da chave data, 
    // e ele vai fazer isso de modo dinamico que criar e intanciar um método set pra cada chave 
    // e valor do array passado como parâmetro nó método setData
    /*
    VAI FICAR ASSIM
    private $values[
        'data' => 'TODOS OS VALORES PASSADOS, ELES VÃO SER FACILMENTE SUBESCRITOS',
        'chave1' => 'valor chave 1',
        'chave2' => 'valor chave 2',
        'chave3' => 'valor chave 3',
        'chave3' => 'valor chave 4',
                ...
    ]
    
    
    */

    public function setData($data = array()){
        foreach ($data as $key => $value) {
            $this -> {"set" .$key}($value);
        }            
    }


    // método que retorna todo o atributo values

    public function getValues(){
        return $this -> values;
    }




}
?>