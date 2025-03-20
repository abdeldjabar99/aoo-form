<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">All Employees</h2>

                <!-- Search Bar -->
                <div class="flex items-center space-x-2 mb-4">
                    <input type="text" wire:model.debounce.500ms="search"
                           placeholder="Search employees..."
                           class="w-64 border p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Employee Table -->
                <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-blue-100 text-gray-700 text-sm">
                                <th class="border p-3 text-left">ID</th>
                                <th class="border p-3 text-left">Full Name</th>
                                <th class="border p-3 text-left">Passport Name</th>
                                <th class="border p-3 text-left">Passport Number</th>
                                <th class="border p-3 text-left">National Number</th>
                                <th class="border p-3 text-left">Job Number</th>
                                <th class="border p-3 text-left">Phone Number</th>
                                <th class="border p-3 text-left">Advance?</th>
                                <th class="border p-3 text-left">Islamic Murabaha?</th>
                                <th class="border p-3 text-left">Management</th>
                                <th class="border p-3 text-left">Department</th>
                                <th class="border p-3 text-left">Workplace</th>
                                <th class="border p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="border p-3">{{ $employee->id }}</td>
                                    <td class="border p-3">{{ $employee->full_name }}</td>
                                    <td class="border p-3">{{ $employee->passport_name }}</td>
                                    <td class="border p-3">{{ $employee->passport_number }}</td>
                                    <td class="border p-3">{{ $employee->national_number }}</td>
                                    <td class="border p-3">{{ $employee->job_number }}</td>
                                    <td class="border p-3">{{ $employee->phone_number }}</td>
                                    <td class="border p-3">{{ $employee->advance ? 'Yes' : 'No' }}</td>
                                    <td class="border p-3">{{ $employee->murabaha_purchase ? 'Yes' : 'No' }}</td>
                                    <td class="border p-3">{{ $employee->management }}</td>
                                    <td class="border p-3">{{ $employee->department }}</td>
                                    <td class="border p-3">{{ $employee->workplace }}</td>
                                    <td class="border p-3 flex space-x-2">
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg"
                                                onclick="confirm('Are you sure you want to delete this employee?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $employee->id }})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-gray-500 py-4">No employees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
