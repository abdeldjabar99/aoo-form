<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">All Withdrawal Requests</h2>

        <!-- Filters Section -->
        <div class="flex flex-wrap md:flex-nowrap items-center gap-6 mb-6 w-3/5">
            <input type="text" wire:model="searchInput" placeholder="Search by Job Number..." class="w-full md:w-64 border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <select wire:model="filterMonthInput" class="w-full md:w-40 border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Months</option>
                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                    <option value="{{ $m }}">{{ $m }}</option>
                @endforeach
            </select>
            
        <button wire:click="applyFilters" class="bg-transparent text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M5 8h14M7 12h10m-3 4h-4"/>
            </svg>
        </button>

        </div>

        <!-- Withdrawal Requests Table -->
        <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="border p-4  text-left">ID</th>
                        <th class="border p-4  text-left">User</th>
                        <th class="border p-4  text-left">Badge Number</th>
                        <th class="border p-4  text-left">Year</th>
                        <th class="border p-4  text-left">Month</th>
                        <th class="border p-4 text-left">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="border p-4">{{ $request->id }}</td>
                            <td class="border p-4">{{ $request->user->full_name ?? 'N/A' }}</td>
                            <td class="border p-4">{{ $request->user->job_number ?? 'N/A' }}</td>
                            <td class="border p-4">{{ $request->year }}</td>
                            <td class="border p-4">{{ $request->month }}</td>
                            <td class="border p-4">{{ $request->percentage }}%</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">No withdrawal requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>