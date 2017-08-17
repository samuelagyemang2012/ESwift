function helper() {
    var select_data = document.getElementById('s_mma').value;

    document.getElementById('mma').value = select_data;
}

function packages_helper() {
    var select_data = document.getElementById('s_pkg').value;

    document.getElementById('pk').value = select_data;
}

function packages(id) {


    var e = document.getElementById("pkg");
    var strUser = e.options[e.selectedIndex].value;

    //var select_data = document.getElementById('pkg').selectedIndex.;

    alert(strUser);

}

function pa() {

    var select_data = document.getElementById('pkg').selectedIndex;

    $.get("http://eswift.npontu.com/api/get_packages/" + select_data,
        //{
        //    username: username,
        //    password: password
        //},

        function (response) {

            if (response.message == "Successful Login") {

                $.cookie('username', username);
                $.cookie('password', password);

                // load_contacts();
                get_stats(username, password);

            }

            if (response.message == "Invalid Credential!") {

                toast("Wrong username or password", 5000);
                // popout("loginfail", "pop");
            }
        });
}