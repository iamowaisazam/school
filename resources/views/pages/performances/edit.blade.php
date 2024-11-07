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
    
    $social_behavior = json_decode($model->social_behavior);
    $personal_habits = json_decode($model->personal_habits);
 
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
                            <form action="{{URL::to('/performances/'.$model->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Student </label>
                                            <select class="form-control" name="student">
                                             <option value="">Select Student</option>
                                              @foreach ($students as $st)
                                               <option @if($model->student_id == $st->id) selected @endif value="{{$st->id}}">{{$st->first_name}}</option>
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
                                                  <option @if($model->class == $item['name']) selected @endif value="{{$item['name']}}">{{$item['name']}}</option>
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
                                            <input value="{{date('Y-m-d',strtotime($model->from))}}"  type="date" name="from_date" class="form-control">
                                            @if($errors->has('from_date'))
                                            <p class="text-danger" >{{ $errors->first('from_date') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" value="{{date('Y-m-d',strtotime($model->to))}}" name="end_date" class="form-control">
                                                @if($errors->has('end_date'))
                                                <p class="text-danger">{{$errors->first('end_date')}}</p>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Week #</label>
                                            <input name="week_number" value="{{$model->week}}" class="form-control">
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
                                                @foreach ($social_behavior as $key => $item)
                                                    <?php 
                                                    // dd($item);
                                                    // $name = str_replace(' ','-',$item['name']);
                                                    ?>
                                                <tr>
                                                    <td>

                                                        <input type="hidden" name="social_behavior[{{$key}}][title]" value="{{$item->title}}" 
                                                        />
                                                    </td>
                                                    <td><input name="social_behavior[{{$key}}][mon]" value="{{$item->mon}}" /></td>
                                                    <td><input name="social_behavior[{{$key}}][tue]"  value="{{$item->tue}}" /></td>
                                                    <td><input name="social_behavior[{{$key}}][wed]" value="{{$item->wed}}" /></td>
                                                    <td><input name="social_behavior[{{$key}}][thu]" value="{{$item->thu}}" /></td>
                                                    <td><input name="social_behavior[{{$key}}][fri]" value="{{$item->fri}}" /></td>
                                                    <td><input name="social_behavior[{{$key}}][sat]" value="{{$item->sat}}" /></td>
                                                    <td><input name="social_behavior[{{$key}}][sun]" value="{{$item->sun}}" /></td>
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
                                                @foreach ($personal_habits as $key => $h)
                                                <tr>
                                                        <td>{{$h->title}}
                                                            <input type="hidden" name="personal_habits[{{$key}}][title]" value="{{$h->title}}" 
                                                            />
                                                        </td>
                                                        <td><input name="personal_habits[{{$key}}][mon]" value="{{$h->mon}}" /></td>
                                                        <td><input name="personal_habits[{{$key}}][tue]"  value="{{$h->tue}}" /></td>
                                                        <td><input name="personal_habits[{{$key}}][wed]" value="{{$h->wed}}" /></td>
                                                        <td><input name="personal_habits[{{$key}}][thu]" value="{{$h->thu}}" /></td>
                                                        <td><input name="personal_habits[{{$key}}][fri]" value="{{$h->fri}}" /></td>
                                                        <td><input name="personal_habits[{{$key}}][sat]" value="{{$h->sat}}" /></td>
                                                        <td><input name="personal_habits[{{$key}}][sun]" value="{{$h->sun}}" /></td>
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
