/**
 * Created by huangzhongjian on 17/9/19.
 */


import '../../../lib/unslider/dist/js/unslider-min.js'
//import '../../../lib/unslider/dist/css/unslider.css'

$('.j-slider').each(function() {
    $(this).unslider({
        animation: 'fade',
        autoplay: true,
        speed: 600,
        delay: 5000
    });
});
