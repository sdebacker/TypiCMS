var $          = require('jquery'),
    fancybox   = require('../../vendor/fancybox/source/jquery.fancybox.pack.js');
    dropdown   = require('../../vendor/bootstrap/js/dropdown.js'),
    collapse   = require('../../vendor/bootstrap/js/collapse.js'),
    alert      = require('../../vendor/bootstrap/js/alert.js'),
    transition = require('../../vendor/bootstrap/js/transition.js'),
    gmaps      = require('./gmaps.js')();

$(".fancybox").fancybox({
    prevEffect: 'fade',
    nextEffect: 'fade',
    openEffect: 'elastic',
    closeEffect: 'elastic'
});
