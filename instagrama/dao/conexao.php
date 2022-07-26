<?php 

//singleton: padrão de projeto (criacional)
//1 - unico ponto de acesso ao recurso
//2 - o recurso estará disponível para todos 
//3 - restrigir a criação

//mecanismo OO: Herança

class Conexao { //stdClass

    private static $conexao = null;

    private function __construct()
    {
        
    }

    //static = é da classe
    public static function getConnection() {
        if(!isset(self::$conexao)) {
            self::$conexao = new PDO("mysql:host=localhost;dbname=fotoweb", "root", "");
        }
        return self::$conexao;
    }

    function __clone() //reescrevendo
    {
        throw new Exception("Não se pode clonar um singleton!");
    }

}






