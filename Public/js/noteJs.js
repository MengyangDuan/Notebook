

function panelMade(id,title,label,createdate,pointElement,result) {
    $.tmpl(result, {
        "id": id,
        filename:title,
        label:label,
        createtime:createdate,
    }).appendTo(pointElement);
}

function detailNoteEvent(id) {
    var pointElement =  $(('#'+id))
    // var Id =  $(this).attr('id');
        jQuery.ajax({
            url: 'note/detail',
            type: 'post',
            cache: false,
            data:{
                id:id
            },
            success: function(data) {
                if(data.state == true){
                    //弹出展示页面
                }else {
                    swal("OMG", "出错啦,请稍后再试", "error");
                }
            }
        })
    }