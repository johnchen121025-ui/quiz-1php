<?php
// ឯកសារ Helper Functions - ហៅដោយ require_once
declare(strict_types=1);

function e(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function formatMoney(float $amount, string $symbol = "$"): string {
    return number_format($amount, 2) . " " . $symbol;
}

function isActive(string $page): string {
    return basename($_SERVER['PHP_SELF']) === $page ? "active" : "";
}
