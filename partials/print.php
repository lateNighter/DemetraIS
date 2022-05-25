<?php
    header("Content-type: application/json");
    $table = $_POST['table'];
    // echo $table;
    try{
        $htmlfile = 'act.html';
        $html = file_get_contents($htmlfile);
        $html = str_replace('<tbody></tbody>',$table,$html);
        file_put_contents($htmlfile,$html);
        echo json_encode([
            'success' => true,
           'message' => 'successfully updated'
       ]);
    }
    catch(Exception $e){
        echo json_encode([
            'success' => false,
           'message' => $e->getMessage()
       ]);
    }
    // include($htmlfile);
    // echo $html;
    
?>

