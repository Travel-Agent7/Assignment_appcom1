@extends('layouts.main')

@section('content')
    <div class="card bg-dark text-light">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h1>Task Listing</h1>
                    <p><small>Manage your task listings. You can add, edit and delete your tasks.</small></p>
                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addCategoryModal"><i
                            class="fa fa-plus"></i> Add Category</button>
                    <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#addModal"><i
                            class="fa fa-plus"></i> Add Task</button>
                </div>
                <div class="col-md-6">
                    <!-- profile picture -->
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                        style="float:right;width:100px;height:100px">
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Listing Table -->
    <div class="card my-4 shadow">
        <div class="card-header">
            <i class="fas fa-table"></i> Manage Your Tasks
        </div>

        <div class="card-body">
            <!-- Search autocomplete using ajax or axios -->
            <div class="row">
                <div class="col-md-4 form-group">
                    <input class="form-control" type="search" id="search-input" name="name" placeholder="Search"
                        aria-label="Search" oninput="Search(this.value)">
                </div>
                <div class="col-md-2 form-group">
                    <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>

                <div class="col-md-4 form-group">
                    <select class="form-control" aria-label="Default select example" id="category-select"
                        onchange="filterTasks()">
                        <option value="" selected>Choose category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <button type="button" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                </div>
            </div>
            </br>
            <a href="#" id="export-btn" style="float:right;" class="btn btn-success">
                <i class="fa fa-list"></i> Export to Excel
            </a>
            <button type="button" id="deleteBtn" style="float:left;" class="btn btn-danger"><i class="fa fa-trash"></i>
                Delete</button>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th width="90px">S No.</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Category Name</th>
                            <th>Task Image</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="result-tbl">
                        @php $si = 0; @endphp
                        @forelse ($tasks as $task)
                            <tr>
                                <td>
                                    <p>
                                        <label>
                                            <input type="checkbox" name="taskCheckbox" id="taskCheckbox_{{ $task->id }}"
                                                class="task-checkbox" data-task-id="{{ $task->id }}" />
                                            <span></span>
                                        </label>
                                    </p>
                                </td>
                                <td> {{ ++$si }}</td>
                                <td>{{ $task->taskname }}</td>
                                <td>{{ $task->description }}</td>
                                <td> {{ date('d-m-Y', strtotime($task->start_date)) }}</td>
                                <td> {{ date('d-m-Y', strtotime($task->end_date)) }}</td>
                                <td>{{ $task->category->name }}</td>
                                <td class="text-center">
                                    @if ($task->image_path)
                                        <img src="{{ asset('storage/' . $task->image_path) }}"
                                            style="width:70px;height:70px;">
                                    @else
                                        <img src="{{ asset('default_image.jpg') }}" style="width:70px;height:70px;">
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#editModal" data-id="{{ $task->id }}">
                                        <i class="fa fa-edit"></i> Edit Task
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="delete-form" method="POST" action="{{ route('tasks.multiDelete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="task-ids" name="task_ids">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the selected tasks?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Include modals for adding/editing tasks and categories -->
    @include('tasks/add_task')
    @include('tasks/edit_task')
    @include('categories/add_category')

    {{-- Script for export, search and filter --}}
    <script>
        function updateExportLink() {
            const categoryId = document.getElementById('category-select').value;
            const searchValue = document.getElementById('search-input').value;

            const exportUrl = '{{ route('tasks.export') }}' + '?category_id=' + categoryId + '&search=' + searchValue;
            console.log('Search Value:', searchValue);
            console.log('Category:', categoryId);
            console.log('Export url:', exportUrl);

            document.getElementById('export-btn').setAttribute('href', exportUrl);
        }

        function Search(Value) {
            $.ajax({
                url: '{{ route('tasks.search') }}',
                method: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    Value: Value
                },
                success: function(response) {
                    document.getElementById('result-tbl').innerHTML = response;
                    updateExportLink();
                }
            });
        }

        function filterTasks() {
            const categoryId = document.getElementById('category-select').value;

            $.ajax({
                url: '{{ route('tasks.filter') }}',
                method: 'get',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: categoryId
                },
                success: function(response) {
                    document.getElementById('result-tbl').innerHTML = response;
                    updateExportLink();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateExportLink();
        });
    </script>
@endsection
