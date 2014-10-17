/**
 * Fancyboxes
 */
$(".fancybox").fancybox({
    prevEffect: 'fade',
    nextEffect: 'fade',
    openEffect: 'elastic',
    closeEffect: 'elastic'
});

/**
 * Flexliders
 */
var mySwiper = new Swiper('.swiper-container', {
    pagination: '.pagination',
    loop: true,
    grabCursor: true,
    paginationClickable: true
});
$('.arrow-left').on('click', function(e){
    e.preventDefault()
    mySwiper.swipePrev()
});
$('.arrow-right').on('click', function(e){
    e.preventDefault()
    mySwiper.swipeNext()
});