@extends('layouts.app')

@section('content')
	<header class="header header-filter"
	        style="background-image: url('/images/menu-background.png');">
		<main class="container">
			@include('partials.notify-alert', ['data' => 'Cart is updated'])
			<h1 class="text-warning">Shopping Cart</h1>
			<article class="col-md-8">
				@unless (javan_is_open())
					<div class="alert alert-danger">
						<div class="alert-icon"><i class="material-icons">error</i></div>
						We are closed now and cannot accept orders unless you want specific delivery time between 13:00 - 23:00
					</div>
				@endunless
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title">
							Your Details
						</div>
					</div>
					<div class="panel-body">
						<div class="alert alert-warning">
							<div class="container-fluid">
								<div class="alert-icon">
									<i class="material-icons">warning</i>
								</div>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="material-icons">clear</i></span>
								</button>
								Make sure your information is correct before you make a payment if you see your information is incorrect
								please <a class="alert-link" href="{{ route('member.edit', auth()->user()) }}">click here</a> to update
								your information.
							</div>
						</div>

						<dl class="dl-horizontal">
							<dt>Name :</dt>
							<dd>{{ auth()->user()->name ?: '-' }}</dd>
							<dt>Email :</dt>
							<dd>{{ auth()->user()->email ?: '-' }}</dd>
							<dt>Address :</dt>
							<dd>{{ auth()->user()->address ?: '-' }}</dd>
							<dt>City :</dt>
							<dd>{{ auth()->user()->city ?: '-' }}</dd>
							<dt>Post Code :</dt>
							<dd>{{ auth()->user()->post_code ?: '-' }}</dd>
							<dt>Phone :</dt>
							<dd>{{ auth()->user()->phone ?: '-' }}</dd>
						</dl>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title">
							Payment Details
						</div>
					</div>
					<div class="panel-body">
						@if(auth()->user()->address && auth()->user()->post_code && auth()->user()->phone)
							<form action="{{ route('cart.store') }}" method="POST" role="form"
							      class="form-horizontal" id="payment-form">
								{{ csrf_field() }}

								<noscript>
									<div class="alert alert-danger">
										<h4>JavaScript is not enabled!</h4>
										<p>This payment form requires your browser to have JavaScript enabled. Please activate JavaScript
											and reload this page. Check <a href="http://enable-javascript.com" target="_blank">enable-javascript.com</a>
											for more informations.</p>
									</div>
								</noscript>

								<!-- Card Holder Name -->
								<div class="form-group">
									<label class="col-sm-3 control-label" for="card-holder-name">Card Holder's Name</label>
									<div class="col-sm-7">
										<input type="text" name="cardholdername" maxlength="70" minlength="6" placeholder="Name on Card"
										       class="card-holder-name form-control" id="card-holder-name" pattern="[A-Za-z\s]{6,70}"
										       required>
										<span class="help-block text-primary">Name as appeared on cart</span>
									</div>
								</div>

								<!-- Card Number -->
								<div class="form-group">
									<label class="col-sm-3 control-label" for="cardnumber">Card Number</label>
									<div class="col-sm-7">
										<input type="text" id="cardnumber" minlength="16" maxlength="19" placeholder="Card Number"
										       class="card-number form-control" data-stripe="number" pattern="[0-9]{16,19}" required>
										<span class="help-block text-primary">16 digits card number in front of your card</span>
									</div>
								</div>

								<!-- Expiry-->
								<div class="form-group">
									<label class="col-sm-3 control-label" for="exp-date">Card Expiry Date</label>
									<div class="col-sm-7">
										<div class="form-inline">
											<select name="select2" data-stripe="exp_month" id="exp-date"
											        class="card-expiry-month stripe-sensitive required form-control" required>
												@for ($i = 0; $i < 12; $i++)
													<option
															value="{{ $i + 1 }}" {{ $i + 1 == date('m') + 1 ? 'selected' : '' }}>{{ $i + 1 }}</option>
												@endfor
											</select>
											<span> / </span>
											<select name="select2" data-stripe="exp_year" id="exp-date"
											        class="card-expiry-year stripe-sensitive required form-control" required>
												@for ($i = 0; $i < 12; $i++)
													<option
															value="{{ $i + date('Y') }}" {{ $i === 0 ? 'selected' : '' }}>{{ $i + date('Y') }}</option>
												@endfor
											</select>
										</div>
									</div>
								</div>

								<!-- CVV -->
								<div class="form-group">
									<label class="col-sm-3 control-label" for="cvc">CVC / CVV</label>
									<div class="col-sm-3">
										<input type="text" id="cvc" placeholder="CVC" size="4" class="card-cvc form-control"
										       data-stripe="cvc" pattern="[0-9]{1,4}" minlength="1" maxlength="4" required>
										<span class="help-block text-primary"> 3 or 4 digits on back of your card</span>
									</div>
								</div>

								<div class="form-group">
									<label for="note" class="control-label col-sm-3">Instructions</label>
									<div class="col-sm-7">
									<textarea type="text" class="form-control" name="note" id="note"
									          {{ javan_is_open() ? '' : 'required minlength=6' }}
									          placeholder="{{ javan_is_open() ? 'Type Delivery Instruction' : 'We are closed now so please specify the delivery time here between 12:00 to 23:00'}}"></textarea>
										@if (javan_is_open())
											<span class="help-block text-primary">Ex: time of delivery, the house bell and etcetera</span>
										@else
											<span
													class="help-block text-primary">Please specify the delivery time here between 13:00 to 23:00</span>
										@endif
									</div>
								</div>

								<p class="lead text-center text-danger payment-errors animated pulse infinite"></p>

								<div class="control-group">
									<div class="controls">
										<div class="center">
											<button class="btn btn-success btn-raised submit" type="submit">Pay Now</button>
										</div>
									</div>
								</div>

							</form>
						@else
							<div class="alert alert-danger">
								<div class="alert-icon"><i class="material-icons">error</i></div>
								Payment form is not visible because one of your <strong>Address</strong>, <strong>Post
									Code</strong> or <strong>Phone</strong> is empty
								<a class="btn btn-sm btn-default btn-raised btn-round" href="{{ route('member.edit', auth()->user()) }}">Please Update Your Details</a>
							</div>
						@endif
					</div>
				</div>
			</article>
			<aside class="col-md-4">
				@include('partials.cart')
			</aside>
		</main>
	</header>
@stop
@section('scripts')
	<script src="https://js.stripe.com/v2/"></script>
	<script>
		Stripe.setPublishableKey('{{ env('STRIPE_KEY') }}');

		$(function() {
			var $form = $('#payment-form');
			$form.submit(function(event) {
				// Disable the submit button to prevent repeated clicks:
				$form.find('.submit').prop('disabled', true);
				// Request a token from Stripe:
				Stripe.card.createToken($form, stripeResponseHandler);
				// Prevent the form from being submitted:
				return false;
			});

			function stripeResponseHandler(status, response) {
				// Grab the form:
				var $form = $('#payment-form');
				if (response.error) { // Problem!
					// Show the errors on the form:
					$form.find('.payment-errors').text(response.error.message);
					$form.find('.submit').prop('disabled', false); // Re-enable submission
				} else { // Token was created!
					// Get the token ID:
					var token = response.id;
					// Insert the token ID into the form so it gets submitted to the server:
					$form.append($('<input type="hidden" name="stripeToken">').val(token));
					// Submit the form:
					$form.get(0).submit();
				}
			}
		});
	</script>
@stop