<!-- Edit Task Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editTaskForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="user_id" id="user_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="taskname">Task Name</label>
                        <input type="text" class="form-control" id="taskname" name="taskname"
                            placeholder="Enter Name of Task" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Type some details about the task"></textarea>
                        <small id="emailHelp" class="form-text text-muted">(Optional)</small>
                    </div>

                    <div class="form-group">
                        <label for="startdate">Start Date</label>
                        <input type="date" class="form-control" id="startdate" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="enddate">End Date</label>
                        <input type="date" class="form-control" id="enddate" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" id="category" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="task_image">Task Image</label>
                        <input type="file" id="task_image" name="task_image" class="form-control">
                        <img id="current_image" src="" style="width:100px; height:100px; margin-top:10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
