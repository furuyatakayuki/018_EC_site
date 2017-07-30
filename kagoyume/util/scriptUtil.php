<?php
require_once '../util/defineUtil.php';

// トップへ戻る
function return_top(){
    return "<a href='".TOP_URL."'>トップへ戻る</a>";
}

// フォームの再入力時に値があれば返す
function form_value($name){
    if (isset($_POST["mode"]) && $_POST["mode"] == "REINPUT") {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }
}

// postの値をチェックし、存在すればsessionに格納。しなければnullを代入。
function bind_p2s($name){
    if(!empty($_POST[$name])){
        $_SESSION[$name] = $_POST[$name];
        return $_POST[$name];
    }else{
        $_SESSION[$name] = null;
        return null;
    }
}

// 発送方法番号から実際の発送方法を返す。
function send_typenum($type){
    switch ($type){
        case 1;
            return "通常発送";
        case 2;
            return "速達発送";
    }
}