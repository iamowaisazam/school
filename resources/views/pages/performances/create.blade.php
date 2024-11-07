@extends('layouts.app')

@section('content')

<style>

    .tarbiya input{
        width: 40px;
    }

    .grade{
        
    }

</style>

<?php 
 $classes = App\Enums\Classes::DATA;
 $options = App\Enums\Behavior::DATA;
 $GradeKey = App\Enums\GradeKey::DATA;



?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Performance Create</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL::to('performances') }}" method="POST"
                                data-method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Student</label>
                                            <select class="form-control" name="student">
                                             <option value="">Select Student</option>
                                              @foreach ($students as $item)
                                               <option value="{{$item->id}}">{{$item->first_name}}</option>
                                              @endforeach
                                            </select>
                                            @if($errors->has('student'))
                                              <p class="text-danger" >{{ $errors->first('student') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="class">Select Class</label>
                                            <select class="select2bs4 form-control" name="class" data-placeholder="Select Class" style="width: 100%;">
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
                                            <label>From Date</label>
                                            <input value="{{old('from_date')}}"  type="date" name="from_date" class="form-control">
                                            @if($errors->has('from_date'))
                                            <p class="text-danger" >{{ $errors->first('from_date') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" value="{{old('end_date')}}" name="end_date" class="form-control">
                                                @if($errors->has('end_date'))
                                                <p class="text-danger">{{$errors->first('end_date')}}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Week #</label>
                                            <input name="week_number" value="{{old('week_number')}}" class="form-control">
                                                @if($errors->has('week_number'))
                                                <p class="text-danger">{{$errors->first('week_number')}}</p>
                                                @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <table class="tarbiya table" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Mon</th>
                                                    <th>Tue</th>
                                                    <th>Wed</th>
                                                    <th>Thu</th>
                                                    <th>Fri</th>
                                                    <th>Sat</th>
                                                    <th>Sun</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>SOCIAL BEHAVIOR</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @foreach ($options['social_behavior'] as $key => $item)
                                                    <?php 
                                                    // $name = str_replace(' ','-',$item['name']);
                                                    ?>
                                                <tr>
                                                    <td>{{$item['name']}}
                                                        <input type="hidden" name="social_behavior[{{$key}}][title]" value="{{$item['name']}}" 
                                                        />
                                                    </td>
                                                    <td><input name="social_behavior[{{$key}}][mon]" value="" /></td>
                                                    <td><input name="social_behavior[{{$key}}][tue]"  value="" /></td>
                                                    <td><input name="social_behavior[{{$key}}][wed]" value="" /></td>
                                                    <td><input name="social_behavior[{{$key}}][thu]" value="" /></td>
                                                    <td><input name="social_behavior[{{$key}}][fri]" value="" /></td>
                                                    <td><input name="social_behavior[{{$key}}][sat]" value="" /></td>
                                                    <td><input name="social_behavior[{{$key}}][sun]" value="" /></td>
                                                </tr>
                                                @endforeach

                                                <tr>
                                                    <th>PERSONAL HABITS</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @foreach ($options['personal_habits'] as $key => $h)
                                                <tr>
                                                        <td>{{$h['name']}}
                                                            <input type="hidden" name="personal_habits[{{$key}}][title]" value="{{$h['name']}}" 
                                                            />
                                                        </td>
                                                        <td><input name="personal_habits[{{$key}}][mon]" value="" /></td>
                                                        <td><input name="personal_habits[{{$key}}][tue]"  value="" /></td>
                                                        <td><input name="personal_habits[{{$key}}][wed]" value="" /></td>
                                                        <td><input name="personal_habits[{{$key}}][thu]" value="" /></td>
                                                        <td><input name="personal_habits[{{$key}}][fri]" value="" /></td>
                                                        <td><input name="personal_habits[{{$key}}][sat]" value="" /></td>
                                                        <td><input name="personal_habits[{{$key}}][sun]" value="" /></td>
                                                </tr>
                                                @endforeach

                                                <tr>
                                                    <th>Grading Key:</th>
                                                    <td colspan="7"  >
                                                        <div class="d-flex justify-content-between" >
                                                            <span>E = Excellent</span>
                                                            <span>G = Good</span>
                                                            <span>R = Average</span>
                                                            <span>B = Below Average </span>
                                                            <span> N = Needs Improvement</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                           

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-secondary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
