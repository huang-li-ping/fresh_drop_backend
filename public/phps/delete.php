<?php 
header('Access-Control-Allow-Origin:*');

	try {
		require_once("./connect_chd102g2.php");

		$sql = "DELETE FROM opinion 
						WHERE opinion_no = :opinion_no";

		$opinion = $pdo->prepare($sql);
		$opinion->bindValue(":opinion_no", $_POST["opinion_no"]);
		$opinion->execute();
		
		$opinion_file = $_POST["opinion_file"];// images/opinion/2.svg
		$filePath = "../../$opinion_file";
		unlink($filePath); // 將檔案刪除

		$msg = "已刪除圖片";
	
	} catch (PDOException $e) {
		$msg = "error_line: ".$e->getLine().", error_msg: ".$e->getMessage();
	}	


$result= ["msg" => $msg];
echo json_encode($result);

?>   