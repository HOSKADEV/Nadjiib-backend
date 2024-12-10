<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentation;

class DocumentationController extends Controller
{
  public function privacy_policy()
  {
    $privacy_policy = Documentation::privacy_policy()->content(session('locale'));

    return view('content.pages.documentation')->with('data', $privacy_policy);
  }

  public function about()
  {
    $about = Documentation::about()->content(session('locale'));

    return view('content.pages.documentation')->with('data', $about);
  }
}
