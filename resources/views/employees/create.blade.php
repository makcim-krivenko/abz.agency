@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form role="form" class="form-horizontal" method="POST" action='/employees/store'  enctype="multipart/form-data">
                    <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                        <label class="control-label">Emploee avatar</label>
                        <input type="file" class="form-control" name="avatar">
                        @if ($errors->has('avatar'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                        @endif
                    </div>
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
                    <div class="form-group{{ $errors->has('boss') ? ' has-error' : '' }}">
                        <label class="control-label">Boss</label>
                        <select class="form-control js-data-example-ajax" name="boss">
                            <option value="boss" selected="selected">Choice</option>
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
    <script type="text/javascript">
        function formatResult(item) {
            if(!item.id) {
                // return `text` for optgroup
                return '<i>Choice</i>';
            }

            // return item template
            return '<i>' + item.full_name + '</i>';
        }

        function templateSelection(data) {
            if (data.id === '') { // adjust for custom placeholder values
                return 'Custom styled placeholder text';
            }

            if (data.full_name === undefined) {
                return data.text;
            }

            return data.full_name;
        }



        $(".js-data-example-ajax").select2({
            ajax: {
                url: "/employees/search",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter works
            minimumInputLength: 5,
            templateResult: formatResult,
            templateSelection: templateSelection
        });
    </script>
@endsection

