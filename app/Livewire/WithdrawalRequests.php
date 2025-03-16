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
    public $percentage;
    public $editId;
    public $requests;
    public $availableMonths = [];

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
    {
        $this->requests =WithdrawalRequest::where('user_id', Auth::id())->get();

        // Get all months that are already used
        $usedMonths = WithdrawalRequest::where('user_id', Auth::id())->pluck('month')->toArray();

        // Generate list of months (January - December) and filter out the ones already used
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
            'month' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (WithdrawalRequest::where('user_id', auth()->id())->where('month', $value)->exists()) {
                        $fail('You have already made a withdrawal request for this month.');
                    }
                }
            ],
            'percentage' => 'required|numeric|min:1|max:100',
        ]);

        WithdrawalRequest::create([
            'user_id' => auth()->id(),
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

        // Ensure the editId is set and belongs to the current user
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

        // Close the edit modal and refresh the requests
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
