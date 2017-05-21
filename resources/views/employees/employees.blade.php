@extends('layouts.app')

@section('content')

    <div class="col-lg-12">
        <div class="panel-body">
            <div class="table-responsive">
                <div class="form-group{{ $errors->has('save_error') ? ' has-error' : '' }}">
                    @if ($errors->has('isset_error'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('isset_error') }}</strong>
                                    </span>
                    @endif
                </div>
                <h2>Employees</h2>
                <a href="/employees/create/" class="btn btn-primary btn-outline"><i class="fa fa-btn fa-plus"></i>  Add New</a>
                <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
                    <thead>
                    <tr>
                        <th>Position</th>
                        <th>Full name</th>
                        <th>Work from</th>
                        <th>Salary</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($employees as $employee)
                        <?php $i++; ?>
                        <tr>
                            <td>{{$employee->position->name}}</td>
                            <td>{{$employee->full_name}}</td>
                            <td>{{$employee->work_from}}</td>
                            <td>{{$employee->salary}}</td>
                            <td><a href="/employees/edit/{{$employee->id}}" class="btn btn-danger"><i class="fa fa-btn fa-edit"></i>  Edit</a></td>
                            <td><a href="/employees/delete/{{$employee->id}}" class="btn btn-danger"><i class="fa fa-btn fa-trash-o"></i>  Delete</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $employees->links() }}
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>


@endsection