<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraChat - Home</title>
    @vite('resources/css/homepage.css')
</head>

<body>
    <div class="container">
        <nav>
            <h1>LaraChat</h1>
            <p>{{ explode('@', Auth::user()->email)[0] }}</p>
            <form action="{{ route('user.logout') }}" method="GET">
                <input type="submit" value="Logout">
            </form>
        </nav>
        <section>
            <input type="text" placeholder="Search for a user ..." id="user-search">
            <div id="floating-users">
            </div>
        </section>
        <main>
            @if (count($convos) != 0)
                @foreach ($convos as $convo)
                    @if ($convo->latestMessage)
                        <a href="{{ route('user.convopage', $convo->id) }}">
                            <div class="convo">

                                @if ($convo->participantOne->id != Auth::user()->id)
                                    <p>{{ $convo->participantOne->email }}</p>
                                @else
                                    <p>{{ $convo->participantTwo->email }}</p>
                                @endif
                                <p>
                                    @if ($convo->latestMessage->senderID == Auth::user()->id)
                                        You:
                                    @endif
                                    {{ $convo->latestMessage->message }}
                                </p>
                                <p>{{ $convo->latestMessageDate }}</p>

                            </div>
                        </a>
                    @endif
                @endforeach
            @else
                <div class="no-convo">
                    <p>You have no conversations.</p>
                    <p>Your conversations will be listed here!</p>
                </div>
            @endif
        </main>
    </div>

    <script>
        let getID = "{{ Auth::user()->id }}"
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @vite('resources/js/anyMessage.js')
    @vite('resources/js/userSearch.js')
</body>

</html>
