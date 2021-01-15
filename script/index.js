function handleHome() {
  location.href = "index.php";
}

function handleComment(e) {
  const target = $(`.ep${e.getAttribute("data-epNum")}`);
    $(target).toggle(600);
  
  // 작성하다 만 코멘트가 있다면 form 리셋
  const test = document.querySelector(`.form${e.getAttribute("data-epNum")}`);
  test.reset();
}

function checkValue(e) {
  const formNum = e.getAttribute("data-formNum");
  console.log(formNum);
  if (!document.querySelector(`.nic${formNum}`).value) {
    alert("닉네임을 입력하세요.");
    return false;
  }

  if (!document.querySelector(`.comment${formNum}`).value) {
    alert("코멘트를 입력하세요.");
    return false;
  }
}

function getCommentList(e) {
  const season = e.getAttribute("data-season");
  const episode = e.getAttribute("data-epNum");
  const target = $(`.commentItem${e.getAttribute("data-epNum")}`);
  
  $(target).empty();
    $.ajax({
      async: true,
      type : 'GET',
      data : `season=${season}&episode=${episode}`,
      url : "proc/loadComment.php",
      dataType : "json",
      contentType: "application/json; charset=UTF-8",
      success : function(data) {
              $(data).each(function(){
                let str = 
                `<li>
                  <div class='nic'>${this.writer}</div>
                  <div class='comment'>${this.comment}</div>
                </li>`
                // view페이지에 불러온 데이터 추가
                $(target).append(str);
              });
      }
    }
  )
}
