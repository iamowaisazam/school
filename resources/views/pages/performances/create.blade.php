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
                                            <label for="class">Select Class</label>
                                            <select class="select2bs4 form-control" name="class" data-placeholder="Select Class" style="width: 100%;">
                                                @foreach (App\Enums\Classes::DATA as $item)
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

                                @include('pages.performances.sheet1')

                          
                           

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

@section('script')
    

<script>
        let students = @json($students);

        $('select[name=class]').change(function (e) {

            $('select[name=student]').html('');
            students.forEach(element => {
                if(element.class == $('select[name=class]').val()){
                    $('select[name=student]').append(`<option value="${element.id}">${element.first_name} ${element.last_name}</option>`);
                }
            });
           
        }).change();

</script>

@endsection

