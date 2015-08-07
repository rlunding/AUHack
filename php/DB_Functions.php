<?php
/**
 * Created by Lunding
 * Date: 06/08/15
 * Time: 22.33
 */

class DB_Functions {
    private $db = null;

    function __construct(){
        require_once('config.php');
        require_once('translation/en.php');
        require_once('libraries/PHPMailer.php');

        $this->db = new PDO('mysql:host='. DB_HOST .';dbname='. DB_DATABASE . ';charset=utf8', DB_USER, DB_PASSWORD);

    }

    function __destruct(){
        if ($this->db != null){
            $this->db = null;
        }
    }

    private function databaseConnection(){
        if ($this->db != null){
            return true;
        } else {
            try {
                $this->db = new PDO('mysql:host='. DB_HOST .';dbname='. DB_DATABASE . ';charset=utf8', DB_USER, DB_PASSWORD);
                return true;
            } catch (PDOException $e){
                return false;
            }
        }
    }

    //TODO: extract data from JSON
    //TODO: validate  data
    //TODO: check if participant already exists
    //TODO: insert participant
    public function registerNewParticipant($dataJSON, &$response){
        if (empty($dataJSON)){
            $response["error_msg"] = MESSAGE_MISSING_PARAMETERS;
        } else {
            $data = json_decode($dataJSON);
            $fullname = trim($data->fullName);
            $age = intval($data->age);
            $email = trim($data->email);
            $phone = $data->phone;
            $university = $data->university;
            $major = $data->major;
            $story = $data->story;

            $dietary = $this->setNullIfEmpty($data->dietary);
            $hackathons = $this->setIntNullIfEmpty($data->hackathons);
            $graduation = $this->setIntNullIfEmpty($data->graduation);
            $gender = $this->setNullIfEmpty($data->gender);
            $country = $this->setNullIfEmpty($data->country);
            $shirt = $this->setNullIfEmpty($data->shirt);
            $linkedin = $this->setNullIfEmpty($data->linkedin);
            $github = $this->setNullIfEmpty($data->github);
            $freetext = $this->setNullIfEmpty($data->freetext);

            if (empty($fullname)) {
                $response["error_msg"] = MESSAGE_FULL_NAME_EMPTY;
            } elseif (empty($age)){
                $response["error_msg"] = MESSAGE_AGE_EMPTY;
            } elseif (empty($email)){
                $response["error_msg"] = MESSAGE_EMAIL_EMPTY;
            } elseif (empty($phone)){
                $response["error_msg"] = MESSAGE_PHONE_EMPTY;
            } elseif (empty($university)){
                $response["error_msg"] = MESSAGE_UNIVERSITY_EMPTY;
            } elseif (empty($major)){
                $response["error_msg"] = MESSAGE_MAJOR_EMPTY;
            } elseif (empty($story)){
                $response["error_msg"] = MESSAGE_STORY_EMPTY;
            } elseif (strlen($fullname) > 64 || strlen($fullname) < 2){
                $response["error_msg"] = MESSAGE_FULL_NAME_BAD_LENGTH;
            } elseif (strlen($email) > 64){
                $response["error_msg"] = MESSAGE_EMAIL_TOO_LONG;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $response["error_msg"] = MESSAGE_EMAIL_INVALID;
            } elseif (strlen($phone) > 64){
                $response["error_msg"] = MESSAGE_PHONE_BAD_LENGTH;
            } elseif (strlen($university) > 128){
                $response["error_msg"] = MESSAGE_UNIVERSITY_BAD_LENGTH;
            } elseif (strlen($major) > 64){
                $response["error_msg"] = MESSAGE_MAJOR_BAD_LENGTH;
            } elseif (strlen($story) > 500){
                $response["error_msg"] = MESSAGE_STORY_BAD_LENGTH;
            } elseif ($this->databaseConnection()){
                //check if username or email already exists
                $query_check_participant = $this->db->prepare("SELECT participant_email FROM participant
                WHERE participant_email = :participant_email");
                $query_check_participant->bindValue(":participant_email", $email, PDO::PARAM_STR);
                $query_check_participant->execute();
                $result = $query_check_participant->fetchObject();
                if (isset($result->participant_email)) {
                    $response["error_msg"] = MESSAGE_EMAIL_ALREADY_EXISTS;
                } else {
                    $ipAddress = $this->getClientIP();
                    $registration_time = date('Y-m-d H:i:s');

                    //Write new users data into database
                    $query_new_user_insert = $this->db->prepare("INSERT INTO participant (ip_address, registration_time, participant_name, participant_birth_year, participant_email, participant_phone_number, participant_university, participant_major, participant_story, participant_dietary_requirements, participant_hackathons_attended, participant_year_of_graduation, participant_gender, participant_country, participant_shirt_size, participant_linkedin, participant_github, participant_comments)
                        VALUES(:ip_address, :registration_time, :participant_name, :participant_birth_year, :participant_email, :participant_phone_number, :participant_university, :participant_major, :participant_story, :participant_dietary_requirements, :participant_hackathons_attended, :participant_year_of_graduation, :participant_gender, :participant_country, :participant_shirt_size, :participant_linkedin, :participant_github, :participant_comments)");
                    $query_new_user_insert->bindValue(":ip_address", $ipAddress, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":registration_time", $registration_time, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_name", $fullname, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_birth_year", $age, PDO::PARAM_INT);
                    $query_new_user_insert->bindValue(":participant_email", $email, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_phone_number", $phone, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_university", $university, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_major", $major, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_story", $story, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_dietary_requirements", $dietary, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_hackathons_attended", $hackathons, PDO::PARAM_INT);
                    $query_new_user_insert->bindValue(":participant_year_of_graduation", $graduation, PDO::PARAM_INT);
                    $query_new_user_insert->bindValue(":participant_gender", $gender, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_country", $country, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_shirt_size", $shirt, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_linkedin", $linkedin, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_github", $github, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(":participant_comments", $freetext, PDO::PARAM_STR);
                    $query_new_user_insert->execute();

                    //Id of new participant
                    $participant_id = $this->db->lastInsertId();

                    if ($query_new_user_insert && $participant_id > 0){
                        //Send a verification email
                        if($this->sendConfirmationEmail($fullname, $email, $response)){ //TODO: remove when testing
                            //when mail has been send successfully
                            $response["msg"] = MESSAGE_VERIFICATION_MAIL_SENT;
                            $response["error"] = FALSE;
                        } else {
                            //delete this users account immediately, as we could not send a verification email
                            $query_delete_user = $this->db->prepare('DELETE FROM participant WHERE participant_id = :participant_id');
                            $query_delete_user->bindValue(":participant_id", $participant_id, PDO::PARAM_INT);
                            $query_delete_user->execute();

                            $response["error_msg"] = MESSAGE_VERIFICATION_MAIL_ERROR . $response["error_msg"];
                        }
                    } else {
                        $response["error_msg"] = MESSAGE_REGISTRATION_FAILED;
                    }
                }
            } else {
                $response["error_msg"] = MESSAGE_DATABASE_ERROR;
            }
        }
    }

    private function setNullIfEmpty($value){
        return empty($value) ? "NULL" : $value;
    }

    private function setIntNullIfEmpty($value){
        if (empty($value) || !is_numeric($value)){
            return null;
        } else {
            return intval($value);
        }
    }

    private function sendConfirmationEmail($name, $email, &$response){
        $mail = new PHPMailer;

        if (EMAIL_USE_SMTP){
            $mail->IsSMTP(); //Use SMTP
            //$mail->SMTPDebug = 1; //Debug
            $mail->SMTPAuth = EMAIL_SMTP_AUTH; //Enable SMTP authentication
            if (defined(EMAIL_SMTP_ENCRYPTION)){
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION; //Enable encryption
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        //Generate mail
        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddReplyTo(EMAIL_VERIFICATION_REPLY);
        $mail->AddAddress($email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;

        //TODO: set email body
        $mail->Body = "Hello " . $name ." \n You are now signed up for AUHack. You will receive a confirmation email within the next weeks. \n\nBest regards \nThe AUHack Team";

        if(!$mail->Send()) {
            $response["error_msg"] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    private function getClientIP() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        if(filter_var($ipaddress, FILTER_VALIDATE_IP)){
            return $ipaddress;
        } else {
            return "Invalid ip";
        }
    }
}