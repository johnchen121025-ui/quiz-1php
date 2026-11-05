<?php
/*
 * លំហាត់ទី ៦ : HTTP GET & $_GET - មេរៀនទី ៤ (៤.១.១)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. បង្កើត Form ស្វែងរកមុខវិជ្ជា (method="GET") មាន input q និង select cat។
 *  ខ. ប្រើ $_GET ជាមួយ ?? ដើម្បីទទួលតម្លៃ (q ទទេ, cat = 'all')។
 *  គ. ត្រង (filter) បញ្ជីមុខវិជ្ជាតាម Keyword និងប្រភេទ ហើយបង្ហាញលទ្ធផល។
 *  ឃ. ត្រូវប្រើ htmlspecialchars() នៅពេល echo ទិន្នន័យ។ សង្កេតមើល URL ថាមាន ?q=...&cat=...
 */
declare(strict_types=1);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$courses = [
    ["title" => "PHP & MySQL",       "cat" => "web"],
    ["title" => "JavaScript Basics", "cat" => "web"],
    ["title" => "Python for Data",   "cat" => "data"],
    ["title" => "SQL Fundamentals",  "cat" => "data"],
    ["title" => "Computer Network",  "cat" => "network"],
];

$keyword  = trim($_GET['q'] ?? '');
$category = $_GET['cat'] ?? 'all';

$results = array_filter($courses, function (array $c) use ($keyword, $category): bool {
    $matchKeyword  = ($keyword === '') || (stripos($c['title'], $keyword) !== false);
    $matchCategory = ($category === 'all') || ($c['cat'] === $category);
    return $matchKeyword && $matchCategory;
});
?>
<!DOCTYPE html>
<html lang="km"><head><meta charset="UTF-8"><title>Ex06</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="box">
<h2>លំហាត់ទី ៦ : GET Search Form</h2>
<form method="GET" action="<?= e($_SERVER['PHP_SELF']) ?>">
    <label>Keyword</label>
    <input type="text" name="q" value="<?= e($keyword) ?>" placeholder="ស្វែងរក...">
    <label>ប្រភេទ</label>
    <select name="cat">
        <option value="all"     <?= $category==='all'?'selected':'' ?>>ទាំងអស់</option>
        <option value="web"     <?= $category==='web'?'selected':'' ?>>Web</option>
        <option value="data"    <?= $category==='data'?'selected':'' ?>>Data</option>
        <option value="network" <?= $category==='network'?'selected':'' ?>>Network</option>
    </select>
    <button type="submit">ស្វែងរក</button>
</form>

<?php if ($keyword !== '' || $category !== 'all'): ?>
    <p>លទ្ធផលសម្រាប់៖ <b><?= e($keyword) ?></b> (ប្រភេទ៖ <?= e($category) ?>) - រកឃើញ <?= count($results) ?> មុខ</p>
<?php endif; ?>
<ul>
    <?php foreach ($results as $c): ?>
        <li><?= e($c['title']) ?> <small>[<?= e($c['cat']) ?>]</small></li>
    <?php endforeach; ?>
    <?php if (!$results): ?><li class="error">មិនមានលទ្ធផលឡើយ!</li><?php endif; ?>
</ul>
</div></body></html>
