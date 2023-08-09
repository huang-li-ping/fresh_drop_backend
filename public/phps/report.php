<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");
    
    $sql = "select report_no, member_fk, date, reason, state, opinion_on
            from report";
    $member = $pdo->query($sql);
    $memberRows = $member->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($memberRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>