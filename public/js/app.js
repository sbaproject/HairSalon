// auto close alert after 2 seconds
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

function onOption1Change(list_option) {
    let option = document.getElementById("select-option-1").value;
    let newOption;

    list_option.forEach((element) => {
        if (element.op_id == option) {
            newOption = element
        }
    })
    document.getElementById("option-amount-1").innerHTML = newOption.op_amount;
    totalAmount();
}

function onOption2Change(list_option) {
    let option = document.getElementById("select-option-2").value;
    let newOption;

    list_option.forEach((element) => {
        if (element.op_id == option) {
            newOption = element
        }
    })
    document.getElementById("option-amount-2").innerHTML = newOption.op_amount;
    totalAmount();
}

function onOption3Change(list_option) {
    let option = document.getElementById("select-option-3").value;
    let newOption;

    list_option.forEach((element) => {
        if (element.op_id == option) {
            newOption = element
        }
    })
    document.getElementById("option-amount-3").innerHTML = newOption.op_amount;
    totalAmount();
}

function totalAmount() {
    let option1 = parseInt(document.getElementById("option-amount-1").innerHTML);
    let option2 = parseInt(document.getElementById("option-amount-2").innerHTML);
    let option3 = parseInt(document.getElementById("option-amount-3").innerHTML);
    let total = option1 + option2 + option3;
    document.getElementById("co_money").value = total;
}
