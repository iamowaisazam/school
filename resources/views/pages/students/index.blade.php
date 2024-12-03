@extends('layouts.app')

@section('content')
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
                            <h3 class="card-title">Upload Students</h3>

                        </div>
                        <div class="card-body">
                            <!-- Form to upload file -->
                            <form action="{{URL::to('students/import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- File input field -->
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                name="file" required>
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Choose a file to upload. Supported file types: .csv,
                                        .xls, .xlsx</small>
                                </div>
                            </form>

                            <!-- Download Sample File button -->
                            <div class="form-group mt-3">
                                <a href="{{ asset('files/sample_students.xlsx') }}" class="btn btn-secondary">
                                    Download Sample File
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 style="float: none!important" class="card-title d-flex justify-content-between"> Students
                                <a class="btn btn-primary" href="{{URL::to('students/create')}}">Create</a>
                            </h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>sid</th>
                                        <th>first name</th>
                                        <th>last name</th>
                                        <th>Registration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Student Modal -->
        <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewStudentModalLabel">Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Student details will be loaded here via AJAX -->
                        <div id="studentDetails" class="row">
                            <!-- Left column: Image and download button -->
                            <div class="col-md-6 text-center">
                                <p><strong>Image:</strong></p>
                                <img id="studentImage" src="" alt="Student Image" class="img-thumbnail"
                                    style="max-width: 200px; display: none;">
                                <p id="noImageMessage" style="display: none;">No image found</p>
                                <br>
                                <a id="downloadImage" href="#" class="btn btn-primary mt-2" download
                                    style="display: none;">
                                    Download Image
                                </a>
                            </div>


                            <!-- Right column: Student details -->
                            <div class="col-md-6">
                                <p><strong>Student ID (SID):</strong> <span id="sid"></span></p>
                                <p><strong>Campus:</strong> <span id="campus"></span></p>
                                <p><strong>First Name:</strong> <span id="first_name"></span></p>
                                <p><strong>Last Name:</strong> <span id="last_name"></span></p>
                                <p><strong>Student Name:</strong> <span id="student_name"></span></p>
                                <p><strong>Father's Name:</strong> <span id="father_name"></span></p>
                                <p><strong>Class:</strong> <span id="class"></span></p>
                                <p><strong>Phone:</strong> <span id="phone"></span></p>
                                <p><strong>Date of Birth:</strong> <span id="dob"></span></p>
                                <p><strong>Address:</strong> <span id="address"></span></p>
                            </div>
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
                ajax: "{{ URL::to('students') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'sid',
                        name: 'sid'
                    },

                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'is_registered',
                        name: 'is_registered',
                        render: function(data, type, row) {
                            return data ? 'Yes' : 'No';
                        }
                    },
                    {
                        data: 'action',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Delete event handler
            $('#table').on('click', '.delete', function(event) {
                event.preventDefault();

                var studentId = $(this).data('id');
                var row = $(this).closest('tr');
                const url = "{{URL::to('students/:id')}}".replace(':id', studentId);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');



                if (confirm("Are you sure you want to delete this student?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE', // Use DELETE method for deletion
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            toastr.success('Student deleted successfully')
                            dataTable.row(row).remove().draw(
                                false); // Remove row from DataTable
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Failed to delete student');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.view', function() {
            
            const studentId = $(this).data('id');
            let path = "{{URL::to('/')}}";

            // Generate the URL dynamically using the student ID with the Laravel route helper
            const url = "{{ URL::to('students/:id') }}".replace(':id', studentId);


            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    
                    // Populate the modal with the student's data
                    $('#sid').text(response.sid);
                    $('#campus').text(response.campus);
                    $('#first_name').text(response.first_name);
                    $('#last_name').text(response.last_name);
                    $('#student_name').text(response.student_name);
                    $('#father_name').text(response.father_name);
                    $('#class').text(response.class);
                    $('#phone').text(response.phone);
                    $('#dob').text(response.dob);
                    $('#address').text(response.address);

                    // Handle image
                    if (response.image) {
                        $('#studentImage').attr('src', path+response.image)
                            .show();

                        $('#downloadImage').attr('href', path+response.image)
                            .show();

                        $('#noImageMessage').hide();
                    
                    } else {
                        $('#studentImage').hide(); // Hide the image
                        $('#downloadImage').hide(); // Hide the download button
                        $('#noImageMessage').show(); // Show "No image found" message
                    }

                    // Show the modal
                    $('#viewStudentModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching student data:', xhr.responseText);
                    toastr.error('Failed to load student data. Please try again.');
                }
            });
        });
    </script>
@endsection
