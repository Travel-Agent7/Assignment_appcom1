<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Dashboard')</title>

    <!-- CSS -->
    <link href="{{ asset('admin/assets/css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark static-top" style="background-color: #2d46c8;">
        <a class="navbar-brand mr-1" href="{{ route('dashboard') }}">Dashboard</a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <div class="ml-auto d-flex align-items-center">
            <!-- Logged In User Info -->
            <span class="text-white mr-0">Logged in as <strong>{{ auth()->user()->fullname }}</strong></span>
            <a class="btn btn-link text-white" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i>Logout</a>
            {{-- <form action="{{ route('logout') }}" method="POST" class="ml-0">
                @csrf
                <button type="submit" class="btn btn-link text-white">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Log Out</span>
                </button>
            </form> --}}
        </div>
    </nav>

    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Main</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Are you sure you want to Logout?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <div class="modal-body">Logout</div> --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input class="btn btn-primary" type="submit" value="Logout">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sb-admin.min.js') }}"></script>

    {{-- Script to Trigger Modal by id (Update) --}}
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var taskId = button.data('id');
            // console.log(taskId);
            $.ajax({
                url: '/tasks/' + taskId,
                method: 'GET',
                success: function(response) {
                    var modal = $('#editModal');

                    modal.find('#taskname').val(response.taskname);
                    modal.find('#description').val(response.description);
                    modal.find('#startdate').val(response.start_date);
                    modal.find('#enddate').val(response.end_date);
                    modal.find('#category').val(response.category_id);

                    if (response.image_path) {
                        modal.find('#current_image').attr('src',
                            '{{ asset('storage/') }}/' + response.image_path);
                    } else {
                        modal.find('#current_image').attr('src', '{{ asset('default_image.jpg') }}');
                    }

                    modal.find('#editTaskForm').attr('action', '{{ route('tasks.update', '') }}/' +
                        taskId);
                    modal.find('input[name="user_id"]').val(response.user_id);
                },
                error: function() {
                    alert('Error fetching task details');
                }
            });
        });

        // Script to retreive checked tasks (Delete)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#deleteBtn').addEventListener('click', function() {
                var checkboxes = document.querySelectorAll('input[name="taskCheckbox"]:checked');

                var taskIds = Array.from(checkboxes)
                    .map(checkbox => checkbox.dataset.taskId)
                    .filter(taskId => taskId)
                    .join(',');

                // console.log('Task IDs:', taskIds);

                if (!taskIds) {
                    // console.log('No tasks selected');
                    alert('Please select at least one task to delete!!');
                    return;
                }

                // console.log('Tasks selected, opening modal');
                document.querySelector('#task-ids').value = taskIds;
                // alert(taskIds);
                $('#confirmModal').modal('show');
            });
        });
    </script>

</body>

</html>
