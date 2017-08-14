<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
require_once '../util/defineUtil.php';

session_start();

// ログイン後の遷移先として適切かどうかの判断
$check = array("top.php", "search.php", "item.php", "my_data.php", "my_history.php", "my_data_update.php", "my_delete.php", "cart.php");
// ログイン成功時の遷移先ページの設定
$before_page = TOP_URL;
// befor_pageがあった場合、その情報を引き継ぎ。(ログイン成功時の遷移先になるように)。ユーザ名かパスワードが間違っていて同じページに遷移してきたとき対策も。
if (isset($_POST["before_page"]) && $_POST["before_page"] != LOGIN && in_array($_POST["before_page"], $check)) {
    $before_page = $_POST["before_page"];
}

// ログイン判定。ログインボタンが押されたら。
if (isset($_POST["btnsubmit"])) {
    if (!empty($_POST["login_name"]) && !empty($_POST["password"])) {
        // エラー文の初期化
        $str_1 = "";
        $str_2 = "";
        // ここでログイン処理
        $user_data = login_check($_POST["login_name"]);
        if (is_array($user_data) && (count($user_data > 0))) {
            foreach ($user_data as $i) {
                // ログイン成功
                if ((password_verify($_POST["password"], $i["password"])) && ($i["deleteFlg"] == 0)){
                    session_regenerate_id(true);
                    // ログイン情報の記憶
                    $_SESSION["login_name"] = $i["name"];
                    $_SESSION["login_id"] = $i["userID"];
                    // カートがまだなかったら初期化
                    if (!isset($_SESSION["cart_Item_" . $_SESSION["login_id"]], $_SESSION["cart_Name_" . $_SESSION["login_id"]], $_SESSION["cart_Price_" . $_SESSION["login_id"]], $_SESSION["cart_Image_" . $_SESSION["login_id"]], $_SESSION["cart_date_" . $_SESSION["login_id"]])) {
                        $_SESSION["cart_Item_" . $_SESSION["login_id"]] = array();
                        $_SESSION["cart_Name_" . $_SESSION["login_id"]] = array();
                        $_SESSION["cart_Price_" . $_SESSION["login_id"]] = array();
                        $_SESSION["cart_Image_" . $_SESSION["login_id"]] = array();
                        $_SESSION["cart_date_" . $_SESSION["login_id"]] = array();
                    }
                    // カートの中身を移動
                    if (isset($_SESSION["gest_cart_Item"], $_SESSION["gest_cart_Name"], $_SESSION["gest_cart_Price"], $_SESSION["gest_cart_Image"], $_SESSION["gest_cart_date"])){
                        $_SESSION["cart_Item_" . $_SESSION["login_id"]] = $_SESSION["gest_cart_Item"];
                        $_SESSION["cart_Name_" . $_SESSION["login_id"]] = $_SESSION["gest_cart_Name"];
                        $_SESSION["cart_Price_" . $_SESSION["login_id"]] = $_SESSION["gest_cart_Price"];
                        $_SESSION["cart_Image_" . $_SESSION["login_id"]] = $_SESSION["gest_cart_Image"];
                        $_SESSION["cart_date_" . $_SESSION["login_id"]] = $_SESSION["gest_cart_date"];
                        // カートの中身を移動後、ゲストカートを初期化。
                        $_SESSION["gest_cart_Item"] = array();
                        $_SESSION["gest_cart_Name"] = array();
                        $_SESSION["gest_cart_Price"] = array();
                        $_SESSION["gest_cart_Image"] = array();
                        $_SESSION["gest_cart_date"] = array();
                    }
                    header("Location: " . $before_page);
                    exit();
                }
            }
            // ログインできなかった場合、foreachを超えてくる
            $str_2 = "ユーザ名かパスワードが間違っています。<br>";
        } else {
            $str_1 = "エラーです。<br>" . $user_data . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>ログインページ</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
    <?php if (!isset($_SESSION['login_name'])) { ?>
    <?php require_once '../util/header.php'; ?>

    <h1 class="text-center">かごゆめ</h1>
    <div class="container">
            <form action="" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-4">ユーザ名(メールアドレス)</label>
                    <div class="col-md-4">
                        <input type="text" name="login_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">パスワード</label>
                    <div class="col-md-4">
                        <input type="text" name="password" autocomplete="off" class="form-control">
                    </div>
                </div>
                <div class="form-group margin_b0">
                    <input type="hidden" name="before_page" value="<?php echo $before_page; ?>">
                    <div class="col-md-offset-4 col-md-4">
                        <button type="submit" name="btnsubmit" class="btn btn-warning btn-block">ログイン</button>
                    </div>
                </div>
            </form>

            <div class="col-md-offset-4 col-md-4">
                <hr>
            </div>

            <form action="<?php echo REGISTRATION ?>" method="post" class="form-horizontal">
                <div class="form-group">
                    <input type="hidden" name="mode" value="REGISTRATION">
                    <div class="col-md-offset-4 col-md-4">
                        <button type="submit" name="registration" class="btn btn-primary btn-block">新規登録</button>
                    </div>
                </div>
            </form>
    </div>
    <?php
    if (isset($str_1) && $str_1 != "") {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;"><?php echo $str_1; ?></p></div>
        <?php
    }
    if (isset($str_2) && $str_2 != "") {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;"><?php echo $str_2; ?></p></div>
        <?php
    }
    } else {
        $_SESSION = array();
        session_destroy();
        require_once '../util/header.php';
        ?>
        <div class="alert-info h4 text-center"><p style="padding: 10px;">ログアウトしました。</p></div>
        <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>
