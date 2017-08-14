<?php
require_once "../util/defineUtil.php";
require_once "../util/scriptUtil.php";
require_once "../util/dbaccesUtil.php";

session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>登録結果</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>

    <?php
    if (!isset($_POST["mode"]) || !$_POST["mode"] == "COMPLETE"){
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>
        <?php
    } else {
        $result = insert_users($_SESSION["registration_name"], password_hash($_SESSION["registration_pass"], PASSWORD_DEFAULT), $_SESSION["registration_mail"], $_SESSION["registration_address"]);

        if (!isset($result)) {
            ?>
            <h1 class="text-center">登録結果</h1>
            <div class="container">
                <div class="col-md-offset-4 col-md-4 panel panel-default">
                    <div class="panel-body text-center">
                        <p>名前：<?php echo $_SESSION["registration_name"] ;?></p>
                        <p>パスワード：<?php echo str_pad("", mb_strlen($_SESSION["registration_pass"]), "*") ;?></p>
                        <p>メールアドレス：<?php echo $_SESSION["registration_mail"] ;?></p>
                        <p>住所：<?php echo $_SESSION["registration_address"] ;?></p>
                        <hr>
                        <p>以上の内容で登録しました。</p>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="alert-danger h4 text-center"><p style="padding: 10px;"><p><?php echo "データの挿入に失敗しました。<br>時期のエラーによって処理を中断します：" . $result; ?></p></div>
            <?php
        }
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>