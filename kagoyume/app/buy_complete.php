<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
require_once '../util/defineUtil.php';

session_start();

// ログインチェック
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
    <title>購入</title>
</head>
<body>
    <?php
    if (!$_POST["mode"] == "COMPLETE") {
        echo "アクセスルートが不正です。もう一度やり直してください。<br>";
    } else {
        $result = buy_complete($_SESSION["login_id"], $_SESSION["cart_Item_" . $_SESSION["login_id"]], $_POST["sendding"]);

        if ($result == null) {
            $total_result = total_price($_SESSION["login_id"], $_POST["price"]);
            if ($total_result == null) {
                // カートの初期化
                $_SESSION["cart_Item_" . $_SESSION["login_id"]] = array();
                $_SESSION["cart_Name_" . $_SESSION["login_id"]] = array();
                $_SESSION["cart_Price_" . $_SESSION["login_id"]] = array();
                $_SESSION["cart_Image_" . $_SESSION["login_id"]] = array();
                $_SESSION["cart_date_" . $_SESSION["login_id"]] = array();
                echo "購入が完了しました。<br>";
            } else {
                echo "エラーです<br>" . $total_result . "<br>";
            }
        } else {
            echo "エラーです。<br>" . $result . "<br>";
        }
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>