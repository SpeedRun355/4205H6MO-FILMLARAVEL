<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FilmUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $review = FilmUser::latest()->paginate(10);
        return response()->json( 
            
             $review,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $review = $request->all();
        
        $request->validate([
            'review'     => 'required',
            'comment'   => 'required',
            'photo'     => 'required|image',
            'film_id'  => 'required',
        ]);

        

        if ($review = $request ->file('photo')){
            $image = $request->photo;
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->move('images/upload', $fileName, 'public');
        // $review=$request-> $fileName ;
        // $review = $fileName ;
        }


        $review =  FilmUser::create([
            'review' => $request->input('review'),
            'comment' => $request->input('comment'),
            'photo' => $fileName,
            'film_id' => $request->input('film_id'),
            'user_id' => $request->user()->id,
        ]);

        // On retourne les informations du nouvel review en JSON
        return response()->json([$review,"message" => "Review ajouté"], 201);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return FilmUser::find($id);
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
        $review = FilmUser::findOrFail($id);
        if (!$review) {
            return response() ->json(['message' => 'Id not found'], 404);
        }
        $validator = Validator::make($request->all(),[
            'review'=>'required',
            'comment'=> 'required',
            'photo'=> 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        if ($validator->fails()) {
            return response() ->json(['success' => false, 'message' => $validator->errors()], 400);
        }
 
        if ($request->hasfile('photo')) {
            $image = $request->photo;
            $fileName = time() . '.' . $image->getClientOriginalName();
            $path = $request->photo->storeAs('images/upload', $fileName, 'public');
            $review['photo'] = $path;
    
        }
        $review->update($request->except('photo'));

        return response()->json([$review,"message" => "Review modifé avec succée" ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = FilmUser::findOrFail($id);
        if ($review->photo) {
            Storage::disk('public')->delete($review->photo);
        }
        $review->delete();
        return response()->json(null, 204);
    }

}
