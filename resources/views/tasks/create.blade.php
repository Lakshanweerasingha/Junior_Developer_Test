<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-4">Create New Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-lg font-medium">Title</label>
                <input type="text" id="title" name="title" class="mt-1 p-2 w-full border rounded" value="{{ old('title') }}" required maxlength="255">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-lg font-medium">Description</label>
                <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded" required minlength="10">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-lg font-medium">Status</label>
                <select name="status" id="status" class="mt-1 p-2 w-full border rounded" required>
                    <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-lg font-medium">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="mt-1 p-2 w-full border rounded" value="{{ old('due_date') }}" required>
                @error('due_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded mt-4 w-full sm:w-auto">Create Task</button>
        </form>
    </div>

</body>
</html>
