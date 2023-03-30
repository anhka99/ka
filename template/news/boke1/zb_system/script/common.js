
//WAPdaohang手机导航
        jQuery(document).ready(function ($) {

            /* prepend menu icon */

            $('#navs-wrap').prepend('<div id="menu-icon">导航</div>');

            /* toggle nav */

            $("#menu-icon").on("click", function () {

                $("#navs").slideToggle();

                $(this).toggleClass("active");

            });

        });

//daohanggaoliang导航高亮
jQuery(document).ready(function($){ 
var datatype=$("#hamburgermenu").attr("data-type");
    $(".menu>li ").each(function(){
        try{
            var myid=$(this).attr("id");
            if("index"==datatype){
                if(myid=="nvabar-item-index"){
                    $("#nvabar-item-index a:first-child").addClass("on");
                }
            }else if("category"==datatype){
                var infoid=$("#hamburgermenu").attr("data-infoid");
                if(infoid!=null){
                    var b=infoid.split(' ');
                    for(var i=0;i<b.length;i++){
                        if(myid=="navbar-category-"+b[i]){
                            $("#navbar-category-"+b[i]+" a:first-child").addClass("on");
                        }
                    }
                }
            }else if("article"==datatype){
                var infoid=$("#hamburgermenu").attr("data-infoid");
                if(infoid!=null){
                    var b=infoid.split(' ');
                    for(var i=0;i<b.length;i++){
                        if(myid=="navbar-category-"+b[i]){
                            $("#navbar-category-"+b[i]+" a:first-child").addClass("on");
                        }
                    }
                }
            }else if("page"==datatype){
                var infoid=$("#hamburgermenu").attr("data-infoid");
                if(infoid!=null){
                    if(myid=="navbar-page-"+infoid){
                        $("#navbar-page-"+infoid+" a:first-child").addClass("on");
                    }
                }
            }else if("tag"==datatype){
                var infoid=$("#hamburgermenu").attr("data-infoid");
                if(infoid!=null){
                    if(myid=="navbar-tag-"+infoid){
                        $("#navbar-tag-"+infoid+" a:first-child").addClass("on");
                    }
                }
            }
        }catch(E){}
    });
});

//celan侧栏跟随   
                (function () {
                    var oDiv = document.getElementById("float");
                    var H = 0,
                        iE6;
                    var Y = oDiv;
                    while (Y) {
                        H += Y.offsetTop;
                        Y = Y.offsetParent
                    };
                    iE6 = window.ActiveXObject && !window.XMLHttpRequest;
                    if (!iE6) {
                        window.onscroll = function () {
                            var s = document.body.scrollTop || document.documentElement.scrollTop;
                            if (s > H) {
                                oDiv.className = "div1 div2";
                                if (iE6) {
                                    oDiv.style.top = (s - H) + "px";
                                }
                            } else {
                                oDiv.className = "div1";
                            }
                        };
                    }
                })();
//top+comment
        //top+comment

        lastScrollY = 0;



        function heartBeat() {

            var diffY;

            if (document.documentElement && document.documentElement.scrollTop)

                diffY = document.documentElement.scrollTop;

            else if (document.body)

                diffY = document.body.scrollTop

            else { /*Netscape stuff*/ }

            percent = .1 * (diffY - lastScrollY);

            if (percent > 0) percent = Math.ceil(percent);

            else percent = Math.floor(percent);

            document.getElementById("full").style.top = parseInt(document.getElementById("full").style.top) + percent + "px";

            lastScrollY = lastScrollY + percent;

            if (diffY > 200) {

                document.getElementById("full").style.display = "block"

            } else {

                document.getElementById("full").style.display = "none"

            }

        }

        suspendcode = "<div id=\"topend\"><div id=\"full\" style='display:none; width:15px; height:57px; POSITION:absolute; left:50%; top:420px; margin-left:320px;  z-index:100; text-align:center;'><a href='#'><img src='https://lusongsong.com/zb_users/theme/LuSongSong/style/images/btn_top.gif' /></a><br><br><a href='https://lusongsong.com/tougao.html' target='_blank'><img src='https://lusongsong.com/zb_users/theme/LuSongSong/style/images/btn_tougao.gif' /></a><br><br><a href='#comment'><img src='https://lusongsong.com/zb_users/theme/LuSongSong/style/images/btn_comment.gif' /></a></div></div>"

        document.write(suspendcode);

        window.setInterval("heartBeat()", 1);



        function switchImage(imageId, imageUrl, linkId, linkUrl, preview, title, alt) {

            if (imageId && imageUrl) {

                var image = $(imageId);

                image.src = imageUrl;



                if (title) {

                    image.title = title;

                }

                if (alt) {

                    image.alt = alt;

                }

            }



            if (linkId && linkUrl) {

                var link = $(linkId);

                link.href = linkUrl;

            }

        }
//baidu share