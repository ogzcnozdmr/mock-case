<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Detail</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<h3 style="color:#2c2cd9;">Task Hafta : {{ $taskGroup->id }}, Task Adı : {{ $taskGroup->name }}</h3>
<h2 style="color:#85c21e;">Minimum Bitirme Haftası: {{ $taskGroup->week }}</h2>

@foreach($developers as $developer)
    <span style="color:#bb1b41;">Developer ID : {{ $developer->id }}, Developer : {{ $developer->uniq }} için görev atamaları tablosu</span><br>
    <table>
        <tr>
            <th>Task Id</th>
            <th>Bitirme Süresi</th>
            <th>İş Haftası</th>
        </tr>
        @foreach($tasks as $task)
            @if($task->developers_id != $developer->id)
                @continue
            @endif
            <tr>
                <td>{{ $task->tasks_id }}</td>
                <td>{{ $task->duration }}h</td>
                <td>{{ $task->week }}</td>
            </tr>
        @endforeach
    </table>
    <br><br>
@endforeach
</body>
</html>
