<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Create Task</title>
</head>

<body>
    <h1>Create Task </h1>
    <form method="post" action="{{ route('tasks.store') }}">
        @csrf
        <lable for="task">Task</lable>
        <input type="text" name="name">
        <button type="submit"> Add Task </button>
    </form>
    <a href="{{ route('tasks.index') }}">Back to Task List</a>
</body>

</html>