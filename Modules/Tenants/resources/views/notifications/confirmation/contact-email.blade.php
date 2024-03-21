<?php
/*
 * seo-api | contact-email-replay.blade.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/19/2024 12:04 PM
*/

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .1);
        }

        h2 {
            color: #444;
        }

        p {
            line-height: 1.6;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Contact Request</h2>
    <p>Hello, {{ $customer->customerDetails->name }} {{ $customer->customerDetails->lastname }},</p>
    <p>Thank you for reaching out to us. Your message is important to us, and someone from our team will get back to you
        as soon as possible.</p>
    <p>Here is the information you submitted:</p>
    <p>Email: {{ $customer->email }}</p>
    <p>Message: {{ $data['message'] }}</p>
    <div class="footer">
        <p>If you need to add additional information to your request, please do not hesitate to contact us again.</p>
    </div>
</div>
</body>
</html>

