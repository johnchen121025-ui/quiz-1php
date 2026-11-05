<?php
/*
 * លំហាត់ទី ១២ (Capstone) : Student Registration - រួមបញ្ចូល Functions + Form
 * ----------------------------------------------------------------------
 * ប្រើបច្ចេកទេសពីមេរៀនទី ៣ និងទី ៤៖
 *  - Functions ដែលមាន Type + Return   : e(), cleanInput(), validateRegistration(), calcTuition()
 *  - Arrow Function                    : $isKhmerName
 *  - Single-File Form Architecture     : Define → POST? → Validate → Render
 *  - Sticky (text, radio, select, checkbox[]) + $errors Array
 *  - Security : htmlspecialchars(ENT_QUOTES), filter_var, trim
 *  - PRG Pattern : redirect ទៅ ?status=success រួចបង្ហាញបង្កាន់ដៃ (រក្សាក្នុង $_GET)
 *  តម្រូវការ៖
 *   fullname (>=3), email (valid), age (16-60), gender, degree, courses[] (>=1), password (>=8, មិន Sticky)
 *   ថ្លៃសិក្សា = ថ្លៃមុខវិជ្ជា × ចំនួន Course (បញ្ចុះតម្លៃ 10% បើជ្រើស ≥ 3 មុខ)
 */
declare(strict_types=1);

const COURSES = ["PHP" => 120.0, "SQL" => 100.0, "JavaScript" => 110.0, "Laravel" => 150.0];
const DEGREES = ["CS" => "Computer Science", "IT" => "Information Technology"];

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function cleanInput(?string $v): string {
    return trim($v ?? '');
}

function calcTuition(array $selected, float $discountRate = 0.10): float {
    $total = 0.0;
    foreach ($selected as $c) {
        $total += COURSES[$c] ?? 0.0;
    }
    return count($selected) >= 3 ? $total * (1 - $discountRate) : $total;
}

function validateRegistration(array $d): array {
    $errors = [];
    if ($d['fullname'] === '')                 $errors['fullname'] = "សូមបញ្ចូលឈ្មោះពេញ!";
    elseif (mb_strlen($d['fullname']) < 3)     $errors['fullname'] = "ឈ្មោះយ៉ាងតិច ៣ តួអក្សរ!";

    if (filter_var($d['email'], FILTER_VALIDATE_EMAIL) === false) $errors['email'] = "អ៊ីមែលមិនត្រឹមត្រូវ!";

    $age = filter_var($d['age'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 16, "max_range" => 60]]);
    if ($age === false)                        $errors['age'] = "អាយុត្រូវជាចំនួនគត់ 16-60!";

    if (!isset(DEGREES[$d['degree']]))         $errors['degree'] = "សូមជ្រើសរើសជំនាញ!";
    if (!in_array($d['gender'], ['male', 'female'], true)) $errors['gender'] = "សូមជ្រើសរើសភេទ!";
    if (count($d['courses']) === 0)            $errors['courses'] = "ជ្រើសរើសមុខវិជ្ជាយ៉ាងតិច ១!";
    if (strlen($d['password']) < 8)            $errors['password'] = "លេខសម្ងាត់យ៉ាងតិច ៨ តួអក្សរ!";
    return $errors;
}

// Arrow function: ត្រួតពិនិត្យថាតើមានអក្សរខ្មែរក្នុងឈ្មោះឬអត់
$hasKhmer = fn(string $s): bool => preg_match('/\p{Khmer}/u', $s) === 1;

// ---------- 1. Define ----------
$data = ['fullname' => '', 'email' => '', 'age' => '', 'gender' => 'male', 'degree' => '', 'courses' => [], 'password' => ''];
$errors = [];

