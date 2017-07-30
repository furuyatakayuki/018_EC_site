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
    <title>登録内容確認</title>
</head>
<body>
    <?php
    if (!$_POST["mode"] == "CONFIRM") {
        echo "アクセスルートが不正です。<br>もう一度やり直してください";
    } else {
        $isset_user = login_check($_POST["registration_mail"]);
        $confirm_values = array(
            "registration_name" => bind_p2s("registration_name"),
            "registration_pass" => bind_p2s("registration_pass"),
            "registration_mail" => bind_p2s("registration_mail"),
            "registration_address" => bind_p2s("registration_address")
            );
        if (!in_array(null, $confirm_values, true) && count($isset_user) == 0){
            ?>
            <h1>登録内容確認</h1><br>
            ユーザ名：<?php echo $confirm_values["registration_name"] ?><br>
            パスワード：<?php echo str_pad("", mb_strlen($_SESSION["registration_pass"]), "*") ;?><br>
            メールアドレス：<?php echo $confirm_values["registration_mail"] ?><br>
            住所：<?php echo $confirm_values["registration_address"] ?><br><br>
            上記の内容で登録いたします。<br>よろしいですか？<br>
            <form action="<?php echo REGISTRATION_COMPLETE ?>" method="post">
                <input type="hidden" name="mode" value="COMPLETE">
                <input type="submit" name="yes" value="はい" style="width:100px">
            </form>
            <form action="<?php echo REGISTRATION ?>" method="post">
                <input type="hidden" name="mode" value="REINPUT">
                <input type="submit" name="no" value="いいえ" style="width:100px">
            </form>
            <?php
        } else {
            ?>
            <h1>入力項目が不完全です</h1><br>
            下記の項目を入力してください<br>
            <h3>再入力項目</h3>
            <?php
            if ($confirm_values["registration_name"] == null) {
                echo "・ユーザ名<br>";
            }
            if ($confirm_values["registration_pass"] == null) {
                echo "・パスワード<br>";
            }
            if ($confirm_values["registration_mail"] == null || count($isset_user) != 0) {
                echo "・メールアドレス";
                if (count($isset_user) != 0){
                    echo "(使用できないメールアドレスです)<br>";
                }
                echo "<br>";
            }
            if ($confirm_values["registration_address"] == null) {
                echo "・住所<br>";
            }
            ?>
            <form action="<?php echo REGISTRATION ?>" method="post">
                <input type="hidden" name="mode" value="REINPUT">
                <input type="submit" name="return" value="登録画面に戻る">
            </form>
            <?php
        }
    }

    ?>
    <?php echo return_top(); ?>
</body>
</html>