<?php
require_once "../util/defineUtil.php";
require_once "../util/scriptUtil.php";

session_start();

?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>新規会員登録</title>
</head>
<body>
    <?php
    if (!$_POST["mode"] == "ADD") {
        echo "アクセスルートが不正です。<br>もう一度やり直してください。<br>";
    } else {
        ?>
    <form action="<?php echo REGISTRATION_CONFIRM ?>" method="post">
        ユーザ名：<br>
        <input type="text" name="registration_name" value="<?php echo form_value('registration_name'); ?>">
        <br><br>

        パスワード：<br>
        <input type="text" name="registration_pass" value="<?php echo form_value('registration_pass'); ?>" autocomplete="off">
        <br><br>

        メールアドレス：<br>
        <input type="text" name="registration_mail" value="<?php echo form_value('registration_mail'); ?>">
        <br><br>

        住所：<br>
        <input type="text" name="registration_address" value="<?php echo form_value('registration_address'); ?>">
        <br><br>

        <input type="hidden" name="mode" value="CONFIRM">
        <input type="submit" name="btnsubmit" value="確認画面へ">
    </form>
    <?php
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>