<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property \Illuminate\Database\Eloquent\Model $target
 * @property \Illuminate\Foundation\Auth\User $user
 * @property array|null $changes
 * @property array|null $original
 * @property int $id
 * @property string $batch_id
 * @property int $user_id
 * @property string $name
 * @property string $actionable_type
 * @property int $actionable_id
 * @property string $target_type
 * @property int $target_id
 * @property string $model_type
 * @property int|null $model_id
 * @property string $fields
 * @property string $status
 * @property string $exception
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionEvent query()
 */
	class ActionEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property bool $super_admin
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile
 * @property bool $tfa
 * @property string|null $tfa_otp
 * @property string $theme
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $last_seen_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $api_token
 * @property string $password
 * @property string|null $remember_token
 * @property-read string $last_seen
 * @property-read string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\AdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin withoutTrashed()
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Organization|null $organization
 * @property-read \App\Models\Service|null $service
 * @property-read \App\Models\Subscription|null $subscription
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking query()
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $mobile
 * @property string|null $subject
 * @property string $message
 * @property string $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactForm query()
 */
	class ContactForm extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string $organization_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization query()
 */
	class Organization extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property int $organization_id
 * @property string|null $primary_color
 * @property string|null $secondary_color
 * @property string|null $logo_small
 * @property string|null $logo_large
 * @property string|null $time_zone
 * @property int $appointment_duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Organization $organization
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrganizationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrganizationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrganizationSetting query()
 */
	class OrganizationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Organization|null $organization
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service query()
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property bool $editable
 * @property string $type
 * @property string $key
 * @property mixed|null $value
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $organization_id
 * @property int $subscription_plan_id
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Organization $organization
 * @property-read \App\Models\SubscriptionPlan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription query()
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $max_bookings
 * @property int $has_sms_notifications
 * @property int $has_email_notifications
 * @property string $price
 * @property int $duration_in_days
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionPlan query()
 */
	class SubscriptionPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string $theme
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $api_token
 * @property string $password
 * @property string|null $remember_token
 * @property-read string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

