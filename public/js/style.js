function getLikeDislike() {

    let bid = $("#id").text();
    $.ajax({
        url: "/blog/" + bid + "/getCountValues",
        type: "GET",
        cache: false,
        success: function (dataResult) {
            setValues(dataResult)
        }
    });
}

function setValues(dataResult){
    $("#like").text(dataResult["total_likes"]);
    $("#dislike").text(dataResult["total_dislikes"]);
    $("#c_counter").text(dataResult["total_comment"]);
    if(dataResult["user_likes"] == 0)
        $like_image_path = "../../img/like.png";
    else if(dataResult["user_likes"] == 1)
        $like_image_path = "../../img/like-fill.png";
    if(dataResult["user_dislikes"] == 0)
        $dislike_image_path = "../../img/dislike.png";
    else if(dataResult["user_dislikes"] == 1)
        $dislike_image_path = "../../img/dislike-fill.png";
    $("#likeimg").attr("src", $like_image_path);
    $("#dislikeimg").attr("src", $dislike_image_path);
}

function scrollCommentSection(){
    var scrolled=0;
    scrolled =  $("#co").css("height");
    $(".commentSection").animate({
        scrollTop:  scrolled
    },2000);
}

function getNestedCommentData(cid){

    let bid = $("#id").text();
    $.ajax({
        url: "/blog/" + bid + "/"+ cid +"/nested-comment",
        type: "GET",
        cache: false,
        success: function (dataResult) {
            dataResult = JSON.parse(dataResult);
            let dataStr = "";
            for (let i = 0; i < dataResult.length; i++) {
                var mydate = new Date(dataResult[i]["created_at"]);
                var month = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"][mydate.getMonth()];

                var date = mydate.getDate() + " " + month + "," + mydate.getFullYear();
                if(dataResult["length"] !== 0){
                    dataStr += "<div class='container p-2 mb-3 w-75 float-right bg-white rounded '>" +
                        "           <div class='container clearfix w-100'>\n" +
                            "              <h6 class='text-dark float-left '>"+dataResult[i]["name"]+"</h6>\n" +
                            "              <h6 class='float-left text-secondary'>&nbsp "+ date +"</h6>\n" +
                            "          </div>\n" +
                            "          <hr class='m-2 bg-secondary'>\n" +
                            "              <div class='container '>\n" +
                            "                      <p class=' text-dark '>"+dataResult[i]["sub_comment"]+"</p>\n" +
                            "               </div>\n" +
                        "  </div>";

                }
                $("#nestedCommentSection"+cid).html(dataStr);
            }
        }
    });
}

function userBlogsCounterValues(bid){
    $.ajax({
        url: "/blog/" + bid + "/getCountValues",
        type: "GET",
        cache: false,
        success: function (dataResult) {
            $("#likes"+bid).text(dataResult["total_likes"]);
            $("#dislikes"+bid).text(dataResult["total_dislikes"]);
            $("#comments"+bid).text(dataResult["total_comment"]);
        }
    });
}
$(document).ready(function () {

    $("#upArrow").on("click",function (){
        var scrolled=0;
            $(".commentSection").animate({
                scrollTop:  scrolled
            },2000);
    });
    /* comment section toggle */
    scrollCommentSection();
    $(document).off("click","#comment");
    $(document).on('click',"#comment", function () {
        var counter = $("#c_counter").text();
        if(counter != 0) {
            $("#comment-section").fadeToggle("slow");
        }
        else{
            $("#comment-section").text("No Comments");
            $("#comment-section").fadeToggle("slow");
        }
    });

    /* set like dislike */
    $("#likeimg").on('click',function (){
        let bid = $("#id").text();
        let str = "like";
        $.ajax({
            url: "/blog/" + bid + "/"+str,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                getLikeDislike()
            }
        });
    });

    /* Disike Button Code */
    $("#dislikeimg").on('click',function (){
        let bid = $("#id").text();
        let str = "dislikes";
        $.ajax({
            url: "/blog/" + bid + "/"+str,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                getLikeDislike()
            }
        });
    });

    $(document).off("click",".reply");
    $(".reply").on('click',function (){
        if($(this).data('clicked',true)){
            let v = $(this).val();
            let c = "#".concat(v);
            $(c).fadeToggle("slow");
        }
    });

    $(document).off("click",".sub");
    $(".sub").on("click",function(){
        if($(this).data('clicked',true)) {
            let v = $(this).val();
            let c = "textarea#commentReply".concat(v);
            let value = $(c).val();
            let blog_id = $("#id").text();
            let comment_id = $(this).val();
            let errorid = ".replyError".concat(comment_id);
            if(value == ""){
                $(errorid).addClass("text-danger");
                $(errorid).text("this field is required");
            }else{
                $(errorid).text("");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/blog/" + blog_id + "/"+comment_id+"/reply",
                    type: "post",
                    data:{
                        blog_id : blog_id,
                        comment_id : comment_id,
                        comment : value
                    },
                    cache: false,
                    success: function (dataResult) {
                        getLikeDislike()
                        $(errorid).addClass("text-success");
                        $(errorid).text(dataResult);
                        getNestedCommentData(comment_id);
                        setTimeout(function (){
                            $(c).val("");
                            $(errorid).text("");
                            $("#"+comment_id).fadeToggle("slow");
                        },1000);
                    }
                });
            }
        }
    });

});

