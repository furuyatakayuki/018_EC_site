<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
// require_once '../util/defineUtil.php';
require_once '../util/yahoo_api_util.php';


session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>購入履歴</title>
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
    <h1 class="text-center">購入履歴</h1>

    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            <table class="table table-bordered text-center">
                <tr>
                    <td>商品名</td>
                    <td>画像</td>
                    <td>発送方法</td>
                </tr>
            <?php
            $history_data = get_my_history($_SESSION["login_id"]);
            if (is_array($history_data) && (count($history_data) > 0)){
                foreach ($history_data as $i) {
                    ?>
                    <tr>
                    <?php
                    $hits = itemcode_get($i["itemCode"]);
                    if ($hits != null) {
                        ?>
                            <td><?php echo h($hits->Name); ?></td>
                            <td><img src="<?php echo h($hits->Image->Medium); ?>" /></td>
                            <td><?php echo send_typenum($i["type"]); ?></td>
                    <?php
                    } else {
                        ?>
                        <td colspan=3>表示エラーです</td>
                        <?php
                    }
                    ?>
                    </tr>
                    <?php
                }
            } elseif (count($history_data) == 0) {
                ?>
                <tr><td colspan=3>購入履歴はありません</td></tr>
                <?php
            } else {
                ?>
                <tr><td colspan=3>エラーです。<br><?php echo $history_data ?></td></tr>
                <?php
            }
            ?>
            </table>
        </div>
    </div>
<?php require_once '../util/footer.php' ?>
</body>
</html>