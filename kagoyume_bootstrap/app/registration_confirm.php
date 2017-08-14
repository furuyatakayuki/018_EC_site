<?php
require_once "../util/defineUtil.php";
require_once "../util/scriptUtil.php";
require_once "../util/dbaccesUtil.php";

session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>登録内容確認</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>

    <?php
    if (!isset($_POST["mode"]) || !$_POST["mode"] == "CONFIRM") {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>
        <?php
    } else {
        $isset_user = login_check($_POST["registration_mail"]);
        $confirm_values = array(
            "registration_name" => bind_p2s("registration_name"),
            "registration_pass" => bind_p2s("registration_pass"),
            "registration_mail" => bind_p2s("registration_mail"),
            "registration_address" => bind_p2s("registration_address")
            );
        if (!in_array(null, $confirm_values, true) && count($isset_user) == 0){
            ?>
            <h1 class="text-center">登録内容確認</h1>
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 panel panel-default">
                        <div class="panel-body text-center">

                            <p>ユーザ名：<?php echo $confirm_values["registration_name"] ?></p>
                            <p>パスワード：<?php echo str_pad("", mb_strlen($_SESSION["registration_pass"]), "*") ;?></p>
                            <p>メールアドレス：<?php echo $confirm_values["registration_mail"] ?></p>
                            <p>住所：<?php echo $confirm_values["registration_address"] ?></p>
                            <hr>
                            <p>上記の内容で登録いたします。<br>よろしいですか？</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                <form action="<?php echo REGISTRATION_COMPLETE ?>" method="post" class="form-horizontal">
                    <div class="form-group margin_b0">
                        <input type="hidden" name="mode" value="COMPLETE">
                        <div class="col-md-offset-4 col-md-4">
                            <button type="submit" name="yes" class="btn btn-warning btn-block">はい</button>
                        </div>
                    </div>
                </form>

                <div class="col-md-offset-4 col-md-4">
                    <hr>
                </div>

                <form action="<?php echo REGISTRATION ?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <input type="hidden" name="mode" value="REINPUT">
                        <div class="col-md-offset-4 col-md-4">
                            <button type="submit" name="no" class="btn btn-primary btn-block">いいえ</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <?php
        } else {
            ?>
            <h1 class="text-center alert-danger">入力項目が不完全です<br>下記の項目を入力してください</h1><br>
            <h3 class="text-center">再入力項目</h1><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 panel panel-default">
                        <div class="panel-body text-center">
                        <?php
                        if ($confirm_values["registration_name"] == null) {
                            echo "<p>ユーザ名</p>";
                        }
                        if ($confirm_values["registration_pass"] == null) {
                            echo "<p>パスワード</p>";
                        }
                        if ($confirm_values["registration_mail"] == null || count($isset_user) != 0) {
                            echo "<p>メールアドレス";
                            if (count($isset_user) != 0){
                                echo "<br>(使用できないメールアドレスです)";
                            }
                            echo "</p>";
                        }
                        if ($confirm_values["registration_address"] == null) {
                            echo "<p>住所</p>";
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
            <form action="<?php echo REGISTRATION ?>" method="post">
                <input type="hidden" name="mode" value="REINPUT">
                <div class="col-md-offset-4 col-md-4">
                    <button type="submit" name="return" class="btn btn-primary btn-block">登録画面に戻る</button>
                </div>
            </form>
            </div>
            <?php
        }
    }

    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>