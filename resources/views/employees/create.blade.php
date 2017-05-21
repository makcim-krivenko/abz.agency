@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form role="form" class="form-horizontal" method="POST" action='/employees/store'>
                    <div>
                        @if ($errors->has('save_error'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('save_error') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                        <label class="control-label">Full name</label>
                        <input type="text" class="form-control" name="full_name" value="">
                        @if ($errors->has('full_name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('work_from') ? ' has-error' : '' }}">
                        <label class="control-label">Work from</label>
                        <input id="work_from" type="date" class="form-control" name="work_from" value="">
                        @if ($errors->has('work_from'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('work_from') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Salary</label>
                        <input id="salary" type="text" class="form-control" name="salary" value="">
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
                                <option value="{{$position->name}}">{{$position->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary btn-outline">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

