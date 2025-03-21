<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-4">My Tasks</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Create Task Button --}}
        <div class="mb-4">
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Create New Task</a>
        </div>

        {{-- Table Layout --}}
        <div class="overflow-x-auto mb-6">
            <table class="table-fixed w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3 w-1/4 text-left">Title</th>
                        <th class="border p-3 w-1/4 text-left">Description</th>
                        <th class="border p-3 w-1/6 text-left">Due Date</th>
                        <th class="border p-3 w-1/6 text-left">Status</th>
                        <th class="border p-3 w-1/6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="border">
                            <td class="border p-3">{{ $task->title }}</td>
                            <td class="border p-3">{{ $task->description }}</td>
                            <td class="border p-3">{{ $task->due_date }}</td>
                            <td class="border p-3">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-status" data-task-id="{{ $task->id }}" {{ $task->status == 'Completed' ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td class="border p-3 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                {{-- Edit Button --}}
                                <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition w-full sm:w-auto text-center">
                                    Edit
                                </a>

                                {{-- Delete Button --}}
                                <button class="bg-red-500 text-white px-4 py-2 rounded w-full sm:w-auto sm:ml-2 text-center delete-task" data-task-id="{{ $task->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card Layout --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($tasks as $task)
            <div class="p-4 border rounded-lg shadow-lg bg-white task-card" data-task-id="{{ $task->id }}">
    <h3 class="text-lg font-bold">{{ $task->title }}</h3>
    <p class="text-gray-600">{{ $task->description }}</p>
    <p class="text-sm text-gray-500">Due: {{ $task->due_date }}</p>
    <span class="inline-block mt-2 px-2 py-1 rounded text-white task-status {{ $task->status == 'Completed' ? 'bg-green-500' : 'bg-yellow-500' }}">
        {{ ucfirst($task->status) }}
    </span>

    {{-- Edit and Delete Buttons --}}
    <div class="mt-4 flex space-x-2">
        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Edit</a>
        <button class="bg-red-500 text-white px-4 py-2 rounded delete-task" data-task-id="{{ $task->id }}">Delete</button>
    </div>
</div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    </div>

    <!-- Add custom CSS for the slider (switch) -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 50px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            border-radius: 50px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }

        input:checked + .slider:before {
            transform: translateX(14px);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
 $(document).on('change', '.toggle-status', function() {
    var taskId = $(this).data('task-id');
    var checkbox = $(this);
    var status = checkbox.is(':checked') ? 'Completed' : 'Pending';

    // Send AJAX request to update the status
    $.ajax({
        url: '/tasks/' + taskId + '/toggle-status',  
        method: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}',
            status: status  // Send the new status along with the request
        },
        success: function(response) {
            if (response.status) {
                // Update the status text color and label in the table row
                var statusLabel = checkbox.closest('tr').find('.task-status'); // Get the status label for the row
                statusLabel.text(response.status);
                statusLabel.removeClass('bg-green-500 bg-yellow-500'); // Remove old status color
                if (response.status === 'Completed') {
                    statusLabel.addClass('bg-green-500');
                } else {
                    statusLabel.addClass('bg-yellow-500');
                }

                // Optionally, also update the checkbox state
                checkbox.prop('checked', response.status === 'Completed');

                // Update the status in the card layout
                var card = $('.task-card[data-task-id="' + taskId + '"]');
                var cardStatusLabel = card.find('.task-status');
                cardStatusLabel.text(response.status);
                cardStatusLabel.removeClass('bg-green-500 bg-yellow-500');
                if (response.status === 'Completed') {
                    cardStatusLabel.addClass('bg-green-500');
                } else {
                    cardStatusLabel.addClass('bg-yellow-500');
                }

                // Optionally, update the status in the task title or description as well
                // card.find('.task-title').text(response.title); // Example
            } else {
                alert('Error toggling status: ' + response.error);
            }
        },
        error: function(xhr) {
            alert('Error toggling status.');
        }
    });
});


        document.querySelectorAll('.delete-task').forEach(button => {
            button.addEventListener('click', function () {
                const taskId = this.getAttribute('data-task-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This task will be deleted and can be restored later!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create form and submit it to delete the task
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/tasks/' + taskId;

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>

</body>
</html>
