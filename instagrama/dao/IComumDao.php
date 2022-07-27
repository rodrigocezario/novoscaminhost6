<?php 

//DAO - Data Access Object
interface IComumDao { //padronizar (defini um contrato)

    //CRUD - Operações
    //Create = criar (salvar) - OK
    //Read = ler (buscar)
    //Update = atualizar - OK
    //Delete = apagar (excluir) - OK

    //operações (definições)
    public function salvar($obj);
    public function atualizar($obj);
    public function excluir($id);

}

