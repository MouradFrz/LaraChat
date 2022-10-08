<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraChat - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>

<body>
    <div class="container">
        <nav>
            <div class="user-info">
                <i style="font-size: 1.2rem" class="bi bi-person-fill"></i>
                <div>
                    <span class="green-circle"></span>
                    <p>{{ explode('@', Auth::user()->email)[0] }}</p>
                </div>
            </div>
            
            <form action="{{ route('user.logout') }}" method="GET">
                <button><i class="bi bi-box-arrow-right"></i></button>
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
                        <a data-code="@if ($convo->participantOne->id != Auth::user()->id){{$convo->participantOne->email}}@else{{$convo->participantTwo->email}}@endif" href="{{ route('user.convopage', $convo->hashid) }}">
                            <div class="convo offline">

                                @if ($convo->participantOne->id != Auth::user()->id)
                                    <p class="convo-email">{{ $convo->participantOne->email }}</p>
                                @else
                                    <p class="convo-email">{{ $convo->participantTwo->email }}</p>
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
    <script src="{{ asset('js/anyMessage.js') }}"></script>
    <script src="{{ asset('js/userSearch.js') }}"></script>
</body>

</html>
