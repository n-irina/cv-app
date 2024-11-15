<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Détails des prospecting du user {{ $user->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; padding: 20px; }
        .header , h1 { text-align: center; }
        .details { margin-top: 20px; }
        .details p { margin: 5px 0; } img { border: 1px solid #ddd; border-radius: 4px; padding: 5px; }
    </style>
</head>
<body>
<h1>Prospectings of {{ $user->name }}</h1>
<div class="container">
    @foreach($prospectings as $key => $prospecting)
        <div class="header">
            <h2>Prospecting n°{{ $key+1 }}</h2>
        </div>
        <div class="details">
            <p><strong>Subject:</strong> {{ $prospecting->subject }} </p>
            <p><strong>Contacts:</strong> {{ $prospecting->contacts }} </p>
            <p><strong>On:</strong> {{ $prospecting->created_at }}</p>
            <p><strong>Type:</strong>{{ $prospecting->type }}</p>
            @if(!empty($prospecting->observation))
               <p><strong>Observation:</strong>{{ $prospecting->observation }}</p>
            @endif
            @if(!empty($prospecting->note))
               <p><strong>Note:</strong>{{ $prospecting->note }}</p>
            @endif
        </div>
    @endforeach
    </div>

</body>
</html>
