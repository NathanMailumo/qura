<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $hospital = Hospital::with('departments')->find(1);

        // 2. Extract the departments collection
        $departments = $hospital ? $hospital->departments : collect();

        // 3. Pass both variables to your 'index' view
        return view('index', compact('hospital', 'departments'));
    }
}
