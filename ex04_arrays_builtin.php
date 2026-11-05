<?php
/*
 * លំហាត់ទី ៤ : Arrays + Built-in Functions + Function ផ្ទាល់ខ្លួន - មេរៀនទី ៣ (៣.១ & ៣.២)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. បង្កើត Multidimensional Array ទំនិញ ៤ មុខ (title, price, qty)។
 *  ខ. array_push() បន្ថែមទំនិញទី ៥។
 *  គ. cartTotal(array $items): float  គណនាតម្លៃសរុប (price × qty)។
 *  ឃ. hasProduct(array $items, string $title): bool  ប្រើ in_array() ក្នុងបញ្ជីឈ្មោះ (array_column)។
 *  ង. បង្ហាញចំនួនទំនិញ count(), ឈ្មោះអក្សរធំ strtoupper(), ប្រវែង strlen()។
 */
declare(strict_types=1);

function cartTotal(array $items): float {
    $total = 0.0;
    foreach ($items as $item) {
        $total += $item["price"] * $item["qty"];
    }
    return $total;
}

function hasProduct(array $items, string $title): bool {
    return in_array($title, array_column($items, "title"));
}

$cart = [
    ["title" => "Laptop Dell",     "price" => 850.0, "qty" => 1],
    ["title" => "Mouse Logitech",  "price" => 25.0,  "qty" => 2],
    ["title" => "Keyboard",        "price" => 40.0,  "qty" => 1],
    ["title" => "USB Flash 64GB",  "price" => 12.5,  "qty" => 4],
];
array_push($cart, ["title" => "Monitor 24 inch", "price" => 160.0, "qty" => 2]);

$shop = "angkor computer shop";
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex04</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ៤ : Array & Built-in Functions</h2>
<p>ហាង៖ <b><?= strtoupper($shop) ?></b> (ប្រវែងឈ្មោះ <?= strlen($shop) ?> តួអក្សរ)</p>
<p>ចំនួនទំនិញក្នុងកន្ត្រក៖ <b><?= count($cart) ?></b> មុខ</p>
<table>
    <tr><th>#</th><th>ទំនិញ</th><th>តម្លៃ</th><th>ចំនួន</th><th>សរុប</th></tr>
    <?php foreach ($cart as $i => $item): ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($item["title"]) ?></td>
        <td><?= number_format($item["price"], 2) ?> $</td>
        <td><?= $item["qty"] ?></td>
        <td><?= number_format($item["price"] * $item["qty"], 2) ?> $</td>
    </tr>
    <?php endforeach; ?>
    <tr><th colspan="4">សរុបទាំងអស់</th><th><?= number_format(cartTotal($cart), 2) ?> $</th></tr>
</table>
<p>មាន "Keyboard" ក្នុងកន្ត្រក? <b><?= hasProduct($cart, "Keyboard") ? "មាន" : "គ្មាន" ?></b></p>
<p>មាន "Printer" ក្នុងកន្ត្រក? <b><?= hasProduct($cart, "Printer") ? "មាន" : "គ្មាន" ?></b></p>
</div></body></html>
