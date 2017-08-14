<?php
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
session_start();

?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>カートへ追加</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>

    <?php
    if (!isset($_POST["mode"]) || !$_POST["mode"] == "ADD") {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>
        <?php
    } else {
        $datetime = new Datetime();
        $add_date = $datetime->format('Y-m-d H:i:s');
    
        // ゲストカートの選択
        $cart_item = "gest_cart_Item";
        $cart_name = "gest_cart_Name";
        $cart_price = "gest_cart_Price";
        $cart_image = "gest_cart_Image";
        $cart_date = "gest_cart_date";
        
        if (isset($_SESSION["login_name"], $_SESSION["login_id"])) {
            $cart_item = "cart_Item_" . $_SESSION["login_id"];
            $cart_name = "cart_Name_" . $_SESSION["login_id"];
            $cart_price = "cart_Price_" . $_SESSION["login_id"];
            $cart_image = "cart_Image_" . $_SESSION["login_id"];
            $cart_date = "cart_date_" . $_SESSION["login_id"];
        }
        
        // カートの中身がなかった場合、カートを初期化。
        if (!isset($_SESSION[$cart_item], $_SESSION[$cart_name], $_SESSION[$cart_price], $_SESSION[$cart_image], $_SESSION[$cart_date])) {
            $_SESSION[$cart_item] = array();
            $_SESSION[$cart_name] = array();
            $_SESSION[$cart_price] = array();
            $_SESSION[$cart_image] = array();
            $_SESSION[$cart_date] = array();
        }
    
        // カートに商品情報を追加
        $_SESSION[$cart_item][] = $_POST["Itemcode"];
        $_SESSION[$cart_name][] = $_POST["Name"];
        $_SESSION[$cart_price][] = $_POST["Price"];
        $_SESSION[$cart_image][] = $_POST["Image"];
        $_SESSION[$cart_date][] = $add_date;

    ?>
    <div class="container">
        <div class="col-md-offset-4 col-md-4 panel panel-default">
            <div class="panel-body text-center">
                <P class="h4">カートに追加されました</P>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>