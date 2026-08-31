<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Qura Management' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full m-0 p-0 antialiased bg-[#F8FAFC]">

    {{$slot}}

</body>
</html>