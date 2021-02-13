<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::orderBy('created_at','DESC')->paginate(30);
        return view ('file.index',['files' => $files]);
    }

    public function create()
    {
        //return view('file.upload');
        //or
        return view('file.dropzone');//for dropzone
    }


    public function store(Request $request)
    {
        /*//for single image upload
        $this->validate($request, [
            'file' => 'required|file|mimes:png,jpg,gif,pdf,xps,webp|max:20000'
        ]);
        $upload = $request->file('file');
        $path = $upload->store('public/storage');
        $file = File::create([
            'title' => $upload->getClientOriginalName(),
            'description' => '',
            'path' => $path
        ]);*/

        //multiple upload
        $files = $request->file('file');
        foreach($files as $file){
         File::create([
            'title' => $file->getClientOriginalName(),
            'description' => '',
            'path' => $file->store('public/storage')
         ]);
        }
        return redirect('/file')->with('success','File successfully uploaded');
    }

    //download image
    public function show($id)
    {
        $dl = File::find($id);
        return Storage::download($dl->path, $dl->title);
    }


    //added dropzone,edit,destroy refer video
    public function dropzone(Request $request){
        $file = $request->file('file');
        File::create([
            'title' => $file->getClientOriginalName(),
            'description' => 'Upload with dropzone.js',
            'path' => $file->store('public/storage')
        ]);
    }


    //email attachment
    public function emailattachment($id)
    {
        $fl = File::find($id);
        $data = array('title' => $fl->title, 'path' => $fl->path);
        Mail::send('emails.attachment', $data, function($message) use($fl){
            $message->to('abhi144k@gmail.com', 'abhishek')->subject('Laravel file attachment and embed');
            $message->attach(storage_path('app/'.$fl->path));
            $message->from('abhi144k@gmail.com', 'abhishek');
        });
        return redirect('/file')->with('success','File attachment has been sent to your email');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $del = File::find($id);
        Storage::delete($del->path);
        $del->delete();
        return redirect('/file');
    }
}
