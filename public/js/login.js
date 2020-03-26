$(document).ready(function(){  


    var windowsize = $(window).width();

        $(window).resize(function() {
        var windowsize = $(window).width();
        });

    if (windowsize <= 1024) {
               
    }else{
        $('#login_img').removeClass("col-5").addClass("col-6");
        $('#login_frm').removeClass("col-7").addClass("col-6");
    }
});