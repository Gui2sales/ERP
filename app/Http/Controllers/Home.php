<?php

namespace App\Http\Controllers;

use App\Services\DataLakeDBService;
use App\Services\NewOpusSocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    public function index(NewOpusSocketService $opus)
    {
        return view('Home.main');
    }
}
