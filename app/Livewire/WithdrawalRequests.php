<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;

class WithdrawalRequests extends Component
{
    public $isOpen = false;
    public $isEditOpen = false;
    public $month;
    public $year;
    public $percentage;
    public $editId;
    public $requests;
    public $selectedYear;
    public $availableMonths = [];

public function mount()
{
    $this->year = date('Y'); // Default filter for table (all years)
    $this->selectedYear = date('Y'); // Default for new requests
    $this->loadRequests(); // Load all requests (don't filter by year)
    $this->updateAvailableMonths(); // Refresh available months
}



    public function updatedSelectedYear()
    {
        $this->updateAvailableMonths(); // Refresh months dynamically
    }


    public function loadRequests()
    {
        $this->requests = WithdrawalRequest::where('user_id', Auth::id())->get(); // Show all years

        // Get all months that are already used for the selected year in the modal
        $usedMonths = WithdrawalRequest::where('user_id', Auth::id())
            ->where('year', $this->selectedYear)
            ->pluck('month')
            ->toArray();

        // Generate list of months (January - December) and filter out the ones already used
        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        $this->availableMonths = array_diff($allMonths, $usedMonths);
    }

    public function updateAvailableMonths()
{
    // Get all months that are already used for the selected year
    $usedMonths = WithdrawalRequest::where('user_id', Auth::id())
        ->where('year', $this->selectedYear)
        ->pluck('month')
        ->toArray();

    // Full list of months
    $allMonths = [
        'January', 'February', 'March', 'April', 'May', 'June', 
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // Only keep months that haven't been used
    $this->availableMonths = array_diff($allMonths, $usedMonths);
}

    public function openModal()
    {
        $this->isOpen = true;
        $this->loadRequests(); // Reload available months
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function create()
    {
        $this->validate([
            'selectedYear' => 'required|numeric|min:2020|max:' . date('Y'),
            'month' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (WithdrawalRequest::where('user_id', auth()->id())
                        ->where('year', $this->selectedYear) // Now using selectedYear
                        ->where('month', $value)
                        ->exists()
                    ) {
                        $fail('You have already made a withdrawal request for this month in the selected year.');
                    }
                }
            ],
            'percentage' => 'required|numeric|min:1|max:100',
        ]);

        WithdrawalRequest::create([
            'user_id' => auth()->id(),
            'year' => $this->selectedYear, // Now using selectedYear
            'month' => $this->month,
            'percentage' => $this->percentage,
        ]);

        $this->closeModal();
        $this->loadRequests(); // Refresh table
    }


    public function edit($id)
    {
        $request = WithdrawalRequest::findOrFail($id);
        $this->editId = $request->id;
        $this->year = $request->year;
        $this->month = $request->month;
        $this->percentage = $request->percentage;
        $this->isEditOpen = true; // Open Edit Modal
    }

    public function delete($id)
    {
        WithdrawalRequest::where('id', $id)->where('user_id', auth()->id())->delete();
        $this->loadRequests(); // Refresh the table
    }

    public function update()
    {
        $this->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($this->editId) {
            $request = WithdrawalRequest::where('id', $this->editId)
                ->where('user_id', auth()->id())
                ->first();

            if ($request) {
                $request->update([
                    'percentage' => $this->percentage,
                ]);
            }
        }

        $this->isEditOpen = false;
        $this->editId = null;
        $this->percentage = null;
        $this->loadRequests(); // Refresh the table
    }



    public function render()
    {
        return view('livewire.withdrawal-requests')
            ->layout('layouts.app');
    }
}
