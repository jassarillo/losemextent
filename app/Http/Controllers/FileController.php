<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('files/upload');
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
        
        //echo $path = public_path()."/uploads/";

        //$files = $request->file('file');
        $file = $request->file;

        if ($request->hasFile('file')) {
            //echo $extension = $request->file->extension();
            //$fileName = $request->file->getClientOriginalName();
            //$estado = $request->file->storeAs('uploads', 'filenamesss.jpg');

            $estado = $request->file->store('avatares');
           
            
            if($estado){
                return response()->json(['estatus' => 'true',  'message' => 'Se guardo la imagen']);
            }

            //print_r($request->file);
            //var_dump($request->file('file')->isValid());
        }

        return response()->json(['estatus' => 'false',  'message' => 'No se pudo subir']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
    }
}
