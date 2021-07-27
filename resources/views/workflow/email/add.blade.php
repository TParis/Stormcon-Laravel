{{ Form::label('role', 'Team', array('class' => 'control-label required-field')) }}
{{ Form::select('role', $roles,'', array('class' => 'form-control')) }}
{{ Form::label('subject', 'Message Subject', array('class' => 'control-label required-field')) }}
{{ Form::text('subject', '', array('class' => 'form-control')) }}
{{ Form::label('message', 'Message Body', array('class' => 'control-label required-field')) }}
{{ Form::textarea('message', '', array('class' => 'form-control')) }}
