<!-- lib.php -->
<?php
// データベースに接続する
function dbcon(){
    try {
        $pdo = new PDO(DSN,DB_USER,DB_PASS);
        // プリペアドステートメントのエミュレーションを無効にする
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // 例外がスローされる設定にする
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }catch (Exception $e) {
        echo '<span class="error">エラーがありました。</span><br>';
        echo $e->getMessage();
      }
    // 値を戻す
    return $pdo;
}