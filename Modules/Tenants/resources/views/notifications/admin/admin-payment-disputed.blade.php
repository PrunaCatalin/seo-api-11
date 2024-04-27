<?php
/*
 * seo-api | admin-payment-disputed.blade.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/27/2024 1:10 PM
*/

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <h2>Customer: {{ $customer->customerDetails->name . ' ' . $customer->customerDetails->lastname }} </h2>
    <p>A new contact request has been received from [{{$provider}}]:</p>
    <p>Email: {{ $customer->email }}</p>
    <p>Reason : {{ $data['reason'] }}</p>
    <p>Status : {{ $data['status'] }} </p>
    <p>Payment_method_details : {{ $data['payment_method_details'] }} </p>
    <p>Currency : {{ $data['currency'] }} </p>
    <p>Amount : {{ $data['amount'] }} </p>
    <p>Dispute_id : {{ $data['dispute_id'] }} </p>
    <p>Try to solve until : {{ $data['due_by'] }}</p>
    <div class="footer">
        <p>Please review and respond to this dispute as soon as possible.</p>
    </div>
</div>
</body>
</html>
