<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;
class AirportController extends Controller {
    public function store(Request $request){
        $request->validate(['code'=>'required|string|max:5|unique:airports','name'=>'required|string','city'=>'required|string','country'=>'nullable|string']);
        Airport::create($request->all());
        return back()->with('success','Airport added.');
    }
}
