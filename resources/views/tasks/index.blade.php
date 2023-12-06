<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Task Manager -Task </title>
</head>

<body>
    <h2>Hello User</h2>
    <h1>Task List </h1>
    <ul>
        @foreach ($tasks as $task)
            <li> {{$task->name}} </li>
            <form method="POST" action="/tasks/{{$task->id}}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" value="{{ $task->id }}" />
                <input type="submit" value="delete">
            </form>
        @endforeach
    </ul>
    <a href="{{ route('tasks.create') }}">Add Task</a> </br>
    <a href = "/logout">Logout</a>

</body>

</html>