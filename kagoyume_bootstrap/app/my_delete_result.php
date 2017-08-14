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
    <title>退会完了</title>
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
    if (!isset($_POST["mode"]) || !$_POST["mode"] == "DELETE"){
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>

        <?php
    } else {
        $result = delete_users($_SESSION["login_id"]);

        if (!isset($result)) {
            $_SESSION = array();
            session_destroy();
            ?>
            <div class="container">
                <div class="col-md-offset-4 col-md-4 panel panel-default">
                    <div class="panel-body text-center">
                        <P class="h4">退会が完了しました</P>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $result; ?></p></div>
            <?php
        }
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>