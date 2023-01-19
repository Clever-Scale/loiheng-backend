<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loiheng - Contact</title>
</head>

<body>
    <h2>Hey, It's me {{ $data->name }}</h2>
    <br>

    <strong>User details: </strong><br>
    <strong>Name: </strong>{{ $data->name }} <br>
    <strong>Email: </strong>{{ $data->email }} <br><br>
    <hr>
    <strong>{{ $data->subject }} </strong><br><br>
    <p>{{ $data->description }}</p>
    <br><br>
    <hr>
    Thank you
</body>

</html>
