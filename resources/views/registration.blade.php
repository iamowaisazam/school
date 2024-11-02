<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Form</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('/assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/dist/css/adminlte.min.css?v=3.2.0')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <style>
        .login-box,
        .register-box {
            width: 50% !important;
            max-width: 600px;
            /* Optional: Set a max width for larger screens */
            margin: auto;
            /* Center the box */
        }

        @media (max-width: 768px) {

            .login-box,
            .register-box {
                width: 100% !important;
                /* Full width on mobile */
            }
        }
    </style>

</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card">
            <div class="card-body register-card-body">
                <h3 class="login-box-msg">Registration Form</h3>
                <form method="POST" action="{{ URL::to('/submit-form')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="campus">Select Campus</label>
                                <select class="select2bs4" id="campus" name="campus"
                                    data-placeholder="Select Campus" style="width: 100%;" required>
                                    <option value="" disabled selected>Select Campus</option>
                                    <option value="Johar">Johar</option>
                                    <option value="North Nazimabad">North Nazimabad</option>
                                </select>
                            </div>
                        </div>

                        <div id="dynamic-registration-fields" class="col-12"></div>
                        <div id="dynamic-registration-fields2" class="col-12"></div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <div id="already-registered-message" style="display:none;" class="alert alert-warning">This student is already registered.</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/assets/dist/js/adminlte.min.js?v=3.2.0')}}"></script>
    <script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        
        // Define the registration fields template as a JS variable
        var registrationFields = `<div class="row">
                        <div class="col-12 col-sm-12 mb-3">
                <div class="form-group">
                    <label for="student_name">Student Name (as it will appear on card)</label>
                    <input type="text" id="student_name" name="student_name" class="form-control"
                        placeholder="Enter Student Name" required>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="form-group">
                    <label for="father_name">Father's Name</label>
                    <input type="text" id="father_name" name="father_name" class="form-control"
                        placeholder="Enter Father's Name" required>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        placeholder="Enter Phone Number" required>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control"
                        placeholder="Enter Date of Birth" required>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" class="form-control"
                        placeholder="Enter Address" required>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" id="image" name="image" class="form-control-file"
                        accept="image/*" required>
                </div>
            </div>
            <div class="col-12">
            <div class="input-group mb-3">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
          </div>
        </div>`;

        // Define the registration fields template as a JS variable
        var registrationFields2 = `
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label for="class_id">Select Class</label>
                    <select class="select2bs4" id="class_id" name="class_id"
                        data-placeholder="Select Class" style="width: 100%;" required>
                        <option value="" disabled selected>Select Class</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Junior">Junior</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4 Girls">Grade 4 Girls</option>
                        <option value="Grade 4 Boys">Grade 4 Boys</option>
                        <option value="Senior">Senior</option>
                        <option value="Hifz Boys">Hifz Boys</option>
                        <option value="Hifz Girls">Hifz Girls</option>

                    </select>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="form-group">
                    <label for="student_id">Select Student</label>
                    <select class="select2bs4 student-select" id="student_id" name="student_id"
                        data-placeholder="Select Student" style="width: 100%;" required>
                        <option value="" disabled selected>Select Student</option>
                        <!-- Students will be populated dynamically based on class selection -->
                    </select>
                </div>
            </div>`;


        $(document).ready(function() {
            $('.student-select').select2({
                theme: 'bootstrap4',
                placeholder: "Select Student",
                minimumInputLength: 3, // Start searching after 3 characters
                width: '100%' // Ensure the select box is responsive
            });
        });

        function loadSelect2() {
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: "Select Student",
                width: '100%' // Ensure the select box is responsive
            });
        }

        function loadStudents() {
            // Handle class change event
            $('#class_id').on('change', function() {
                var classId = $(this).val();
                var campus = $('#campus').val();
                console.log(campus)

                // Fetch students based on selected class (AJAX or pre-loaded data)
                $.ajax({url: '/get-students-by-class/' + classId + '/' +
                        campus, // Adjust the URL to match your route
                    method: 'GET',
                    success: function(data) {
                        var studentSelect = $('#student_id');
                        studentSelect.empty();
                        studentSelect.append(
                            '<option value="" disabled selected>Select Student</option>');

                        // Populate students
                        $.each(data.students, function(index, student) {
                            studentSelect.append('<option value="' + student.id +
                                '" data-is-registered="' + student.is_registered +
                                '">' +
                                'ID: ' + student.sid + ' - ' + student.first_name +
                                ' ' + student.last_name + '</option>');
                        });
                    }
                });
            });
        }

        function loadRegistrationFields() {
            // Handle student change event
            $('#student_id').on('change', function() {
                var isRegistered = $(this).find(':selected').data('is-registered');

                if (isRegistered == 0) {
                    // Inject registration fields dynamically
                    $('#dynamic-registration-fields2').html(registrationFields);
                    $('#already-registered-message').hide();
                } else {
                    // Show already registered message and remove registration fields
                    $('#dynamic-registration-fields2').empty();
                    $('#already-registered-message').show();
                }
            });
        }

        loadSelect2()
        loadStudents()
        loadRegistrationFields()

        $(document).ready(function() {
            $('#campus').on('change', function() {
                // Inject registration fields dynamically
                $('#dynamic-registration-fields').html(registrationFields2);
                loadSelect2()
                loadStudents()
                loadRegistrationFields()

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            @if (session('message'))
                toastr.success("{{ session('message') }}", "Success", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            @elseif (session('error'))
                toastr.error("{{ session('error') }}", "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            @elseif (session('warning'))
                toastr.warning("{{ session('warning') }}", "Warning", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {
            // Display validation errors if any
            @if ($errors->any())
                var errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += "{{ $error }}\n";
                @endforeach
                toastr.error(errorMessages, "Validation Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            @endif
        });
    </script>
    <script></script>
</body>
</html>
