<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Services\UploadMedia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home.index', ['content' => PHP_EOL . \Illuminate\Foundation\Inspiring::quote() . PHP_EOL]);
    }

    public function demo()
    {
        return view('demo', ['content' => PHP_EOL . \Illuminate\Foundation\Inspiring::quote() . PHP_EOL]);
    }

    public function upload(Request $request, $type)
    {
        $response = app(UploadMedia::class)->upload($request, $type);
        if (!empty($response)) {
            return $response;
        }
        return ['files' => 'upload failed'];
    }

    public function deleteTempFile(Request $request, $type)
    {
        $response = app(UploadMedia::class)->deleteTempFile($request, $type);
        if (!empty($response)) {
            return $response;
        }
        return [];
    }

    public function deleteFile(Request $request, $type)
    {
        $response = app(UploadMedia::class)->deleteFile($request, $type);
        if (!empty($response)) {
            return $response;
        }
        return [];
    }
}