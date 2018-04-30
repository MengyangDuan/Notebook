
function init() {
    getLatestNotes();
    $('#detail-button').on('click', function () {
        addMoments();
    });
    $('#detail-button-xs').on('click', function () {
        addMoments();
    });
}
function getLatestNotes() {
    jQuery.ajax({
        url: 'note',
        cache: false,
        success: function(data) {
            if(data.state == true){
                $("div").remove(".mainPanel");
                var object = data.object;
                if(object !=null) {
                    var showNum=10;
                    if(object.length<10)
                        showNum=object.length;
                    for (var i = 0; i < showNum; i++) {
                        var tem = makeTheHtmlElement(object[i].id, object[i].title, object[i].createdate, object[i].label,i);
                        $('#mainControl').after(tem);
                    }

                    var btns = $('.deletebutton');
                    for (var i = 0; i < btns.length; ++i) {
                        btns[i].onclick = function () {
                            deleteButton($(this).attr('id'));
                        }
                    }

                    var btns2 = $('.detailbutton');
                    for (var i = 0; i < btns.length; ++i) {
                        btns2[i].onclick = function () {
                            detailButton($(this).attr('id'));
                        }
                    }
                }
            }
        }
    })
}

function makeTheHtmlElement(elementid,id,name,time,title,isMy,buttonId) {
    var result = "	<div class='col-xs-10 col-sm-10 col-md-10  col-lg-10 col-xs-offset-1  col-sm-offset-1 col-md-offset-1  col-lg-offset-1  media-list-base mainPanel' >";
    result +="<div class='media'>";
    result= result+"<p style=visibility: hidden>"+elementid+"</p>";
    result+="<a class='media-left' href='#'>";
    result= result + "<img src=\'\./others/dp\/"+picMatch(id)+".png\' alt='dp' class='img-circle'>";
    result+= "</a>";
    result+= "<div class='media-body'>";
    result+="<h4 class='media-heading'>";
    result+=name;

    result+=" <img src='\.\/images\/deleteButton\.png' class='detailbutton' title='删除' id='"+buttonId+"'>";
    if(isMy == true){
        result+=" <img src='\.\/images\/deleteButton\.png' class='deletebutton' title='查看详情' id='"+buttonId+"'>";
    }
    result+="</h4>";
    result+="<p class='time'>";
    result+=time;
    result+="</p>";
    result+="<div class='content'>";
    result+=content;
    result= result+"</div></div></div></div>";
    return result;
}