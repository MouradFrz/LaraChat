<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('user.logout') }}" method="GET">
        <input type="submit" value="Logout">
    </form>
    <form id="message-form" action="{{ route('send-message') }}" method="post">
        @csrf
        <label for="">Message : </label>
        <input class="input-field" type="text">
    </form>
    @vite('resources/js/app.js')
    <script>
        document.querySelector('#message-form').addEventListener('submit',(ev)=>{
            ev.preventDefault()
            axios.post('/send-message',{message:document.querySelector('.input-field').value})
        })

        
    </script>
</body>

</html>
