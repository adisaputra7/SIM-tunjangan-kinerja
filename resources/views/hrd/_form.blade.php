<div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
    {!! Form::label('name', 'Nama Pegawai') !!}
    {!! Form::text('name', $skp->users->name, ['class'=>'form-control', 'disabled']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}                
</div>