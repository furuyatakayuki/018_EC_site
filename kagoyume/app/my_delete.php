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
    <title>退会ページ</title>
</head>
<body>
    <?php
    $user_data = get_my_data($_SESSION["login_id"]);
    
    if (is_array($user_data) && (count($user_data > 0))){
        echo "ユーザ名：" . $user_data[0]["name"] . "<br>";
        echo "パスワード：" . str_pad("", mb_strlen($user_data[0]["password"]), "*") . "<br>";
        echo "メールアドレス：" . $user_data[0]["mail"] . "<br>";
        echo "住所：" . $user_data[0]["address"] . "<br>";
        echo "合計購買金額：￥" . $user_data[0]["total"] . "<br>";
        echo "登録日時：" . $user_data[0]["newDate"] . "<br>";

        echo "このユーザをマジで削除しますか？<br>";
        ?>
        <form action="<?php echo MY_DELETE_RESULT ?>" method="post">
            <input type="hidden" name="mode" value="DELETE">
            <input type="submit" name="btnsubmit" value="はい">
        </form>
        <form action="<?php echo TOP_URL ?>" method="post">
            <input type="submit" name="no" value="いいえ">
        </form>
        <?php
    } else {
        echo "エラーです。<br>" . $user_data . "<br>";
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>