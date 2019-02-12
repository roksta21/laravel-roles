@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="heading">Permissions for {{ $user->name }}</h3>
		<a href="{{ route(config('permissions.route_name_prefix').'permissions.users.show', $user->id) }}" class="pull-right" >cancel</a>
		<form method="post" action="{{ route(config('permissions.route_name_prefix').'permissions.users.update', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<table class="table table-striped table-bordered not-data">
				<thead>
					<tr>
						<th>Route Name</th>
						<th>Route Path</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($permissions as $permission)
					<tr>
						<td>{{ $permission->name }}</td>
						<td>{{ explode('?', route($permission->name, 'id'))[0] }}</td>
						<td>
							<input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $user->permissions()->contains($permission->name) ? 'checked' : '' }}>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<button class="btn btn-info">Save</button>
		</form>
	</div>
</div>
@endsection