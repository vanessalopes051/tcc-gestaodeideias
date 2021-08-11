<?php

class Mensagem {

    private static $tentativas;

    public static function Sucesso($msg = null){

        return "<script> alert('".$msg."'); </script>";

    }

    public static function Error($msg, $tentativas = null){

        return "<script> alert('".$msg."'); </script>";

    }

}