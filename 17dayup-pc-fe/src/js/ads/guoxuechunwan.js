/**
 * Created by huangzhongjian on 18/2/11.
 */


(function() {

    function bootstrap(options) {
        var now = +new Date();
        var start = +new Date(options.startTime);
        var end = +new Date(options.endTime);
        console.log(now, start, end);
        if (now >= start && now <= end) {
            render();
        }
    }

    function render () {
        var $el = $('<a class="guoxuechunwan-ads" target="_blank" ' +
        'href="//www.wdyedu.com/activity/spring-festival">' +
        '<i class="close-ads"></i></a>').appendTo('body');

        $el.find('.close-ads').on('click', function(e){
            $el.remove();
            e.stopPropagation();
            e.preventDefault();
        });
    }
    (!window.LOCALE && LOCALE == 'zh_CN') && bootstrap({
        startTime: '2018-02-13T16:00:00Z',
        endTime: '2018-05-01T12:00:00Z'
    });
})();
