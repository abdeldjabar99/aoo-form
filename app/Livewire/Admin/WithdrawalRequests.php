<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\WithdrawalRequest;

class WithdrawalRequests extends Component
{
    public $searchInput = '';
    public $filterMonthInput = '';
    public $search = '';
    public $filterMonth = '';

    public function applyFilters()
    {
        $this->search = $this->searchInput;
        $this->filterMonth = $this->filterMonthInput;
    }

    public function delete($id)
    {
        WithdrawalRequest::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = WithdrawalRequest::with('user');

        if (!empty($this->search)) {
            $query->whereHas('user', function ($q) {
                $q->where('job_number', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->filterMonth)) {
            $query->where('month', $this->filterMonth);
        }

        return view('livewire.admin.withdrawal-requests', [
            'requests' => $query->get()
        ])->layout('layouts.app');
    }
}
