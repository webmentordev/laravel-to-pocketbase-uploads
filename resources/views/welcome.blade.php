<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <input type="text" name="name" required placeholder="Write name">
        <button type="submit">Send</button>
    </form>
</body>

</html>
