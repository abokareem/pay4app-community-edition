
<p>
	<ul>
	  @foreach ($errors->all() as $error)
	    <li>{{ $error }}</li>
	  @endforeach
	</ul>
</p>

<form method="post" action="/ecocash">
	@include('checkoutvariables')
	<p>
		Phone Number: <input type="text" name="phone_number" value="{{ old('phone_number') }}">
	</p>
	<p>
		<input type="submit">
	</p>
</form>