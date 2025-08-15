<?php

namespace App\Helpers;

class FuncoesHelper
{
    public static function removerCaracter($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }

    public static function mascara($valor, $formato = null)
    {
        $mascara = "";

        switch (strtolower($formato)) {
            case "cnpj":
                $mascara = '##.###.###/####-##';
                break;
            case "cpf":
                $mascara = '###.###.###-##';
                break;
            case "cep":
                $mascara = '#####-###';
                break;
            case "celular":
                $mascara = '(##) #####-####';
                break;
            default:
                return $valor;
        }

        $valorComMascara = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mascara) - 1; $i++) {
            if ($mascara[$i] == '#') {
                if (isset($valor[$k])) {
                    $valorComMascara .= $valor[$k++];
                }
            } else {
                if (isset($mascara[$i])) {
                    $valorComMascara .= $mascara[$i];
                }
            }
        }

        return $valorComMascara;
    }

    public static function anoLetivo()
    {
        $anos = [];
        $ano = date('Y');

        for ($i = $ano; $i <= $ano + 4; $i++) {
            $anos[$i] = $i;
        }

        return $anos;
    }
}