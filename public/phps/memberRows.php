<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select cus_no, cus_name, cus_email, phone, birth, address
            from customer";
    $member = $pdo->query($sql);
    $memberRows = $member->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    // var_dump($memberRows);
    // exit();
    echo json_encode($memberRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>