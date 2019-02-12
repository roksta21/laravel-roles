@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="heading">Permissions</h3>
		<a href="{{ route(config('permissions.route_name_prefix').'permissions.roles.show', $role->id) }}" class="pull-right" >cancel</a>
		<form method="post" action="{{ route(config('permissions.route_name_prefix').'permissions.roles.update', $role->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" value="{{ $role->name }}" class="form-control">
			</div>
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
							<input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $role->permissions()->contains($permission->name) ? 'checked' : '' }}>
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