<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");
    
    $sql = "select r.report_no, r.member_fk, r.date, r.reason, r.state, r.opinion_no, o.experience, o.opinion_no_pic as 'report_pic'
        from report r left join opinion o on r.opinion_no = o.opinion_no";
    $report = $pdo->query($sql);
    $reportRows = $report->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($reportRows);
    
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>