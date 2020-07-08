function locationInfo() {
    var baseURL = window.location.origin;       // "http://localhost:****" or site domain
    var filePath = "/helper/routing.php";
    let csrf_token = $("[name='csrf_token']").val();
    this.getCountries = function() {
        var data = {
            "fetch": "getAllCountry",
            "csrf_token": csrf_token
        };
        $('#country_id').find("option:eq(0)").html("Please wait..");
        $.ajax({
            url: baseURL + filePath,
            method: "POST",
            data: data,
            success : function(data) {
                if(data[0].status == 1){
                    let countries = data[0].result;
                    $('#country_id').find("option:eq(0)").html("Select Country");
                    countries.forEach(function (country) {
                        $("#country_id").append(
                            `<option value='${country.id}'>${country.name}</option>`
                        );
                    });
                    $("#country_id").prop("disabled",false);
                }
                else {
                    alert(data[0].result)
                    $("#country_id").prop("disabled",true);
                }
            },
            error: function(e) {
                console.log(e);
                alert("Error found \nError Code: "+e.status+" \nError Message: "+e.statusText);
            },
            dataType: "json",
            timeout: 60000
        });
    };

    this.getCountryCodes = function() {
        var data = {
            "fetch": "getCountryCodes",
            "csrf_token": csrf_token
        };
        $('#country_code').find("option:eq(0)").html("Please wait..");
        $.ajax({
            url: baseURL + filePath,
            method: "POST",
            data: data,
            success : function(data) {
                if(data[0].status == 1){
                    let countries = data[0].result;
                    $('#country_code').find("option:eq(0)").html("Select Country");
                    countries.forEach(function (country) {
                        $("#country_code").append(
                            `<option value='${country.phonecode}'>${country.name} (${country.phonecode})</option>`
                        );
                    });
                    $("#country_code").prop("disabled",false);
                }
                else {
                    alert(data[0].result)
                    $("#country_code").prop("disabled",true);
                }
            },
            error: function(e) {
                console.log(e);
                alert("Error found \nError Code: "+e.status+" \nError Message: "+e.statusText);
            },
            dataType: "json",
            timeout: 60000
        });
    };

    this.getStates = function(id) {
        $("#state_id option:gt(0)").remove();
        var data = {
            "fetch": "getStates",
            "csrf_token": csrf_token,
            "country_id": id,
        };
        $('#state_id').find("option:eq(0)").html("Please wait..");
        $.ajax({
            url: baseURL + filePath,
            method: "POST",
            data: data,
            success : function(data) {
                if(data[0].status == 1){
                    let states = data[0].result;
                    $('#state_id').find("option:eq(0)").html("Select State");
                    states.forEach(function (state) {
                        $("#state_id").append(
                            `<option value='${state.id}'>${state.name}</option>`
                        );
                    });
                    $("#state_id").prop("disabled",false);
                }
                else {
                    alert(data[0].result)
                    $("#state_id").prop("disabled",true);
                }
            },
            error: function(e) {
                console.log(e);
                alert("Error found \nError Code: "+e.status+" \nError Message: "+e.statusText);
            },
            dataType: "json",
            timeout: 60000
        });
    };
}

function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#preview-image').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$(document).ready(function() {

    var loc = new locationInfo();
    loc.getCountries();
    loc.getCountryCodes();
    $("#country_id").on("change", function(ev) {
        var countryId = $(this).val();
        if(countryId != ''){
            loc.getStates(countryId);
        }
        else{
            $("#state_id option:gt(0)").remove();
        }
    });

    $('#store_id').select2({
        theme: "classic",
        width: "resolve",
    });
    $('#type_id').select2({
        theme: "classic",
        width: "resolve",
    });

    $("#image").change(function() {
        previewImage(this);
    });

    $("#add-employee").validate({
        rules: {
            'email':{
                'required': true,
                'email': true,
                'minlength': 2,
                'maxlength': 255
            },
            'first_name' : {
                'required' : true,
                'minlength' : 2,
                'maxlength' : 255,
            },
            'last_name' : {
                'required' : true,
                'minlength' : 2,
                'maxlength' : 255,
            },
            'store_id' : {
                'required' : true,
            },
            'type_id' : {
                'required' : true,
            },
            'phone' : {
                'required' : true,
                'phone' : true,
            },
            'gender' : {
                'required' : true,
            },
            'birthdate' : {
                'required' : true,
            },
            'building' : {
                'required' : true,
                'minlength' : 2,
                'maxlength' : 255,
            },
            'street' : {
                'minlength' : 2,
                'maxlength' : 255,
            },
            'pincode' : {
                'required' : true,
                'minlength' : 7,
                'maxlength' : 7,
            },
            'landmark' : {
                'minlength' : 2,
                'maxlength' : 255,
            },
            'city' : {
                'required' : true,
                'minlength' : 2,
                'maxlength' : 255,
            },
            'state_id' : {
                'required' : true,
            },
            'country_id' : {
                'required' : true,
            },
            'salary' : {
                'required' : true,
                'min' : 0
            },
            'date_of_joining' : {
                'required' : true,
            },
        },
        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
    });

});
