<?php
namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class User extends Model{
    const SESSION = "User";

    public static function login($login, $password){

        $sql = new Sql();

       $results =  $sql -> select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN" => $login
        ));

        if (count($results) === 0) {
            throw new \Exception("Úsuario inexistente ou senha inválida .");
            
        }

        $data = $results[0];

        if ($password === $data["despassword"]) {
            $user = new User();
            
            // vai enviar todo o array data, retornado do banco de dados, com todas as chaves 
            // valores
            $user -> setData($data);

            // definindo o nome de uma sessão, colocando um valor dentro dela e com uma 
            // contante que vai ser acessado de forma 
            //statica e vai ser definida seu valor no inicio da class
            $_SESSION[User::SESSION] = $user -> getValues();

            return $user;
            
        } else{
            throw new \Exception("Úsuario inexistente ou senha inválida.");
        }
    }


    // método de verificação de login
    public static function verifyLogin( $inadmin = true){

        if (
            !isset($_SESSION[User::SESSION]) // se não existir uma session com esse nome
            ||                                      // vai direciona para a pagina login
            !$_SESSION[User::SESSION]        // se a sessão não tiver nada vai direcioan para 
            ||                                      // pagina de login
            !(int)$_SESSION[User::SESSION]["iduser"] > 0 // se o id usuario não for maior que 
            ||                                                  // zero, ele direciona
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin // se o subarray na session
                                                        // não for true  e ai causar uma diferença 
                                                        // na operação e com isso retornar um valor
                                                        // false, direciona para o login.
            ) {
            header("Location: /admin/login"); // se alguma coisa ai em cima for verdadeira, ele 
                                                    // direciona

            exit;    // e para de ler e executar bem aqui.


        }

    

    }

    // método statico que esvazia tudo que tem dentro da session User
    public static function logout(){
        $_SESSION[User::SESSION] = NULL;
    }
}



?>