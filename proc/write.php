<?php
  
  // 코멘트 작성
  function writeComment() {
    // DB연결
    $server = "localhost";
    $user = "errdayphp";
    $pw = "qwertymania!";
    $db = "errdayphp";
    $conn = mysqli_connect($server, $user, $pw, $db);

    // 코멘트 DB에 저장
    $sql1 = "INSERT INTO comment (season, episode, writer, comment) VALUES ('{$_POST['season']}','{$_POST['episode']}','{$_POST['nic']}', '{$_POST['comment']}')";
    mysqli_query($conn, $sql1);

    // 해당 에피소드 코멘트 갯수 가져오기
    $sql2 = "SELECT COUNT(*) FROM (SELECT * FROM comment WHERE SEASON='{$_POST['season']}' AND EPISODE='{$_POST['episode']}') AS test";
    $result = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_array($result);
    $newHit = $row['COUNT(*)'];

    // 해당 에피소드의 코멘트 갯수 업데이트
    $sql3 = "UPDATE {$_POST['season']} SET HIT ={$newHit} WHERE ID={$_POST['episode']}";
    mysqli_query($conn, $sql3);
    
    mysqli_close($conn);  
  }
  writeComment();
  header("Location: $_POST[url]#top");
?>