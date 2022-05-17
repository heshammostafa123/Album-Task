<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums=Album::all();
        return view('albums.index',compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        return $request;
        DB::beginTransaction();
        try {
            $album = new Album();
            $album->name =$request->album_name;
            $album->user_id = Auth()->user()->id;
            $album->save();
            // insert img
            if($request->hasfile('pic'))
            {
                foreach($request->file('pic') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/'.$album->id, $file->getClientOriginalName(),'upload_attachments');

                    // insert in image_table
                    $pictures= new Picture();
                    $pictures->image=$name;
                    $pictures->album_id= $album->id;
                    $pictures->save();
                }
            }
            DB::commit(); 
            toastr()->success("Album Created Successfully");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album=Album::findOrFail($id);
        $pictures=Picture::where('album_id',$album->id)->get();
        return view('albums.show',compact('album','pictures'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album=Album::findOrFail($id);
        return view('albums.Edit',compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $album=Album::findOrFail($id);
            $album->update([
                'name'=>$request->album_name,
            ]);
            
            if($request->hasfile('pic'))
            {
                Picture::where('album_id',$album->id)->delete();
                Storage::disk('upload_attachments')->deleteDirectory('attachments/'.$album->id);
                foreach($request->file('pic') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/'.$album->id, $file->getClientOriginalName(),'upload_attachments');

                    $pictures= new Picture();
                    $pictures->image=$name;
                    $pictures->album_id= $album->id;
                    $pictures->save();
                }
            }
            DB::commit();
            toastr()->success("Album Updated Successfully");
            return redirect()->route('album.index');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->has('album_name') && !empty($request->input('album_name'))) {
            $search=Album::where('name', 'like', '%' . $request->album_name . '%')->get();
            if($search->isNotEmpty()){
                DB::beginTransaction();
                Picture::where('album_id',$request->id)
                ->update([
                    'album_id'=>$search[0]->id
                ]);
                $oldalbumpictures = Storage::disk('upload_attachments')->allFiles("attachments/".$request->id);
                foreach ($oldalbumpictures as $file) {
                    $string = explode('/', $file);
                    $imagename = array_pop($string);
                    Storage::disk('upload_attachments')->move($file,"attachments/".$search[0]->id.'/'.$imagename);
                }
                Storage::disk('upload_attachments')->deleteDirectory('attachments/'.$request->id);
                DB::commit();
                toastr()->success("Album Pictures Moved Successfully");
                return redirect()->route('album.index');
            }else{
                toastr()->error("Album Name Not Found");
                return redirect()->back();
            }
        }else{
            //delete all pictures inside album
            Storage::disk('upload_attachments')->deleteDirectory('attachments/'.$request->id);
            Picture::where('album_id',$request->id)->delete();
            toastr()->success("Album Pictures Deleted Successfully");
            return redirect()->back();
        }
    }
}
