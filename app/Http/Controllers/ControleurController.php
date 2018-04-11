<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControleurController extends Controller
{
  public function home(){
    return view('controleur.dashboard');
  }
}
