$(document).ready(function(){

    $("#submit2").hover(function(){
    $('input[name="hid"]').val('2');
    });

    $("#submit1").hover(function(){
    $('input[name="hid"]').val('1');
    }); 

    $(".statusResult").fadeOut( 7000, function() {
        $("#statusResult").attr('class', 'statusBefore');
        $("#statusResult").html('');
        $("#statusResult").show()
      });

    $(".table-fixed td").each(function(){
        
        var bien = $(this).html();
        
        if (bien === '') {
            $(this).css('padding','27px');
        }

        if($(this).attr('id') =='link' ){   

        }else{
            if (bien.length > 50 ) {
                $(this).html(bien.substring(0,50)+'...');
            }
 
          }       
    });


    $("#course-table td").each(function(){
        
        var bien = $(this).html();
        
        if (bien === '') {
            $(this).css('padding','27px');
        }

        if($(this).attr('id') =='link' ){   

        }else{
            if (bien.length > 10 ) {
                $(this).html(bien.substring(0,10)+'...');
            }
 
          }       
    });

    $("#option-table td").each(function(){
        
        var bien = $(this).html();
        
        if (bien === '') {
            $(this).css('padding','27px');
        }

        if($(this).attr('id') =='link' ){   

        }else{
            if (bien.length > 50 ) {
                $(this).html(bien.substring(0,50)+'...');
            }
 
          }       
    });

    var windowsize1 = $(window).width();
    ReponsivePage(windowsize1);

    $(window).resize(function() {
        var windowsize = $(window).width();
        ReponsivePage(windowsize);        
    });    

    $('#s_money').keyup(function() {
        var string = numeral($('#s_money').val()).format('0,0');
        $('#s_money').val(string);
    });
});

function ReponsivePage(windowsize){
    if (windowsize <= 1024) {

        $('#option-table > thead  > tr').each(function(index, tr) {             
            $(this).find("th:eq(0)").removeAttr('width').css("width", "15%");
            $(this).find("th:eq(1)").removeAttr('width').css("width", "45%");
            $(this).find("th:eq(2)").removeAttr('width').css("width", "20%");
            $(this).find("th:eq(3)").removeAttr('width').css("width", "20%");
         });

        $('#option-table > tbody  > tr').each(function(index, tr) {             
            $(this).find("th:eq(0)").removeAttr('width').css("width", "15%");
            $(this).find("td:eq(0)").removeAttr('width').css("width", "45%");
            $(this).find("td:eq(1)").removeAttr('width').css("width", "20%");
            $(this).find("td:eq(2)").removeAttr('width').css("width", "20%");
         });
         

        // IPAD
        if(windowsize<=768){
            // QUAY DOC
            
            //page master/banner
            $('#title').removeClass("col-4").addClass("col-3");
            $('#title_cls').removeClass("title_cls").addClass("title_cls_ver");   
            $('#user-name').removeClass("user-name").addClass("user-name_ver"); 
            $('#user-logout').removeClass("user-logout").addClass("user-logout_ver"); 

            //page login
            $('#login_img').removeClass("col-5").addClass("col-4");
            $('#login_frm').removeClass("col-7").addClass("col-8");

            //page sales
            $('#sale_search').removeClass("col-8").addClass("col-10");
            $('#sale_total').removeClass("col-3").addClass("col-4");
            $('#sale_pre').removeClass("col-2").addClass("col-2");
            $('#sale_totalPrice').removeClass("col-3").addClass("col-4");            
            
            //page customer
            $('#customer_search_error').removeClass().addClass("col-md-10");            
            $('#customer_title_result').removeClass().addClass("col-md-3");      
            
            //All page width
            $('#sales_new_edit_frm').removeClass().addClass("col-12");         
            $('#course_new_edit_frm').removeClass().addClass("col-12");   
            $('#option_new_edit_frm').removeClass().addClass("col-12");   
            $('#staff_new_edit_frm').removeClass().addClass("col-12");   
            $('#customer_new_edit_frm').removeClass().addClass("col-12"); 
            
            //page customer
            $('#sale_date').removeClass("col-md-2").addClass("col-md-3");
            
        }else{
            // QUAY NGANG

            //page master/banner
            $('#title').removeClass("col-3").addClass("col-4");
            $('#title_cls').removeClass("title_cls_ver").addClass("title_cls");   
            $('#user-name').removeClass("user-name_ver").addClass("user-name"); 
            $('#user-logout').removeClass("user-logout_ver").addClass("user-logout"); 

             //page sales
             $('#sale_search').removeClass("col-10").addClass("col-8");
             $('#sale_total').removeClass("col-4").addClass("col-3");
             $('#sale_pre').removeClass("col-2").addClass("col-2");
             $('#sale_totalPrice').removeClass("col-4").addClass("col-3");  

             //page customer
            $('#customer_search_error').removeClass().addClass("col-md-10");            
            $('#customer_title_result').removeClass().addClass("col-md-3"); 

            //All page width
            $('#sales_new_edit_frm').removeClass().addClass("col-11");         
            $('#course_new_edit_frm').removeClass().addClass("col-11");   
            $('#option_new_edit_frm').removeClass().addClass("col-11");   
            $('#staff_new_edit_frm').removeClass().addClass("col-11");   
            $('#customer_new_edit_frm').removeClass().addClass("col-11");  

            //page customer
            $('#sale_date').removeClass("col-md-3").addClass("col-md-2");
        }
    }else{
        // MAY BANG

        //page master/banner
        $('#logo').removeClass("col-3").addClass("col-2");
        $('#username').removeClass("col-3").addClass("col-4");

        //page login
        $('#login_img').removeClass("col-5").addClass("col-6");
        $('#login_frm').removeClass("col-7").addClass("col-6");

        //page sales
        $('#sale_search').removeClass("col-8").addClass("col-5");
        $('#sale_total').removeClass("col-3").addClass("col-2");
        $('#sale_pre').removeClass("col-2").addClass("col-1");
        $('#sale_totalPrice').removeClass("col-3").addClass("col-2");
    }
}

