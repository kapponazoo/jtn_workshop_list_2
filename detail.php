<?php
session_start();
$id = $_GET["id"];
// 1 PHP
include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM jtn_ws_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',    $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);


?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ワークショップ登録</title>
  <link rel="stylesheet" href="css/style.css" >

</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <?php include("menu.php"); ?>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form action="update.php" method="post" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>情報を更新してください</legend>
    <h2>ワークショップタイトル</h2>
<p class="answer"><input type="text" name="workshop_title" value="<?=$v["workshop_title"]?>"></p>
<h2>出来上がりのイメージ</h2>
<img src="images/<?=$v["image"]?>" alt="出来上がりのイメージ" width="200px"><br>
<input type="file" name="image">

<h2>開催日と時間</h2>
    <p class="answer"><input type="text" name="workshop_date" value="<?=$v["workshop_date"]?>"></p>
   <h2>講師</h2>
    <p class="answer"><input type="text" name="workshop_teacher" value="<?=$v["workshop_teacher"]?>"></p>
    <h2>内容</h2>
    <p class="answer"><textArea name="workshop_description" rows="4" cols="40"><?=$v["workshop_description"]?></textArea></p>
    
    <h2>ワークショップタイプ</h2>
    <p>
<input type="radio" name="workshop_type" id="workshop_type01" value="ハンズオン"<?php echo ($v["workshop_type"]==="ハンズオン" ? ' checked' : ''); ?>>ハンズオン
<input type="radio" name="workshop_type" id="workshop_type02" value="デモンストレーション"<?php echo ($v["workshop_type"]==="デモンストレーション" ? ' checked' : ''); ?>>デモンストレーション
<input type="radio" name="workshop_type" id="workshop_type03" value="ワークショップ"<?php echo ($v["workshop_type"]==="ワークショップ" ? ' checked' : ''); ?>>ワークショップ
</p>    
<h2>対象者</h2>
<p>
<input type="radio" name="level_type" id="level_type01" value="初心者"<?php echo ($v["level_type"]==="初心者" ? ' checked' : ''); ?>>初心者
<input type="radio" name="level_type" id="level_type02" value="中級者"<?php echo ($v["level_type"]==="中級者" ? ' checked' : ''); ?>>中級者
<input type="radio" name="level_type" id="level_type03" value="上級者"<?php echo ($v["level_type"]==="上級者" ? ' checked' : ''); ?>>上級者
</p>

   
<h2>種別</h2>
<p>
<input type="checkbox" name="category_type[]" value="織り"<?php if(strpos($v["category_type"],'織り') !== false){ echo ' checked'; } ?>>織り
<input type="checkbox" name="category_type[]" value="染め"<?php if(strpos($v["category_type"],'染め') !== false){ echo ' checked'; } ?>>染め
<input type="checkbox" name="category_type[]" value="刺繍"<?php if(strpos($v["category_type"],'刺繍') !== false){ echo ' checked'; } ?>>刺繍
<input type="checkbox" name="category_type[]" value="キルト"<?php if(strpos($v["category_type"],'キルト') !== false){ echo ' checked'; } ?>>キルト
<input type="checkbox" name="category_type[]" value="アート"<?php if(strpos($v["category_type"],'アート') !== false){ echo ' checked'; } ?>>アート
</p>

<h2>受講料</h2>
<p class="answer"><input type="text" name="workshop_fee" value="<?=$v["workshop_fee"]?>"></p>
<h2>持ち物</h2>
<p class="answer"><input type="text" name="belongings" value="<?=$v["belongings"]?>"></p>

<h2>予約</h2>
<p>
<input type="radio" name="reservation" id="reservation_type01" value="予約必須"<?php echo ($v["reservation"]==="予約必須" ? ' checked' : ''); ?>>予約必須
<input type="radio" name="reservation" id="reservation_type02" value="予約可能"<?php echo ($v["reservation"]==="予約可能" ? ' checked' : ''); ?>>予約可能
<input type="radio" name="reservation" id="reservation_type03" value="予約不要"<?php echo ($v["reservation"]==="予約不要" ? ' checked' : ''); ?>>予約不要
</p>
<h2>会場名</h2>
<p class="answer"><input type="text" name="facility_name" value="<?=$v["facility_name"]?>"></p>
<h2>ワークショップ会場住所</h2>
<p class="answer"><input type="text" name="facility_add" value="<?=$v["facility_add"]?>"></p>


