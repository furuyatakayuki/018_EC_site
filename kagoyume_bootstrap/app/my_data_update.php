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
    <title>会員情報の更新</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>
<?php
if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
    $user_data = get_my_data($_SESSION["login_id"]);
    if (is_array($user_data) && (count($user_data) > 0)){
    } else {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $user_data; ?></p></div>
        <?php
        exit;
    }
} else {
    ?>
    <div class="alert-info h4 text-center"><p style="padding: 10px;">ログインしてください</p></div>
    <?php
    exit;
}
?>
    <h1 class="text-center">登録情報の更新</h1>
        <div class="container">
            <form action="<?php echo MY_UPDATE_RESULT ?>" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-4">ユーザ名</label>
                    <div class="col-md-4">
                        <input type="text" name="update_name" value="<?php echo $user_data[0]["name"] ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">パスワード</label>
                    <div class="col-md-4">
                        <input type="text" name="update_pass" value="" autocomplete="off" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">メールアドレス</label>
                    <div class="col-md-4">
                        <input type="text" name="update_mail" value="<?php echo $user_data[0]["mail"] ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">住所</label>
                    <div class="col-md-4">
                        <input type="text" name="update_address" value="<?php echo $user_data[0]["address"] ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="mode" value="UPDATE">
                    <div class="col-md-offset-4 col-md-4">
                        <button type="submit" name="btnsubmit" class="btn btn-warning btn-block">変更を登録</button>
                    </div>
                </div>
            </form>
        </div>
<?php require_once '../util/footer.php' ?>
</body>
</html>