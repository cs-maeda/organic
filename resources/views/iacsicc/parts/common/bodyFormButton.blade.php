<script>
    $().ready(function()
        {
            var $_windowWidth = $(window).outerWidth();
            var $_distance = $('.mainV').height()+$('.formTitle').height()+$('.formArea').height();
            if($_windowWidth < 640){
                $(window).scroll(
                    function(){
                        if($(this).scrollTop() > $_distance){
                            $('.formButton').fadeIn(500);
                        } else {
                            $('.formButton').fadeOut(500);
                        }
                    });
            } else {
                $('.formButton').hide();
            }
        }
    );
</script>

<div class="formButton sp">
    <a href="https://www.sumaistar.{$smarty.const.DOMAIN|regex_replace:'/^([^\.]+\.)+/':''}/drive/form/sell/?formId={$formId}">最短45秒無料査定　START</a>
</div>

