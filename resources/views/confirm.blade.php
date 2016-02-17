
<p>
	<ul>
	  @foreach ($errors->all() as $error)
	    <li>{{ $error }}</li>
	  @endforeach
	</ul>
</p>

Phone number: {{ session('phone_number') }}
<br/>
<form method="post" action="/ecocash/submit">
	@include('checkoutvariables')
	<input type="hidden" name="phone_number" value="{{ session('phone_number') }}">
	<input type="submit" name="choice" value="Change">
	<input type="submit" name="choice" value="Confirm">
</form>