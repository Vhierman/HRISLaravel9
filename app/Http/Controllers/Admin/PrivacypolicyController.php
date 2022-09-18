<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacypolicyController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('pages.admin.privacypolicy.index');
    }
}
