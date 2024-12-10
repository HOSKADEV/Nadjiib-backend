<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentation;

class DocumentationController extends Controller
{
  public function privacy_policy()
  {
    $privacy_policy = Documentation::privacy_policy();

    $data = $privacy_policy->content(session('locale'));

    $title = __($privacy_policy->name);

    return view('content.pages.documentation',compact('data','title'));
  }

  public function about()
  {
    $about = Documentation::about();

    $data = $about->content(session('locale'));

    $title = __($about->name);

    return view('content.pages.documentation',compact('data','title'));
  }
}
