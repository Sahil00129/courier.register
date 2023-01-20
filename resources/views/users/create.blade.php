@extends('layouts.app')
@section('content')

<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card">
            <div class="card-header">Create user
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('users.index') }}">Users</a>
                </span>
            </div>

            <div class="card-body">
                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' =>
                    'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Role:</strong>
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                </div>
                <div class="form-group">
                    <strong>Company:</strong>
                    <select name="company_id" class="form-control" id="select_company">
                        <option value="">Select</option>
                        <?php 
                            if(count($getcompanys)>0) {
                                foreach ($getcompanys as $key => $getcompany) {  
                            ?>
                        <option value="{{ $getcompany->id }}">{{ucwords($getcompany->name)}}</option>
                        <?php 
                                }
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <strong>Location:</strong>
                    <select name="location_id" class="form-control" id="select_location">
                        <option value="">Select Location</option>
                        
                    </select>
                </div>
                <div class="form-group">
                    <strong>Department:</strong>
                    <select name="department_id" class="form-control" id="select_department">
                        <option value="">Select Department</option>
                        
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
/*======get location on company change in user page =====*/
    $("#select_company").change(function (e) {
        var company_id = $(this).val();
        $("#select_location").empty();
        $("#select_department").empty();
        $.ajax({
            url: "/get-locations",
            type: "get",
            cache: false,
            data: { company_id: company_id },
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="_token"]').attr("content"),
            },
            beforeSend: function () {
                $("#select_location").empty();
            },
            success: function (res) {
                $("#select_location").append(
                    '<option value="">select location</option>'
                );
                $("#select_department").append(
                    '<option value="">Select Department</option>'
                );
                $.each(res.data, function (index, value) {
                    $("#select_location").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.name +
                            "</option>"
                    );
                });
            },
        });
    });

    /*===== get department on location change in user page =====*/
    $("#select_location").change(function (e) {
        $("#select_department").empty();
        let location_id = $(this).val();

        $.ajax({
            type: "get",
            url: "/get_departments",
            data: { location_id: location_id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (res) {
                $("#select_department").append(
                    '<option value="">Select Department</option>'
                );
                $.each(res.data, function (key, value) {
                    $("#select_department").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.name +
                            "</option>"
                    );
                });
            },
        });
    });
    </script>
@endsection