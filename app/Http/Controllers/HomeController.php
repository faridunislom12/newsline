<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function home()
    {
        return Inertia::render('Home/Index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublished()
    {
        return response()->json([
            'articles' => Article::where('publish_at', '<=', date('Y-m-d'))->orderBy('publish_at', 'DESC')->get()
        ]);
    }

}
