import infinite_scroll from "../features/infinite_scroll"



$("#content3 .witchComment").click(function () {
    var self = this;
    var val = this.value ;
    var json = {
        type: 1,
        rank: val,
        object_id: courseId
    };
    console.log(json);
    $("#content3 .tab .active").removeClass('active');
    $(self).addClass('active');
    infinite_scroll.reload(json)
});
