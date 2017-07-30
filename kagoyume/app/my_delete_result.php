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
    <title>退会完了</title>
</head>
<body>
    <?php
    if (!$_POST["mode"] == "DELETE"){
        echo "アクセスルートが不正です。もう一度やり直してください。<br>";
    } else {
        $result = delete_users($_SESSION["login_id"]);

        if (!isset($result)) {
            $_SESSION = array();
            session_destroy();
            echo "削除しました<br>";
        } else {
            echo "データの削除に失敗しました。<br>次のエラーによって処理を中断します：" . $result . "<br>";
        }
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>