<?php
require_once '../util/scriptUtil.php';
require_once '../util/yahoo_api_util.php';

session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>商品詳細ページ</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>

    <?php
    $hits = array();
    // 未定義を回避するための""代入
    $itemcode = isset($_GET["itemcode"]) ? $_GET["itemcode"] : "";
    $hits = itemcode_get($itemcode);

    if ($hits != null){
        ?>
        <div class="container margin_t10">
            <div class="row row-eq-height">
                <div class="col-md-offset-1 col-md-5">
                    <div class="text-center"><img src="<?php echo h($hits->ExImage->Url); ?>"></div>
                </div>
                <div class="col-md-5">
                    <p class="h3"><?php echo h($hits->Name); ?></p>
                    <hr>
                    <p>価格:</p>
                    <p class="h4">￥<?php echo h($hits->Price); ?></p>
                    <p>レビュー件数:</p>
                    <p><?php echo h($hits->Review->Count); ?></p>
                    <p>レビュー平均:</p><?php echo h($hits->Review->Rate); ?></p>
                    <form action="./add.php" method="post">
                        <input type="hidden" name="Itemcode" value="<?php echo h($hits->Code); ?>">
                        <input type="hidden" name="Name" value="<?php echo h($hits->Name); ?>">
                        <input type="hidden" name="Image" value="<?php echo h($hits->Image->Medium); ?>">
                        <input type="hidden" name="Price" value="<?php echo h($hits->Price); ?>">
                        <input type="hidden" name="mode" value="ADD">
                        <button type="submit" class="btn btn-warning">カートに追加する</button>
                    </form>
                </div>
                <div class="col-md-offset-1 col-md-10"><hr></div>
                <div class="col-md-offset-1 col-md-10">
                    <p class="h3">商品説明<p>
                    <p><?php echo $hits->Description; ?></p>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="alert-warning h4 text-center"><p style="padding: 10px;">エラーです<br>商品情報がありません</p></div>
        <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>