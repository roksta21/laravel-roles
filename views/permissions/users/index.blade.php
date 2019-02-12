@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="heading">Users</h3>
		<table class="table table-striped table-bordered dTableR" id="dt_a">
			<thead>
				<tr>
					<th>Name</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>
						<a href="{{ route(config('permissions.route_name_prefix').'permissions.users.show', $user->id) }}">View Permissions</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection