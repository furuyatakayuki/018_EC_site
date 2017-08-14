<?php
// yahooショッピングAPIの共通ファイル読み込み
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
require_once '../util/yahoo_api_util.php';

session_start();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>かごゆめ-検索フォーム-</title>
        <!-- <link rel="stylesheet" type="text/css" href="../css/prototype.css"> -->
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body class="text-center">
<?php require_once '../util/header.php'; ?>
<?php $hits = query_get($query, $sort, $category_id); ?>
    <h1 class="text-center"><a href="<?php echo SEARCH ?>">かごゆめ - 検索フォーム</a></h1>

    <div>
        <form action="" class="Search">
        表示順序:
        <select name="sort">
        <?php foreach ($sortOrder as $key => $value) { ?>
        <option value="<?php echo h($key); ?>" <?php if($sort == $key) echo "selected=\"selected\""; ?>><?php echo h($value);?></option>
        <?php } ?>
        </select>
        キーワード検索：
        <select name="category_id">
        <?php foreach ($categories as $id => $name) { ?>
        <option value="<?php echo h($id); ?>" <?php if($category_id == $id) echo "selected=\"selected\""; ?>><?php echo h($name);?></option>
        <?php } ?>
        </select>
        <input type="text" name="query" value="<?php echo h($query); ?>"/>
        <button type="submit" class="btn-warning">かごゆめ検索</button>
        </form>
    </div>

    <!-- 検索結果の表示 -->
    <?php
    $count = 0;
    if ($hits != null) {
        echo "<p>検索結果" . count($hits) . "件中 1-10件 \"" . h($query) . "\"</p>";
        echo "<hr>";

        ?>
        <div class="container">
        <div class="row row-eq-height">
        <?php
        foreach ($hits as $hit) {
        ?>
        <div class="col-md-4">
        <div class="panel panel-default">
        <div class="panel-body">
            <p>
            <a href="./item.php?itemcode=<?php echo h($hit->Code); ?>">
                <img class="img-thumbnail" src="<?php echo h($hit->Image->Medium); ?>" />
            </a><br>
            <hr>
            <a href="./item.php?itemcode=<?php echo h($hit->Code); ?>"><?php echo h($hit->Name); ?></a><br>
            <?php echo "￥ " . h($hit->Price); ?>
            </p>
        </div>
        </div>
        </div>
        <?php
            $count++;
            if ($count >= 10 ) {
                break;
            }
        }
        ?>
        </div>
        </div>
        <?php
    }
    if (isset($_GET["query"]) && ($query == "")) {
        ?>
        <div class="alert-info h4 text-center"><p style="padding: 10px;">キーワードを入力し、商品を検索しましょう</p></div>
        <?php
    } elseif (isset($_GET["query"]) && ($count == 0)) {
        ?>
        <div class="alert-warning h4 text-center"><p style="padding: 10px;">検索結果がありませんでした</p></div>
        <?php
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>