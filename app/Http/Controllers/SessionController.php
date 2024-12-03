<?php

namespace App\Http\Controllers;

use App\Enums\Behavior;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Imports\StudentsImport;
use App\Models\Performance;
use App\Models\SchoolSession;
use App\Models\Week;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PDF;

class SessionController extends Controller
{
 
    public function index(Request $request)
    {

        if ($request->ajax()) {


            $query = SchoolSession::query();

            // $search = $request->get('search')[0];
            // if($search != ""){
            //    $query = $query->where(function ($s) use($search) {
            //        $s->where('title','like','%'.$search.'%');
            //    });
            // }
            
            $count = $query->count();       
            $data = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('id','desc')
            ->select('*')
            ->get();


            $response = [];
            foreach ($data as $key => $value) {
                

                $action = '<a href="' . URL::to('/sessions/'.$value->id.'/edit').'" class="edit btn btn-primary btn-sm">';
                $action .= '<i class="fas fa-edit"></i>';
                $action .= '</a>';

                $action .= ' <a data-id="'.URL::to('/sessions/'.$value->id).'" class="delete_btn btn btn-danger btn-sm">';
                $action .= '<i class="fas fa-trash-alt"></i>';
                $action .= '</a>';

                array_push($response,[
                    $value->id,
                    $value->title,
                    $action,
                ]);        
            }

            // dd($response);

            return response()->json([
                "draw" => $request->draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                'data'=> $response,
            ]);
        }

        $data = [];
        return view('pages.sessions.index',$data);

    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
        ];

        return view('pages.sessions.create',$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title" => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $p = SchoolSession::create([
            'title' => $request->title,
        ]);

        return redirect('sessions');
        
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $data = [
            'model' => SchoolSession::findOrFail($id),
        ];

        return view('pages.sessions.edit',$data);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            "title" => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = SchoolSession::where('id',$id)->update([
            'title' => $request->title,
        ]);

        return back()->with('success','Record Updated');

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // try {


            $student = SchoolSession::findOrFail($id);
            $week  = Week::where('schoolsession_id',$id)->get();

            if(count($week) > 0){
                return response()->json([
                    'message' => 'Cannot Delete This Session Used Some Where', 
                ], 500);
            }

            if($student->delete()){
                return response()->json(['message' => 'Student deleted successfully'], 200);

            }


        // } catch (\Exception $e) {
            // return response()->json(['message' => 'Failed to delete Student', 'error' => $e->getMessage()], 500);
        // }
    }

}