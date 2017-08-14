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
    exit;
}
?>
    <?php
    if (!$_POST["mode"] == "COMPLETE") {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>
        <?php
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
                ?>
                <div class="container">
                    <div class="col-md-offset-4 col-md-4 panel panel-default">
                        <div class="panel-body text-center">
                            <P class="h4">購入が完了しました</P>
                        </div>
                    </div>
                </div>

                <?php
            } else {
                ?>
                <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $total_result; ?></div>
                <?php
            }
        } else {
            ?>
            <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $result; ?></div>
            <?php
        }
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>