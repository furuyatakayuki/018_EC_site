<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
require_once '../util/defineUtil.php';

session_start();

// ログインチェック
if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
} else {
    echo "ログインしてください<br>";
    header("Location: " . LOGIN);
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
    if (!$_POST["mode"] == "CONFIRM") {
        echo "アクセスルートが不正です。もう一度やり直してください。<br>";
    } else {
        ?>
        <table border=1>
            <tr>
                <td>商品名</td>
                <td>価格</td>
            </tr>
            <?php
            $sum_price = 0;
            foreach ($_SESSION["cart_Name_" . $_SESSION["login_id"]] as $key => $value) {
                ?>
                <tr>
                    <td><?php echo $_SESSION["cart_Name_" . $_SESSION["login_id"]][$key]; ?></td>
                    <td>￥<?php echo $_SESSION["cart_Price_" . $_SESSION["login_id"]][$key]; ?></td>
                </tr>
                <?php
                $sum_price += $_SESSION["cart_Price_" . $_SESSION["login_id"]][$key];
            }
            ?>
        </table>
        <p>合計価格：￥<?php echo $sum_price; ?></p>
        <!-- ここに発送方法のラジオボタン -->
        <form action="<?php echo BUY_COMPLETE ?>" method="post">
            発送方法(デフォルトでは通常になります)：
            <input type="radio" name="sendding" value="1" checked>通常発送　
            <input type="radio" name="sendding" value="2">速達発送<br><br>
            <input type="hidden" name="price" value=<?php echo $sum_price ?>>
            <input type="hidden" name="mode" value="COMPLETE">
            <input type="submit" name="btnsubmit" value="上記の内容で購入を確定する">
        </form>
        <form action="<?php echo CART ?>" method="post">
            <input type="submit" name="btnsubmit" value="カートへ戻る">
        </form>
        <?php
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>
