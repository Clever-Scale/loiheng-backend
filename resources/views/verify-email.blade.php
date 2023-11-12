<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOIHENG</title>
</head>

<body>
    <h2>Hey, {{ $data->fullname }}</h2>
    <br>
    <strong>Your verification code is: {{ $data->verify_code }} </strong><br>
    <br><br>
    <hr>
    Thank you
</body>

</html>
