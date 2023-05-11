<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);

        $file = $request->file;
        $fileMd5 = md5_file('/tmp/'.$file->getFileName());

        $resource = Resource::whereMd5($fileMd5)->first();
        if ($resource) {
            return $resource;
        }

        $path = Storage::put('/file/', $file);

        $resource = new Resource();
        $resource->resourceable_type = 'upload';
        $resource->resourceable_id = 0;
        $resource->name = $file->getClientOriginalName();
        $resource->path = $path;
        $resource->md5 = $fileMd5;
        $resource->size = $file->getSize();
        $resource->extension = $file->getClientOriginalExtension();
        $resource->save();
        return $resource;
    }

    public function download(Request $request)
    {
        $this->validate($request, [
            'resource_id' => 'required|int|exists:resources,id',
        ]);
        $resource = Resource::find($request->resource_id);
        return Storage::download($resource->path);
    }
}
