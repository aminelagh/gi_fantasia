<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OuvrierController extends Controller
{
  public function home(){
    return view('ouvrier.dashboard');
  }
}
