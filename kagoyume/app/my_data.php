<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
require_once '../util/defineUtil.php';

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
    <title>マイページ</title>
</head>
<body>
    <?php
    echo "<br>";
    $user_data = get_my_data($_SESSION["login_id"]);

    if (is_array($user_data) && (count($user_data > 0))){
        echo "ユーザ名：" . $user_data[0]["name"] . "<br>";
        echo "パスワード：" . str_pad("", mb_strlen($user_data[0]["password"]), "*") . "<br>";
        echo "メールアドレス：" . $user_data[0]["mail"] . "<br>";
        echo "住所：" . $user_data[0]["address"] . "<br>";
        echo "合計購買金額：￥" . $user_data[0]["total"] . "<br>";
        echo "登録日時：" . $user_data[0]["newDate"] . "<br>";
    } else {
        echo "エラーです。<br>" . $user_data . "<br>";
    }
    ?>
    <!-- 購入履歴 -->
    <form action="<?php echo MY_HISTORY ?>" method="post">
        <input type="submit" name="history" value="購入履歴">
    </form>
    <!-- 登録情報の更新 -->
    <form action="<?php echo MY_UPDATE ?>" method="post">
        <input type="submit" name="update" value="登録情報の変更">
    </form>
    <br>
    <!-- 退会処理 -->
    <form action="<?php echo MY_DELETE ?>" method="post">
        <input type="submit" name="delete" value="退会">
    </form>
    <br>
    <?php echo return_top(); ?>
</body>
</html>