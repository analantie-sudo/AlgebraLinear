<?php

namespace Model;

class SistemaLinear
{
    public function resolver(array $coeficientes, array $termosIndependentes): array
    {
        if($coeficientes===[] || $termosIndependentes===[]) throw new ArgumentoInvalido("O sistema não pode ser vazio.");
        $n=count($coeficientes);
        if($n!==count($coeficientes[0])) throw new ArgumentoInvalido("O sistema deve ser quadrado.");
        if(count($termosIndependentes)!==$n) throw new ArgumentoInvalido("A quantidade de termos independentes é incompatível.");
        foreach($coeficientes as $linha) if(count($linha)!==$n) throw new ArgumentoInvalido("A matriz de coeficientes deve ser retangular.");
        $a=[];
        for($i=0;$i<$n;$i++){ $a[$i]=array_map("floatval",$coeficientes[$i]); $a[$i][]=(float)$termosIndependentes[$i]; }

        for($c=0;$c<$n;$c++){
            $p=$c;
            for($l=$c+1;$l<$n;$l++) if(abs($a[$l][$c])>abs($a[$p][$c])) $p=$l;
            if(abs($a[$p][$c])<1e-12) continue;
            if($p!==$c) [$a[$c],$a[$p]]=[$a[$p],$a[$c]];
            for($l=$c+1;$l<$n;$l++){
                $f=$a[$l][$c]/$a[$c][$c];
                for($j=$c;$j<=$n;$j++) $a[$l][$j]-=$f*$a[$c][$j];
            }
        }

        $postoA=0;$postoAug=0;
        for($i=0;$i<$n;$i++){
            $temA=false;$temAug=false;
            for($j=0;$j<$n;$j++) if(abs($a[$i][$j])>1e-10){$temA=true;break;}
            for($j=0;$j<=$n;$j++) if(abs($a[$i][$j])>1e-10){$temAug=true;break;}
            if($temA)$postoA++; if($temAug)$postoAug++;
        }
        if($postoA<$postoAug) throw new ArgumentoInvalido("O sistema é impossível: não possui solução.");
        if($postoA<$n) throw new ArgumentoInvalido("O sistema é indeterminado: possui infinitas soluções.");

        $x=array_fill(0,$n,0.0);
        for($i=$n-1;$i>=0;$i--){
            $s=$a[$i][$n];
            for($j=$i+1;$j<$n;$j++) $s-=$a[$i][$j]*$x[$j];
            if(abs($a[$i][$i])<1e-12) throw new ArgumentoInvalido("Não foi possível obter solução única.");
            $x[$i]=$s/$a[$i][$i];
        }
        return $x;
    }
}
