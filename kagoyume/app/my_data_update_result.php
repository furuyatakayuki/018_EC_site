<?php
require_once "../util/scriptUtil.php";
require_once "../util/dbaccesUtil.php";

session_start();
if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
} else {
    echo "ログインしてください<br>";
    exit;
}
?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>登録結果</title>
</head>
<body>
    <?php
    if (!$_POST["mode"] == "UPDATE"){
        echo "アクセスルートが不正です。<br>もう一度やり直してください。<br>";
    } else {
        $result = update_users($_SESSION["login_id"], $_POST["update_name"], $_POST["update_pass"], $_POST["update_mail"], $_POST["update_address"]);

        if (!isset($result)) {
            // 更新成功時、ログイン中の名称も変更する。
            $_SESSION["login_name"] = $_POST["update_name"];
            ?>
            <h1>更新結果結果</h1><br>
            名前：<?php echo $_POST["update_name"] ;?><br>
            パスワード：<?php echo str_pad("", mb_strlen($_POST["update_pass"]), "*") ;?><br>
            メールアドレス：<?php echo $_POST["update_mail"] ;?><br>
            住所：<?php echo $_POST["update_address"] ;?><br><br>
            以上の内容で更新しました。<br>
            <?php
        } else {
            echo "データの挿入に失敗しました。<br>時期のエラーによって処理を中断します：" . $result . "<br>";
        }
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>