<?php

namespace Testes;

use Controller\ControladorSistemaLinear;
use PHPUnit\Framework\TestCase;

class ControladorSistemaLinearTest extends TestCase
{
    public function testResolve(): void
    {
        $r = (new ControladorSistemaLinear())->resolver([[1,1],[2,-1]],[5,1]);

        $this->assertEqualsWithDelta(2.0, $r[0], 0.000001);
        $this->assertEqualsWithDelta(3.0, $r[1], 0.000001);
    }
}
