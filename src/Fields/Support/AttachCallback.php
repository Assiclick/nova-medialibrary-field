<?php

declare(strict_types = 1);

namespace DmitryBubyakin\NovaMedialibraryField\Fields\Support;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use DmitryBubyakin\NovaMedialibraryField\TransientModel;

class AttachCallback
{
    public function __invoke(
        HasMedia $model,
        UploadedFile $file,
        string $collectionName,
        string $diskName,
        string $fieldUuid
    ): Media {
        // you can override this behaviour: Medialibrary::attachUsing()
        if ($model instanceof TransientModel) {
            $collectionName = $fieldUuid;
        }

        return $model
            ->addMedia($file)
            ->toMediaCollection($collectionName, $diskName);
    }
}
