<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $semesters = Semester::where('name', 'like', '%' . $request->search . '%')->paginate(4);
            return view('semester.index', compact('semesters'));
        }
        $semesters = Semester::paginate(4);
        return view('semester.index', compact('semesters'));
    }

    public function destroy($id)
    {
        $semester = Semester::find($id);
        if (!$semester) {
            return redirect('/semester')->with(['error' => 'Semester not found!']);
        }
        $semester->delete();
        return redirect('/semester')->with(['success' => 'Semester deleted successfully!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);


        $code = 'SM' . str_pad(Semester::max('id') + 1, 3, '0', STR_PAD_LEFT);

        if (Semester::where('code', $code)->exists()) {
            $code = 'SM' . str_pad(Semester::max('id') + 2, 3, '0', STR_PAD_LEFT);
        }

        $semester = Semester::create([
            'name' => $request->name,
            'code' => $code
        ]);

        if (!$semester) {
            return redirect('/semester')->with(['error' => 'Semester not created!']);
        }

        return redirect('/semester')->with(['success' => 'Semester created successfully!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $semester = Semester::find($id);

        if (!$semester) {
            return redirect('/semester')->with(['error' => 'Semester not found!']);
        }

        $semester->update([
            'name' => $request->name,
        ]);

        return redirect('/semester')->with(['success' => 'Semester updated successfully!']);
    }
}
