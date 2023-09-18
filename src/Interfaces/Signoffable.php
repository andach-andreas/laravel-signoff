<?php

namespace Andach\LaravelSignoff\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Signoffable
{
    public function signoff(): MorphOne;

    public function doFirstSignoff(): bool;

    public function getSignoffHtmlAttribute(): string;

    public function getSignoffNameAttribute(): string;

    public function isFullySignedOff(): bool;

    public function isFirstSignedOff(): bool;
}
