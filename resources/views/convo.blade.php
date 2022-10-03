<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversation</title>
</head>

<body>
    @foreach ($convo->messages as $message)
        <p>{{ $message->message }} by {{ $message->user->email }}</p>
    @endforeach
    <form id="send-message-form">
        <input type="text" class="input-field">
        <input type="submit" value="Send">
    </form>
</body>
<script>
    let getID = "{{ $convo->id }}"
</script>
@vite('resources/js/privateListener.js')
<script>
    document.querySelector('#send-message-form').addEventListener('submit', (ev) => {
            ev.preventDefault()
            axios.post('/send-message', {
                message: document.querySelector('.input-field').value,
                convo: "{{ $convo->id }}"
            }).then((res)=>{
                console.log(res)
            })
        })
</script>
</html>
