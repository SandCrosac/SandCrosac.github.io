$(function(){
    $(document).on('click','[data-tab]',function(){
        var obj = $(this);
            if(obj.attr('data-tab') == 'biaoqing'){
                if($('#biaoqing').attr('style') == 'display: block;'){
                    $('#biaoqing').css('display','none');
                }else{
                    $('#pic').css('display','none');
                    $('#biaoqing').css('display','block');
                }
            }else if(obj.attr('data-tab') == 'tupian'){
                if($('#pic').attr('style') == 'display: block;'){
                    $('#pic').css('display','none');
                }else{
                    $('#biaoqing').css('display','none');
                    $('#pic').css('display','block');
                }
            }
    });
    $(document).on('click','.jubao .cell-item',function(){
        var fid = $('[name="jubao"]:checked');
		if(fid.length != 0){
            $('#tijiao').removeClass('btn-disabled');
		}else{
            $('#tijiao').addClass('btn-disabled');
		}
    })
    // 投票选定
    $(document).on('click','.stamp .cell-item',function(){
        var fid = $('[name="stamp"]:checked');
		if(fid.length != 0){
            $('#btn-stamp').removeClass('btn-disabled');
		}else{
            $('#btn-stamp').addClass('btn-disabled');
		}
    })
    // 返回顶部
    $(window).scroll(function() {
        if ($(document).scrollTop() >= 100) {
            $('.top a').addClass('top-bg'); 
            // 首页
            $('.index-navbar').show();             
        }else{
            $('.top a').removeClass('top-bg');
            $('.index-navbar').hide();   
        }
        if ($(document).scrollTop() >= 290) {
            // 首页
            $('.index-navbar').show();             
        }else{
            $('.index-navbar').hide();   
        } 
    });
    // 懒加载
    $("img.lazyload").lazyload();

    // pjax
    $(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax',{timeout: 10000,maxCacheLength:0,fragment:'#pjax'});
    $(document).on('pjax:click', function() {
        // 关闭ActionSheet窗口
        $('#candan,#yd-popup').actionSheet('close');
    })
    $(document).on('pjax:send', function() {
        $('.loading-page').show()
    })
    $(document).on('pjax:complete', function() {
        $('.loading-page').fadeOut()
    })
    $(document).on('pjax:end', function(event) {

        $("img.lazyload").lazyload();
        $('.mask-black').remove();
    })

    // 分享
    $(document).on('click','.soshm-item',function(){
        var tid = $('[data-shear-id]').attr('data-shear-id');
        $.ajax({
            url:WWW+"plugins"+exp+"share",
            type:'post',
            dataType:'json',
            data:{'share':tid},
            success:function(e){
                if(e.error){
                    $('#shareBtn').children('p').text(parseInt($('#shareBtn').children('p').text())+1);
                }
            },
            error:function(){}
        });
    });
})

$('#sou').bind('input propertychange',function () { 
    var obj = $(this);
    if(obj.val() != ''){
        $('.shbtn').show();
    }
});

function top_t() {
    $('html,body').animate({
        scrollTop: 0
    },500);
}

