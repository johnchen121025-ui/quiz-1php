<?php
/*
 * លំហាត់ទី ៩ : Sticky Multi-Controls (Radio, Select, Checkbox Array, Textarea) - មេរៀនទី ៤ (៤.២.៣ & ៤.២.៤)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖ Form "ពាក្យសុំចូលរៀន"
 *  - gender  : Radio (male/female)       → checked
 *  - degree  : Select (CS/IT/BA)         → selected
 *  - skills[]: Checkbox Array            → in_array() + checked
 *  - note    : Textarea                  → ដាក់តម្លៃចន្លោះ Tag
 *  - ត្រូវជ្រើស Skill យ៉ាងតិច ១ ហើយបើមាន Error ត្រូវរក្សាតម្លៃទាំងអស់ (Sticky)។
 */
declare(strict_types=1);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$allSkills = ["PHP", "JavaScript", "SQL", "HTML/CSS"];
$degrees   = ["CS" => "Computer Science", "IT" => "Information Technology", "BA" => "Business Administration"];

$gender = $_POST['gender'] ?? 'male';
$degree = $_POST['degree'] ?? '';
$skills = $_POST['skills'] ?? [];
$note   = trim($_POST['note'] ?? '');
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!array_key_exists($degree, $degrees)) $errors['degree'] = "សូមជ្រើសរើសជំនាញ!";
    if (count($skills) === 0)                  $errors['skills'] = "សូមជ្រើសរើស Skill យ៉ាងតិច ១!";
    $success = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex09</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ៩ : Sticky Controls</h2>
<?php if ($success): ?>
    <div class="ok">✓ ទទួលពាក្យសុំ៖ <?= e($degrees[$degree]) ?> | Skills: <?= e(implode(", ", $skills)) ?></div>
<?php endif; ?>
<form method="POST" action="<?= e($_SERVER['PHP_SELF']) ?>">
    <label>ភេទ</label>
    <input type="radio" name="gender" value="male"   <?= $gender==='male'  ?'checked':'' ?>> ប្រុស
    <input type="radio" name="gender" value="female" <?= $gender==='female'?'checked':'' ?>> ស្រី

    <label>ជំនាញ</label>
    <select name="degree">
        <option value="">-- ជ្រើសរើស --</option>
        <?php foreach ($degrees as $code => $label): ?>
            <option value="<?= e($code) ?>" <?= $degree===$code?'selected':'' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
    </select>
    <span class="error"><?= $errors['degree'] ?? '' ?></span>

    <label>Skills</label>
    <?php foreach ($allSkills as $s): ?>
        <label style="font-weight:normal;display:inline-block;margin-right:12px">
            <input type="checkbox" name="skills[]" value="<?= e($s) ?>" <?= in_array($s, $skills) ? 'checked' : '' ?>> <?= e($s) ?>
        </label>
    <?php endforeach; ?>
    <div class="error"><?= $errors['skills'] ?? '' ?></div>

    <label>កំណត់ចំណាំ</label>
    <textarea name="note" rows="3"><?= e($note) ?></textarea>

    <button type="submit">បញ្ជូន</button>
</form>
</div></body></html>
