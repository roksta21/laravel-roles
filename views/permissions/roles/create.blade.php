@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="heading">Add User Role</h3>
		<a href="{{ route(config('permissions.route_name_prefix').'permissions.roles.index') }}" class="pull-right" >cancel</a>
		<form method="post" action="{{ route(config('permissions.route_name_prefix').'permissions.roles.store') }}">
			{{ csrf_field() }}
			<div class="form-group">
				<label>Role Name</label>
				<input type="text" name="name" class="form-control">
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
							<input type="checkbox" name="permissions[]" value="{{ $permission->name }}" >
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