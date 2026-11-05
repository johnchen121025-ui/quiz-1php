<?php
/*
 * លំហាត់ទី ១០ : XSS Defense & Sanitization - មេរៀនទី ៤ (៤.៣)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖ ទំព័រ "Guestbook" (សៀវភៅភ្ញៀវ)
 *  ក. ទទួល name និង comment តាម POST។
 *  ខ. ប្រើ filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) សម្អាតអ៊ីមែល។
 *  គ. ប្រើ htmlspecialchars($v, ENT_QUOTES, 'UTF-8') នៅពេល echo ទាំងអស់។
 *  ឃ. សាកល្បងបញ្ចូល  <script>alert('Hacked!')</script>  → ត្រូវបង្ហាញជាអក្សរធម្មតា មិនរត់ Script។
 *  ង. បង្ហាញ "ប្រៀបធៀប" កូដគ្រោះថ្នាក់ (Vulnerable) ធៀបនឹងកូដសុវត្ថិភាព (Secure) ក្នុងតារាង។
 *  ចំណាំ៖ Entries រក្សាក្នុង Array តែក្នុង Request នេះប៉ុណ្ណោះ (មិនមាន Database)។
 */
declare(strict_types=1);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$errors = [];
$name = $comment = $email = '';
$raw = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = trim($_POST['name'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $email   = trim((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    if ($name === '')    $errors['name']    = "សូមបញ្ចូលឈ្មោះ!";
    if ($comment === '') $errors['comment'] = "សូមបញ្ចូលមតិយោបល់!";
    if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "អ៊ីមែលមិនត្រឹមត្រូវ!";
    }
    $raw = $comment;
}
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex10</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ១០ : XSS Defense</h2>
<form method="POST" action="<?= e($_SERVER['PHP_SELF']) ?>">
    <label>ឈ្មោះ</label>
    <input type="text" name="name" value="<?= e($name) ?>">
    <span class="error"><?= $errors['name'] ?? '' ?></span>
    <label>អ៊ីមែល (មិនបង្ខំ)</label>
    <input type="text" name="email" value="<?= e($email) ?>">
    <span class="error"><?= $errors['email'] ?? '' ?></span>
    <label>មតិយោបល់</label>
    <textarea name="comment" rows="3"><?= e($comment) ?></textarea>
    <span class="error"><?= $errors['comment'] ?? '' ?></span>
    <button type="submit">ផ្ញើ</button>
</form>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errors)): ?>
    <h3>លទ្ធផល</h3>
    <table>
        <tr><th>ប្រភេទ</th><th>កូដ</th><th>លទ្ធផលលើ HTML Source</th></tr>
        <tr>
            <td>❌ Vulnerable</td>
            <td><code>echo $comment;</code></td>
            <td><code><?= e($raw) ?></code> <small>(Browser នឹងរត់ប្រសិនបើ echo ដោយផ្ទាល់)</small></td>
        </tr>
        <tr>
            <td>✅ Secure</td>
            <td><code>echo htmlspecialchars($comment, ENT_QUOTES);</code></td>
            <td><?= e($raw) ?></td>
        </tr>
    </table>
    <div class="ok">មតិរបស់ <b><?= e($name) ?></b>៖ <?= e($comment) ?></div>
<?php endif; ?>
</div></body></html>
