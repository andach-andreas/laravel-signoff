<?php

namespace Andach\LaravelSignoff\Models;

use Andach\LaravelPrimaryKeyUuid\Traits\PrimaryKeyUUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Signoff extends Model
{
    use PrimaryKeyUUID;
    use SoftDeletes;

    protected $fillable = ['signoffable_id', 'signoffable_type', 'user_id', 'first_signoff_timestamp', 'first_signoff_image',
        'is_second_signoff_required', 'second_user_id', 'second_signoff_timestamp', 'second_signoff_image'];

    /*
     * Returns true if the first signoff was successful, or if the item was already signed off.
     * Returns false if the user isn't the person assigned to sign off.
     */
    public function doFirstSignoff(): bool
    {
        if ($this->isFirstSignedOff()) {
            return true;
        }

        if (Auth::id() !== $this->user_id && $this->user_id) {
            return false;
        }

        $this->first_signoff_timestamp = Carbon::now()->toDateTimeString();
        $this->user_id                 = Auth::id();
        $this->first_signoff_image     = request()->input('sign');
        $this->save();

        return true;
    }

    /*
     * Returns true if the second signoff was successful, or if the item was already double signed off.
     * Returns false if the user isn't the person assigned to sign off, or if it is not first signed off, or if the user did the first signoff.
     */
    public function doSecondSignoff(): bool
    {
        if ($this->isSecondSignedOff()) {
            return true;
        }

        if (!$this->isFirstSignedOff()) {
            return false;
        }

        if (Auth::id() !== $this->second_user_id && $this->second_user_id) {
            return false;
        }

        if (Auth::id() === $this->user_id) {
            return false;
        }

        $this->second_signoff_timestamp = Carbon::now()->toDateTimeString();
        $this->second_user_id           = Auth::id();
        $this->second_signoff_image     = request()->input('sign');
        $this->save();

        return true;
    }

    public function isFirstSignedOff(): bool
    {
        return $this->first_signoff_timestamp ? true : false;
    }

    public function isFullySignedOff(): bool
    {
        if ($this->isSecondSignedOff()) {
            return true;
        }

        if ($this->isSecondSignoffRequired()) {
            return false;
        }

        return $this->isFirstSignedOff();
    }

    public function isSecondSignedOff(): bool
    {
        return $this->second_signoff_timestamp ? true : false;
    }

    public function isSecondSignoffRequired(): bool
    {
        return $this->is_second_signoff_required ? true : false;
    }

    public function signoffable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function userSecond(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'second_user_id');
    }
}
