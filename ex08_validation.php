<?php
/*
 * លំហាត់ទី ៨ : Server-Side Validation (trim, empty, strlen, filter_var) - មេរៀនទី ៤ (៤.២.១ & ៤.២.២)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖ Form "ចុះឈ្មោះសម្រាប់ព្រឹត្តិការណ៍" មាន fullname, email, age, website
 *  - fullname : ត្រូវបំពេញ និងមានយ៉ាងតិច ៣ តួអក្សរ (ប្រើ trim + empty + mb_strlen)
 *  - email    : ត្រូវតែជាទម្រង់អ៊ីមែលត្រឹមត្រូវ  (FILTER_VALIDATE_EMAIL)
 *  - age      : ជាចំនួនគត់ ពី 16 ដល់ 60 (FILTER_VALIDATE_INT ជាមួយ options min_range/max_range)
 *  - website  : មិនបង្ខំ តែបើបំពេញ ត្រូវតែជា URL ត្រឹមត្រូវ (FILTER_VALIDATE_URL)
 *  - ប្រើ $errors Associative Array បង្ហាញ Error ក្រោម Input នីមួយៗ និង Sticky Values។
 *  - ចំណាំ៖ ប្រៀបធៀបលទ្ធផល filter_var() ជាមួយ === false ជានិច្ច។
 */
declare(strict_types=1);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$errors = [];
$fullname = $email = $age = $website = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $age      = trim($_POST['age'] ?? '');
    $website  = trim($_POST['website'] ?? '');

    // fullname
    if (empty($fullname)) {
        $errors['fullname'] = "សូមបញ្ចូលឈ្មោះពេញរបស់អ្នក!";
    } elseif (mb_strlen($fullname) < 3) {
        $errors['fullname'] = "ឈ្មោះត្រូវមានប្រវែងយ៉ាងតិច ៣ តួអក្សរ!";
    }

    // email
    if (empty($email)) {
        $errors['email'] = "សូមបញ្ចូលអ៊ីមែល!";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "ទម្រង់អាសយដ្ឋានអ៊ីមែលមិនត្រឹមត្រូវឡើយ!";
    }

    // age (range 16-60)
    $ageCheck = filter_var($age, FILTER_VALIDATE_INT, ["options" => ["min_range" => 16, "max_range" => 60]]);
    if ($ageCheck === false) {
        $errors['age'] = "អាយុត្រូវតែជាចំនួនគត់ ចន្លោះពី 16 ដល់ 60!";
    }

    // website (optional)
    if ($website !== '' && filter_var($website, FILTER_VALIDATE_URL) === false) {
        $errors['website'] = "URL មិនត្រឹមត្រូវ (ឧ. https://example.com)!";
    }

    $success = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex08</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ៨ : Validation Form</h2>
<?php if ($success): ?>
    <div class="ok">✓ ទិន្នន័យត្រឹមត្រូវទាំងអស់! សូមស្វាគមន៍ <b><?= e($fullname) ?></b> (<?= e($email) ?>)</div>
<?php endif; ?>
<form method="POST" action="<?= e($_SERVER['PHP_SELF']) ?>" novalidate>
    <label>ឈ្មោះពេញ</label>
    <input type="text" name="fullname" value="<?= e($fullname) ?>">
    <span class="error"><?= $errors['fullname'] ?? '' ?></span>

    <label>អ៊ីមែល</label>
    <input type="text" name="email" value="<?= e($email) ?>">
    <span class="error"><?= $errors['email'] ?? '' ?></span>

    <label>អាយុ</label>
    <input type="text" name="age" value="<?= e($age) ?>">
    <span class="error"><?= $errors['age'] ?? '' ?></span>

    <label>Website (មិនបង្ខំ)</label>
    <input type="text" name="website" value="<?= e($website) ?>">
    <span class="error"><?= $errors['website'] ?? '' ?></span>

    <button type="submit">ចុះឈ្មោះ</button>
</form>
</div></body></html>
