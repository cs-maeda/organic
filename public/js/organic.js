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

//3.フォームのフォーカス
function formFocus(){
    $('.lpForm select').on('change',
    function()
    {
        $('.lpForm li').removeClass('focusOn');
        var $_selectVal = $(this).val();
        if($_selectVal != ""){
            $(this).parent('li').next().addClass('focusOn');
        }
    });
}

//4.都道府県のプルダウン
function openPref(){
    $('.areaLink .top').on('click',
    function()
    {
        if($(this).hasClass('open')){
            $(this).removeClass('open');
            $(this).parent('ul').children('.pref').slideUp(200);
        } else {
            $(this).addClass('open');
            $(this).parent('ul').children('.pref').slideDown(200);
        }
    });
}

$().ready(function()
{
    //1.トップへ戻るボタン
    pageTop();
    //3.フォームのフォーカス
   formFocus();


//windowWidth<640　対応
    var $_windowWidth = $(window).outerWidth();
    if($_windowWidth < 640){
        //2.スマホ、フォームボタン表示
        spFormButton();
        //4.都道府県のプルダウン
        openPref();
    }
});
