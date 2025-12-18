<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function show()
    {
        return view('curriculum.show-curriculum');
    }
}
?>