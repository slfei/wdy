import { parseQuery } from '~/js/utils/index';

//console.log(sort_course)
//let checked_num = sort_course.checked_num;
//let sort_type = sort_course.sort_type;
//let sort_id = sort_course.course_id;
//let go_href,course_type;
var params = parseQuery();

$('.listen_checked').click(function(e){
    /*course_type = e.target.id.slice(5)
    if (course_type=='course') {
        go_href = '/institute/courselist/'
    }
    else{
        go_href = '/teacher/courselist/'
    }
    if (sort_course.checked_num=='0') {
        $('.listen_checked').attr("checked",true)
        window.location.href = go_href+sort_id+'?type='+sort_type+'&is_listen=1';
    }
    else{
        $('.listen_checked').attr("checked",false)
        window.location.href = go_href+sort_id+'?type='+sort_type+'&is_listen=0';
    }*/

    var type = $(this).toggleClass('course_listen_active').hasClass('course_listen_active');

    if (type) {
        params['is_listen'] = 1
    } else {
        delete params['is_listen'];
    }
    location.href = '?' + $.param(params);
});
