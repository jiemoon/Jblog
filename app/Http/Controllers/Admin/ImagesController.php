<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;

class ImagesController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('img');
        if($file->isValid()) {
            $image = new Image();
            $image->name = $file->getClientOriginalName();
            $image->size = round($file->getSize() / 1024);
            $image->extension = $file->getClientOriginalExtension();
            if (!in_array($image->extension, array('jpg', 'jpeg', 'gif', 'png')))  {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Invalid image extension we just allow JPG, GIF, PNG, JPEG'
                ]);
            };

            $image->mime_type = $file->getMimeType();
            $image->path = $file->store('/upload/images', 'qiniu');
            $image->width = '';
            $image->height = '';

            $image->save();
            return response()->json([
                'status' => 'success',
                'uri' => env('QINIU_DOMAIN') . '/' . $image->path
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => '文件非法'
        ]);
    }
}