$(function() {
    $.datepicker.regional["ja"] = {
        closeText: "閉じる",
        prevText: "&#x3c;前",
        nextText: "次&#x3e;",
        currentText: "今日",
        monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        monthNamesShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        dayNames: ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"],
        dayNamesShort: ["日", "月", "火", "水", "木", "金", "土"],
        dayNamesMin: ["日", "月", "火", "水", "木", "金", "土"],
        weekHeader: "週",
        dateFormat: "yy/mm/dd",
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(2000, 0, 1),
        maxDate: new Date(2030, 11, 31),
        yearRange: "2000:2030",
        yearSuffix: "年"
    };
    $.datepicker.setDefaults($.datepicker.regional["ja"]);
});

// datepicerセット.
$(function() {
    $('.datetimepicker-input').datepicker();
});

function onCustomerChange(list_customer) {  

    let option = document.getElementById("hid_s_c_id").value;
    let newOption;   

    list_customer.forEach((element) => {
        if (element.c_id == option) {
            newOption = element
        }
    })

    if(newOption != null){
        $('input[name="txt_lastname"]').val(newOption.c_lastname);
        $('input[name="txt_firstname"]').val(newOption.c_firstname);
    }else{
        $('input[name="txt_lastname"]').val('');
        $('input[name="txt_firstname"]').val('');
    }        
}

