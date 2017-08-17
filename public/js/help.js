function helper() {
    var select_data = document.getElementById('s_mma').value;

    document.getElementById('mma').value = select_data;
}

function packages_helper() {
    var select_data = document.getElementById('s_pkg').value;

    document.getElementById('pk').value = select_data;
}

function packages() {

    var select_data = document.getElementById('pkg').selectedIndex;

}

function pa() {

    $.get("http://deywuro.com/api/login",
        {
            username: username,
            password: password
        },

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