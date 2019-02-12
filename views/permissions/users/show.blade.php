@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="heading">Permissions for {{ $user->name }}</h3>
		<a href="{{ route(config('permissions.route_name_prefix').'permissions.users.edit', $user->id) }}" class="pull-right" >edit</a>
		<table class="table table-striped table-bordered not-data">
			<thead>
				<tr>
					<th>Route Name</th>
					<th>Route Path</th>
				</tr>
			</thead>
			<tbody>
				@foreach($user->permissions() as $permission)
				<tr>
					<td>{{ $permission }}</td>
					<td>{{ explode('?', route($permission, 'id'))[0] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection