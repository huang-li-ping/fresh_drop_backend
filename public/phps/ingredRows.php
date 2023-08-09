<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select ingred_no, ingred_name, allergy, dislike
            from ingred";
    $ingred = $pdo->query($sql);
    $ingredRows = $ingred->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($ingredRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>
