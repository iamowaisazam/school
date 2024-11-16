@extends('layouts.app')

@section('content')

<style>
      @media (max-width: 767px){
        .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {       
            overflow: scroll!important;
        }
    }

    .dataTables_length{
        display: contents;
    }

    .dataTables_length label{
        display: contents;
        margin-bottom: 0px!important;
    }

    .dataTables_info {
     float: right!important;
     padding-bottom: 23px!important;
    }
</style>

    <section class="content-header">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Sheet</h3>
                        </div>
                        <div class="card-body">
                          

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="class">Class</label>
                                        <select class="select2bs4 form-control" name="class" data-placeholder="Select Class" style="width: 100%;">
                                            <option value="">Select Class</option>
                                            @foreach (App\Enums\Classes::DATA as $item)
                                              <option value="{{$item['name']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Students</label>
                                    <div class="form-group">
                                        <select name="student" class="form-control">
                                            <option value="">Select Student</option>
                                            @foreach ($students as $item)
                                            <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Week Number</label>
                                    <div class="form-group">
                                        <input name="week_number" class="form-control"  />
                                    </div>
                                </div>
                         
                                <div class="col-md-4">
                                    <label>Start Date</label>
                                    <div class="form-group">
                                        <input type="date" name="start_date" class="form-control"  />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>End Date</label>
                                    <div class="form-group">
                                        <input type="date" name="end_date" class="form-control"  />
                                    </div>
                                </div>

                                <div class="col-12 mt-3 text-center">
                                    <button class="search_btn btn btn-primary" >Search</button>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Students</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>SID</th>
                                        <th>Student Name</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Class</th>
                                        <th>Week Number</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {


            // DataTable initialization
            var dataTable = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: true, 
                dom: 'lirtp',
                lengthMenu: [[10,25, 50, 100,500],[10,25, 50, 100,500]],
                ajax: {
                    url: "{{URL::to('performances')}}",
                    type: "GET",
                    data: function ( d ) {  

                        d.class = $('select[name=class]').val();
                        d.student = $('select[name=student]').val();
                        d.week_number = $('input[name=week_number]').val();
                        d.start_date = $('input[name=start_date]').val();
                        d.end_date = $('input[name=end_date]').val();

                    }
                },
            });
            
            $(".search_btn").click(e =>{ 
                dataTable.draw();
            });

            $("#table").delegate(".delete_btn", "click", function(){
            
            var id = $(this).data('id'); 
            $.ajax({
                url:id,
                method:"delete",
                data:{
                  '_token': "{{ csrf_token() }}",
                },
                success: function (response) {
                    
                    toastr.success('Student deleted successfully');
                    dataTable.draw();
                },
                error:function (response) {
                    
              
                },
            });

        });

            
            // $('#table').on('click', '.delete', function(event) {
            //     event.preventDefault();

            //     var studentId = $(this).data('id');
            //     var row = $(this).closest('tr');
            //     const url = "{{URL::to('students/:id')}}".replace(':id', studentId);
            //     const csrfToken = $('meta[name="csrf-token"]').attr('content');

            //     if (confirm("Are you sure you want to delete this student?")) {
            //         $.ajax({
            //             url: url,
            //             type: 'DELETE', 
            //             headers: {
            //                 'X-CSRF-TOKEN': csrfToken
            //             },
            //             success: function(response) {
            //                 toastr.success('Student deleted successfully')
            //                 dataTable.row(row).remove().draw(
            //                     false); 
            //             },
            //             error: function(xhr) {
            //                 console.error(xhr.responseText);
            //                 alert('Failed to delete student');
            //             }
            //         });
            //     }
            // });

            


        });
    </script>

    <script>
        // $(document).on('click', '.view', function() {

        //     const studentId = $(this).data('id');
        //     let path = "{{URL::to('/')}}";
        //     const url = "{{ URL::to('students/:id') }}".replace(':id', studentId);

        //     $.ajax({
        //         url: url,
        //         type: 'GET',
        //         success: function(response) {
        //             $('#sid').text(response.sid);
        //             $('#campus').text(response.campus);
        //             $('#first_name').text(response.first_name);
        //             $('#last_name').text(response.last_name);
        //             $('#student_name').text(response.student_name);
        //             $('#father_name').text(response.father_name);
        //             $('#class').text(response.class);
        //             $('#phone').text(response.phone);
        //             $('#dob').text(response.dob);
        //             $('#address').text(response.address);
        //             if (response.image) {
        //                 $('#studentImage').attr('src', path+response.image)
        //                     .show();
        //                 $('#downloadImage').attr('href', path+response.image)
        //                     .show();
        //                 $('#noImageMessage').hide();
        //             } else {
        //                 $('#studentImage').hide();
        //                 $('#downloadImage').hide();
        //                 $('#noImageMessage').show();
        //             }
        //             $('#viewStudentModal').modal('show');
        //         },
        //         error: function(xhr) {
        //             console.error('Error fetching student data:', xhr.responseText);
        //             toastr.error('Failed to load student data. Please try again.');
        //         }
        //     });

        // });
    </script>
@endsection
