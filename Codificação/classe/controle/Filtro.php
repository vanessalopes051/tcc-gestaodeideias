<?php 

class Filtro {


    /*
    * Função que recebe um array e verifica se algun dos campos está vázio
    */
    public static function verificaCampos($parms){

        foreach ($parms as $key => $value) {
            if(!$value)
                return false;
        }

        return true;

    }

}