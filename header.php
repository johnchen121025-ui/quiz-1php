<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title><?= e($pageTitle ?? APP_NAME) ?> | <?= APP_NAME ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="box">
    <h1><?= APP_NAME ?></h1>
    <nav>
        <a href="index.php" class="<?= isActive('index.php') ?>">Home</a>
        <a href="about.php" class="<?= isActive('about.php') ?>">About</a>
    </nav>
    <hr>
