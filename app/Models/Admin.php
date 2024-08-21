<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use App\Traits\TwoFactorAuth;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;

class Admin extends CrudAuthModel
{
    use HasFactory, MustVerifyEmail, Notifiable, SoftDeletes, TwoFactorAuth;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'super_admin',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'tfa',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'super_admin',
        'tfa',
        'tfa_otp',
        'last_seen_at',
        'email_verified_at',
        'api_token',
        'password',
        'remember_token',
    ];

    /**
     * The model's default attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'super_admin' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'super_admin'       => 'boolean',
        'tfa'               => 'boolean',
        'email_verified_at' => 'datetime',
        'last_seen_at'      => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    /**
     * Search input fields' keys.
     *
     * @var array<int, string>
     */
    protected static array $searchable = [
        'search',
        'super_admin',
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
     * Get Admin's full name.
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
     * Get Admin's last seen date & time.
     */
    public function lastSeen(): Attribute
    {
        return Attribute::make(function (): string {
            if ($this->last_seen_at) {
                return $this->last_seen_at->isToday()
                    ? $this->last_seen_at->diffForHumans()
                    : $this->last_seen_at->format(\Settings::get('datetime_format'));
            }

            return 'Never';
        })->shouldCache();
    }

    /**
     * Route notifications for the Panacea channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     */
    public function routeNotificationForPanacea($notification): string
    {
        return $this->mobile;
    }

    /**
     * Check admin status.
     */
    public function isAdmin(): bool
    {
        return true;
    }

    /**
     * Check super admin status.
     */
    public function isSuperAdmin(): bool
    {
        return $this->super_admin;
    }

    /**
     * Redirect to dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboardRedirect()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Gravatar image source.
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
        $builder = static::whereNot('id', \Auth::id());

        if ($search = $request->get('search')) {
            $builder->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('mobile', 'like', '%'.$search.'%');
            });
        }

        if ($super_admin = $request->get('super_admin')) {
            if ($super_admin == 'yes') {
                $builder->where('super_admin', 1);
            } else {
                $builder->where('super_admin', 0);
            }
        }

        return $builder->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate();
    }
}
