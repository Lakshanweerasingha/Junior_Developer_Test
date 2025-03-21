<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-4">Edit Task</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-2">Title:</label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Description:</label>
                <textarea name="description" class="w-full border p-2 rounded">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Due Date:</label>
                <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Status:</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto">Update Task</button>
        </form>
    </div>

</body>
</html>
