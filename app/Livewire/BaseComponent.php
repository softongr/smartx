<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class BaseComponent extends Component
{
    // Καθιστούμε τη μεταβλητή $user nullable και με τύπο User.
    protected ?User $user = null;
    protected array $permissions = [];

    public function mount()
    {
        // Αρχικοποιούμε το $user μέσα στην μέθοδο mount().
        $this->user = Auth::user();
        $this->registerPermissions();
    }

    /**
     * Δημιουργεί permissions στη βάση αν δεν υπάρχουν.
     */
    protected function registerPermissions()
    {
        foreach ($this->permissions as $method => $permissionName) {
            if (!Permission::where('name', $permissionName)->exists()) {
                Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
            }
        }
    }

    /**
     * Ελέγχει αν ο χρήστης έχει το κατάλληλο permission.
     */
    protected function hasPermission($method): bool
    {
        if (!isset($this->permissions[$method])) {
            return true; // Αν η μέθοδος δεν έχει ορισμένο permission, επιτρέπεται η πρόσβαση
        }

        $permissionName = $this->permissions[$method];

        if ($this->user && $this->user->superadmin()) {
            return true; // Superadmin bypasses all permissions
        }

        return $this->user?->can($permissionName) ?? false;
    }

    /**
     * Διαχειρίζεται την κλήση των μεθόδων και ελέγχει permissions.
     */
    public function __call($method, $params)
    {
        if (!$this->hasPermission($method)) {
            abort(403, __('You do not have permission for this action.'));
        }

        return parent::__call($method, $params);
    }
}

