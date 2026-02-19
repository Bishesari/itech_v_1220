<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable;

    protected $fillable = ['user_name', 'password', 'is_active'];

    protected $hidden = ['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        $first = $this->profile->f_name_fa ? Str::substr($this->profile->f_name_fa, 0, 1) : '';
        $last = $this->profile->l_name_fa ? Str::substr($this->profile->l_name_fa, 0, 1) : '';

        return trim($first.' '.$last);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_user', 'user_id', 'contact_id')
            ->using(ContactUser::class)
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'institute_user', 'user_id', 'role_id')
            ->using(InstituteUser::class)
            ->withPivot(['institute_id', 'branch_id', 'is_active'])
            ->withTimestamps();
    }

    public function institutes(): BelongsToMany
    {
        return $this->belongsToMany(Institute::class, 'institute_user', 'user_id', 'institute_id')
            ->using(InstituteUser::class)
            ->distinct();
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'institute_user', 'user_id', 'branch_id')
            ->using(InstituteUser::class)
            ->distinct();
    }

    public function designedQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'designer_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(InstituteUser::class);
    }

    public function activeAssignment(): ?InstituteUser
    {
        return $this->assignments()
            ->where('id', session('active_assignment_id'))
            ->first();
    }

    public function activeRole(): ?Role
    {
        return $this->activeAssignment()?->role;
    }

    public function activeBranch(): ?Branch
    {
        return $this->activeAssignment()?->branch;
    }

    public function activeInstitute(): ?Institute
    {
        return $this->activeAssignment()?->institute;
    }

    public function hasRole(string $role, ?Institute $institute = null, ?Branch $branch = null): bool
    {
        return $this->roles()
            ->where('name_en', $role)
            ->when($institute, fn ($q) => $q->wherePivot('institute_id', $institute->id)
            )
            ->when($branch, fn ($q) => $q->wherePivot('branch_id', $branch->id)
            )
            ->exists();
    }
}
