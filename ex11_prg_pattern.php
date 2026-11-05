<?php
/*
 * លំហាត់ទី ១១ : PRG Pattern (Post/Redirect/Get) - មេរៀនទី ៤ (៤.៤.២)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖ Form "Subscribe Newsletter"
 *  ក. ទទួល email តាម POST ហើយ Validate (trim, empty, FILTER_VALIDATE_EMAIL)។
 *  ខ. បើគ្មាន Error → header("Location: ...?status=success"); exit();
 *  គ. header() ត្រូវតែរត់ មុន ពេលមាន HTML ណាមួយចេញ (កុំឱ្យមាន "headers already sent")។
 *  ឃ. បង្ហាញសារជោគជ័យពី $_GET['status'] ហើយសាកល្បងចុច F5 ថាគ្មាន "Confirm Form Resubmission"។
 */
declare(strict_types=1);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$errors = [];
$email = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $errors['email'] = "សូមបញ្ចូលអ៊ីមែល!";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "ទម្រង់អ៊ីមែលមិនត្រឹមត្រូវ!";
    }

    if (empty($errors)) {
        // (នៅទីនេះ គឺជាកន្លែងរក្សាទុកទិន្នន័យចូល Database)
        header("Location: " . $_SERVER['PHP_SELF'] . "?status=success");
        exit(); // ត្រូវតែដាក់ exit() ជានិច្ចបន្ទាប់ពី header()
    }
}
$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex11</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ១១ : PRG Pattern</h2>
<?php if ($status === 'success'): ?>
    <div class="ok">✓ ការចុះឈ្មោះត្រូវបានរក្សាទុកដោយជោគជ័យ! (ព្យាយាមចុច F5 - គ្មាន Warning ឡើយ)</div>
<?php endif; ?>
<form method="POST" action="<?= e($_SERVER['PHP_SELF']) ?>">
    <label>អ៊ីមែល</label>
    <input type="text" name="email" value="<?= e($email) ?>" placeholder="sok@gmail.com">
    <span class="error"><?= $errors['email'] ?? '' ?></span>
    <button type="submit">Subscribe</button>
</form>
</div></body></html>
