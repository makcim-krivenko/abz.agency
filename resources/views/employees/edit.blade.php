@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {{--<div style="height: 201px; width: 201px;">--}}
                    {{--<img src="{{ GlideImage::load($user->avatar)->modify(['h'=>200, 'w'=>200, 'fit'=>'fill', 'crop'=>'crop-center']) }}"--}}
                         {{--alt="avatar"/>--}}
                {{--</div>--}}
                <form role="form" class="form-horizontal" method="post" action='/employees/update/{{$employee->id}}' enctype="multipart/form-data">
                    <div>
                        @if ($errors->has('isset_error'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('save_error') }}</strong>
                                    </span>
                        @endif
                    </div>
                    {{--<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">--}}
                        {{--<label class="control-label">User avatar</label>--}}
                        {{--<input type="file" class="form-control" name="avatar">--}}
                        {{--@if ($errors->has('avatar'))--}}
                            {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('avatar') }}</strong>--}}
                                    {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    <div class="form-group{{ $errors->has('save_error') ? ' has-error' : '' }}">
                        @if ($errors->has('save_error'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('save_error') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                        <label class="control-label">Full name</label>
                        <input type="text" class="form-control" name="full_name" value="{{$employee->full_name}}">
                        @if ($errors->has('full_name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('work_from') ? ' has-error' : '' }}">
                        <label class="control-label">Work from</label>
                        <input id="work_from" type="date" class="form-control" name="work_from" value="{{$employee->work_from}}">
                        @if ($errors->has('work_from'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('work_from') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Salary</label>
                        <input id="salary" type="text" class="form-control" name="salary" value="{{$employee->salary}}">
                        @if ($errors->has('salary'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('salary') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                        <label class="control-label">Position</label>
                        <select class="form-control" name="position">
                            <option disabled selected></option>
                            @foreach ($positions as $position)
                                <option value="{{$position->name}}"
                                        @if ($position->name == $employee->position->name)
                                            selected
                                        @endif
                                        >{{$position->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-btn fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