// ---------- 2. Process POST ----------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data['fullname'] = cleanInput($_POST['fullname'] ?? '');
    $data['email']    = cleanInput($_POST['email'] ?? '');
    $data['age']      = cleanInput($_POST['age'] ?? '');
    $data['gender']   = $_POST['gender'] ?? '';
    $data['degree']   = $_POST['degree'] ?? '';
    $data['courses']  = array_values(array_filter((array)($_POST['courses'] ?? []), fn($c) => isset(COURSES[$c])));
    $data['password'] = $_POST['password'] ?? '';

    $errors = validateRegistration($data);

    if (empty($errors)) {
        $query = http_build_query([
            'status' => 'success',
            'name'   => $data['fullname'],
            'total'  => calcTuition($data['courses']),
            'n'      => count($data['courses']),
        ]);
        header("Location: " . $_SERVER['PHP_SELF'] . "?" . $query);   // PRG
        exit();
    }
}
$isSuccess = ($_GET['status'] ?? '') === 'success';
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex12</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ១២ : ចុះឈ្មោះនិស្សិត (Capstone)</h2>

<?php if ($isSuccess): ?>
    <div class="ok">
        ✓ ចុះឈ្មោះជោគជ័យ!<br>
        និស្សិត៖ <b><?= e($_GET['name'] ?? '') ?></b><br>
        ចំនួនមុខវិជ្ជា៖ <?= (int)($_GET['n'] ?? 0) ?> |
        ថ្លៃសិក្សា៖ <b><?= number_format((float)($_GET['total'] ?? 0), 2) ?> $</b>
    </div>
    <p><a href="<?= e($_SERVER['PHP_SELF']) ?>">← ចុះឈ្មោះម្នាក់ទៀត</a></p>
<?php else: ?>
<form method="POST" action="<?= e($_SERVER['PHP_SELF']) ?>" novalidate>
    <label>ឈ្មោះពេញ</label>
    <input type="text" name="fullname" value="<?= e($data['fullname']) ?>">
    <span class="error"><?= $errors['fullname'] ?? '' ?></span>
    <?php if ($data['fullname'] !== '' && $hasKhmer($data['fullname'])): ?><small>✓ ឈ្មោះជាអក្សរខ្មែរ</small><?php endif; ?>

    <label>អ៊ីមែល</label>
    <input type="text" name="email" value="<?= e($data['email']) ?>">
    <span class="error"><?= $errors['email'] ?? '' ?></span>

    <label>អាយុ</label>
    <input type="text" name="age" value="<?= e($data['age']) ?>">
    <span class="error"><?= $errors['age'] ?? '' ?></span>

    <label>ភេទ</label>
    <input type="radio" name="gender" value="male"   <?= $data['gender']==='male'  ?'checked':'' ?>> ប្រុស
    <input type="radio" name="gender" value="female" <?= $data['gender']==='female'?'checked':'' ?>> ស្រី
    <span class="error"><?= $errors['gender'] ?? '' ?></span>

    <label>ជំនាញ</label>
    <select name="degree">
        <option value="">-- ជ្រើសរើស --</option>
        <?php foreach (DEGREES as $k => $v): ?>
            <option value="<?= e($k) ?>" <?= $data['degree']===$k?'selected':'' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
    </select>
    <span class="error"><?= $errors['degree'] ?? '' ?></span>

    <label>មុខវិជ្ជា (ជ្រើស ≥ 3 បញ្ចុះតម្លៃ 10%)</label>
    <?php foreach (COURSES as $name => $price): ?>
        <label style="font-weight:normal">
            <input type="checkbox" name="courses[]" value="<?= e($name) ?>" <?= in_array($name, $data['courses'], true)?'checked':'' ?>>
            <?= e($name) ?> - <?= number_format($price, 2) ?> $
        </label>
    <?php endforeach; ?>
    <span class="error"><?= $errors['courses'] ?? '' ?></span>

    <label>លេខសម្ងាត់ (មិនធ្វើ Sticky)</label>
    <input type="password" name="password">
    <span class="error"><?= $errors['password'] ?? '' ?></span>

    <button type="submit">ចុះឈ្មោះ</button>
</form>
<?php endif; ?>
</div></body></html>
