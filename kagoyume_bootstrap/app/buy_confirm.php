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
    <title>購入</title>
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
    <?php
    if (!isset($_POST["mode"]) || !$_POST["mode"] == "CONFIRM") {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>
        <?php
    } else {
        ?>
        <h1 class="text-center">購入の確認</h1>
        <div class="container">
        <table class="table table-bordered text-center">
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
        </div>
        <div class="container">
        <div class="col-md-offset-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <p class="h5">合計価格：￥<?php echo $sum_price; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-offset-4 col-md-4">
            <div class="panel panel-default margin_b0">
                <div class="panel-body text-center">
        <!-- ここに発送方法のラジオボタン -->
                    <form action="<?php echo BUY_COMPLETE ?>" method="post">
                        発送方法(デフォルトでは通常になります)：<br>
                        <input type="radio" name="sendding" value="1" checked>通常発送　
                        <input type="radio" name="sendding" value="2">速達発送<br>
                        <hr>
                        <input type="hidden" name="price" value=<?php echo $sum_price ?>>
                        <input type="hidden" name="mode" value="COMPLETE">
                        <button type="submit" name="btnsubmit" class="btn btn-warning">上記の内容で購入を確定する</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-offset-4 col-md-4">
            <hr>
        </div>

        <div class="col-md-offset-4 col-md-4">
            <form action="<?php echo CART ?>" method="post">
                <button type="submit" name="btnsubmit" class="btn btn-primary btn-block">カートへ戻る</button>
            </form>
        </div>
        </div>
        <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>
