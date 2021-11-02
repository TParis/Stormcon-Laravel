{{ Form::label('checklist', 'Checklist', array('class' => 'control-label required-field')) }}
{{ Form::textarea('checklist', '', array('class' => 'form-control')) }}
<div class="w-100 text-right"><small>Separate each item with a new line</small></div>
{{ Form::label('role', 'Team', array('class' => 'control-label required-field')) }}
{{ Form::select('role', $roles,'', array('class' => 'form-control', 'required' => 'required')) }}
{{ Form::label('days', 'Est. Days', array('class' => 'control-label required-field')) }}
{{ Form::text('days', '', array('class' => 'form-control', 'required' => 'required')) }}
