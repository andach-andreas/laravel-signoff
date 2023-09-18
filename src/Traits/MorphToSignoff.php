<?php

namespace Andach\LaravelSignoff\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

trait MorphToSignoff
{
    public function signoff(): MorphOne
    {
        return $this->morphOne('Andach\LaravelSignoff\Models\Signoff', 'signoffable');
    }

    public function doFirstSignoff(): bool
    {
        $signoff = $this->signoff;
        if (!$this->signoff) {
            $signoff = $this->signoff()->create([
                'user_id' => Auth::id(),
            ]);
        }

        return $signoff->doFirstSignoff();
    }

    public function doSecondSignoff(): bool
    {
        $signoff = $this->signoff;
        if (!$this->signoff) {
            return false;
        }

        return $signoff->doSecondSignoff();
    }

    public function getSignoffHtmlAttribute(): string
    {
        if ($this->isFullySignedOff()) {
            return '<i class="fa-solid fa-check"></i>';
        }

        return '<i class="fa-solid fa-xmark"></i>';
    }

    public function getSignoffNameAttribute(): string
    {
        return match (class_basename(__CLASS__)) {
            'CarePlan' => 'Care Plan for ' . $this->resident->preferred_name,
            default    => $this->name,
        };
    }

    public function isFullySignedOff(): bool
    {
        if (!$this->signoff) {
            return false;
        }

        return $this->signoff->isFullySignedOff();
    }

    public function isFirstSignedOff(): bool
    {
        if (!$this->signoff) {
            return false;
        }

        return $this->signoff->isFirstSignedOff();
    }
}
