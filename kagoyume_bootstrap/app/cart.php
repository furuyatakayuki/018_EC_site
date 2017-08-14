<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
require_once '../util/defineUtil.php';

session_start();

?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>カートの中身</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>
<?php
// ログインチェック
if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
} else {
    ?>
    <div class="alert-info h4 text-center"><p style="padding: 10px;">ログインしてください</p></div>
    <?php
    header("Location: " . LOGIN);
    exit;
}
?>
    <h1 class="text-center">カートの中身</h1>
    <div class="container">
    <table class="table table-bordered text-center">
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
                        <button type="submit" name="btnsubmit" class="btn">カートから削除する</button>
                    </form>
                </td>
            </tr>
            <?php
            $sum_price += $_SESSION["cart_Price_" . $_SESSION["login_id"]][$key];
        }
        if (count($_SESSION["cart_Name_" . $_SESSION["login_id"]]) == 0){
            ?>
            <tr><td colspan=5><p class="h5">カートは空です</p></td></tr>
            <?php
        }
        ?>
    </table>
    </div>
    <div class="container">
    <div class="col-md-offset-4 col-md-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <p class="h5">カートの合計価格：￥<?php echo $sum_price; ?></p>
            </div>
        </div>
    </div>
    <?php
    if (count($_SESSION["cart_Name_" . $_SESSION["login_id"]]) > 0) {
        ?>
        <form action="<?php echo BUY_CONFIRM ?>" method="post">
                <input type="hidden" name="mode" value="CONFIRM">
                <div class="col-md-offset-4 col-md-4">
                    <button type="submit" name="btnsubmit" class="btn btn-warning btn-block">購入する</button>
                </div>
        </form>
        <?php
    }
    ?>
    </div>
<?php require_once '../util/footer.php' ?>
</body>
</html>
