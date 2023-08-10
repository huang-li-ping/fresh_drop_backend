<?php
header('Access-Control-Allow-Origin:*');


try {
    require_once("connect_chd102g2.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emp_no = $_POST['emp_no'];
        $emp_name = $_POST['emp_name'];
        $emp_id = $_POST['emp_id'];
        $emp_psw = $_POST['emp_psw'];
        $emp_date = $_POST['emp_date'];
        $emp_status = $_POST['emp_status'];
        echo $_POST['submit'];

        // 新增or修改or刪除
        if (isset($_POST['submit']) && $_POST['submit'] == '新增') {
            // 執行新增
            $sql = "INSERT INTO emp (emp_no, emp_name, emp_id, emp_psw, emp_date, emp_status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$emp_no, $emp_name, $emp_id, $emp_psw, $emp_date, $emp_status]);
            echo json_encode(["message" => "create successfully"]);
        } elseif (isset($_POST['submit']) && $_POST['submit'] == '存檔') {
            // 執行修改
            $sql = "UPDATE emp 
                    SET emp_name = ?, emp_id = ?, emp_psw= ?, emp_date = ?, emp_status = ? 
                    WHERE emp_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$emp_name, $emp_id, $emp_psw, $emp_date, $emp_status, $emp_no]);
            echo json_encode(["message" => "update successfully"]);
        } elseif (isset($_POST['submit']) && $_POST['submit'] == '刪除') {
            // 執行刪除
            $sql = "DELETE FROM emp WHERE emp_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$emp_no]);
            echo json_encode(["message" => "delete successfully"]); 

        }else {
            echo json_encode(["error" => "fail"]);
        }

    }
}catch(Exception $e){
    echo json_encode(["連線失敗failed"]);
}

var_dump($_POST)

?>