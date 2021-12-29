<?php

namespace App\Http\Controllers;

use App\ApiUtils\SiakadUtils;
use App\Http\Resources\KelasResourceCollection;
use App\KelasMahasiswa;
use App\Semester;
use Illuminate\Http\Request;
use Config;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getSemesterAktif()
    {
        $semester = Semester::orderBy('semester')->get()->last();

        return response()->json(['semester_aktif' => $semester->semester]);
    }




}
