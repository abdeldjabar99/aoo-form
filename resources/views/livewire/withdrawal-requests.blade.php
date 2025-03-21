<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">My Withdrawal Requests</h2>

        <!-- Button to Open Modal -->
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition"
            wire:click="openModal">
            + Create Withdrawal Request
        </button>

        <!-- Modal for Creating Request -->
        @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">New Withdrawal Request</h3>
                <!-- Year Dropdown -->
                <label for="year" class="block text-sm font-medium">Year</label>
                <select wire:model="selectedYear" wire:change="updateAvailableMonths" class="w-full border p-2 rounded mt-1">
                    @for ($y = date('Y')-1; $y <= 2030; $y++)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>


                <!-- Month Dropdown -->
                <label class="block text-sm font-medium text-gray-600">Month</label>
                <select wire:model="month"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select a month</option>
                    @foreach ($availableMonths as $m)
                    <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
                @error('month') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Percentage Dropdown -->
                <label class="block text-sm font-medium text-gray-600 mt-2">Percentage</label>
                <select wire:model="percentage"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Percentage --</option>
                    <option value="0">0%</option>
                    <option value="20">20%</option>
                    <option value="50">50%</option>

                    @if (!auth()->user()->advance && !auth()->user()->murabaha_purchase)
                        <option value="70">70%</option>
                        <option value="100">100%</option>
                    @endif
                </select>
                @error('percentage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-2 mt-4">
                    <button class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500"
                        wire:click="closeModal">Cancel</button>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition"
                        wire:click="create">Submit</button>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal for Editing Percentage -->
        @if ($isEditOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Edit Percentage</h3>

                <label class="block text-sm font-medium text-gray-600">Percentage</label>
                <select wire:model="percentage"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="0">0%</option>
                    <option value="20">20%</option>
                    <option value="50">50%</option>
                    <option value="70">70%</option>
                    <option value="100">100%</option>
                </select>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-2 mt-4">
                    <button class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500"
                        wire:click="$set('isEditOpen', false)">Cancel</button>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition"
                        wire:click="update">Update</button>
                </div>
            </div>
        </div>
        @endif

        <!-- Withdrawal Requests Table -->
        <div class="mt-6 bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Month</th>
                        <th class="border p-2 text-left">Year</th>
                        <th class="border p-2 text-left">Percentage</th>
                        <th class="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="border p-2">{{ $request->id }}</td>
                        <td class="border p-2">{{ $request->month }}</td>
                        <td class="border p-2">{{ $request->year }}</td>
                        <td class="border p-2">{{ $request->percentage }}%</td>
                        <td class="border p-2 flex space-x-2">
                            <!-- Edit Button -->
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm"
                                wire:click="edit({{ $request->id }})">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm"
                                wire:click="delete({{ $request->id }})"
                                onclick="return confirm('Are you sure you want to delete this request?')">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
