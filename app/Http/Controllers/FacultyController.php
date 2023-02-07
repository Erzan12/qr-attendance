<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $faculties = Faculty::latest();
        if ($request->has('keyword')) {
            $faculties = $faculties->where('employee_id', 'LIKE', '%'.$request->keyword.'%')
            ->orwhere('name', 'LIKE', '%'.$request->keyword.'%')
            ->orwhere('department', 'LIKE', '%'.$request->keyword.'%')
            ->orwhere('position', 'LIKE', '%'.$request->keyword.'%')
            ->orwhere('email', 'LIKE', '%'.$request->keyword.'%');
        }
        $faculties = $faculties->paginate(10);

        return view('users.faculties.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.faculties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|numeric',
            'name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'contact_number' => 'required|numeric|max:10|min:10',
            'email' => 'required|email',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $faculty = new Faculty;
        $faculty->employee_id = $request->employee_id;
        $faculty->name = $request->name;
        $faculty->department = $request->department;
        $faculty->position = $request->position;
        $faculty->contact_number = $request->contact_number;
        $faculty->email = $request->email;
        $faculty->save();

        
        $user = User::create([
            'username'=> $faculty->employee_id,
            'password' => bcrypt('1234'),
            'user_id' => $faculty->id,
            'account_type'=> 3
            ]);
            

           
            return redirect(route('faculties.index'))->with('success', 'Faculty added.');
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        return view('users.faculties.edit', compact('faculty'));
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
        $validator = Validator::make($request->all(),[
            
            'name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'contact_number' => 'required|numeric',
            'email' => 'required|email',
           

        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
            
            $faculty = Faculty::find($id);
            if(!$faculty) {
                abort(404);
            }

            $faculty->update ([
                'name' => $request->name,
                'department' => $request->department,
                'position' => $request->position,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
            ]);

                return redirect(route('faculties.index'))->with('success', 'Faculty information successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        { 
            $faculty = Faculty::find($id);
            if(!$faculty) {
                abort(404);
            }
            User::where('user_id', $id)->first()->delete();            
            $faculty->delete();
    
            return redirect(route('faculties.index'))->with('success', 'Faculty has been successfully deleted');
        } 
    }
}
