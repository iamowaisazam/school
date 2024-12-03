@extends('layouts.app')
@section('content')
<style>

    .tarbiya input{
        width: 40px;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Week Update</h3>
                        </div>
                        <div class="card-body">
                           

                            
                            <form action="{{URL::to('/weeks/'.$model->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Week # <span class="text-danger">*</span></label>
                                        <input name="week" value="{{$model->week}}" class="form-control">
                                            @if($errors->has('week'))
                                            <p class="text-danger">{{$errors->first('week')}}</p>
                                            @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Session <span class="text-danger">*</span></label>
                                        <select name="session" class="form-control" >
                                            @foreach ($sessions as $s)
                                                <option @if($model->schoolsession_id == $s->id) selected @endif value="{{$s->id}}">{{$s->title}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('session'))
                                        <p class="text-danger">{{$errors->first('session')}}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>From Date <span class="text-danger">*</span></label>
                                        <input value="{{date('Y-m-d',strtotime($model->from))}}"  type="date" name="from_date" class="form-control">
                                        @if($errors->has('from_date'))
                                        <p class="text-danger" >{{ $errors->first('from_date') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <input type="date" value="{{date('Y-m-d',strtotime($model->to))}}" name="end_date" class="form-control">
                                        @if($errors->has('end_date'))
                                        <p class="text-danger">{{$errors->first('end_date')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                           

                                <div class="row pt-3">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-secondary">Update</button>
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

@endsection

