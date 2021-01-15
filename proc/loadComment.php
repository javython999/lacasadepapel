<?php
  function loadComent() {
    // DB연결
    $server = "localhost";
    $user = "#";
    $pw = "#";
    $db = "#";
    $conn = mysqli_connect($server, $user, $pw, $db);
    
    // 코멘트 가져오기    
    $sql = "SELECT  writer, comment FROM comment WHERE season='{$_GET['season']}' AND episode={$_GET['episode']} ORDER BY commentID DESC;";
    $result = mysqli_query($conn, $sql);
    
    $array = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($array,$row);
    }
    $json_array = json_encode($array);
    echo $json_array;
    
  }
  loadComent();
?>
