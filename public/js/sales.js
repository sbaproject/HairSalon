$(document).ready(function(){

    $("#submit2").hover(function(){
    $('input[name="hid"]').val('2');
    });

    $("#submit1").hover(function(){
    $('input[name="hid"]').val('1');
    }); 

    $('input[name="s_money"]').number( true, 0 );

    $(".statusResult").fadeOut( 5000, function() {
        $("#statusResult").attr('class', 'statusBefore');
        $("#statusResult").html('');
        $("#statusResult").show()
      });
});

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

    let option = document.getElementById("s_c_id").value;
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
    let optName1,optName2,optName3,totalAmount = 0;

    list_course.forEach((element) => {
        if (element.co_id == option) {
            newOption = element
        }
    })

    if(newOption == null)return;
    

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
    })
    
    if(optName1 != null){
        $('input[name="s_opt1"]').val(optName1.op_name);
        totalAmount = totalAmount + optName1.op_amount
    }else{
        $('input[name="s_opt1"]').val('');
    }

    if(optName2 != null){
        $('input[name="s_opt2"]').val(optName2.op_name);
        totalAmount = totalAmount + optName2.op_amount
    }else{
        $('input[name="s_opt2"]').val('');
    }

    if(optName3 != null){
        $('input[name="s_opt3"]').val(optName3.op_name);
        totalAmount = totalAmount + optName3.op_amount
    }else{
        $('input[name="s_opt3"]').val('');
    }

    $('input[name="s_money"]').val(totalAmount);

    $('input[name="s_money"]').number( true, 0 );
}    