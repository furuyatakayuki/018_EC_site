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
    <title>退会ページ</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css?ver=20170810">
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
    $user_data = get_my_data($_SESSION["login_id"]);
    
    if (is_array($user_data) && (count($user_data > 0))){
        ?>
        <h1 class="text-center">退会確認</h1>
        <div class="container">
            <div class="col-md-offset-2 col-md-8">
            <table class="table table-bordered text-center">
                <tr>
                    <td>ユーザ名</td><td><?php echo $user_data[0]["name"]; ?></td>
                </tr>
                <tr>
                    <td>メールアドレス</td><td><?php echo $user_data[0]["mail"]; ?></td>
                </tr>
                <tr>
                    <td>住所</td><td><?php echo $user_data[0]["address"]; ?></td>
                </tr>
                <tr>
                    <td>合計購買金額</td><td>￥<?php echo $user_data[0]["total"]; ?></td>
                </tr>
                <tr>
                    <td>登録日時</td><td><?php echo $user_data[0]["newDate"]; ?></td>
                </tr>
            </table>
            </div>
        </div>

        <div class="container">
        <div class="col-md-offset-4 col-md-4">
            <div class="panel panel-default margin_b0">
                <div class="panel-heading text-center">
                    <p class="h4">このユーザをマジで削除しますか？</p>
                </div>
                <div class="panel-body text-center">
                <form action="<?php echo MY_DELETE_RESULT ?>" method="post">
                    <input type="hidden" name="mode" value="DELETE">
                    <button type="submit" name="btnsubmit" class="btn btn-warning btn-block margin_b15">はい</button>
                </form>
                <form action="<?php echo TOP_URL ?>" method="post">
                    <button type="submit" name="no" class="btn btn-primary btn-block">いいえ</button>
                </form>
                </div>
            </div>
        </div>
        </div>

        <?php
    } else {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $user_data; ?></p></div>
        <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>