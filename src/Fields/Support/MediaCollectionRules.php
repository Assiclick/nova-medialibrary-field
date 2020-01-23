<?php

declare(strict_types = 1);

namespace DmitryBubyakin\NovaMedialibraryField\Fields\Support;

use Illuminate\Support\Facades\Validator;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Validation\ClosureValidationRule;
use Illuminate\Contracts\Validation\ImplicitRule;
use DmitryBubyakin\NovaMedialibraryField\TransientModel;

class MediaCollectionRules
{
    public static function make(array $rules, NovaRequest $request, string $collectionName): array
    {
        if (empty($rules)) {
            return [];
        }

        $callback = function ($attribute, $uuid, $fail) use ($rules, $request, $collectionName): void {
            $media = static::getMedia($request, $uuid, $collectionName);

            $validator = Validator::make(
                [$attribute => $media],
                [$attribute => $rules],
            );

            if ($validator->fails()) {
                $fail($validator->errors()->first($attribute));
            }
        };

        return [
            new class($callback) extends ClosureValidationRule implements ImplicitRule {
                //
            },
        ];
    }

    private static function getMedia(NovaRequest $request, string $uuid, string $collectionName): array
    {
        return (
            is_null($request->route('resourceId'))
                ? TransientModel::make()->getMedia($uuid)
                : $request->findModelOrFail()->getMedia($collectionName)
        )->toArray();
    }
}
