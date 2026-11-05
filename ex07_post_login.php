<?php
/*
 * លំហាត់ទី ៧ : HTTP POST & Request Detection - មេរៀនទី ៤ (៤.១.២ & ៤.១.៣)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. បង្កើត Login Form (method="POST") មាន username និង password។
 *  ខ. ប្រើ $_SERVER["REQUEST_METHOD"] === "POST" ដើម្បីបែងចែក GET (បង្ហាញ Form) និង POST (ដំណើរការ)។
 *  គ. ផ្ទៀងផ្ទាត់ជាមួយ username = "lim_admin", password = "au@2026"។
 *  ឃ. បង្ហាញសារជោគជ័យ/បរាជ័យ។ ហាមធ្វើ Sticky លើ password។
 *  ង. ប៊ូតុង Submit មិនត្រូវពឹងលើ isset($_POST['submit']) ឡើយ។
 */
declare(strict_types=1);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$username = '';
$message  = '';
$success  = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === "lim_admin" && $password === "au@2026") {
        $success = true;
        $message = "ចូលប្រព័ន្ធជោគជ័យ! សួស្តី " . e($username);
    } else {
        $message = "ឈ្មោះអ្នកប្រើ ឬលេខសម្ងាត់មិនត្រឹមត្រូវ!";
    }
}
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex07</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ៧ : POST Login Form</h2>
<form method="POST" action="<?= e($_SERVER['PHP_SELF']) ?>">
    <label>ឈ្មោះអ្នកប្រើ</label>
    <input type="text" name="username" value="<?= e($username) ?>">
    <label>លេខសម្ងាត់</label>
    <input type="password" name="password">
    <button type="submit">ចូលប្រព័ន្ធ (Login)</button>
</form>
<?php if ($message): ?>
    <div class="<?= $success ? 'ok' : 'warn' ?>"><?= $message ?></div>
<?php endif; ?>
<p><small>Request Method បច្ចុប្បន្ន៖ <b><?= e($_SERVER['REQUEST_METHOD']) ?></b></small></p>
</div></body></html>
