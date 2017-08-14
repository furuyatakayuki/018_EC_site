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
    <title>マイページ</title>
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
    $user_data = get_my_data($_SESSION["login_id"]);

    if (is_array($user_data) && (count($user_data > 0))){
        ?>
        <h1 class="text-center">マイページ</h1>
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

        <?php
    } else {
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $user_data; ?></p></div>
        <?php
    }
    ?>
    <div class="container">
        <div class="col-md-offset-4 col-md-4">
            <!-- 購入履歴 -->
            <form action="<?php echo MY_HISTORY ?>" method="post">
                <div class="form-group">
                    <button type="submit" name="history" class="btn btn-default btn-block">購入履歴</button>
                </div>
            </form>
        </div>
        <div class="col-md-offset-4 col-md-4">
            <!-- 登録情報の更新 -->
            <form action="<?php echo MY_UPDATE ?>" method="post">
                <div class="form-group margin_b0">
                    <button type="submit" name="update" class="btn btn-warning btn-block">登録情報の変更</button>
                </div>
            </form>
        </div>

        <div class="col-md-offset-4 col-md-4">
            <hr>
        </div>

        <div class="col-md-offset-4 col-md-4">
            <!-- 退会処理 -->
            <form action="<?php echo MY_DELETE ?>" method="post">
                <div class="form-group">
                    <button type="submit" name="delete" class="btn btn-primary btn-block">退会</button>
                </div>
            </form>
        </div>
    </div>
<?php require_once '../util/footer.php' ?>
</body>
</html>