<h2>都道府県</h2>
<select name="pref" class="answer">
  <option value="北海道"<?php echo ($v["pref"]==="北海道" ? ' selected' : ''); ?>>北海道</option>
  <option value="青森県"<?php echo ($v["pref"]==="青森県" ? ' selected' : ''); ?>>青森県</option>
  <option value="岩手県"<?php echo ($v["pref"]==="岩手県" ? ' selected' : ''); ?>>岩手県</option>
  <option value="宮城県"<?php echo ($v["pref"]==="宮城県" ? ' selected' : ''); ?>>宮城県</option>
  <option value="秋田県"<?php echo ($v["pref"]==="秋田県" ? ' selected' : ''); ?>>秋田県</option>
  <option value="山形県"<?php echo ($v["pref"]==="山形県" ? ' selected' : ''); ?>>山形県</option>
  <option value="福島県"<?php echo ($v["pref"]==="福島県" ? ' selected' : ''); ?>>福島県</option>
  <option value="茨城県"<?php echo ($v["pref"]==="茨城県" ? ' selected' : ''); ?>>茨城県</option>
  <option value="栃木県"<?php echo ($v["pref"]==="栃木県" ? ' selected' : ''); ?>>栃木県</option>
  <option value="群馬県"<?php echo ($v["pref"]==="群馬県" ? ' selected' : ''); ?>>群馬県</option>
  <option value="埼玉県"<?php echo ($v["pref"]==="埼玉県" ? ' selected' : ''); ?>>埼玉県</option>
  <option value="千葉県"<?php echo ($v["pref"]==="千葉県" ? ' selected' : ''); ?>>千葉県</option>
  <option value="東京都"<?php echo ($v["pref"]==="東京都" ? ' selected' : ''); ?>>東京都</option>
  <option value="神奈川県"<?php echo ($v["pref"]==="神奈川県" ? ' selected' : ''); ?>>神奈川県</option>
  <option value="新潟県"<?php echo ($v["pref"]==="新潟県" ? ' selected' : ''); ?>>新潟県</option>
  <option value="富山県"<?php echo ($v["pref"]==="富山県" ? ' selected' : ''); ?>>富山県</option>
  <option value="石川県"<?php echo ($v["pref"]==="石川県" ? ' selected' : ''); ?>>石川県</option>
  <option value="福井県"<?php echo ($v["pref"]==="福井県" ? ' selected' : ''); ?>>福井県</option>
  <option value="山梨県"<?php echo ($v["pref"]==="山梨県" ? ' selected' : ''); ?>>山梨県</option>
  <option value="長野県"<?php echo ($v["pref"]==="長野県" ? ' selected' : ''); ?>>長野県</option>
  <option value="岐阜県"<?php echo ($v["pref"]==="岐阜県" ? ' selected' : ''); ?>>岐阜県</option>
  <option value="静岡県"<?php echo ($v["pref"]==="静岡県" ? ' selected' : ''); ?>>静岡県</option>
  <option value="愛知県"<?php echo ($v["pref"]==="愛知県" ? ' selected' : ''); ?>>愛知県</option>
  <option value="三重県"<?php echo ($v["pref"]==="三重県" ? ' selected' : ''); ?>>三重県</option>
  <option value="滋賀県"<?php echo ($v["pref"]==="滋賀県" ? ' selected' : ''); ?>>滋賀県</option>
  <option value="京都府"<?php echo ($v["pref"]==="京都府" ? ' selected' : ''); ?>>京都府</option>
  <option value="大阪府"<?php echo ($v["pref"]==="大阪府" ? ' selected' : ''); ?>>大阪府</option>
  <option value="兵庫県"<?php echo ($v["pref"]==="兵庫県" ? ' selected' : ''); ?>>兵庫県</option>
  <option value="奈良県"<?php echo ($v["pref"]==="奈良県" ? ' selected' : ''); ?>>奈良県</option>
  <option value="和歌山県"<?php echo ($v["pref"]==="和歌山県" ? ' selected' : ''); ?>>和歌山県</option>
  <option value="鳥取県"<?php echo ($v["pref"]==="鳥取県" ? ' selected' : ''); ?>>鳥取県</option>
  <option value="島根県"<?php echo ($v["pref"]==="島根県" ? ' selected' : ''); ?>>島根県</option>
  <option value="岡山県"<?php echo ($v["pref"]==="岡山県" ? ' selected' : ''); ?>>岡山県</option>
  <option value="広島県"<?php echo ($v["pref"]==="広島県" ? ' selected' : ''); ?>>広島県</option>
  <option value="山口県"<?php echo ($v["pref"]==="山口県" ? ' selected' : ''); ?>>山口県</option>
  <option value="徳島県"<?php echo ($v["pref"]==="徳島県" ? ' selected' : ''); ?>>徳島県</option>
  <option value="香川県"<?php echo ($v["pref"]==="香川県" ? ' selected' : ''); ?>>香川県</option>
  <option value="愛媛県"<?php echo ($v["pref"]==="愛媛県" ? ' selected' : ''); ?>>愛媛県</option>
  <option value="高知県"<?php echo ($v["pref"]==="高知県" ? ' selected' : ''); ?>>高知県</option>
  <option value="福岡県"<?php echo ($v["pref"]==="福岡県" ? ' selected' : ''); ?>>福岡県</option>
  <option value="佐賀県"<?php echo ($v["pref"]==="佐賀県" ? ' selected' : ''); ?>>佐賀県</option>
  <option value="長崎県"<?php echo ($v["pref"]==="長崎県" ? ' selected' : ''); ?>>長崎県</option>
  <option value="熊本県"<?php echo ($v["pref"]==="熊本県" ? ' selected' : ''); ?>>熊本県</option>
  <option value="大分県"<?php echo ($v["pref"]==="大分県" ? ' selected' : ''); ?>>大分県</option>
  <option value="宮崎県"<?php echo ($v["pref"]==="宮崎県" ? ' selected' : ''); ?>>宮崎県</option>
  <option value="鹿児島県"<?php echo ($v["pref"]==="鹿児島県" ? ' selected' : ''); ?>>鹿児島県</option>
  <option value="沖縄県"<?php echo ($v["pref"]==="沖縄県" ? ' selected' : ''); ?>>沖縄県</option>
</select>
<h2>詳細情報URL</h2>
<p class="answer"><input type="url" name="workshop_url" value="<?=$v["workshop_url"]?>"></p>
<h2>お問い合わせ先</h2>
<p class="answer"><input type="text" name="contact" value="<?=$v["contact"]?>"></p>
<input type="hidden" name="id" value="<?=$v["id"]?>">
<br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
