function helper() {
    var select_data = document.getElementById('s_mma').value;

    document.getElementById('mma').value = select_data;
}

function packages_helper() {
    var select_data = document.getElementById('s_pkg').value;

    document.getElementById('pk').value = select_data;
}

function process_tel() {

    var first, tel, substring, prefix, prefix2;

    tel = $("#tel").val();

    tel = tel.split("+");

    tel = tel.join("");

    //mma = $("#mobile_money_account");

    if (tel.length != 0) {

        first = tel.charAt(0);

        if (first == '0') {

            $("#telplus").html("");
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

        $("#telplus").html("");
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

function get_balance() {

    var package = $('#pkg').val();

    $.get('http://eswift.npontu.com/api/get_packages/' + package,

        {},

        function (response) {

            if (response.code == 1) {
                alert(response.maximum);
            } else {
                alert('fail');
            }
        }
    );


}