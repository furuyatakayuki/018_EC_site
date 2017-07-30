<?php
require_once "../util/defineUtil.php";
require_once "../util/scriptUtil.php";
require_once "../util/dbaccesUtil.php";

session_start();
if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
    $user_data = get_my_data($_SESSION["login_id"]);
    if (is_array($user_data) && (count($user_data) > 0)){
    } else {
        echo "エラーです。<br>" . $user_data . "<br>";
        exit;
    }
} else {
    echo "ログインしてください<br>";
    exit;
}

?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>会員情報の更新</title>
</head>
<body>
    <form action="<?php echo MY_UPDATE_RESULT ?>" method="post">
        ユーザ名：<br>
        <input type="text" name="update_name" value="<?php echo $user_data[0]["name"] ?>">
        <br><br>

        パスワード：<br>
        <input type="text" name="update_pass" value="<?php echo $user_data[0]["password"] ?>" autocomplete="off">
        <br><br>

        メールアドレス：<br>
        <input type="text" name="update_mail" value="<?php echo $user_data[0]["mail"] ?>">
        <br><br>

        住所：<br>
        <input type="text" name="update_address" value="<?php echo $user_data[0]["address"] ?>">
        <br><br>

        <input type="hidden" name="mode" value="UPDATE">
        <input type="submit" name="btnsubmit" value="変更を登録">
    </form>
    <?php echo return_top(); ?>
</body>
</html>