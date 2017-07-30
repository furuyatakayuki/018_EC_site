<?php
require_once '../util/scriptUtil.php';
require_once '../util/yahoo_api_util.php';
?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品詳細ページ</title>
</head>
<body>
    <?php
    $hits = array();
    // 未定義を回避するための""代入
    $itemcode = isset($_GET["itemcode"]) ? $_GET["itemcode"] : "";
    $hits = itemcode_get($itemcode);

    if ($hits != null){
        echo "[商品名]" . h($hits->Name) . "<br>";
        echo "<img src='" . h($hits->Image->Medium) . "'><br>";
        echo "[価格]￥" . h($hits->Price) . "<br>";
        echo "[商品説明]<br>" . $hits->Description . "<br>";
        echo "[レビュー件数]" . h($hits->Review->Count) . "<br>";
        echo "[レビュー平均]" . h($hits->Review->Rate) . "<br>";
        ?>
        <form action="./add.php" method="post">
            <input type="hidden" name="Itemcode" value="<?php echo h($hits->Code); ?>">
            <input type="hidden" name="Name" value="<?php echo h($hits->Name); ?>">
            <input type="hidden" name="Image" value="<?php echo h($hits->Image->Medium); ?>">
            <input type="hidden" name="Price" value="<?php echo h($hits->Price); ?>">
            <input type="hidden" name="mode" value="ADD">
            <input type="submit" value="カートに追加する">
        </form>
        <?php
    } else {
        echo "商品がありません<br>";
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>