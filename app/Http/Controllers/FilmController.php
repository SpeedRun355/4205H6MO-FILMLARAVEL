<?php

namespace App\Http\Controllers;

use App\Models\Films;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Films::all();
        return view('films.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('films.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name'=>'required',
                'global_rating'=> 'required',
                'film_genre'=> 'required',
                'actors'=> 'required',
                'director'=> 'required',
                'photo'=> 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if($validator->fails())
            {
                return redirect()->back()->with('warning','Tous les champs sont requis');   
            }
            else{
                
                if ($request->file('photo')->isValid()) {
                    $image = $request->file('photo');
                    $fileName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/upload'), $fileName);
                }
                Films::create([
                    'name' => $request->input('name'),
                    'global_rating' => $request->input('global_rating'),
                    'film_genre' => $request->input('film_genre'),
                    'actors' => $request->input('actors'),
                    'director' => $request->input('director'),
                    'photo' => $fileName,
                ]);   
                return redirect('/')->with('success', 'film Ajouté avec succès');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Films::findOrFail($id);
        return view('films.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $film = Films::findOrFail($id);

        return view('films.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Films $film)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'global_rating'=> 'required',
            'film_genre'=> 'required',
            'actors'=> 'required',
            'director'=> 'required',
            'photo'=> 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
            //return redirect()->back()->with('warning','Tous les champs sont requis');   
        }
        else{
            $data = $request->only(['name', 'global_rating', 'film_genre', 'actors', 'director']);

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $image = $request->file('photo');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/upload'), $fileName);
                $data['photo'] = $fileName;
            }

            $film->update($data);
            return redirect('/')->with('success', 'film Modifié avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Films::findOrFail($id);
        $film->delete();
        return redirect('/')->with('success', 'film Supprimé avec succès');
    }
}
