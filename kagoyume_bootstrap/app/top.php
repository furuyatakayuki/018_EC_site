<?php
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';

session_start();

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>かごゆめ</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<div id="pack">
<?php require_once '../util/header.php'; ?>
    <div id="contents">
    <div class="jumbotron">
        <h1 class="text-center">かごゆめ</h1>
        <h3 class="text-center">かごゆめは日ごろ買いたくても買えないものを好きなだけ買う(気分を味わう)ことができるショッピングサイトです。<br>買い物かごにゆめを詰め込みましょう！</h3>
    </div>

    <div class="container">
        <div class="row row-eq-height">
        <div class="col-md-4 col-md-offset-2 panel panel-default">
            <div class="panel-body text-center">
            <form action="<?php echo SEARCH ?>" method="get">
                キーワード検索:
                <input type="text" name="query">
                <input type="submit" value="かごゆめ検索" class="btn-warning" />
            </form>
            </div>
        </div>

        <div class="col-md-4 panel panel-default">
            <div class="panel-body text-center ">
            <form action="<?php echo LOGIN?>" method="post">
                <input type="submit" value="ログイン" class="btn-warning">
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>

<?php require_once '../util/footer.php' ?>
</div>
</body>
</html>