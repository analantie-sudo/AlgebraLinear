<?php

namespace Model;

class Matriz
{
    public function validar(array $matriz): void
    {
        if ($matriz === []) throw new ArgumentoInvalido("A matriz não pode ser vazia.");
        $colunas = null;
        foreach ($matriz as $linha) {
            if (!is_array($linha) || $linha === []) throw new ArgumentoInvalido("Todas as linhas devem conter valores.");
            $q = count($linha);
            if ($colunas === null) $colunas = $q;
            elseif ($q !== $colunas) throw new ArgumentoInvalido("A matriz deve ser retangular.");
            foreach ($linha as $valor) if (!is_numeric($valor)) throw new ArgumentoInvalido("Todos os elementos devem ser numéricos.");
        }
    }

    public function linhas(array $matriz): int { $this->validar($matriz); return count($matriz); }
    public function colunas(array $matriz): int { $this->validar($matriz); return count($matriz[0]); }

    public function soma(array $a, array $b): array
    {
        $this->validar($a); $this->validar($b);
        if ($this->linhas($a) !== $this->linhas($b) || $this->colunas($a) !== $this->colunas($b))
            throw new ArgumentoInvalido("As matrizes devem ter as mesmas dimensões para a soma.");
        $r=[];
        for($i=0;$i<count($a);$i++) for($j=0;$j<count($a[0]);$j++) $r[$i][$j]=$a[$i][$j]+$b[$i][$j];
        return $r;
    }

    public function subtracao(array $a, array $b): array
    {
        $this->validar($a); $this->validar($b);
        if ($this->linhas($a) !== $this->linhas($b) || $this->colunas($a) !== $this->colunas($b))
            throw new ArgumentoInvalido("As matrizes devem ter as mesmas dimensões para a subtração.");
        $r=[];
        for($i=0;$i<count($a);$i++) for($j=0;$j<count($a[0]);$j++) $r[$i][$j]=$a[$i][$j]-$b[$i][$j];
        return $r;
    }

    public function multiplicacao(array $a, array $b): array
    {
        $this->validar($a); $this->validar($b);
        if ($this->colunas($a) !== $this->linhas($b))
            throw new ArgumentoInvalido("As dimensões são incompatíveis para multiplicação.");
        $r=[]; $la=count($a); $ca=count($a[0]); $cb=count($b[0]);
        for($i=0;$i<$la;$i++) for($j=0;$j<$cb;$j++){
            $r[$i][$j]=0;
            for($k=0;$k<$ca;$k++) $r[$i][$j]+=$a[$i][$k]*$b[$k][$j];
        }
        return $r;
    }

    public function transposta(array $matriz): array
    {
        $this->validar($matriz); $r=[];
        for($j=0;$j<count($matriz[0]);$j++) for($i=0;$i<count($matriz);$i++) $r[$j][$i]=$matriz[$i][$j];
        return $r;
    }

    public function determinante(array $matriz): float
    {
        $this->validar($matriz);
        if(count($matriz)!==count($matriz[0])) throw new ArgumentoInvalido("O determinante exige matriz quadrada.");
        $n=count($matriz);
        if($n===1) return (float)$matriz[0][0];
        if($n===2) return (float)($matriz[0][0]*$matriz[1][1]-$matriz[0][1]*$matriz[1][0]);
        $a=array_map(fn($l)=>array_map("floatval",$l),$matriz); $det=1.0;
        for($i=0;$i<$n;$i++){
            $p=$i;
            for($l=$i+1;$l<$n;$l++) if(abs($a[$l][$i])>abs($a[$p][$i])) $p=$l;
            if(abs($a[$p][$i])<1e-12) return 0.0;
            if($p!==$i){[$a[$i],$a[$p]]=[$a[$p],$a[$i]];$det*=-1;}
            $det*=$a[$i][$i];
            for($l=$i+1;$l<$n;$l++){
                $f=$a[$l][$i]/$a[$i][$i];
                for($c=$i+1;$c<$n;$c++) $a[$l][$c]-=$f*$a[$i][$c];
            }
        }
        return $det;
    }

    public function inversa(array $matriz): array
    {
        $this->validar($matriz);
        if(count($matriz)!==count($matriz[0])) throw new ArgumentoInvalido("A inversa exige matriz quadrada.");
        $n=count($matriz); $a=[];
        for($i=0;$i<$n;$i++){
            $a[$i]=array_map("floatval",$matriz[$i]);
            for($j=0;$j<$n;$j++) $a[$i][]=$i===$j?1.0:0.0;
        }
        for($c=0;$c<$n;$c++){
            $p=$c;
            for($l=$c+1;$l<$n;$l++) if(abs($a[$l][$c])>abs($a[$p][$c])) $p=$l;
            if(abs($a[$p][$c])<1e-12) throw new ArgumentoInvalido("A matriz é singular e não possui inversa.");
            if($p!==$c) [$a[$c],$a[$p]]=[$a[$p],$a[$c]];
            $pivo=$a[$c][$c];
            for($j=0;$j<2*$n;$j++) $a[$c][$j]/=$pivo;
            for($l=0;$l<$n;$l++){
                if($l===$c) continue;
                $f=$a[$l][$c];
                for($j=0;$j<2*$n;$j++) $a[$l][$j]-=$f*$a[$c][$j];
            }
        }
        return array_map(fn($l)=>array_slice($l,$n),$a);
    }
}
