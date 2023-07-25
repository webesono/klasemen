<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require APPPATH . '/libraries/phpmailer/phpmailer/src/PHPMailer.php';
require APPPATH . 'libraries/phpmailer/phpmailer/src/Exception.php';
require APPPATH . 'libraries/phpmailer/phpmailer/src/SMTP.php';

function viewUser($c_name, $content, $data)
{
    $c_name->load->view('user/templates/header', $data);
    $c_name->load->view('user/templates/navbar', $data);
    $c_name->load->view($content, $data);
    $c_name->load->view('user/templates/footer', $data);
}

function viewAdmin($c_name, $content, $data)
{
    $c_name->load->view('admin/templates/sidebar', $data);
    $c_name->load->view('admin/templates/navbar', $data);
    $c_name->load->view($content, $data);
    $c_name->load->view('admin/templates/footer', $data);
}

function viewBasic($c_name, $content, $data)
{
    $c_name->load->view('admin/templates/sidebar', $data);
    $c_name->load->view('admin/templates/navbar', $data);
    $c_name->load->view($content, $data);
    $c_name->load->view('admin/templates/footer', $data);
}

function sendEmail($emailto, $message, $subject, $smpt_user, $smpt_pass)
{

    // Recipient Email Address
    $to = $emailto;
    // Email Subject
    $subject = $subject;

    // Gmail SMTP Server Details
    $smtpHost = "smtp.gmail.com";
    $smtpPort = 587;
    $smtpUsername = $smpt_user;
    $smtpPassword = $smpt_pass;

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Set SMTP options
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->Port = $smtpPort;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;

        // Set email content
        $mail->setFrom($smtpUsername);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = 'This is the plain text version of the email';
        $mail->isHTML(true);

        // Send email
        $mail->send();
        $result = [
            'success' => true,
            'message' => 'Berhasil mengirimkan email'
        ];
    } catch (Exception $e) {
        $result = [
            'success' => false,
            'message' => "Mailer Error: " . $mail->ErrorInfo
        ];
    }
    return $result;

    // //set up email
    // $config = array(
    //     'protocol' => 'smtp',
    //     'smtp_host' => 'smtp.gmail.com',
    //     'smtp_port' => 487,
    //     'smtp_user' => $smpt_user,
    //     'smtp_pass' => $smpt_pass,
    //     'mailtype'  => 'html',
    //     'charset'   => 'iso-8859-1'
    // );

    // $c_name->load->library('email', $config);

    // // $c_name->email->initialize($config);
    // $c_name->email->set_newline("\r\n");
    // $c_name->email->from($config['smtp_user']);
    // $c_name->email->to($emailto);
    // $c_name->email->subject($subject);
    // $c_name->email->message($message);

    // $send = $c_name->email->send();

    // //sending email
    // if ($send) {
    //     $result = [
    //         'success' => true,
    //         'message' => 'Berhasil mengirimkan email'
    //     ];
    // } else {
    //     $result = [
    //         'success' => false,
    //         'message' => $c_name->email->print_debugger()
    //     ];
    // }
    // return $result;
}

function unlinkFile($filename)
{
    // try to use real path
    if (realpath($filename) && realpath($filename) !== $filename) {
        return is_writable($filename) && @unlink(realpath($filename));
    } else {
        return false;
    }
}

function valid_url($url)
{
    $regex = "((https?|ftp)\:\/\/)?";
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
    $regex .= "(\:[0-9]{2,5})?";
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";

    if (preg_match("/^$regex$/i", $url)) {
        return true;
    }

    return false;
}

function callAPI($method, $url, $data, $headers = false)
{
    $curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    if (!$headers) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
    } else {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            $headers
        ));
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    //Get status code
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if (!$result) {
        $result = "Connection Failure";
        $status = 502;
    }
    curl_close($curl);
    return [
        'result' => $result,
        'status' => $status
    ];
}

function search($array, $search_list)
{

    // Create the result array
    $result = array();

    // Iterate over each array element
    foreach ($array as $key => $value) {

        // Iterate over each search condition
        foreach ($search_list as $k => $v) {

            // If the array element does not meet
            // the search condition then continue
            // to the next element
            if (!isset($value[$k]) || $value[$k] != $v) {

                // Skip two loops
                continue 2;
            }
        }

        // Append array element's key to the
        //result array
        $result[] = $value;
    }

    // Return result 
    return $result;
}
