<?php
/*
 * លំហាត់ទី ១ : Function None Return Value (Void) - មេរៀនទី ៣ (៣.៣.១)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. សរសេរ function showHeaderBanner(): void  (គ្មាន Parameter) បង្ហាញ Banner "ប្រព័ន្ធគ្រប់គ្រងសិស្ស"។
 *  ខ. សរសេរ function printStudentNotice(string $name, string $status): void  (មាន Parameter)។
 *  គ. ហៅ function ក ១ ដង និង function ខ ចំនួន ៣ ដង ជាមួយនិស្សិតខុសៗគ្នា។
 */
declare(strict_types=1);

// (ក) Void - Without Parameter
function showHeaderBanner(): void {
    echo "====================================<br>";
    echo "<h3>ប្រព័ន្ធគ្រប់គ្រងនិស្សិត សាកលវិទ្យាល័យអង្គរ</h3>";
    echo "====================================<br>";
}

// (ខ) Void - With Parameters
function printStudentNotice(string $name, string $status): void {
    echo "ជំរាបសួរ និស្សិត៖ <b>{$name}</b> - ស្ថានភាព៖ {$status}<br>";
}
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex01</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ១ : Void Functions</h2>
<?php
showHeaderBanner();
printStudentNotice("សុខ ជា", "បានចុះឈ្មោះរួចរាល់");
printStudentNotice("កែវ ណារ៉ា", "រង់ចាំការផ្ទៀងផ្ទាត់");
printStudentNotice("ចាន់ ដារា", "បានបង់ថ្លៃសិក្សា");
?>
</div></body></html>
