<?php
// yahooショッピングAPIの共通ファイル読み込み
require_once '../util/scriptUtil.php';
require_once '../util/yahoo_api_util.php';

session_start();

$hits = array();
$query = !empty($_GET["query"]) ? $_GET["query"] : "";
$sort = !empty($_GET["sort"]) && array_key_exists($_GET["sort"], $sortOrder) ? $_GET["sort"] : "-score";
// $_GET無しでページに来たときの未定義を回避するためにnullを代入
if (!isset($_GET["category_id"])) {
    $_GET["category_id"] = null;
}
$category_id = ctype_digit($_GET["category_id"]) && array_key_exists($_GET["category_id"], $categories) ? $_GET["category_id"] : 1;

$hits = query_get($query, $sort, $category_id);
?>

<?php require_once '../util/login_btn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <title>かごゆめ-検索フォーム-</title>
        <link rel="stylesheet" type="text/css" href="../css/prototype.css"/>
</head>
<body>
    <h1><a href="./search.php">かごゆめ - 商品を検索する</a></h1>
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
    <input type="submit" value="かごゆめ検索"/>
    </form>

    <!-- 検索結果の表示 -->
    <?php
    if ($hits != null) {
        echo "<p>検索結果" . count($hits) . "件中 1-10件 \"" . h($query) . "\"</p>";
        $count = 0;
        foreach ($hits as $hit) {
        ?>
        <div class="Item">
            <p>
            <a href="./item.php?itemcode=<?php echo h($hit->Code); ?>"><img src="<?php echo h($hit->Image->Medium); ?>" /></a>
            <a href="./item.php?itemcode=<?php echo h($hit->Code); ?>"><?php echo h($hit->Name); ?></a><br>
            <?php echo "\\ " . h($hit->Price); ?>
            </p>
        </div>
        <?php
            $count++;
            if ($count >= 10 ) {
                break;
            }
        }
    }
    if (isset($_GET["query"]) && ($query == "")) {
        echo "エラー<br>キーワードを入力してください<br>";
    } elseif (isset($_GET["query"]) && ($count == 0)) {
        echo "検索結果がありませんでした<br>";
    }
    ?>
    <?php echo return_top(); ?>
</body>
</html>