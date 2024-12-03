

@extends('layouts.app')

@section('content')

<style>

    .tarbiya input{
        width: 40px;
    }

    .grade{
        
    }

</style>



    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Performance Update</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{URL::to('/performances/'.$model->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Student </label>
                                            <input readonly value="{{$model->student->id}} {{$model->student->first_name}}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="class">Select Class</label>
                                            <input readonly value="{{$model->class}}" 
                                            class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>From Date</label>
                                            <input readonly value="{{date('Y-m-d',strtotime($model->weekModel->from))}}" name="from_date" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input readonly value="{{date('Y-m-d',strtotime($model->weekModel->to))}}"  class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Session</label>
                                            <input readonly value="{{$model->weekModel->sessionModel->title}}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Week #</label>
                                            <input readonly value="{{$model->weekModel->week}}" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                @if(in_array($model->class,['Beginner','Junior','Senior']))
                                   @include('pages.performances.sheet1')
                                @else
                                    @include('pages.performances.sheet2')
                                @endif
                           
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
    

<script>
    
    $(document).ready(function() {



        function cc(i) {
            
            if(i){

                i = String(i).toLowerCase(); 
            
                if (i === 'e') {
                    return 5;
                } else if (i === 'g') {
                    return 4;
                } else if (i === 'r') {
                    return 3;
                } else if (i === 'b') {
                    return 2;
                } else if (i === 'n') {
                    return 1;
                } else {
                    return 0;
                }

            }else{
                i = 0;
            }

            return 0;
        }



        function calculate(){

            let mon = 0;
            let tue = 0;
            let wed = 0;
            let thu = 0;
            let fri = 0;
            let sat = 0;
            let sun = 0;

             $('.tarbiya tr').each(function(index, element) { 

                let el = $(this);

                 mon += cc(el.find('.mon').val());
                 tue += cc(el.find('.tue').val());
                 wed += cc(el.find('.wed').val());
                 thu += cc(el.find('.thu').val());
                 fri += cc(el.find('.fri').val());
                 sat += cc(el.find('.sat').val());
                 sun += cc(el.find('.sun').val());
                 
            });


            $('.mons').text(mon);
            $('.tues').text(tue);
            $('.weds').text(wed);
            $('.thus').text(thu);
            $('.fris').text(fri);
            $('.sats').text(sat);
            $('.suns').text(sun);

            $('.total_label').text(mon + tue + wed + thu + fri + sat + sun);
            $('input[name=total]').val(mon + tue + wed + thu + fri + sat + sun);
        }


        $('.tarbiya').change(function (e) { 
            calculate();
        });

        calculate();

        $('.mon,.tue,.wed,.thu,.fris,.sats,.suns').on('input', function () {
            const validValues = ['E', 'G', 'R', 'B', 'N'];
            const inputValue = $(this).val(); 
            if (!validValues.includes(inputValue)) {
                $(this).val('');
            }
        });

    });
</script>

@endsection

