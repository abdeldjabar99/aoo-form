<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class EmployeesList extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedEmployeeId;
    public $newPassword;
    public $showPasswordForm = false;


    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when searching
    }


    public function showPasswordModal($id)
    {
        $this->selectedEmployeeId = $id;
        $this->newPassword = '';
        $this->showPasswordForm = true;
    }

    public function updatePassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6',
        ]);

        $employee = User::findOrFail($this->selectedEmployeeId);
        $employee->password = bcrypt($this->newPassword);
        $employee->save();

        $this->showPasswordForm = false;
        session()->flash('message', 'Password updated successfully!');
    }
    public function render()
    {
        $employees = User::whereHas('roles', function ($query) {
                $query->where('name', 'employee');
            })
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%");
                }
            })
            ->paginate(10);

        return view('livewire.admin.employees-list', compact('employees'))
            ->layout('layouts.app');
    }
}
