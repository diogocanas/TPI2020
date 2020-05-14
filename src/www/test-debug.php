<?php

$a = 10;
$b = 20;

$i = $a * $b;

$i = multiply($a, $b);

/**
 * Fait la multiplication de deux nombres
 *
 * @param integer $num1 Le premier chiffre à multiplier
 * @param integer $num2 Le deuxième chiffre à multiplier
 * @return integer Le résultat de la multiplication
 */
function multiply($num1, $num2)
{
    return $num1 * $num2;
}
?>