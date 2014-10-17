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
 * Slider
 */
var mySwiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    loop: true,
    grabCursor: true,
    paginationClickable: true,
    calculateHeight: true
});
$('.arrow-left').on('click', function(e){
    e.preventDefault()
    mySwiper.swipePrev()
});
$('.arrow-right').on('click', function(e){
    e.preventDefault()
    mySwiper.swipeNext()
});
