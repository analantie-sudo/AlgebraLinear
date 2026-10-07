<?php

namespace Testes;

use Controller\ControladorMatriz;
use PHPUnit\Framework\TestCase;

class ControladorMatrizTest extends TestCase
{
    public function testExecutaSoma(): void
    {
        $r = (new ControladorMatriz())->executar("soma", [[1, 2]], [[3, 4]]);
        
        $this->assertSame([[4, 6]], $r);
    }

    public function testExecutaDeterminante(): void
    {
        $r = (new ControladorMatriz())->executar("determinante", [[2, 0], [0, 3]]);
        
        $this->assertEqualsWithDelta(6.0, $r[0]["resultado"], 0.000001);
    }
}
