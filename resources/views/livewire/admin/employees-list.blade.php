<div class="py-12">
    @if($showPasswordForm)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Set New Password</h3>
            <input type="password" wire:model.defer="newPassword"
                   class="w-full border p-2 rounded mb-4" placeholder="Enter new password">

            <div class="flex justify-end space-x-2">
                <button wire:click="updatePassword"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Save
                </button>
                <button wire:click="$set('showPasswordForm', false)"
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endif
@if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('message') }}
    </div>
@endif

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
                                <th class="border p-3 text-left">Email</th>
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
                                    <td class="border p-3">{{ $employee->email }}</td>
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
                                         <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg"
                                                wire:click="showPasswordModal({{ $employee->id }})">
                                            Set Password
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
