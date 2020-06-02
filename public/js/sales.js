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

    $("#btn-add-course").click(function() {
        var index = $("#hd-block").val();
        if (index == ''){
            index = 1;
        }
        index++;
        $("#course_group_" + index).css("display", "block");
        if (index >= 5){
            index = 5;
            $(".form-add-course").css("display", "none");
        }
        $("#hd-block").val(index);
        $("#saleoff").prop("checked", false);
        calculatorTotal();
    });

    $(".btn-remove-course").click(function() {
        var index = $("#hd-block").val();
        $("#course_group_" + index).css("display", "none");
        $("#s_co_id" + index).val('');

        $("#s_money_" + index).prop("readonly", false);
        $('#s_money_' + index).val('');
        $('#s_money-hidden_' + index).val('');

        $('input[name="' + 's_opt1_' + index +'"]').val('');
        $('select[name="s_opts1_' + index + '"]').val('');
        $('select[name="s_opts1_' + index + '"]').prop("disabled", false);
        $('input[name="' + 's_opt2_' + index +'"]').val('');
        $('select[name="s_opts2_' + index + '"]').val('');
        $('select[name="s_opts2_' + index + '"]').prop("disabled", false);
        $('input[name="' + 's_opt3_' + index +'"]').val('');
        $('select[name="s_opts3_' + index + '"]').val('');
        $('select[name="s_opts3_' + index + '"]').prop("disabled", false);
        $('input[name="' + 's_opt4_' + index +'"]').val('');
        $('select[name="s_opts4_' + index + '"]').val('');
        $('select[name="s_opts4_' + index + '"]').prop("disabled", false);
        $('input[name="' + 's_opt5_' + index +'"]').val('');
        $('select[name="s_opts5_' + index + '"]').val('');
        $('select[name="s_opts5_' + index + '"]').prop("disabled", false);

        index--;
        if (index < 1){
            index = 1;
        }
        $(".form-add-course").css("display", "block");
        $("#hd-block").val(index);
        $("#saleoff").prop("checked", false);
        calculatorTotal();
    });

    var windowsize1 = $(window).width();
    ReponsivePage(windowsize1);

    $(window).resize(function() {
        var windowsize = $(window).width();
        ReponsivePage(windowsize);        
    });    

    $('#s_money_1').keyup(function() {
        var string = numeral($('#s_money_1').val()).format('0,0');
        $('#s_money_1').val(string);
        calculatorTotal();
    });

    $('#s_money_2').keyup(function() {
        var string = numeral($('#s_money_2').val()).format('0,0');
        $('#s_money_2').val(string);
        calculatorTotal();
    });

    $('#s_money_3').keyup(function() {
        var string = numeral($('#s_money_3').val()).format('0,0');
        $('#s_money_3').val(string);
        calculatorTotal();
    });

    $('#s_money_4').keyup(function() {
        var string = numeral($('#s_money_4').val()).format('0,0');
        $('#s_money_4').val(string);
        calculatorTotal();
    });

    $('#s_money_5').keyup(function() {
        var string = numeral($('#s_money_5').val()).format('0,0');
        $('#s_money_5').val(string);
        calculatorTotal();
    });
});

