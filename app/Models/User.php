<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;

class User extends CrudAuthModel implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'email_verified_at',
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The model's default attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        //
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    /**
     * Search input fields' keys.
     *
     * @var array<int, string>
     */
    protected static array $searchable = [
        'search',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Get User's full name.
     */
    public function name(): Attribute
    {
        return Attribute::make(function (): string {
            if ($this->last_name) {
                return sprintf('%s %s', $this->first_name, $this->last_name);
            }

            return $this->first_name;
        })->shouldCache();
    }

    /**
     * Check admin status.
     */
    public function isAdmin(): bool
    {
        return false;
    }

    /**
     * Check super admin status.
     */
    public function isSuperAdmin(): bool
    {
        return false;
    }

    /**
     * Redirect to dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboardRedirect()
    {
        return redirect()->route('user.dashboard');
    }

    /**
     * Gravatar image URL.
     */
    public function gravatar(int $size = 256): string
    {
        return \Gravatar::get($this->email, $size);
    }

    /**
     * Search & filter models.
     */
    protected static function filter(Request $request): LengthAwarePaginator
    {
        $builder = static::query();

        if ($search = $request->get('search')) {
            $builder->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        return $builder->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate();
    }

    // Define the relationship with Organization
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user');
    }
}
