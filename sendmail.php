<?php
session_start();

// Enter your credentials
$global_host = "smtp.gmail.com"; //eg: Gmail Host => smtp.gmail.com 
$global_email = "syedanwar.sa1@gmail.com";
$global_password = "hyhv owmo rqvj wpxo";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function contacttemplate($fullname, $email, $phonenumber, $message)
{
    return '
        <html>
            <head>
                <style>
                    .container{
                        /* background-color: gray; */
                        padding: 10px;
                    }
                    #customers {
                        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }
                    #customers th{
                        width: 30%;
                    }
                    #customers tr:nth-child(even){
                        background-color: #f2f2f2;
                    }
                    #customers tr:hover {
                        background-color: #ddd;
                    }
                    #customers th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #4CAF50;
                        color: white;
                    }
                    .heading{
                        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                        background-color: lightgray;
                        padding: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="heading">
                        <h1>HighLine Home Decor | New Enquiry</h1>
                    </div>
                    <table id="customers">
                        <tr>
                            <th>Full Name</th>
                            <td>'.$fullname.'</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>'.$email.'</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>'.$phonenumber.'</td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td>'.$message.'</td>
                        </tr>
                    </table>
                </div>
            </body>
        </html>
    ';
}

function modalQuoteTemplate($fullname, $email, $phonenumber, $message, $subject)
{
    return '
        <html>
            <head>
                <style>
                    .container{
                        /* background-color: gray; */
                        padding: 10px;
                    }
                    #customers {
                        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }
                    #customers th{
                        width: 30%;
                    }
                    #customers tr:nth-child(even){
                        background-color: #f2f2f2;
                    }
                    #customers tr:hover {
                        background-color: #ddd;
                    }
                    #customers th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #4CAF50;
                        color: white;
                    }
                    .heading{
                        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                        background-color: lightgray;
                        padding: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="heading">
                        <h1>HighLine Home Decor | Requested a Quote</h1>
                    </div>
                    <table id="customers">
                        <tr>
                            <th>Full Name</th>
                            <td>'.$fullname.'</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>'.$email.'</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>'.$phonenumber.'</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>'.$subject.'</td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td>'.$message.'</td>
                        </tr>
                    </table>
                </div>
            </body>
        </html>
    ';
}


if(isset($_POST['send_contactus']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phone'];
    $message = $_POST['message'];
    
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "$global_host";
    $mail->Username = "$global_email";
    $mail->Password = "$global_password";

    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("$global_email",$fullname);
    $mail->addAddress("$global_email");

    $mail->isHTML(true);
    $mail->Subject = "New Enquiry";

    $mail->Body = contacttemplate($fullname, $email, $phonenumber, $message);
    // $mail->send();
    if($mail->send())
    {
        $_SESSION['status'] = "We appreciate you contacting us. One of our colleagues will get back in touch with you soon! Have a great day!";
       header('Location: index.html');
      	header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
    else
    {
        $_SESSION['status']  = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('Location: index.html');
      	header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
}
else if(isset($_POST['send_request_quote']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "$global_host";
    $mail->Username = "$global_email";
    $mail->Password = "$global_password";

    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;

    $mail->setFrom("$global_email",$fullname);
    $mail->addAddress("$global_email");

    $mail->isHTML(true);
    $mail->Subject = "New Requested a Quote";

    $mail->Body = modalQuoteTemplate($fullname, $email, $phonenumber, $message, $subject);
    // $mail->send();
    if($mail->send())
    {
        $_SESSION['status'] = "We appreciate you contacting us. One of our colleagues will get back in touch with you soon! Have a great day!";
       header('Location: index.html');
      	header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
    else
    {
        $_SESSION['status']  = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('Location: index.html');
      	header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
}
elseif(isset($_POST['send_newsletter']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    if(empty($fullname) || empty($email))
    {
        $_SESSION['status'] = "All fields are mandetory!";
      	header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
    else
    {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "$global_host";
        $mail->Username = "$global_email";
        $mail->Password = "$global_password";

        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("$global_email",$fullname);
        $mail->addAddress("$global_email");

        $mail->isHTML(true);
        $mail->Subject = "New Enquiry";

        $mail->Body = newslettertemplate($fullname, $email);
        $mail->send();
        if($mail->send())
        {
            $_SESSION['status'] = "We appreciate you contacting us. One of our colleagues will get back in touch with you soon! Have a great day!";
            header("Location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
        else
        {
            $_SESSION['status']  = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: {$_SERVER["HTTP_REFERER"]}");
            exit();
        }
    }
}
else
{
    header('Location: index.html');
    exit();
}
?>