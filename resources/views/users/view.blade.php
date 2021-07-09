<div class="panel panel-default">
    <div class="panel-heading">
        <h2>{{$user->name}}</h2>
    </div>
    <div class="panel-body">
        <div class="col-md-12"><h3 align=center>{{$user->first_name}} {{$user->last_name}}</h3></div>
        <div class="col-md-2 col-md-offset-2">
        </div>
        <div class="col-md-2 col-md-offset-4">
            Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a><br />
            Password: <a href="{{ route('users::changepass', $user->id) }}">Change</a><br />
        </div>
    </div>
    <div class="panel-footer">
        @if(Auth::user()->can('delete'))
        {{ Form::open(array('route' => array('users::delete', $user->id), 'method' => 'DELETE', 'class'	=> 'form-horizontal')) }}
            {{ Form::hidden('id', $user->id) }}
            {{ Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-default btn-danger pull-right']) }}
        {{ Form::close() }}
        @endif
        <a href="{{ route('users::edit', $user->id) }}" class="btn btn-default btn-info"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
    </div>
</div>
