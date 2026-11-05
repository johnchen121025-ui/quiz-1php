<?php
require_once "config.php";
require_once "functions.php";
$pageTitle = "អំពីយើង";
require "header.php";
?>
<h2>អំពីយើង</h2>
<p><?= e("សាកលវិទ្យាល័យអង្គរ - Faculty of Science & Technology") ?></p>
<p>ថ្លៃឯកសារ៖ <b><?= formatMoney(15000, "៛") ?></b></p>
<?php include "footer.php"; ?>
