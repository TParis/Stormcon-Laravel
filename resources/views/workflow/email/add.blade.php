{{ Form::label('role', 'Team', array('class' => 'control-label required-field')) }}
{{ Form::select('role[]', $roles,'', array('class' => 'form-control', 'multiple' => 'multiple', 'style' => 'height:150px;')) }}
{{ Form::label('subject', 'Message Subject', array('class' => 'control-label required-field')) }}
{{ Form::text('subject', '', array('class' => 'form-control', 'required' => 'required')) }}
{{ Form::label('message', 'Message Body', array('class' => 'control-label required-field')) }}
{{ Form::textarea('message', '', array('class' => 'form-control', 'required' => 'required')) }}
