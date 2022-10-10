<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use Illuminate\Http\Request;

use DB;

class AlbumsController extends Controller
{

    public function index()
    {
        $albums = Album::with('_album')->orderBy('id','DESC') -> paginate(PAGINATION_COUNT);
        return view('dashboard.albums.index', compact('albums'));
    }

    public function create()
    {
         $albums = Album::select('id','album_id')->get();
        return view('dashboard.albums.create',compact('albums'));
    }

    public function store(AlbumRequest $request)
    {

        try {

          

            $albums = Album::create($request->except('_token'));

            $albums->name = $request->name;
            $albums->save();
            DB::commit();

            return redirect()->route('admin.albums')->with(['success' => 'تم ألاضافة بنجاح']);
           // DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.albums')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function edit($id)
    {
           
           $albums = Album::orderBy('id', 'DESC')->find($id);

        if (!$albums)
            return redirect('admin.albums')->with(['error' => 'هذا القسم غير موجود']);

        return view('dashboard.albums.edit',compact('albums')) ;
        }


        public function update($id, AlbumRequest $request)
        {
            try {
                //validation
    
                //update DB
    
    
                $albums = Album::find($id);
    
                if (!$albums)
                    return redirect()->route('admin.albums')->with(['error' => 'هذا القسم غير موجود']);
    
             
                $albums->update($request->all());
    
                $albums->name = $request->name;
                $albums->save();
    
                return redirect()->route('admin.albums')->with(['success' => 'تم ألتحديث بنجاح']);
            } catch (\Exception $ex) {
    
                return redirect()->route('admin.albums')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
    
        }

     // delete method //
        public function destroy($id)
        {
    
            try {
                $albums = Album::orderBy('id', 'DESC')->find($id);
    
                if (!$albums)
                    return redirect()->route('admin.albums')->with(['error' => 'هذا القسم غير موجود ']);
    
                $albums->delete();
    
                return redirect()->route('admin.albums')->with(['success' => 'تم  الحذف بنجاح']);
    
            } catch (\Exception $ex) {
                return redirect()->route('admin.albums')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
        }
    
    
}