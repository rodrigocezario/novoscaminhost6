<?php 

//classe abstrata: servir para abstração (trabalhar herança)
//não cria instancias a partir desta classe
//permite ter métodos abstratos - não tem corpo (somente assinatura)
//permite ter métodos concretos - os têm corpo

abstract class AbstractDao implements IComumDao {

    //Modificadores de visibilidade
    //private = restrito somente ao escopo da classe
    //public = acessivel de fora e internamente a classe
    //protected = protegido - herança
    //subclasse = o acesso ao atributo será como se fosse publico
    //classes externas (que usam) - o atributo se comportará como se fosse privado
    protected $conexao = null;

    function __construct()
    {
        try {
            $this->conexao = Conexao::getConnection();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}


