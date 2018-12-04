"use strict";

var $ = function (id) {
    return document.getElementById(id);
};

var sendMessage = function () {
    var first_name = $("first_name").value;
    var notepad = $("textbox").value;
    var errorMessage = "";

    // validate the entries
    if (first_name === "") {
        errorMessage = "First name entry required";
        $("first_name").focus();
    } else if (notepad === "") {
        errorMessage = "Please enter your message to send!";
        $("textbox").focus();
    }

    // submit the form if all entries are valid
    // otherwise, display an error message
    if (errorMessage === "") {
        window.location.href = "message_thx.html"
    } else {
        alert(errorMessage);
    }
};

window.onload = function () {
    $("submit_btn").onclick = sendMessage;
    $("first_name").focus();
};
