<?php
/*
 * លំហាត់ទី ២ : Function Return Value - មេរៀនទី ៣ (៣.៣.២)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. getAcademicYear(): string  (គ្មាន Parameter) ប្រគល់ "ឆ្នាំសិក្សា 2025-2026"។
 *  ខ. calculateFinalScore(float $midterm, float $final): float
 *     ពិន្ទុសរុប = Midterm × 40% + Final × 60%
 *  គ. getGrade(float $score): string  ប្រគល់ A (>=85), B (>=70), C (>=50), F (ក្រៅពីនោះ)
 *  ឃ. ហៅ function ទាំងអស់ រួចបង្ហាញលទ្ធផលក្នុងតារាងសម្រាប់និស្សិត ៣ នាក់។
 */
declare(strict_types=1);

function getAcademicYear(): string {
    $startYear = 2025;
    $endYear = 2026;
    return "ឆ្នាំសិក្សា {$startYear}-{$endYear}";
}

function calculateFinalScore(float $midterm, float $final): float {
    return ($midterm * 0.40) + ($final * 0.60);
}

function getGrade(float $score): string {
    if ($score >= 85) return "A";
    if ($score >= 70) return "B";
    if ($score >= 50) return "C";
    return "F";
}

$students = [
    ["name" => "សុខ ជា",     "mid" => 85.0, "final" => 90.0],
    ["name" => "កែវ ណារ៉ា",   "mid" => 60.0, "final" => 72.0],
    ["name" => "ចាន់ ដារា",   "mid" => 40.0, "final" => 45.0],
];
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex02</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ២ : Return Value Functions</h2>
<p>ព័ត៌មាន៖ <?= getAcademicYear() ?></p>
<table>
    <tr><th>ឈ្មោះ</th><th>Midterm</th><th>Final</th><th>ពិន្ទុសរុប</th><th>និទ្ទេស</th></tr>
    <?php foreach ($students as $s):
        $total = calculateFinalScore($s["mid"], $s["final"]); ?>
    <tr>
        <td><?= htmlspecialchars($s["name"]) ?></td>
        <td><?= $s["mid"] ?></td>
        <td><?= $s["final"] ?></td>
        <td><?= number_format($total, 2) ?></td>
        <td><?= getGrade($total) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</div></body></html>
