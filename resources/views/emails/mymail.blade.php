<h1>Hello {{$user['name']}}</h1>
<p>Please click link below for your email verification {{$user['email']}} </p>
<a href="{{url('/verification', $user->verification->token)}}">Verify Email</a>
