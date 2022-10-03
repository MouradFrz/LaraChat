<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraChat - Home</title>
</head>

<body>

    @foreach ($convos as $convo)
        <a href="{{ route('user.convopage', $convo->id) }}">
            <div>
                @if ($convo->latestMessage)
                    @if ($convo->participantOne->id != Auth::user()->id)
                        <p><b>{{ $convo->participantOne->email }}</b></p>
                    @else
                        <p><b>{{ $convo->participantTwo->email }}</b></p>
                    @endif
                    <p>{{ $convo->latestMessage->message }}</p>
                    <small>{{ $convo->latestMessage->created_at }}</small>
                @endif
            </div>
        </a>
    @endforeach


    <form action="{{ route('user.logout') }}" method="GET">
        <input type="submit" value="Logout">
    </form>
    
    @vite('resources/js/app.js')

</body>

</html>
