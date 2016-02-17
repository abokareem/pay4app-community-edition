{!! csrf_field() !!}
<input type="hidden" name="account" value="{{ session('account') }}" />
<input type="hidden" name="order" value="{{ session('order') }}" />
<input type="hidden" name="narration" value="{{ session('narration') }}" />
<input type="hidden" name="amount" value="{{ session('amount') }}" />
<input type="hidden" name="redirectURL" value="{{ session('redirectURL') }}" />
<input type="hidden" name="cancelURL" value="{{ session('cancelURL') }}" />
<input type="hidden" name="signature" value="{{ session('signature') }}" />
