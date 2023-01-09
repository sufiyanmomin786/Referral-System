<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,intial-sclae=1.0">
    {{-- print_r($data); --}}
    <title>{{ $data['title'] }}</title>
</head>

<body>
    <p>Hiii {{ $data['name'] }},Welcome to Referral System!</p>
    <p>Please<a href="{{ $data['url'] }}">Click here</a>to verify your mail</p>
    <p>Thank You!</p>
</body>


</html>
