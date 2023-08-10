<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select opinion_no,recipe_no, recipe_name, step, state, des, recipe_pic, class
            from recipe";

    $recipe = $pdo->query($sql);
    $recipeRows = $recipe->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($recipeRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>
