<?php
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
// require_once '../util/defineUtil.php';
require_once '../util/yahoo_api_util.php';


session_start();

if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
} else {
    echo "ログインしてください<br>";
    exit;
}

?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>購入履歴</title>
</head>
<body>
    <h1>購入履歴</h1>
    <table border=1>
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
    <?php echo return_top(); ?>
</body>
</html>