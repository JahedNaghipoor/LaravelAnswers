<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class UploadController extends Controller
{
    public function getUpload()
    {
        return view('upload');
    }

    public function postUpload(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('picture');
        if ($file) {
            $filename = uniqid($user->id . "_", true) . "." . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($filename, File::get($file), 'public');
            $url = Storage::disk('s3')->url($filename);
            $user->profile_picture = $url;
            $user->save();
            return redirect('/profile/' . $user->id);
        } else {
            return redirect('/profile/' . $user->id);
        }
    }

    public function download($id)
    {
        $question = Question::findOrFail($id);
        $path = $question->file;
        $fs = Storage::getDriver();
        $stream = $fs->readStream($path);

        return Response::stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            "Content-Type" => $fs->getMimetype($path),
            "Content-Length" => $fs->getSize($path),
            "Content-disposition" => "attachment; filename=\"" . basename($path) . "\"",
        ]);
    }
    // public function upload(Request $request)
    // {
    //     if ($request->hasFile('upload')) {
    //         //get filename with extension
    //         $filenamewithextension = $request->file('upload')->getClientOriginalName();

    //         //get filename without extension
    //         $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

    //         //get file extension
    //         $extension = $request->file('upload')->getClientOriginalExtension();

    //         //filename to store
    //         $filenametostore = $filename . '_' . time() . '.' . $extension;

    //         //Upload File
    //         $request->file('upload')->storeAs('public/uploads', $filenametostore);

    //         $CKEditorFuncNum = $request->input('CKEditorFuncNum');
    //         $url = asset('storage/uploads/' . $filenametostore);
    //         $msg = 'Image successfully uploaded';
    //         $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

    //         // Render HTML output
    //         @header('Content-type: text/html; charset=utf-8');
    //         echo $re;
    //     }
    // }
}
