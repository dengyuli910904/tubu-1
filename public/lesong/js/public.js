// document.write('<div id="loading"><div class="center"><img src="images/zh-logo.png">加载中...</div></div>')
// document.onreadystatechange = completeLoading;
// function completeLoading() {
//     if (document.readyState == "complete") {
//         setTimeout(function(){
//             $('#loading').fadeOut();
//         },400);
//     }
// }



//设置页面最小高度
var H = window.innerHeight || window.screen.availHeight;
var btnH = $('.bottom-tab').height() || 0;
$('.main').css('minHeight',(H - btnH) + 'px');
$('.login').css('minHeight',(H - btnH) + 'px');

// $('.nav .panel').hide();
//首页筛选框下拉面板
// $('.nav ul li').click(function(){
//     $(this).parent().find('li').removeClass('active');
//     $(this).toggleClass('active');
//     $(this).find('a').find('i').toggleClass('icon-xiangxia2');
//     $(this).find('a').find('i').toggleClass('icon-xiangshang2');
//     var type = $(this).attr('type');
//     if(type == 'selected'){
//         var id = $(this).attr('id');
//         if($(this).find('a').find('i').hasClass('icon-xiangshang2')){
//             $('.nav .panel').css('display','table');
//             $('.nav .panel .'+id).css('display','block');
//             if(id == 'choose-tag'){
//                 $('.nav .panel .choose-pay').css('display','none');
//                 $('.nav ul li#choose-pay a i').removeClass('icon-xiangshang2').addClass('icon-xiangxia2');
//             }else{
//                 $('.nav .panel .choose-tag').css('display','none');
//                 $('.nav ul li#choose-tag a i').removeClass('icon-xiangshang2').addClass('icon-xiangxia2');
//             }
//         }else{
//             $('.nav .panel').css('display','none');
//             $('.nav .panel .'+id).css('display','none');
//             if(id == 'choose-tag'){
//                 $('.nav .panel .choose-pay').css('display','block');
//             }else{
//                 $('.nav .panel .choose-tag').css('display','block');
//             }
//         }
//     }
//
// });

//展开收起
$('.act-body .long-text').each(function(index,ele){
    $(ele).find('.text-content').css('height','65');
    // $(ele).find('.long-hide').hide();
    // if($(ele).find('.text-content').height()>100){
    //     $(ele).find('.long-hide').show();
    // }
});
// $('.long-hide').click(function(){
//     if($(this).find('i').hasClass('icon-less')){
//         $(this).parent('.long-text').find('.text-content').css('height','65');
//     }else{
//         // alert('ddd');
//         $(this).parent('.long-text').find('.text-content').css('height','auto');
//     }
//     $(this).find('i').toggleClass('icon-less');
//     $(this).find('i').toggleClass('icon-more');
//
// });

//选择框
$('.select-result').click(function(){
    $(this).parent().toggleClass('active');
});
$('.select-item').click(function(){
    $(this).parent().addClass('current').siblings().removeClass('current');
    var str = $(this).text();
    $(this).parents('.select-box').find('.select-result span').text(str);
});


// 角色认领选择角色
$('.role-list li').click(function(){
    $('.role-list li').removeClass('active');
    $(this).toggleClass('active');
});

