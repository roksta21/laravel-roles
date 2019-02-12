@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="heading">Permissions for {{ $role->name }}</h3>
		<a href="{{ route(config('permissions.route_name_prefix').'permissions.roles.edit', $role->id) }}" class="pull-right" >edit</a>
		<table class="table table-striped table-bordered not-data">
			<thead>
				<tr>
					<th>Route Name</th>
					<th>Route Path</th>
				</tr>
			</thead>
			<tbody>
				@foreach($role->permissions() as $permission)
				<tr>
					<td>{{ $permission }}</td>
					<td>{{ explode('?', route($permission, 'id'))[0] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<form method="post" action="{{ route(config('permissions.route_name_prefix').'permissions.roles.destroy', $role->id) }}">
			@csrf
			@method("DELETE")
			<div class="form-group">
				<button class="btn btn-danger">Delete</button>
			</div>
		</form>
	</div>
</div>
@endsection