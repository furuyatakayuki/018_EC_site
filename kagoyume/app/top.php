<?php
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';

session_start();
?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>かごゆめ</title>
</head>
<body>
    <h1>かごゆめ</h1><br>
    <h3>かごゆめは日ごろ買いたくても買えないものを好きなだけ買う(気分を味わう)ことができるショッピングサイトです。<br>
    買い物かごにゆめを詰め込みましょう！<br></h3>
    <form action="<?php echo SEARCH ?>" method="get">
        キーワード検索:<br>
        <input type="text" name="query">
        <input type="submit" value="ゆめかご検索"/>
    </form>
    <?php echo return_top(); ?>
</body>
</html>