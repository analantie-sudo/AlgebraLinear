<?php

namespace Testes;

use Model\ArgumentoInvalido;
use Model\SistemaLinear;
use PHPUnit\Framework\TestCase;

class SistemaLinearTest extends TestCase
{
    private SistemaLinear $s;

    protected function setUp(): void
    {
        $this->s = new SistemaLinear();
    }

    public function testSolucaoConhecida(): void
{
    $r = $this->s->resolver(
        [
            [2, 1],
            [-1, 1]
        ],
        [5, 1]
    );

    $this->assertEqualsWithDelta(
        4 / 3,
        (float) $r[0],
        0.000001
    );

    $this->assertEqualsWithDelta(
        7 / 3,
        (float) $r[1],
        0.000001
    );
}
    public function testSistemaTresPorTres(): void
    {
        $r = $this->s->resolver(
            [
                [1, 1, 1],
                [2, -1, 1],
                [1, 2, -1]
            ],
            [6, 3, 2]
        );

        $this->assertEqualsWithDelta(
            1.0,
            (float) $r[0],
            0.000001
        );

        $this->assertEqualsWithDelta(
            2.0,
            (float) $r[1],
            0.000001
        );

        $this->assertEqualsWithDelta(
            3.0,
            (float) $r[2],
            0.000001
        );
    }

    public function testImpossivel(): void
    {
        $this->expectException(ArgumentoInvalido::class);

        $this->s->resolver(
            [
                [1, 1],
                [2, 2]
            ],
            [2, 5]
        );
    }

    public function testIndeterminado(): void
    {
        $this->expectException(ArgumentoInvalido::class);

        $this->s->resolver(
            [
                [1, 1],
                [2, 2]
            ],
            [2, 4]
        );
    }

    public function testTermosIncompativeis(): void
    {
        $this->expectException(ArgumentoInvalido::class);

        $this->s->resolver(
            [
                [1, 2],
                [3, 4]
            ],
            [5]
        );
    }

    public function testNaoQuadrado(): void
    {
        $this->expectException(ArgumentoInvalido::class);

        $this->s->resolver(
            [
                [1, 2, 3],
                [4, 5, 6]
            ],
            [7, 8]
        );
    }

    public function testVazio(): void
    {
        $this->expectException(ArgumentoInvalido::class);

        $this->s->resolver([], []);
    }
}