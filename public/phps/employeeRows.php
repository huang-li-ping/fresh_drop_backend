<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select emp_no, emp_name, emp_id, emp_psw, emp_status, emp_date 
            from emp";
    $employee = $pdo->query($sql);
    $employeeRows = $employee->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($employeeRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>