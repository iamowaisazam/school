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
                            <h3 class="card-title">Session Update</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{URL::to('/sessions/'.$model->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title" value="{{$model->title}}" class="form-control">
                                            @if($errors->has('title'))
                                            <p class="text-danger">{{$errors->first('title')}}</p>
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

