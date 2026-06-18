<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CrewMember;
use Illuminate\Http\Request;
class CrewController extends Controller {
    public function index(){
        $crew = CrewMember::latest()->get();
        return view('admin.crew.index', compact('crew'));
    }
    public function store(Request $request){
        $request->validate(['name'=>'required|string','role'=>'required|string','phone'=>'nullable|string','email'=>'nullable|email','salary'=>'nullable|numeric']);
        CrewMember::create([...$request->all(),'status'=>'active']);
        return redirect()->route('admin.crew.index')->with('success','Crew member added.');
    }
    public function update(Request $request, CrewMember $crew){
        $request->validate(['name'=>'required','role'=>'required','status'=>'required|in:active,inactive']);
        $crew->update($request->all());
        return back()->with('success','Crew member updated.');
    }
    public function destroy(CrewMember $crew){
        $crew->update(['status'=>'inactive']);
        return back()->with('success','Crew member set inactive.');
    }
}
