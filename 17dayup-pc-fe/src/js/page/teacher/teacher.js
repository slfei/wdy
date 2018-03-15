$(function(){
    let comment_type = person_comment.comment_type;
    $('input:radio').click(function(e){
        // console.log(e.target.id)
        let cur_id = person_comment.sort_type;
        // console.log(typeof(cur_id))
        let teacher_id = person_comment.teacher_id;
        let sort_type = e.target.id.slice(5)
        // console.log(sort_type);
        if (cur_id==sort_type) {
            return;
        }
        else{
            if (comment_type == 1) {
                window.location.href = '/teacher/commentlist/'+teacher_id+'?type='+sort_type;
            }
            else{
                window.location.href = '/personal/commentlist/'+teacher_id+'?type='+sort_type;
            }
        }
    })
})