function ReponsivePage(windowsize){
    if (windowsize <= 1433) {

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

function onCourseChange(index ,selectBox ,list_course,list_option) {
    let option = document.getElementById(selectBox).value;
    let newOption;
    let optName1,optName2,optName3,optName4,optName5,totalAmount = 0;

    if(option == ''){
        $('input[name="' + 's_opt1_' + index +'"]').val('');
        $('select[name="s_opts1_' + index + '"]').val('');
        $('input[name="' + 's_opt2_' + index +'"]').val('');
        $('select[name="s_opts2_' + index + '"]').val('');
        $('input[name="' + 's_opt3_' + index +'"]').val('');
        $('select[name="s_opts3_' + index + '"]').val('');
        $('input[name="' + 's_opt4_' + index +'"]').val('');
        $('select[name="s_opts4_' + index + '"]').val('');
        $('input[name="' + 's_opt5_' + index +'"]').val('');
        $('select[name="s_opts5_' + index + '"]').val('');
        $('input[name="s_money_' + index + '"]').val('');
        $('input[name="s_money-hidden' + index + '"]').val('');
        $("#saleoff").prop("checked", false);   // reset checkbox saleoff to unchecked
        calculatorTotal();
        return;
    }

    if (option == 0) {
        // remove readonly prop for s_money to type the money
        $("#s_money_" + index).prop("readonly", false);
        $('#s_money_' + index).val('');

        $('input[name="' + 's_opt1_' + index +'"]').val('フリー');
        $('select[name="s_opts1_' + index + '"]').val('');
        $('input[name="' + 's_opt2_' + index +'"]').val('');
        $('select[name="s_opts2_' + index + '"]').val('');
        $('select[name="s_opts2_' + index + '"]').prop("disabled", true);
        $('input[name="' + 's_opt3_' + index +'"]').val('');
        $('select[name="s_opts3_' + index + '"]').val('');
        $('select[name="s_opts3_' + index + '"]').prop("disabled", true);
        $('input[name="' + 's_opt4_' + index +'"]').val('');
        $('select[name="s_opts4_' + index + '"]').val('');
        $('select[name="s_opts4_' + index + '"]').prop("disabled", true);
        $('input[name="' + 's_opt5_' + index +'"]').val('');
        $('select[name="s_opts5_' + index + '"]').val('');
        $('select[name="s_opts5_' + index + '"]').prop("disabled", true);
        $('#course_changed').val('1');
        $("#saleoff").prop("checked", false);   // reset checkbox saleoff to unchecked
        calculatorTotal();
        return;
    }

    if (option == 9999) {
        // remove readonly prop for s_money to type the money
        $("#s_money_" + index).prop("readonly", false);
        $('#s_money_' + index).val('');
        $('input[name="' + 's_opt1_' + index +'"]').val('商品販売');
        $('select[name="s_opts1_' + index + '"]').val('');
        $('input[name="' + 's_opt2_' + index +'"]').val('');
        $('select[name="s_opts2_' + index + '"]').val('');
        $('select[name="s_opts2_' + index + '"]').prop("disabled", true);
        $('input[name="' + 's_opt3_' + index +'"]').val('');
        $('select[name="s_opts3_' + index + '"]').val('');
        $('select[name="s_opts3_' + index + '"]').prop("disabled", true);
        $('input[name="' + 's_opt4_' + index +'"]').val('');
        $('select[name="s_opts4_' + index + '"]').val('');
        $('select[name="s_opts4_' + index + '"]').prop("disabled", true);
        $('input[name="' + 's_opt5_' + index +'"]').val('');
        $('select[name="s_opts5_' + index + '"]').val('');
        $('select[name="s_opts5_' + index + '"]').prop("disabled", true);
        $('#course_changed').val('1');
        $("#saleoff").prop("checked", false);   // reset checkbox saleoff to unchecked
        calculatorTotal();
        return;
    }

    $("#s_money_" + index).prop("readonly", true);
    
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
        $('input[name="' + 's_opt1_' + index +'"]').val(optName1.op_name);
        totalAmount = totalAmount + parseInt(optName1.op_amount);
        $('select[name="s_opts1_' + index + '"]').prop("disabled", false);
    }else{
        $('input[name="' + 's_opt1_' + index +'"]').val('');
        $('select[name="s_opts1_' + index + '"]').val('');
        $('select[name="s_opts1_' + index + '"]').prop("disabled", true);
    }

    if(optName2 != null){
        $('input[name="' + 's_opt2_' + index +'"]').val(optName2.op_name);
        totalAmount = totalAmount + parseInt(optName2.op_amount);
        $('select[name="s_opts2_' + index + '"]').prop("disabled", false);
    }else{
        $('input[name="' + 's_opt2_' + index +'"]').val('');
        $('select[name="s_opts2_' + index + '"]').val('');
        $('select[name="s_opts2_' + index + '"]').prop("disabled", true);
    }

    if(optName3 != null){
        $('input[name="' + 's_opt3_' + index +'"]').val(optName3.op_name);
        totalAmount = totalAmount + parseInt(optName3.op_amount);
        $('select[name="s_opts3_' + index + '"]').prop("disabled", false);
    }else{
        $('input[name="' + 's_opt3_' + index +'"]').val('');
        $('select[name="s_opts3_' + index + '"]').val('');
        $('select[name="s_opts3_' + index + '"]').prop("disabled", true);
    }

    if(optName4 != null){
        $('input[name="' + 's_opt4_' + index +'"]').val(optName4.op_name);
        totalAmount = totalAmount + parseInt(optName4.op_amount);
        $('select[name="s_opts4_' + index + '"]').prop("disabled", false);
    }else{
        $('input[name="' + 's_opt4_' + index +'"]').val('');
        $('select[name="s_opts4_' + index + '"]').val('');
        $('select[name="s_opts4_' + index + '"]').prop("disabled", true);
    }

    if(optName5 != null){
        $('input[name="' + 's_opt5_' + index +'"]').val(optName5.op_name);
        totalAmount = totalAmount + parseInt(optName5.op_amount);
        $('select[name="s_opts5_' + index + '"]').prop("disabled", false);
    }else{
        $('input[name="' + 's_opt5_' + index +'"]').val('');
        $('select[name="s_opts5_' + index + '"]').val('');
        $('select[name="s_opts5_' + index + '"]').prop("disabled", true);
    }

    var totalAmountFormat = numeral(totalAmount).format('0,0');
    $('input[name="s_money_' + index +'"]').val(totalAmountFormat);
    $('input[name="s_money-hidden_'+ index+ '"]').val(totalAmountFormat);
    calculatorTotal();
    $('#course_changed').val('1');
    
    // reset checkbox saleoff to unchecked
    $("#saleoff").prop("checked", false);
}

function calculatorTotal() {
    var money_1 = $('#s_money_1').val();
    var money_2 = $('#s_money_2').val();
    var money_3 = $('#s_money_3').val();
    var money_4 = $('#s_money_4').val();
    var money_5 = $('#s_money_5').val();
    var money_total = 0;

    money_1 = money_1.replace(/,/g, '');
    if (money_1 != '') {
        money_total += parseInt(money_1);
    }
    money_2 = money_2.replace(/,/g, '');
    if (money_2 != '') {
        money_total +=parseInt(money_2);
    }

    money_3 = money_3.replace(/,/g, '');
    if (money_3 != '') {
        money_total +=parseInt(money_3);
    }

    money_4 = money_4.replace(/,/g, '');
    if (money_4 != '') {
        money_total +=parseInt(money_4);
    }

    money_5 = money_5.replace(/,/g, '');
    if (money_5 != '') {
        money_total +=parseInt(money_5);
    }

    var totalAmountFormat = '';
    if (money_total > 0){
         totalAmountFormat = numeral(money_total).format('0,0');
    }
    $('input[name="s_total_money"]').val(totalAmountFormat);
    $('input[name="s_total_money-hidden"]').val(totalAmountFormat);


}