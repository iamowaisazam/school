@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Session Create</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL::to('sessions') }}" method="POST"
                                data-method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title" value="{{old('title')}}" class="form-control">
                                                @if($errors->has('title'))
                                                <p class="text-danger">{{$errors->first('title')}}</p>
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