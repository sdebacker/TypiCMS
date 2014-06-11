var $          = jQuery = require('jquery'),
    fancybox   = require('../../components/fancybox/source/jquery.fancybox.pack.js');
    dropdown   = require('../../components/bootstrap/js/dropdown.js'),
    collapse   = require('../../components/bootstrap/js/collapse.js'),
    alert      = require('../../components/bootstrap/js/alert.js'),
    transition = require('../../components/bootstrap/js/transition.js');

$(".fancybox").fancybox({
    prevEffect: 'fade',
    nextEffect: 'fade',
    openEffect: 'elastic',
    closeEffect: 'elastic'
});
