<?php

namespace App\Http\Controllers;

use App\UploadFile;
use Arr;
use Auth;
use Illuminate\Http\Request;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::user()->id;
        $files = UploadFile::where('user_id', $id)->get();

        $list_directories = Storage::directories($id);
        $list_files = Storage::files($id);

        $list_object = array_merge($list_directories, $list_files);

        $list = array_map(function($item){
            return [
                'name' => basename($item),
                'path' => $item,
                'size' => Storage::size($item)/1048576,
            ];
            dd($item);
        }, $list_object);

        return view('home', ['list' => $list]);

    }
    public function download(){
        // dd(request('path'));
        return Storage::download(request('path'));
    }

    public function getName(){
        // dd(request()->fileName);
        $userId = Auth::user()->id;

        $fileName = request()->fileName;

        if (Storage::exists($userId . '/' . $fileName) == true) {
            return response()->json(['success'=>true]);

        }else{
            return response()->json(['success'=>false]);
        }
    }
}
