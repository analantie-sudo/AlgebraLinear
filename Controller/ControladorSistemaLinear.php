<?php

namespace Controller;

use Model\SistemaLinear;

class ControladorSistemaLinear
{
    public function resolver(array $coeficientes,array $termosIndependentes):array
    {
        return (new SistemaLinear())->resolver($coeficientes,$termosIndependentes);
    }
}
