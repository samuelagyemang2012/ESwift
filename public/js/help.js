function helper() {
    var select_data = document.getElementById('s_mma').value;

    document.getElementById('mma').value = select_data;
}

function packages_helper() {
    var select_data = document.getElementById('s_pkg').value;

    document.getElementById('pk').value = select_data;
}

//function packages() {
//
//}

function process_tel() {

    var first, tel, substring, prefix, prefix2;

    tel = $("#tel").val();

    //mma = $("#mobile_money_account");

    if (tel.length != 0) {

        first = tel.charAt(0);

        if (first == '0') {

            first = '233';
            substring = tel.substring(1, 10);
            prefix = tel.substring(0, 3);

            //alert(prefix2);

            $("#tel").val(first + substring);

            if (prefix == '024' || prefix == '054' || prefix == '055') {
                $("#mobile_money_account").val("MTN");
            }

            if (prefix == '027' || prefix == '057' || prefix == '029') {
                $("#mobile_money_account").val("TIGO");
            }

            if (prefix == '020' || prefix == '050') {
                $("#mobile_money_account").val("VODAFONE");
            }

            if (prefix == '026' || prefix == '056') {
                $("#mobile_money_account").val("VODAFONE");
            }
        }
    }

    if (first == '2') {

        prefix2 = tel.substring(0, 5);

        //alert(prefix2);

        if (prefix2 == '23324' || prefix2 == '23354' || prefix2 == '23355') {
            $("#mobile_money_account").val("MTN");
        }

        if (prefix2 == '23327' || prefix2 == '23357' || prefix2 == '23329') {
            $("#mobile_money_account").val("TIGO");
        }

        if (prefix2 == '23320' || prefix2 == '23350') {
            $("#mobile_money_account").val("VODAFONE");
        }

        if (prefix2 == '23326' || prefix2 == '23356') {
            $("#mobile_money_account").val("VODAFONE");
        }
    }
}
//var e = document.getElementById("pkg");
//var strUser = e.options[e.selectedIndex].value;
//
////alert(strUser);
//
//$.get("http://eswift.npontu.com/api/get_packages/" + strUser,
//
//    {},
//
//    function (response) {
//
//        if (response.id == 1) {
//
//            console.log(response);
//            document.getElementById("package").innerHTML = "The maximum amount you can borrow is " + response.maximum;
//        }else {
//            //alert('dasdas');
//        }
//
//    });
//}