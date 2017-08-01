/**
 * Created by samuel on 5/22/2017.
 */


function readURL(input) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image').attr("src", e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

//function cha
//
$("#pic").change(function () {
    alert("gghjh");
    //readURL(this);
//
});


function validate(name, id, min) {
    var input = $("#" + name);

    var data = input.val();
    var span = $("#" + id);

    var m = parseInt(min);

    if (data.length < min) {
        input.css('border', '1px solid red');
        span.html("<b style='color: crimson'>Minimum: " + m + "</b>");
    } else {
        input.css('border', '1px solid #5FFC3F');
        span.html('<b></b>');
    }
}


