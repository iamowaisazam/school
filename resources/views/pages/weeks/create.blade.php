@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Week Create</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL::to('weeks') }}" method="POST"
                                data-method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Week # <span class="text-danger">*</span></label>
                                            <input name="week" value="{{old('week')}}" class="form-control">
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
                                                    <option value="{{$s->id}}">{{$s->title}}</option>
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
                                            <input value="{{old('from_date')}}"  type="date" name="from_date" class="form-control">
                                            @if($errors->has('from_date'))
                                            <p class="text-danger" >{{ $errors->first('from_date') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>End Date <span class="text-danger">*</span></label>
                                            <input type="date" value="{{old('end_date')}}" name="end_date" class="form-control">
                                            @if($errors->has('end_date'))
                                            <p class="text-danger">{{$errors->first('end_date')}}</p>
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
       
</script>
@endsection