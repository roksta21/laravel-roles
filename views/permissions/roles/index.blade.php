@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route(config('permissions.route_name_prefix') . 'permissions.roles.create') }}" class="btn btn-primary pull-right">New</a>
		<h3 class="heading">User Roles</h3>
		<table class="table table-striped table-bordered" id="dt_a">
			<thead>
				<tr>
					<th>Name</th>
					<th>Permissions</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($roles as $role)
				<tr>
					<td>{{ $role->name }}</td>
					<td>
						{{ $role->permissions()->count() }}
					</td>
					<td>
						<a href="{{ route(config('permissions.route_name_prefix') . 'permissions.roles.show', $role->id) }}">Show</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection