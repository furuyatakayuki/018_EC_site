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
    <title>カートの中身</title>
</head>
<body>
    <table border=1>
        <tr>
            <td>商品名</td>
            <td>価格</td>
            <td>画像</td>
            <td>カートに追加した日時</td>
            <td>　</td>
        </tr>
        <?php
        $sum_price = 0;
        // 削除ボタンが押された場合
        if (isset($_POST["delete_key"])) {
            $split = array_splice($_SESSION["cart_Item_" . $_SESSION["login_id"]], $_POST["delete_key"], 1);
            $split = array_splice($_SESSION["cart_Name_" . $_SESSION["login_id"]], $_POST["delete_key"], 1);
            $split = array_splice($_SESSION["cart_Price_" . $_SESSION["login_id"]], $_POST["delete_key"], 1);
            $split = array_splice($_SESSION["cart_Image_" . $_SESSION["login_id"]], $_POST["delete_key"], 1);
            $split = array_splice($_SESSION["cart_date_" . $_SESSION["login_id"]], $_POST["delete_key"], 1);
        }
        foreach ($_SESSION["cart_Name_" . $_SESSION["login_id"]] as $key => $value) {
            ?>
            <tr>
                <td><a href="./item.php?itemcode=<?php echo $_SESSION["cart_Item_" . $_SESSION["login_id"]][$key]; ?>"><?php echo $_SESSION["cart_Name_" . $_SESSION["login_id"]][$key]; ?></a></td>
                <td><?php echo "￥" . $_SESSION["cart_Price_" . $_SESSION["login_id"]][$key]; ?></td>
                <td><img src="<?php echo $_SESSION["cart_Image_" . $_SESSION["login_id"]][$key]; ?>" /></td>
                <td><?php echo $_SESSION["cart_date_" . $_SESSION["login_id"]][$key]; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="delete_key" value="<?php echo $key ?>">
                        <input type="submit" name="btnsubmit" value="カートから削除する">
                    </form>
                </td>
            </tr>
            <?php
            $sum_price += $_SESSION["cart_Price_" . $_SESSION["login_id"]][$key];
        }
        if (count($_SESSION["cart_Name_" . $_SESSION["login_id"]]) == 0){
            ?>
            <tr><td colspan=5>カートは空です</td></tr>
            <?php
        }
        ?>
    </table>
    <p>カートの合計価格：￥<?php echo $sum_price; ?></p>
    <?php
    if (count($_SESSION["cart_Name_" . $_SESSION["login_id"]]) > 0) {
        ?>
        <form action="<?php echo BUY_CONFIRM ?>" method="post">
            <input type="hidden" name="mode" value="CONFIRM">
            <input type="submit" name="btnsubmit" value="購入する">
        </form>
        <?php
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>
