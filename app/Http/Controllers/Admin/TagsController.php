<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::select('id', 'name')->get();
        return response()->json($tags);
    }
}
