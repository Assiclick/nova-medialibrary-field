<?php

declare(strict_types = 1);

namespace DmitryBubyakin\NovaMedialibraryField\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\FileManipulator;

class RegenerateController
{
    public function __invoke(Request $request, FileManipulator $fileManipulator): JsonResponse
    {
        $media = Media::findOrFail($request->route('media'));

        $fileManipulator->createDerivedFiles($media);

        return response()->json();
    }
}