function onCourseChange(list_course,list_option) {  
    let option = document.getElementById("s_co_id").value;
    let newOption;
    let optName1,optName2,optName3,optName4,optName5,totalAmount = 0;

    if(option == ''){
        $('input[name="s_opt1"]').val('');
        $('select[name="s_opts1"]').val('');
        $('input[name="s_opt2"]').val('');
        $('select[name="s_opts2"]').val('');
        $('input[name="s_opt3"]').val('');
        $('select[name="s_opts3"]').val('');
        $('input[name="s_opt4"]').val('');
        $('select[name="s_opts4"]').val('');
        $('input[name="s_opt5"]').val('');
        $('select[name="s_opts5"]').val('');
        $('input[name="s_money"]').val('');
        $('input[name="s_money-hidden"]').val('');
        $("#saleoff").prop("checked", false);   // reset checkbox saleoff to unchecked
        return;
    }

    if (option == 0) {
        // remove readonly prop for s_money to type the money
        $("#s_money").prop("readonly", false);
        $('#s_money').val('');

        $('input[name="s_opt1"]').val('フリー');
        $('select[name="s_opts1"]').val('');
        $('input[name="s_opt2"]').val('');
        $('select[name="s_opts2"]').val('');
        $('select[name="s_opts2"]').prop("disabled", true);
        $('input[name="s_opt3"]').val('');
        $('select[name="s_opts3"]').val('');
        $('select[name="s_opts3"]').prop("disabled", true);
        $('input[name="s_opt4"]').val('');
        $('select[name="s_opts4"]').val('');
        $('select[name="s_opts4"]').prop("disabled", true);
        $('input[name="s_opt5"]').val('');
        $('select[name="s_opts5"]').val('');
        $('select[name="s_opts5"]').prop("disabled", true);
        $('#course_changed').val('1');
        $("#saleoff").prop("checked", false);   // reset checkbox saleoff to unchecked
        return;
    } 

    $("#s_money").prop("readonly", true);
    
    list_course.forEach((element) => {
        if (element.co_id == option) {
            newOption = element
        }
    })
    
    list_option.forEach((element) => {
        if (element.op_id == newOption.co_opt1) {
            optName1 = element
        }
        if (element.op_id == newOption.co_opt2) {
            optName2 = element
        }
        if (element.op_id == newOption.co_opt3) {
            optName3 = element
        }
        if (element.op_id == newOption.co_opt4) {
            optName4 = element
        }
        if (element.op_id == newOption.co_opt5) {
            optName5 = element
        }
    })
    
    if(optName1 != null){
        $('input[name="s_opt1"]').val(optName1.op_name);
        totalAmount = totalAmount + parseInt(optName1.op_amount);
        $('select[name="s_opts1"]').prop("disabled", false);
    }else{
        $('input[name="s_opt1"]').val('');
        $('select[name="s_opts1"]').val('');
        $('select[name="s_opts1"]').prop("disabled", true);
    }

    if(optName2 != null){
        $('input[name="s_opt2"]').val(optName2.op_name);
        totalAmount = totalAmount + parseInt(optName2.op_amount);
        $('select[name="s_opts2"]').prop("disabled", false);
    }else{
        $('input[name="s_opt2"]').val('');
        $('select[name="s_opts2"]').val('');
        $('select[name="s_opts2"]').prop("disabled", true);
    }

    if(optName3 != null){
        $('input[name="s_opt3"]').val(optName3.op_name);
        totalAmount = totalAmount + parseInt(optName3.op_amount);
        $('select[name="s_opts3"]').prop("disabled", false);
    }else{
        $('input[name="s_opt3"]').val('');
        $('select[name="s_opts3"]').val('');
        $('select[name="s_opts3"]').prop("disabled", true);
    }

    if(optName4 != null){
        $('input[name="s_opt4"]').val(optName4.op_name);
        totalAmount = totalAmount + parseInt(optName4.op_amount);
        $('select[name="s_opts4"]').prop("disabled", false);
    }else{
        $('input[name="s_opt4"]').val('');
        $('select[name="s_opts4"]').val('');
        $('select[name="s_opts4"]').prop("disabled", true);
    }

    if(optName5 != null){
        $('input[name="s_opt5"]').val(optName5.op_name);
        totalAmount = totalAmount + parseInt(optName5.op_amount);
        $('select[name="s_opts5"]').prop("disabled", false);
    }else{
        $('input[name="s_opt5"]').val('');
        $('select[name="s_opts5"]').val('');
        $('select[name="s_opts5"]').prop("disabled", true);
    }

    var totalAmountFormat = numeral(totalAmount).format('0,0');
    $('input[name="s_money"]').val(totalAmountFormat);
    $('input[name="s_money-hidden"]').val(totalAmountFormat);
    $('#course_changed').val('1');
    
    // reset checkbox saleoff to unchecked
    $("#saleoff").prop("checked", false);
}    