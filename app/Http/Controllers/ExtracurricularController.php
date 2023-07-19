<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //lay ds tat ca san pham
        $extracurricular = Extracurricular::paginate(3);
        return view('extracurriculars.index', ['extracurriculars' => $extracurricular]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //luu tru san pham
        //đọc thêm về validate
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,png|max:2048',
            'start_at' => 'required'
        ]);
        //upload
        $file = $request->file('photo');
        $destinationPath = 'img';
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
        $extracurricular = new Extracurricular($request->all());
        $extracurricular->photo = $fileName;
        $extracurricular->save();
        return redirect()->route('extracurriculars.index')->with('success', 'Added successFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_at' => 'required'
        ]);
        // Product::create($request->all())->categories()->attach($request->input('categories'));
        $extra = new Extracurricular($request->all());
        $extra = Extracurricular::find($id);
        $extra->name = $request->input('name');
        $extra->description = $request->input('description');
        $extra->start_at = $request->input('start_at');
        if ($request->hasFile('photo')) {
            if (file_exists(public_path('img/' . $extra->photo))) {
                unlink(public_path('img/' . $extra->photo));
            }
            $file = $request->file('photo');
            $destinationPath = 'img';
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $extra->photo = $fileName;
        }
        $extra->save();
        return redirect()->route('extracurriculars.index')->with('success', 'Edited successFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $extracurricular = Extracurricular::find($id);
        if (file_exists(public_path('img/' . $extracurricular->photo))) {
            unlink(public_path('img/' . $extracurricular->photo));
        }
        $extracurricular->delete();
        return redirect()->route('extracurriculars.index')->with('success', 'Delete successFully');
    }
    public function deleteAll(Request $request)
    {
        $id = $request->ids;
        dd($id);
    }
    public function search(Request $request)
    {
        $query = Extracurricular::query();
        if ($request->ajax()) {
            $extras = $query
                ->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%')
                ->orWhere('start_at', 'like', '%' . $request->keyword . '%')
                ->get();
            return response()->json(['extracurriculars' => $extras]);
        }else{
            $extras = $query->get();
            return view('extracurriculars.index', ['extracurriculars' => $extras]);
        }
    }
    public function getNewest()
    {
        $extras = Extracurricular::orderBy('start_at', 'ASC')->get();
        return response()->json($extras);
    }
}
