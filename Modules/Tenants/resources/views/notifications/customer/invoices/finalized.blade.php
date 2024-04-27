<?php
/*
 * seo-api | finalized.blade.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/26/2024 7:13 PM
*/

?>
<x-mail::message>
    # Subscription invoice

    A new invoice for your subscription is available.

    See the attached invoice, or visit your billing portal.

    <x-mail::button :url="config('app.url')">
        Billing portal
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
