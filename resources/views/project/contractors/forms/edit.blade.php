<div class="contractor-item contractor-{{ $contractor->id }}" id="contractor-{{$contractor->id}}">
    <div class="container-fluid delete-item-container">
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-info del-item" onClick="delContractor({{ $contractor->id }})">-</button>
            </div>
        </div>
    </div>
    @if ($contractor->role)
        <h3>{{ $contractor->role }}</h3>
    @else
        <h3>New Contractor</h3>
    @endif
    <h4>Information</h4>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_role', 'Role', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::select('contractor_' . $contractor->id . '_role', $roles, $contractor->role, array('class' => 'form-control')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_address', 'Address', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_address', $contractor->address, array('class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_name', 'Name', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            <select id="contractor_{{$contractor->id}}_name" name="contractor_{{$contractor->id}}_name" class="company-select form-control">
                <option value="">Please select...</option>
                @foreach ($companies as $company)
                    @php
                        $selected = ($company->name == $contractor->name) ? "selected" : "";
                    @endphp
                    <option value="{{$company->name}}" {{$selected}} id="{{$company->id}}">{{$company->name}}</option>
                @endforeach
            </select>
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_city', 'City', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_city', $contractor->city, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_legal_name', 'Legal Name', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_legal_name', $contractor->legal_name, array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_state', 'State', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::select('contractor_' . $contractor->id . '_state', $states, $contractor->state, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_also_known_as', 'Also Known As', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_also_known_as', $contractor->also_known_as, array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_zipcode', 'Zipcode', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_zipcode', $contractor->zipcode, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_phone', 'Phone Number', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_phone', $contractor->phone, array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_federal_tax_id', $contractor->federal_tax_id, array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_fax', 'Fax Number', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_fax', $contractor->fax, array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_state_tax_id', 'State Tax ID', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_state_tax_id', $contractor->state_tax_id, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_website', 'Website', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_website', $contractor->website, array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_division', 'Division', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_division', $contractor->division, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_type', 'Type of Company', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_type', $contractor->type, array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_sos', 'SOS Number', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_sos', $contractor->sos, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_num_of_employees', 'Number of Employees', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::number('contractor_' . $contractor->id . '_num_of_employees', $contractor->num_of_employees, array('class' => 'form-control', 'placeholder' => '5')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_cn', 'CN Number', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_cn', $contractor->cn, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_sic', 'SIC Code', array('class' => 'offset-6 col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_sic', $contractor->sic, array('class' => 'form-control')) }}
        </div>
    </div>
    <hr>
    <h4>Contact</h4>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_contact_name', 'Name', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            <select name="contractor_{{$contractor->id}}_contact_name" class="contact-name form-control">
                <option value="">Please select...</option>
                @foreach ($contacts as $contact)
                    @php
                    $selected = ($contact->first_name . " " . $contact->last_name == $contractor->contact_name) ? "selected" : "";
                    @endphp
                    <option value="{{$contact->first_name}} {{$contact->last_name}}" {{$selected}} id="{{$contact->id}}">{{$contact->first_name}} {{$contact->last_name}}</option>
                @endforeach
            </select>
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_contact_title', 'Title', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_contact_title', $contractor->contact_title, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_contact_phone', 'Phone', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_contact_phone', $contractor->contact_phone, array('class' => 'form-control')) }}
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_contact_fax', 'Fax', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_contact_fax', $contractor->contact_fax, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_contact_email', 'Email', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_contact_email', $contractor->contact_email, array('class' => 'form-control')) }}
        </div>
    </div>
    <hr>
    <h4>NOI Signer</h4>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_noi_signer_name', 'Name', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            <select name="contractor_{{$contractor->id}}_noi_signer_name" class="noi-signer-name form-control">
                <option value="">Please select...</option>
                @foreach ($contacts as $contact)
                    @php
                        $selected = ($contact->first_name . " " . $contact->last_name == $contractor->noi_signer_name) ? "selected" : "";
                    @endphp
                    <option value="{{$contact->first_name}} {{$contact->last_name}}" {{$selected}} id="{{$contact->id}}">{{$contact->first_name}} {{$contact->last_name}}</option>
                @endforeach
            </select>
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_noi_signer_title', 'Title', array('class' => 'col-3 text-right control-label')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_noi_signer_title', $contractor->noi_signer_title, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_noi_signed', 'NOI Signed', array('class' => 'col-3 text-right control-label')) }}
        <div class="col-9">
            {{ Form::checkbox('contractor_' . $contractor->id . '_noi_signed', 'true', $contractor->noi_signed, array('class' => 'control-label', 'style' => 'margin-top: 7px;')) }}
        </div>
    </div>
    <hr>
    <h4>NOT Signer</h4>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_not_signer_name', 'Name', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-3">
            <select name="contractor_{{$contractor->id}}_not_signer_name" class="not-signer-name form-control">
                <option value="">Please select...</option>
                @foreach ($contacts as $contact)
                    @php
                        $selected = ($contact->first_name . " " . $contact->last_name == $contractor->not_signer_name) ? "selected" : "";
                    @endphp
                    <option value="{{$contact->first_name}} {{$contact->last_name}}" {{$selected}} id="{{$contact->id}}">{{$contact->first_name}} {{$contact->last_name}}</option>
                @endforeach
            </select>
        </div>
        {{ Form::label('contractor_' . $contractor->id . '_not_signer_title', 'Title', array('class' => 'col-3 text-right control-label')) }}
        <div class="col-3">
            {{ Form::text('contractor_' . $contractor->id . '_not_signer_title', $contractor->not_signer_title, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_not_signed', 'NOT Signed', array('class' => 'col-3 text-right control-label')) }}
        <div class="col-9">
            {{ Form::checkbox('contractor_' . $contractor->id . '_not_signed', 'true', $contractor->not_signed, array('class' => 'control-label', 'style' => 'margin-top: 7px;')) }}
        </div>
    </div>
    <hr>
    <h4>Responsibilities</h4>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_responsibilities', 'Responsibilities', array('class' => 'col-3 text-right control-label required-field')) }}
        <div class="col-9">
            <div class="table-bordered" style="min-height: 30px;">
            @foreach ($responsibilities as $responsibility)
                @php
                    $checked = (is_array($contractor->responsibilities) && in_array($responsibility->narrative, $contractor->responsibilities)) ? 'checked' : '';
                @endphp
                <div class="form-check">
                    <input class="form-check-input" {{ $checked }} name="contractor_{{ $contractor->id }}_responsibilities[]" type="checkbox" value="{{ $responsibility->narrative }}" id="responsibility-{{$contractor->id}}-{{ $responsibility->id }}">
                    <label class="form-check-label" for="bmp-{{$contractor->id}}-{{ $responsibility->id }}">
                        {{ $responsibility->narrative }}
                    </label>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
