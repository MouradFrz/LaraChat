<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    @vite('resources/css/convo.css')
</head>

<body>
    <div class="container">
        <nav>
            <h1>LaraChat</h1>
                @if ($convo->participant_one == Auth::user()->id)
                    {{ explode('@', $convo->participantTwo->email)[0] }}
                @else
                    {{ explode('@', $convo->participantOne->email)[0] }}
                @endif
            </p>

            <form action="{{ route('user.logout') }}" method="GET">
                <input type="submit" value="Logout">
            </form>
        </nav>
        <main>
            <div class="messages-wrapper">
                @foreach ($convo->messages as $message)
                    <div class="message 
                @if ($message->user->email !== Auth::user()->email) sent @endif">
                        <p>{{ $message->message }}</p>
                    </div>
                @endforeach
            </div>

        </main>
        <form id="send-message-form">
            <input type="text" class="input-field">
            <button class="send-btn"><i class="bi bi-send"></i></button>
        </form>
    </div>


    <script>
        let getID = "{{ $convo->id }}"
        let email = "{{ Auth::user()->email }}"
    </script>
    @vite('resources/js/privateListener.js')
    <script>
        document.querySelector('.messages-wrapper').scrollTop = document.querySelector('.messages-wrapper').scrollHeight;
        document.querySelector('#send-message-form').addEventListener('submit', (ev) => {
            ev.preventDefault()
            axios.post('/send-message', {
                message: document.querySelector('.input-field').value,
                convo: "{{ $convo->id }}"
            })
        })
    </script>
</body>

</html>
