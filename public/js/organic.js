//1.トップへ戻るボタン
function pageTop(){
	$('.pageTop').removeClass('on');
	var $_windowHeight = $(window).height();
	$(window).scroll(function(){
		var $_scrollCount = $(window).scrollTop();
		if($_scrollCount > $_windowHeight*0.2){
			$('.pageTop').addClass('on');
		}else{
			$('.pageTop').removeClass('on');
		}
	});

	$('.pageTop').on('click',
		function(){
		$('body,html').animate({
			scrollTop:0
			}, 500);
			return false;
		}
	);
}

//2.スマホ、フォームボタン表示
function spFormButton(){
    var $_distance = $('#form_0').offset().top + $('#form_0').height();
    $(window).scroll(function(){
        var $_scrollCount = $(window).scrollTop();
        if($_scrollCount  > $_distance){
            $('.formButton').addClass('show');
        } else {
            $('.formButton').removeClass('show');
        }
    });
}

$().ready(function()
{
    //1.トップへ戻るボタン
    pageTop();

//windowWidth<640　対応
    var $_windowWidth = $(window).outerWidth();
    if($_windowWidth < 640){
        //2.スマホ、フォームボタン表示
        spFormButton();
    }
});
