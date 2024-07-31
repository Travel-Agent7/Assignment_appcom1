@php $si = 0; @endphp
@forelse ($tasks as $task)
    <tr>
        <td>
            <p>
                <label>
                    <input type="checkbox" name="taskCheckbox" id="taskCheckbox_{{ $task->id }}" class="task-checkbox"
                        data-task-id="{{ $task->id }}" />
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
                <img src="{{ asset('storage/' . $task->image_path) }}" style="width:70px;height:70px;">
            @else
                <img src="{{ asset('default_image.jpg') }}" style="width:70px;height:70px;">
            @endif
        </td>

        <td>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal"
                data-id="{{ $task->id }}">
                <i class="fa fa-edit"></i> Edit Task
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center">No tasks found.</td>
    </tr>
@endforelse
