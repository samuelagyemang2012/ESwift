function helper() {
    var select_data = document.getElementById('s_mma').value;

    document.getElementById('mma').value = select_data;
}

function packages_helper() {
    var select_data = document.getElementById('s_pkg').value;

    document.getElementById('pk').value = select_data;
}

function packages() {
    var package = document.getElementById('pkg').value;

    if (package == "BRONZE") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 500";
    }

    if (package == "SILVER") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 1000";
    }

    if (package == "GOLD") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 1500";
    }

    if (package == "PLATINUM") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 2000";
    }

    if (package == "PREMIUM") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 3000";
    }

    if (package == "PREMIUM_DELUXE") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 4000";
    }

    if (package == "PREMIUM_CLASSIC") {
        document.getElementById('package').innerHTML = "This package allows you to borrow a maximum of GHC 5000";
    }

    if (package == "") {
        document.getElementById('package').innerHTML = "";
    }

}