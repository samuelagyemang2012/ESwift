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

function packages() {

    var e = document.getElementById("pkg");
    var strUser = e.options[e.selectedIndex].value;

    alert(strUser);

    $.get("http://eswift.npontu.com/api/get_packages/" + strUser,

        {},

        function (response) {

            if (response.id == 1) {

                console.log(response);
                document.getElementById("package").innerHTML = "The maximum amount you can borrow is " + response.maximum;
            }else {
                alert('dasdas');
            }

        });
}