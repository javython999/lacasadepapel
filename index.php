<?php
  // 타이틀 출력 
  function title() {
    if($_GET['section'] != null) {
      $title = $_GET['section'];
      switch($title) {
        case 'character.php':
          $SectionName = '등장인물';
          break;
        case 'season1.php':
          $SectionName = '시즌1';
          break;
        case 'season2.php':
          $SectionName = '시즌2';
          break;
        case 'season3.php':
          $SectionName = '시즌3';
          break;
        case 'season4.php':
          $SectionName = '시즌4';
          break;
      }
      echo $SectionName;
    } else {
      echo 'la casa de Papel';
    }
  }

  // 네비게이션 생성
  function contentsList() {
    $list = scandir('./data/');
    array_splice($list, 0, 2);
    $i = 0;
    while($i < count($list)) {
        switch($list[$i]) {
          case 'character.php':
            $menuName = '등장인물';
            break;
          case 'season1.php':
            $menuName = '시즌1';
            break;
          case 'season2.php':
            $menuName = '시즌2';
            break;
          case 'season3.php':
            $menuName = '시즌3';
            break;
          case 'season4.php':
            $menuName = '시즌4';
            break;
        }
        echo "<li><a href=\"index.php?section=$list[$i]#top\">$menuName</a></li>\n";
      $i = $i+1;
    }
  }

  // 컨텐츠별 내용 출력
  function content() {
    $uri= $_SERVER['REQUEST_URI'];
    if($uri == "/lacasadepapel/index.php") {
      include('video/intro.php');
    } else {
      include('data/'.$_GET['section']);
    }
  }
  
  // 등장인물
  // DB에서 데이터가져오기
  function casting() {
    $server = "localhost";
    $user = "#";
    $pw = "#";
    $db = "#";
    $conn = mysqli_connect($server, $user, $pw, $db);
    $sql = "SELECT * FROM cast";
    $result = mysqli_query($conn, $sql);
    
    // 가져온 데이터들 출력
    while($row = mysqli_fetch_array($result)) {
      echo "<li class='characterItem'><div><img class='characterPic' src={$row['PIC']} alt=Pic><img class='characterPic hoverPic' src={$row['HOVERPIC']} alt=Pic></div>";
      echo "<div class='character'>{$row['ROLE']} / {$row['CASTING']}</div>";
      echo "<div class='description'>{$row['DESCRIPTION']}";
      echo "</li>";
    }
    mysqli_close($conn);
  }

  //시즌
  //DB에서 데이터가져오기
  function seasonData() {
    $getUrl = $_GET['section'];
    $slice = explode(".", $getUrl);
    $season = $slice[0];

    $server = "localhost";
    $user = "#";
    $pw = "#";
    $db = "#";
    $conn = mysqli_connect($server, $user, $pw, $db);
    $sql = "SELECT * FROM $season";

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
    echo "<li class='episodeItem'><div class='episodeBox'>";
    echo "<img class='episodeImg' src='img/{$season}/ep{$row['ID']}.jpg' alt='season1'>";
    echo "<div class='episodeInfo'>";
    echo "<span>{$row['ID']}화</span>";
    echo "<div data-epNum='{$row['ID']}' data-season='{$season}' onclick='javascript:handleComment(this); getCommentList(this);'>";
    echo "<span class='commentCount'>{$row['HIT']}</span>";
    echo "<i class='far fa-comment-alt'></i>";
    echo "</div></div></div>";
    echo "<div class='episodeComment ep{$row['ID']}'>";
    echo "<section class='comentForm'>";
    echo "<form action='proc/write.php' method='post' onsubmit='return checkValue(this)' data-formNum='{$row['ID']}' class='form{$row['ID']}'>";
    echo "<input type='text' name='nic' placeholder='닉네임' class='nic{$row['ID']}'>";
    echo "<input type='text' name='comment'placeholder='코멘트' class='comment{$row['ID']}'>";
    echo "<input type='submit' value='작성'>";
    echo "<input type='hidden' value={$_SERVER['REQUEST_URI']} name='url'>";
    echo "<input type='hidden' value={$season} name='season'>";
    echo "<input type='hidden' value={$row['ID']} name='episode'>";
    echo "</form></section><section class='comentList'><ul class='commentItem{$row['ID']} box'></ul></section></div>";
    echo "<div class='episodeDescription'>";
    echo "{$row['DESCRIPTION']}";
    echo "</div></li>";
    }
    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"
  />
  <script src="https://code.jquery.com/jquery-3.5.1.js" defer></script>
  <script src="script/index.js" defer></script>
  <title>
    <?php
      title();  
    ?>
  </title>
</head>
<body>
  <header>
    <img class="logo" src="img/logo.png" alt="logo" onclick=handleHome()>
  </header>
  <section class="banner">
    <img class="background" src="img/banner.jpg" alt="background">
    
  </section>
  <nav>
    <ul class="navbar">
      <?php
        contentsList();
      ?>
    </ul>
  </nav>
  <section class="content">
    <a name="top"></a>
    <?php
      content();
    ?>
  </section>
</body>
</html>
