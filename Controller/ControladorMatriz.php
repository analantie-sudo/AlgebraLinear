<?php

namespace Controller;

use Model\Matriz;

class ControladorMatriz
{
    public function executar(string $operacao,array $matrizA,?array $matrizB=null):array
    {
        $m=new Matriz();
        return match($operacao){
            "soma"=>$m->soma($matrizA,$matrizB??[]),
            "subtracao"=>$m->subtracao($matrizA,$matrizB??[]),
            "multiplicacao"=>$m->multiplicacao($matrizA,$matrizB??[]),
            "transposta"=>$m->transposta($matrizA),
            "determinante"=>[["resultado"=>$m->determinante($matrizA)]],
            "inversa"=>$m->inversa($matrizA),
            default=>throw new \InvalidArgumentException("Operação desconhecida.")
        };
    }
}
