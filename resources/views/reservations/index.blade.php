@extends('layouts.app')

@section('content')
	<main class="main container">
		<a href="{{ route('reservations.create') }}" class="btn btn-raised btn-info pull-right">
			<i class="fa fa-plus fa-lg"></i>
		</a>
		@if ($reservations->isEmpty())
			<div class="clearfix"></div>
			<div class="center">
				<h1>You have no booking yet !</h1>
				<h2>Click the plus button to book a table</h2>
			</div>
		@else
			<h1>{{ $reservations->count() }} {{ str_plural('Reservation', $reservations->count()) }}</h1>

			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>Details</th>
						<th>{!! sort_reservations_by('date', 'Date') !!}</th>
						<th>{!! sort_reservations_by('time', 'Time') !!}</th>
						<th>{!! sort_reservations_by('seats', 'Seats') !!}</th>
						<th>{!! sort_reservations_by('active', 'Active') !!}</th>
						<th colspan="2">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($reservations as $booking)
						<tr class="{{ $booking->active ? '' : 'danger'}}">
							<td>
								<strong class="text-info">{{ $booking->user->name }}</strong> <br>
								<strong class="text-danger">{{ $booking->user->phone }}</strong> <br>
								<strong class="text-success">{{ $booking->user->email }} <br></strong>
								{{ $booking->user->address }} <br>
								{{ $booking->user->city }} <br>
								{{ $booking->user->post_code }} <br>
							</td>
							<td>{{ today($booking->date) ? 'Today' : $booking->date->format('l jS \\of F Y') }}</td>
							<td>{{ $booking->time }}</td>
							<td>{{ $booking->seats }}</td>
							<td>{!! $booking->active ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>' !!}</td>
							<td>
								<form action="{{ route('reservations.destroy', $booking) }}" method="POST">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									@can('adminManager', auth()->user())
										<a href="{{ route('reservations.edit', $booking) }}" class="btn btn-sm btn-raised btn-success">
											Change
										</a>
									@endcan
									<button type="submit" class="btn btn-sm btn-raised btn-danger confirm">
										Cancel
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="center">
				{{ $reservations->appends(request()->input())->links() }}
			</div>
		@endif
	</main>
@stop
