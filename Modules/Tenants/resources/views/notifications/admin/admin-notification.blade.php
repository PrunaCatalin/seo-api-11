<?php
/*
 * seo-api | admin-notification.blade.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/19/2024 12:16 PM
*/

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] }}</title>
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
    <h2>New Contact Request</h2>
    <p>A new contact request has been received from:</p>
    <p>Name: {{ $customer->customerDetails->name }} {{ $customer->customerDetails->lastname }}</p>
    <p>Email: {{ $customer->email }}</p>
    <p>Message: {{ $data['message'] }}</p>
    <div class="footer">
        <p>Please review and respond to the inquiry as soon as possible.</p>
    </div>
</div>
</body>
</html>
