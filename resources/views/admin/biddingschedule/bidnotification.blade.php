<!DOCTYPE html>

<html>
<head>
    <title></title>
</head>

<body>
    <h4>Hello {{ $user->name }}</h4><br>
    <p>You are next to bid in the schedule {{ $schedule->name }}.</p><br>
    <p>You have only {{ $schedule->response_time }} hours to bid.</p>
</body>
</html>
