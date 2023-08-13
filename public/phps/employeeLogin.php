<?php
header('Access-Control-Allow-Origin:*');
// $email = $_POST["email"];
// $psw = $_POST["password"];
try{
    require_once("connect_chd102g2.php");
    
    $account = $_POST["account"];
    $psw = $_POST["psw"];
    // $psw = "865nQtf2";
        $sql = "select *
                from emp
                where emp_id=:account and emp_psw=:psw";
        $member = $pdo->prepare($sql);
        $member->bindValue(":account", $account);
        $member->bindValue(":psw", $psw);
        $member->execute();
        

    if ($member->rowCount() === 0) {
        echo json_encode(["登入失敗"]);
    }else{
        echo json_encode(["登入成功"]);
    }
        
    // echo json_encode(["連線成功"]);
}catch(Exception $e){
        // echo "連線失敗";
        echo json_encode(["連線失敗"]);
    }


?>