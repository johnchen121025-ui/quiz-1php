<?php
/*
 * លំហាត់ទី ៥ : Modular Code (DRY) - មេរៀនទី ៣ (៣.៥)
 * ----------------------------------------------------------------------
 * តម្រូវការ៖
 *  ក. បំបែកកូដជា config.php, functions.php, header.php, footer.php។
 *  ខ. ប្រើ require_once សម្រាប់ config & functions, require សម្រាប់ header, include សម្រាប់ footer។
 *  គ. បង្កើតទំព័រ index.php និង about.php ដែលប្រើ Header/Footer រួមគ្នា (គោលការណ៍ DRY)។
 *  ឃ. Navbar ត្រូវបង្ហាញ class "active" ស្វ័យប្រវត្តិ តាមទំព័របច្ចុប្បន្ន។
 */
require_once "config.php";
require_once "functions.php";
$pageTitle = "ទំព័រដើម";
require "header.php";
?>
<h2>ស្វាគមន៍មកកាន់៖ <?= APP_NAME ?></h2>
<p>នេះជាទំព័រដើមដែលរៀបចំតាមបែប Modular Architecture។</p>
<p>តម្លៃថ្លៃសិក្សា៖ <b><?= formatMoney(450) ?></b></p>
<?php include "footer.php"; ?>
