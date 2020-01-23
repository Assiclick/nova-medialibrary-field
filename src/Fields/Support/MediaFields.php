<?php

declare(strict_types = 1);

namespace DmitryBubyakin\NovaMedialibraryField\Fields\Support;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use DmitryBubyakin\NovaMedialibraryField\Fields\GeneratedConversions;

class MediaFields
{
    public static function make(): callable
    {
        return function (Request $request) {
            return [
                ID::make(),

                Text::make(__('File'), 'file_name')
                    ->rules('required', 'min:2'),

                Text::make(__('Name'), 'name')
                    ->rules('required', 'min:2'),

                Textarea::make(__('Description'), 'custom_properties->description')->alwaysShow(),

                Text::make(__('Disk'), 'disk')->exceptOnForms(),

                Text::make(__('Download Url'), function () {
                    return $this->resource->exists ? "<a href='{$this->resource->getFullUrl()}' target='_blank' class='no-underline font-bold dim text-primary'>{$this->resource->getFullUrl()}</a>" : null;
                })->asHtml(),

                Text::make(__('Size'))->displayUsing(function () {
                    return $this->resource->humanReadableSize;
                })->exceptOnForms(),

                Text::make(__('Updated At'))->displayUsing(function () {
                    return $this->resource->updated_at->diffForHumans();
                })->exceptOnForms(),

                GeneratedConversions::make(__('Conversions')),
            ];
        };
    }
}
