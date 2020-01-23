<?php

declare(strict_types = 1);

namespace DmitryBubyakin\NovaMedialibraryField\Http\Requests;

use Laravel\Nova\Http\Requests\NovaRequest;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;

class MedialibraryRequest extends NovaRequest
{
    public function medialibraryField(): Medialibrary
    {
        return $this
            ->newResource()
            ->availableFields($this)
            ->whereInstanceOf(Medialibrary::class)
            ->findFieldByAttribute($this->field);
    }

    public function resourceExists(): bool
    {
        return $this->route('resourceId') !== 'undefined';
    }

    public function fieldUuid(): string
    {
        return $this->fieldUuid;
    }
}
