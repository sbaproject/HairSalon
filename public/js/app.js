// auto close alert after 1.5 seconds
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1500);