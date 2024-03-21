<?php
/*
 * seo-api | forgotPassword.blade.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: Javascript
 * Created on: 3/11/2024 12:04 PM
*/

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
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

        a.reset-button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
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
    <h2>Password Reset Request</h2>
    <p>Hello,</p>
    <p>You have requested to reset your password. Please click the button below to proceed:</p>
    <a href="{{ $customer->domains->scopeFullUrl(). 'reset-password/' . $token }}" class="reset-button">Reset
        Password</a>
    <p>If you did not request a password reset, please ignore this email.</p>
    <div class="footer">
        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web
            browser:</p>
        <p>
            <a href="{{ $customer->domains->scopeFullUrl(). 'reset-password/' . $token }}">{{ $customer->domains->scopeFullUrl(). 'reset-password/' . $token }}</a>
        </p>
    </div>
</div>
</body>
</html>

