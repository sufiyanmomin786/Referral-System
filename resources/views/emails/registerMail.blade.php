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
    <p><b>Username:-</b>{{ $data['email'] }}</p>
    <p><b>Password:-</b>{{ $data['password'] }}</p>
    <p>You can add users to your Network by share your <a href="{{ $data['url'] }}">Referral Links</a></p>
    <p>Thank You!</p>
</body>


</html>
