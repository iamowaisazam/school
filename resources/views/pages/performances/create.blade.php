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
                                                  <option @if(old('class') == $item['name']) selected @endif  value="{{$item['name']}}">{{$item['name']}}</option>
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
                                            </select>
                                            @if($errors->has('student'))
                                              <p class="text-danger" >{{ $errors->first('student') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Session</label>
                                            <select class="form-control" name="session">
                                             <option value="">Select Session</option>
                                              @foreach ($sessions as $s)
                                               <option @if(old('session') == $s->id) selected @endif value="{{$s->id}}">
                                                {{$s->title}}</option>
                                              @endforeach
                                            </select>
                                            @if($errors->has('session'))
                                              <p class="text-danger" >{{ $errors->first('session') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Week</label>
                                            <select class="form-control" name="week">
                                             <option value="">Select Week</option>
                                            </select>
                                            @if($errors->has('week'))
                                              <p class="text-danger" >{{ $errors->first('week') }}</p>
                                            @endif
                                        </div>
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

@section('script')
    

<script>

        let students = @json($students);
        let weeks = @json($weeks);
        let results = @json($results);

        

        let sstudent = @json(old('student'));
        let sweek = @json(old('week'));

        $('select[name=class]').change(function (e) {
            $('select[name=student]').html('');
            students.forEach(element => {
                if(element.class == $('select[name=class]').val()){
                    $('select[name=student]').append(`<option ${Number(sstudent) == element.id ? 'selected' : ''} value="${element.id}">${element.first_name} ${element.last_name}</option>`);
                }
            });
        }).change();


        $('select[name=session]').change(function (e) {
            $('select[name=week]').html('');
            weeks.forEach(element => {

                if(!results.includes($('select[name=student]').val()+'-'+element.id)) {
                    if(element.schoolsession_id == $('select[name=session]').val()){
                    $('select[name=week]').append(`<option ${Number(sweek) == element.id ? 'selected' : ''} value="${element.id}">${element.week}</option>`);
                    }
                }

                
            });
        }).change();

</script>

@endsection

