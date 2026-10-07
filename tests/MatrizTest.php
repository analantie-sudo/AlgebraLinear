<?php

namespace Testes;

use Model\ArgumentoInvalido;
use Model\Matriz;
use PHPUnit\Framework\TestCase;

class MatrizTest extends TestCase
{
    private Matriz $m;

    protected function setUp(): void
    {
        $this->m = new Matriz();
    }

    public function testSoma(): void
    {
        $this->assertSame(
            [[6, 8], [10, 12]], 
            $this->m->soma([[1, 2], [3, 4]], [[5, 6], [7, 8]])
        );
    }

    public function testSubtracao(): void
    {
        $this->assertSame(
            [[4, 4], [4, 4]], 
            $this->m->subtracao([[5, 6], [7, 8]], [[1, 2], [3, 4]])
        );
    }

    public function testMultiplicacao(): void
    {
        $this->assertSame(
            [[19, 22], [43, 50]], 
            $this->m->multiplicacao([[1, 2], [3, 4]], [[5, 6], [7, 8]])
        );
    }

    public function testTransposta(): void
    {
        $this->assertSame(
            [[1, 4], [2, 5], [3, 6]], 
            $this->m->transposta([[1, 2, 3], [4, 5, 6]])
        );
    }

    public function testUmPorUm(): void
    {
        $this->assertEqualsWithDelta(7.0, $this->m->determinante([[7]]), 0.000001);
    }

    public function testDeterminanteDoisPorDois(): void
    {
        $this->assertEqualsWithDelta(10.0, $this->m->determinante([[4, 7], [2, 6]]), 0.000001);
    }

    public function testDeterminanteTresPorTres(): void
    {
        $this->assertEqualsWithDelta(
            -306.0, 
            $this->m->determinante([[6, 1, 1], [4, -2, 5], [2, 8, 7]]), 
            0.000001
        );
    }

    public function testMatrizNula(): void
    {
        $this->assertEqualsWithDelta(0.0, $this->m->determinante([[0, 0], [0, 0]]), 0.000001);
    }

    public function testInversa(): void
    {
        $r = $this->m->inversa([[4, 7], [2, 6]]);

        $this->assertEqualsWithDelta(0.6, $r, 0.000001);
        $this->assertEqualsWithDelta(-0.7, $r, 0.000001);
        $this->assertEqualsWithDelta(-0.2, $r, 0.000001);
        $this->assertEqualsWithDelta(0.4, $r, 0.000001);
    }

    public function testDimensoesIncompativeis(): void
    {
        $this->expectException(ArgumentoInvalido::class);
        $this->m->soma([[1, 2]], [[1], [2]]);
    }

    public function testMultiplicacaoIncompativel(): void
    {
        $this->expectException(ArgumentoInvalido::class);
        $this->m->multiplicacao([[1, 2]], [[1, 2]]);
    }

    public function testSingular(): void
    {
        $this->expectException(ArgumentoInvalido::class);
        $this->m->inversa([[1, 2], [2, 4]]);
    }

    public function testNaoQuadrada(): void
    {
        $this->expectException(ArgumentoInvalido::class);
        $this->m->determinante([[1, 2, 3], [4, 5, 6]]);
    }

    public function testVazia(): void
    {
        $this->expectException(ArgumentoInvalido::class);
        $this->m->validar([]);
    }

    public function testNaoRetangular(): void
    {
        $this->expectException(ArgumentoInvalido::class);
        $this->m->validar([[1, 2], [3]]);
    }
}
