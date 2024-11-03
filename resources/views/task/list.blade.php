<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Task Adı</th>
            <th>Task Tarihi</th>
            <th></th>
        </tr>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->created_at }}</td>
                <td><a href="{{ route('task.detail', ['id' => $task->id]) }}">Task Detayı</a></td>
            </tr>
        @endforeach
    </table>
</body>
</html>
