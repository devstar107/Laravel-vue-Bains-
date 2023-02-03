<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jobApplication;
class JobController extends Controller
{
    public function jobApplication(){
        $user = collect([]);
        if(\Auth::user()){
            $user = \Auth::user();
        }
        return view('jobApplication')->with(['user' => $user]);
    }

    public function saveJobApplication(Request $request){

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:job_applications',
            'phone' => 'nullable',
            'job' => 'required',
            'date_of_birth' => 'nullable',
            'previous_experience' => 'required'
            
        ]);

        $data = $request->all();
        jobApplication::create($data);
        
        return 'Job Request Addedd Successfully.';
    }
    public function approveApp($id){

        jobApplication::where('id', $id)->update(['status' => 'approved']);

        return "Status updated successfully.";

    }
    public function denyApp($id){

        jobApplication::where('id', $id)->update(['status' => 'denied']);

        return "Status updated successfully.";

    }

    public function view_ajax(Request $request){
        if($request->job != 'all'){
            return jobApplication::where('job',$request->job)->get();
        }
        return jobApplication::all();

    }

    public function view(){
        
        return view('viewJobApplications');

    }
}
