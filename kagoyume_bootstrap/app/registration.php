<?php
require_once "../util/defineUtil.php";
require_once "../util/scriptUtil.php";

session_start();

?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>新規会員登録</title>
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
        ?>
    <h1 class="text-center">新規登録</h1>
    <div class="container">
        <form action="<?php echo REGISTRATION_CONFIRM ?>" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-4">ユーザ名</label>
                <div class="col-md-4">
                    <input type="text" name="registration_name" value="<?php echo form_value('registration_name'); ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">パスワード</label>
                <div class="col-md-4">
                    <input type="text" name="registration_pass" value="<?php echo form_value('registration_pass'); ?>" autocomplete="off" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">メールアドレス</label>
                <div class="col-md-4">
                    <input type="text" name="registration_mail" value="<?php echo form_value('registration_mail'); ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">住所</label>
                <div class="col-md-4">
                    <input type="text" name="registration_address" value="<?php echo form_value('registration_address'); ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" name="mode" value="CONFIRM">
                <div class="col-md-offset-4 col-md-4">
                    <button type="submit" name="btnsubmit" class="btn btn-warning btn-block">確認画面へ</button>
                </div>
            </div>
        </form>
    </div>
    <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>