<!-- Add Task Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="taskname">Task Name</label>
                        <input type="text" class="form-control" name="taskname" placeholder="Enter Name of Task"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Type some details about the task"></textarea>
                        <small id="emailHelp" class="form-text text-muted">(Optional)</small>
                    </div>

                    <div class="form-group">
                        <label for="startdate">Start Date</label>
                        <input type="date" class="form-control" name="start_date" placeholder="start date" required>
                    </div>

                    <div class="form-group">
                        <label for="enddate">End Date</label>
                        <input type="date" class="form-control" name="end date" placeholder="end date" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" id="category" name="category_id">
                            <option value="" disabled selected>Select One</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="task_image">Task Image</label>
                        <input type="file" name="task_image" id="task_image" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
