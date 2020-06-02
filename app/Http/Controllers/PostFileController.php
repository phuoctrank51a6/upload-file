<?php

namespace App\Http\Controllers;

use App\UploadFile;
use Auth;
use Illuminate\Http\Request;
use Response;
use Storage;

class PostFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // if ($_FILES['file']['size'] >= 536870912) {
        //     return redirect()->round('home')->with('status', 'file quá lớn');
        // }
        $userId = Auth::user()->id;

        $file = $request->file('file');

        $uploadFile = new UploadFile();
        $uploadFile->type = $file->getMimeType();
        $uploadFile->name = $file->getClientOriginalName();
        $uploadFile->size = number_format($file->getSize() / 1048576, 2);
        $uploadFile->user_id = $userId;

        // Lưu file vào file public có thể hiện thị ảnh
        // $uploadFile->file = $file->storeAs($userId,   $uploadFile->name, 'public');
        // Private thư mục upload
        $uploadFile->file = $file->storeAs($userId, $uploadFile->name);

        // $uploadFile->save();
        return redirect()->route('home')->with('status', 'Upload file thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(request()->path());
        $data = UploadFile::where('size', $id)->first();
        dd($data);
        $linkFile = $data->file;

        // $file=Storage::disk('public')->get($linkFile);

        return Storage::download($linkFile);
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        // dd(Auth::user()->id . '/' . $id);
        Storage::delete(Auth::user()->id . '/' . $id);
        return redirect()->back()->with('status', 'Xóa thành công');
    }
}
