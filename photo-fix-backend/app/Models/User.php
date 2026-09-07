<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Legacy 'role' column is gone from the access-control decision below —
     * kept as a plain data column for now (harmless) so nothing else that
     * still reads it breaks, but who can actually sign in is decided purely
     * by Spatie roles/permissions (see Filament Shield's "Super Admin" role
     * and per-resource permissions in the admin panel's Roles page).
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Any user with at least one role assigned can sign in — what they can
        // actually see/do once inside is then decided per-resource by that
        // role's permissions (Admin panel → Roles). Zero roles = no access.
        return $this->hasRole(config('filament-shield.super_admin.name', 'super_admin'))
            || $this->roles()->exists();
    }
}
