<?php
/**
 * Created by PhpStorm.
 * User: Lunding
 * Date: 18/04/15
 * Time: 17.30
 */


//Login & registration classes
define("MESSAGE_MISSING_TAG", "Required parameter 'tag' is missing!");
define("MESSAGE_UNKNOWN_TAG", "Unknown 'tag' value.");
define("MESSAGE_MISSING_PARAMETERS", "Required parameters are missing!");


define("MESSAGE_FULL_NAME_EMPTY", "Participants full name field was empty");
define("MESSAGE_FULL_NAME_BAD_LENGTH", "Participants full name must be from 2 to 64 characters");
define("MESSAGE_AGE_EMPTY", "Users age field was empty");
define("MESSAGE_AGE_INVALID", "Users year of birth is invalid.");
define("MESSAGE_EMAIL_EMPTY", "Email cannot be empty");
define("MESSAGE_EMAIL_INVALID", "Your email address is not in a valid email format");
define("MESSAGE_PHONE_EMPTY", "Users phone field was empty");
define("MESSAGE_PHONE_BAD_LENGTH", "Users phone field was too long");
define("MESSAGE_UNIVERSITY_EMPTY", "Users university field was empty");
define("MESSAGE_UNIVERSITY_BAD_LENGTH", "Users university field was too long");
define("MESSAGE_MAJOR_EMPTY", "Users major field was empty");
define("MESSAGE_MAJOR_BAD_LENGTH", "Users major field was too long");
define("MESSAGE_STORY_EMPTY", "Users story field was empty");
define("MESSAGE_STORY_BAD_LENGTH", "Users story field was too long");

define("MESSAGE_REGISTRATION_FAILED", "Sorry, your registration failed. Please go back and try again.");
define("MESSAGE_DATABASE_ERROR", "Database connection problem.");
define("MESSAGE_EMAIL_ALREADY_EXISTS", "This email address is already registered. Please write an email to <a href='mailto:contact@auhack.org?subject=AUHack'>contact@auhack.org</a>");
define("MESSAGE_EMAIL_TOO_LONG", "Email cannot be longer than 64 characters");
define("MESSAGE_LINK_PARAMETER_EMPTY", "Empty link parameter data.");
define("MESSAGE_VERIFICATION_MAIL_ERROR", "Sorry, we could not send you an verification mail. You have NOT been registered. Please try one more time. Otherwise send an email to: <a href='mailto:contact@auhack.org?subject=AUHack'>contact@auhack.org</a>");
define("MESSAGE_VERIFICATION_MAIL_NOT_SENT", "Verification Mail NOT successfully sent! Error: ");
define("MESSAGE_VERIFICATION_MAIL_SENT", "You have been registered successfully and we have sent you an email. Please send us an email, if you find out you won't be able to join us.<br> If you have any questions fill free to contact us on: <a href='mailto:contact@auhack.org?subject=AUHack'>contact@auhack.org</a>");

?>