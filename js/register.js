/**
 * Created by Lunding on 06/08/15.
 */

var firstName;
var lastName;
var email;
var phoneNumber;
var university;
var major;
var story;
var dietary;
var hackathons;
var year;
var gender;
var inputs;

$( document ).ready(function() {
    $("#submit-button").click(function(){
        if (validateUserData() < 1){
            submitUserData();
        }
        return false;
    });
    firstName = $("#firstname");
    lastName = $("#lastname");
    email = $("#email");
    phoneNumber = $("#phonenumber");
    university = $("#university");
    major = $("#major");
    story = $("#story");
    dietary = $("#dietary");
    hackathons = $("#hackathons");
    year = $("#year");
    gender = $("#gender");
    inputs = [gender, year, hackathons, dietary, story, major, university, phoneNumber, email, lastName, firstName];

});

function validateUserData(){
    $(".form-group").removeClass("has-error").removeClass("has-warning");

    var errors = 0;
    var warnings = 0;

    //Validate all input fields
    for (var i = 0; i < inputs.length; i++){
        if (inputs[i].prop("required")){
            errors += validateRequiredInput(inputs[i]);
        } else {
            warnings += validateOptionalInput(inputs[i]);
        }
    }

    //Show text if optional fields are not filled
    var optionalUnfilledText = $("#optional-unfilled-text");
    if(errors < 1 && warnings > 0 && !optionalUnfilledText.is(":visible")){
        optionalUnfilledText.slideDown(250);
        errors++;
    }
    return errors;
}

function submitUserData(){
    var dataJSON = {
        "firstName": firstName.val(),
        "lastName": lastName.val(),
        "email": email.val()
    };
    alert(dataJSON);

    $.post("php/api.php", {
        tag: "submituser",
        data: dataJSON
    }, function(data) {
        $(".register-section").slideUp(1000);
        $(".response-section").slideDown(1000);
        $("#response").html(data);
    });

}

function validateOptionalInput(element){
    if (!element.val() || !validatePattern(element)){
        element.closest('div[class^="form-group"]').addClass("has-warning");
        element.focus();
        return 1;
    } else {
        element.closest('div[class^="form-group"]').addClass("has-success");
        return 0;
    }
}

function validateRequiredInput(element){
    if (!element.val() || !validatePattern(element)){
        element.closest('div[class^="form-group"]').addClass("has-error");
        element.focus();
        return 1;
    } else {
        element.closest('div[class^="form-group"]').addClass("has-success");
        return 0;
    }
}

function validatePattern(element){
    return element.val().match(element.prop('pattern'));
}