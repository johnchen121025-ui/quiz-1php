<?php
/*
 * លំហាត់ទី ៣ : PHP 8 Strict Types, Default Parameters & Arrow Functions - មេរៀនទី ៣ (៣.៤.១)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. ប្រកាស declare(strict_types=1); នៅខាងលើបង្អស់។
 *  ខ. calcPriceWithTax(float $price, float $taxRate = 0.10): float  (Default tax 10%)
 *  គ. calcDiscount(float $price, float $percent = 5.0): float       (Default បញ្ចុះតម្លៃ 5%)
 *  ឃ. Arrow function $doubleFn = fn(int $n): int => $n * $factor;  (ចាប់យក $factor ពី Outer scope)
 *  ង. Arrow function $toKHR = fn(float $usd): float => $usd * $rate;  (អត្រាប្តូរប្រាក់ 4100)
 */
declare(strict_types=1);

function calcPriceWithTax(float $price, float $taxRate = 0.10): float {
    return $price + ($price * $taxRate);
}

function calcDiscount(float $price, float $percent = 5.0): float {
    return $price - ($price * $percent / 100);
}

$factor = 2;
$doubleFn = fn(int $n): int => $n * $factor;

$rate = 4100;
$toKHR = fn(float $usd): float => $usd * $rate;
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex03</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ៣ : PHP 8 Function Features</h2>
<p>តម្លៃ 100$ + ពន្ធ Default (10%)៖ <b><?= calcPriceWithTax(100.0) ?> $</b></p>
<p>តម្លៃ 100$ + ពន្ធ 5%៖ <b><?= calcPriceWithTax(100.0, 0.05) ?> $</b></p>
<p>តម្លៃ 200$ បញ្ចុះ Default (5%)៖ <b><?= calcDiscount(200.0) ?> $</b></p>
<p>តម្លៃ 200$ បញ្ចុះ 20%៖ <b><?= calcDiscount(200.0, 20.0) ?> $</b></p>
<p>Arrow Fn ×2 នៃ 15៖ <b><?= $doubleFn(15) ?></b></p>
<p>25$ ជាប្រាក់រៀល៖ <b><?= number_format($toKHR(25.0)) ?> ៛</b></p>
<div class="warn">សាកល្បង៖ ហៅ <code>calcPriceWithTax("100")</code> នឹងបោះ TypeError ព្រោះ strict_types=1 ។</div>
</div></body></html>
