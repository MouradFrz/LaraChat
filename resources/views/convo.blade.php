<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/convo.css') }}">
</head>

<body>
    <div class="container">
        <nav>
            <h1><a href="{{ route('user.homepage') }}"><i class="bi bi-caret-left-fill"></i></a></h1>

            <div class="user-status">@if ($convo->participant_one == Auth::user()->id)<p id="convo-with">{{ explode('@', $convo->participantTwo->email)[0] }}</p>@else<p id="convo-with">{{ explode('@', $convo->participantOne->email)[0] }}</p>@endif
                </p>
                <div>
                    <span class="circle"></span>
                    <span class="status">Offline</span>
                </div>
            </div>
            <form style="margin-left: auto" action="{{ route('user.logout') }}" method="GET">
                <button><i class="bi bi-box-arrow-right"></i></button>
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
    <script src="{{ asset('js/privateListener.js') }}"></script>
    <script>
        document.querySelector('.messages-wrapper').scrollTop = document.querySelector('.messages-wrapper').scrollHeight;
        document.querySelector('#send-message-form').addEventListener('submit', (ev) => {
            ev.preventDefault()
            let value = document.querySelector(".input-field").value
            document.querySelector(".input-field").value = ""
            axios.post('/send-message', {
                message: value,
                convo: "{{ $convo->id }}"
            })
        })
    </script>
</body>

</html>
