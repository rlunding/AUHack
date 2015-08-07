/**
 * Created by Lunding on 06/08/15.
 */

var fullName;
var age;
var email;
var phoneNumber;
var university;
var major;
var story;
var dietary;
var hackathons;
var graduationYear;
var gender;
var country;
var shirt;
var linkedin;
var github;
var freeText;

var inputs;


$( document ).ready(function() {
    $("#submit-button").click(function(){
        if (validateUserData() < 1){
            submitUserData();
        }
        return false;
    });
    fullName = $("#fullname");
    age = $("#age");
    email = $("#email");
    phoneNumber = $("#phonenumber");
    university = $("#university");
    major = $("#major");
    story = $("#story");
    dietary = $("#dietary");
    hackathons = $("#hackathons");
    graduationYear = $("#graduation");
    gender = $("#gender");
    country = $("#country");
    shirt = $("#shirt");
    linkedin = $("#linkedin");
    github = $("#github");
    freeText = $("#freetext");

    inputs = [freeText, github, linkedin, shirt, country, gender, graduationYear, hackathons, dietary, story, major, university, phoneNumber, email, age, fullName];

    var maxText = 500;
    $("#story-feedback").html(maxText + " characters remaining");

    story.keyup(function(){
        var textLength = story.val().length;
        var textRemaining = maxText - textLength;
        $("#story-feedback").html(textRemaining + " characters remaining");
    });

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
    /*var dataJSON = {
        "fullName": fullName.val(),
        "age": age.val(),
        "email": email.val(),
        "phone": phoneNumber.val(),
        "university": university.val(),
        "major": major.val(),
        "story": story.val(),
        "dietary": dietary.val(),
        "hackathons": hackathons.val(),
        "graduationYear": graduationYear.val(),
        "gender": gender.val(),
        "country": country.val(),
        "shirt": shirt.val(),
        "linkedin": linkedin.val(),
        "github": github.val(),
        "freetext": freeText.val()
    };*/
    var dataJSON = new Object();
    dataJSON.fullName = fullName.val();
    dataJSON.age = age.val();
    dataJSON.email = email.val();
    dataJSON.phone = phoneNumber.val();
    dataJSON.university = university.val();
    dataJSON.major = major.val();
    dataJSON.story = story.val();
    dataJSON.dietary = dietary.val();
    dataJSON.hackathons = hackathons.val();
    dataJSON.graduation = graduationYear.val();
    dataJSON.gender = gender.val();
    dataJSON.country = country.val();
    dataJSON.shirt = shirt.val();
    dataJSON.linkedin = linkedin.val();
    dataJSON.github = github.val();
    dataJSON.freetext = freeText.val();
    var jsonString = JSON.stringify(dataJSON);

    $.post("php/api.php", {
        tag: "submituser",
        data: jsonString
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