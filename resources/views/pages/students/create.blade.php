@extends('layouts.app')

@section('content')

<?php 
 $classes = App\Enums\Classes::DATA;
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Student Create</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL::to('students') }}" method="POST"
                                data-method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sid">Student ID (SID)</label>
                                            <input type="text" id="sid" name="sid" class="form-control"
                                                placeholder="Enter Student ID" >

                                            @if($errors->has('sid'))
                                            <p class="text-danger" >{{ $errors->first('sid') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="campus">Select Campus</label>
                                            <select class="select2bs4 form-control" name="campus"
                                                data-placeholder="Select Campus" style="width: 100%;">
                                                <option value="" disabled>Select Campus</option>
                                                <option value="Johar">Johar</option>
                                                <option value="North Nazimabad">North Nazimabad</option>

                                            </select>
                                            @if($errors->has('campus'))
                                            <p class="text-danger" >{{ $errors->first('campus') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="class">Select Class</label>
                                            <select class="select2bs4 form-control" id="class" name="class" data-placeholder="Select Class" style="width: 100%;">
                                                <option value="" disabled selected>Select Class</option>
                                                @foreach ($classes as $item)
                                                  <option value="{{$item['name']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('class'))
                                            <p class="text-danger" >{{ $errors->first('class') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" id="first_name" name="first_name" class="form-control"
                                                placeholder="Enter First Name">
                                                @if($errors->has('first_name'))
                                                <p class="text-danger" >{{ $errors->first('first_name') }}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control"
                                                placeholder="Enter Last Name">
                                                @if($errors->has('last_name'))
                                                <p class="text-danger" >{{ $errors->first('last_name') }}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="student_name">Student Name (as it will appear on card)</label>
                                            <input type="text" id="student_name" name="student_name" class="form-control"
                                                placeholder="Student Name">
                                                @if($errors->has('student_name'))
                                                <p class="text-danger" >{{ $errors->first('student_name') }}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="father_name">Father's Name</label>
                                            <input type="text" id="father_name" name="father_name" class="form-control"
                                                placeholder="Enter Father's Name">
                                                @if($errors->has('father_name'))
                                                <p class="text-danger" >{{ $errors->first('father_name') }}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                placeholder="Enter Phone Number">
                                                @if($errors->has('phone'))
                                                <p class="text-danger" >{{ $errors->first('phone') }}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" id="dob" name="dob" class="form-control"
                                                placeholder="Enter Date of Birth">
                                                @if($errors->has('dob'))
                                                <p class="text-danger" >{{ $errors->first('dob') }}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" id="address" name="address" class="form-control"
                                                placeholder="Enter Address">
                                            @if($errors->has('address'))
                                            <p class="text-danger" >{{ $errors->first('address') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="is_registered">Allow Registrations</label>
                                            <select id="is_registered" name="is_registered" class="form-control">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            @if($errors->has('is_registered'))
                                            <p class="text-danger" >{{ $errors->first('is_registered') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="image">Upload Image</label>
                                            <input type="file" id="image" name="image"
                                                class="form-control-file" accept="image/*">
                                                @if($errors->has('image'))
                                                <p class="text-danger" >{{ $errors->first('image') }}</p>
                                                @endif
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
