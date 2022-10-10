<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumImagesValidaton;
use App\Models\AlbumImage;
use App\Models\Image;
use Illuminate\Http\Request;
use DB;

class AlbumImagesController extends Controller
{

    public function index()
    {
        $albumImage = AlbumImage::select('id','slug','price','created_at')->paginate(PAGINATION_COUNT);
         return view('dashboard.albumImages.general.index', compact('albumImage'));
    }

    public function create()
    {
           $data =   [];
         
           $data ['albums'] = Albums::active() ->select('id')->get();
         
        return view('dashboard.albumImage.general.create',$data);
    }

    public function store(Request $request)
    {
        try {

            $albumImage->name = $request->name;
            $albumImage->save();


             $albumImage->albums()->attach($request->albums);
             DB::commit();

            return redirect()->route('admin.albumImage')->with(['success' => 'تم ألاضافة بنجاح']);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.albumImages')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


     ///// images ///////////
     public function addImages($album_id)
     {
        return view('dashboard.albumImage.images.create') -> with('id',$album_id);

     }
 
 // to save images
 
    public function saveAlbumImages(Request $request ){
         $file = $request->file('dzfile');
         $filename = uploadImage('dsdsc', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }


    // to save images into db

    public function saveAlbumImagesDB(AlbumsImagesValidaton $request){
        return $request;
        try {
            // save dropzone images
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'album_id' => $request->album_id,
                        'photo' => $image,
                    ]);
                }
            }

            return redirect()->route('admin.albumImages')->with(['success' => 'تم التحديث بنجاح']);

        }catch(\Exception $ex){

        }
    }
 
 
     ///// end images ///////////
 
    public function edit($id)
    {
           $album = Album::orderBy('id', 'DESC')->find($id);

        if (!$album)
            return redirect('admin.albumImages')->with(['error' => 'هذا القسم غير موجود']);

        return view('dashboard.albums.edit',compact('album')) ;
        }


        public function update($id, AlbumRequest $request)
        {
            try {
                //validation
    
                //update DB
    
    
                $album = Album::find($id);
    
                if (!$album)
                    return redirect()->route('admin.albumImages')->with(['error' => 'هذا القسم غير موجود']);
    
                
                $album->update($request->all());
    
               
                $album->name = $request->name;
                $album->save();
    
                return redirect()->route('admin.albumImages')->with(['success' => 'تم ألتحديث بنجاح']);
            } catch (\Exception $ex) {
    
                return redirect()->route('admin.albumImages')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
    
        }

     // delete method //
        public function destroy($id)
        {
    
            try {
                $album = Album::orderBy('id', 'DESC')->find($id);
    
                if (!$album)
                    return redirect()->route('admin.albumImages')->with(['error' => 'هذا القسم غير موجود ']);
    
                $album->delete();
    
                return redirect()->route('admin.albumImages')->with(['success' => 'تم  الحذف بنجاح']);
    
            } catch (\Exception $ex) {
                return redirect()->route('admin.albumImages')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
        }
    
    
}