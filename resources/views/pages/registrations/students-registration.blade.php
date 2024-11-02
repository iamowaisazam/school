@extends('layouts.app')

<style>
    #table_wrapper{
        overflow-x: scroll;
    }
</style>

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

                    <!-- Custom error message from JavaScript -->
                    <div class="alert alert-danger error-message d-none"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php 
                      $classes = App\Enums\Classes::DATA;
                    ?>
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="card-title ">Search By Class</h2>
                        </div>
                        <div class="card-body ">
                                  <form> 
                                     <select class="form-control" name="class_filter">
                                         <option value="">All</option>
                                         @foreach ($classes  as $item)
                                         <option 
                                           @if(request()->class_filter == $item['name']) selected @endif  
                                            
                                            value="{{$item['name']}}">{{$item['name']}}</option>
                                         @endforeach
                                     </select>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header  ">

                            <h3 class="w-100 card-title d-flex alig-items-center justify-content-between align-items-center">
                                <p class="m-0" >Registrations</p>

                                <div class="d-flex text-end" > 

                                    <form class="m-0 selected-students-form" method="POST"
                                    action="{{ URL::to('/students/handle-selected') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="parent">
                                    <input type="hidden" name="selected_ids" class="selected_ids" value="">
                                    <button type="submit" class="btn btn-secondary">Print Parent(s) ID</button>
                                </form>
                                <!-- Student Print Form -->
                                <form class="m-0 selected-students-form" method="POST"
                                    action="{{ URL::to('/students/handle-selected') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="student">
                                    <input type="hidden" name="selected_ids" class="selected_ids" value="">
                                    <button type="submit" class="btn btn-secondary mx-2">Print Student(s) ID</button>
                                </form>
                                <a  href="{{ URL::to('students-registration') }}" class="m-0 btn btn-secondary mx-2">All
                                    Registrations</a>
                                </div>
                            </h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>sid</th>
                                        <th>campus</th>
                                        <th>class</th>
                                        <th>first name</th>
                                        <th>last name</th>
                                        <th>father name</th>
                                        <th>phone</th>
                                        <th>dob</th>
                                        <th>Date/Time</th>
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
        <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel"
            aria-hidden="true">
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
            var classFilter = "{{ request('class_filter') }}"; // Get class filter from query string
            // DataTable initialization
            let selectedRows = [];

            var dataTable = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ URL::to('students-registration')}}",
                    data: function(d) {
                        d.class_filter = classFilter;
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sid',
                        name: 'sid'
                    },
                    {
                        data: 'campus',
                        name: 'campus'
                    },
                    {
                        data: 'class',
                        name: 'class'
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
                        data: 'father_name',
                        name: 'father_name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'dob',
                        name: 'dob'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    // When the table redraws (pagination or filtering), restore checkbox states
                    $('.student-checkbox').each(function() {
                        $(this).prop('checked', selectedRows.includes($(this).val()));
                    });

                    // Set 'Select All' state based on selected rows across all pages
                    $('#selectAll').prop('checked', $('.student-checkbox:checked').length === $(
                        '.student-checkbox').length);
                }
            });

            // "Select All" checkbox functionality
            $('#selectAll').on('click', function() {
                let isChecked = $(this).prop('checked');
                $('.student-checkbox').each(function() {
                    $(this).prop('checked', isChecked);
                    updateSelectedRows($(this).val(), isChecked);
                });
            });

            // Individual checkbox change event
            $('#table').on('change', '.student-checkbox', function() {
                updateSelectedRows($(this).val(), $(this).prop('checked'));
                // Uncheck "Select All" if any checkbox is unchecked
                $('#selectAll').prop('checked', $('.student-checkbox:checked').length === $(
                    '.student-checkbox').length);
            });

            // Function to manage selected rows array
            function updateSelectedRows(id, isSelected) {
                const index = selectedRows.indexOf(id);
                if (isSelected && index === -1) {
                    selectedRows.push(id); // Add to selected
                } else if (!isSelected && index !== -1) {
                    selectedRows.splice(index, 1); // Remove from selected
                }
            }


            var downloadPdfUrl = @json(route('students.download-pdf'));
            // Download PDF event handler
            $('#downloadPdf').on('click', function() {
                var selectedStudents = $('#studentSelect').val();
                if (selectedStudents.length > 0) {
                    var url = downloadPdfUrl + '?students=' + selectedStudents.join(',');
                    window.location.href = url;
                } else {
                    alert('Please select at least one student.');
                }
            });



        });
    </script>

    <script>
        $(document).on('click', '.view', function() {
            const studentId = $(this).data('id');

            // Generate the URL dynamically using the student ID with the Laravel route helper
            const url = "{{ URL::to('students/:id') }}".replace(':id', studentId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    debugger
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
                        $('#studentImage').attr('src', response.image)
                            .show(); // Set the image source and show
                        $('#downloadImage').attr('href', response.image)
                            .show(); // Set the download link and show
                        $('#noImageMessage').hide(); // Hide "No image found" message
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

    {{-- <script>
    $(document).on('click', '#submitSelected', function() {
            var selectedIds = [];
            $('.student-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            // Send AJAX request
            $.ajax({
                url: '{{route("students.handleSelected")}}', // Ensure this matches your route
                method: 'POST',
                data: {
                    selected_ids: selectedIds,
                    _token: '{{ csrf_token() }}' // Ensure CSRF token is included
                },
                success: function(response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Debugging in case of error
                }
            });
        });
</script> --}}
    <script>
        // Attach event listener to each form separately
        document.querySelectorAll('.selected-students-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                var selectedIds = [];

                // Get all selected checkboxes
                document.querySelectorAll('.student-checkbox:checked').forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });

                if (selectedIds.length === 0) {
                    // Prevent form submission and display an error
                    e.preventDefault();

                    // Optionally set error in local session or display an inline message
                    document.querySelector('.error-message').innerHTML =
                        "Please select at least one person.";
                    document.querySelector('.error-message').classList.remove('d-none');
                } else {
                    // Set selected IDs in hidden input
                    form.querySelector('.selected_ids').value = selectedIds.join(',');
                }
            });
        });

    
        document.querySelector('select[name=class_filter]').addEventListener('change',function(event){
            
            let uu = "{{URL::to('students-registration')}}?class_filter=";
            window.location.href= uu + event.target.value;

            
        });

    </script>
@endsection
