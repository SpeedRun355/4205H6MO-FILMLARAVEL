<?php

namespace App\Http\Controllers;

use App\Models\FilmUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'review' => 'required',
            'comment'=>'required',
            'user_id'=> 'required',
            'film_id'=> 'required',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('warning','Tous les champs sont requis');    
        }
        FilmUser::create($request->all());
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filmUser = FilmUser::findOrFail($id);
        $filmUser->delete();
    
        return redirect()->back();
    }

    public function autocomplete(Request $request)
    {
        $search = $request->search;
        $reviews = FilmUser::orderby('comment','asc')
                    ->select('id','comment', 'film_id')
                    ->where('comment', 'LIKE', '%'.$search. '%')
                    ->get();
                    $response = array();
                    foreach($reviews as $review){
                        $response[] = array(
                            'value' => $review->id,
                            'label' => $review->title
                        );
                    }
                    /* $users = User::orderby('name','asc')
                    ->select('id','name')
                    ->where('name', 'LIKE', '%'.$search. '%')
                    ->get();
                    $response = array();
                    foreach($users as $user){
                        $response[] = array(
                            'value' => $user->id,
                            'label' => $user->name
                        );
                    }
                    */

        return response()->json($response);
    } 

}
