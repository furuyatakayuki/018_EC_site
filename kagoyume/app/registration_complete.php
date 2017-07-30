<?php
require_once "../util/defineUtil.php";
require_once "../util/scriptUtil.php";
require_once "../util/dbaccesUtil.php";

session_start();
?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>登録結果</title>
</head>
<body>
    <?php
    if (!$_POST["mode"] == "COMPLETE"){
        echo "アクセスルートが不正です。<br>もう一度やり直してください。<br>";
    } else {
        $result = insert_users($_SESSION["registration_name"], $_SESSION["registration_pass"], $_SESSION["registration_mail"], $_SESSION["registration_address"]);

        if (!isset($result)) {
            ?>
            <h1>登録結果</h1><br>
            名前：<?php echo $_SESSION["registration_name"] ;?><br>
            パスワード：<?php echo str_pad("", mb_strlen($_SESSION["registration_pass"]), "*") ;?><br>
            メールアドレス：<?php echo $_SESSION["registration_mail"] ;?><br>
            住所：<?php echo $_SESSION["registration_address"] ;?><br><br>
            以上の内容で登録しました。<br>
            <?php
        } else {
            echo "データの挿入に失敗しました。<br>時期のエラーによって処理を中断します：" . $result . "<br>";
        }
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>