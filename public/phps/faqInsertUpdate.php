<?php
header('Access-Control-Allow-Origin:*');



try {
    require_once("connect_chd102g2.php");

    // 測試連線
    if ($pdo) {
        echo "連線成功";
    } else {
        echo "連線失敗";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $question_no = $_POST['question_no'];
        $status = $_POST['status'];
        $question_group = $_POST['question_group'];
        $question_des = $_POST['question_des'];
        $ans = $_POST['ans'];
        echo $_POST['submit'];

        // 新增or修改or刪除
        if (isset($_POST['submit']) && $_POST['submit'] == '新增') {
            // 執行新增
            $sql = "INSERT INTO faq (question_no, `status`, question_group, question_des, ans) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$question_no, $status, $question_group, $question_des, $ans]);
            echo json_encode(["message" => "create successfully"]);
        } elseif (isset($_POST['submit']) && $_POST['submit'] == '存檔') {
            $sql = "UPDATE faq 
                    SET question_no = ?, `status` = ?, question_group = ?, question_des = ?, ans = ?
                    WHERE question_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$question_no, $status, $question_group, $question_des, $ans, $question_no]);
            echo json_encode(["message" => "update successfully"]);
        } elseif (isset($_POST['submit']) && $_POST['submit'] == '刪除') {
            // 執行刪除
            $sql = "DELETE FROM faq WHERE question_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$question_no]);
            echo json_encode(["message" => "delete successfully"]);
        } else {
            echo json_encode(["error" => "fail"]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["連線失敗failed"]);
}

var_dump($_POST);
