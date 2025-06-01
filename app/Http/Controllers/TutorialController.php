<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::latest()->get()->map(function ($tutorial) {
            $videoId = null;
            if (preg_match('/v=([^&]+)/', $tutorial->youtube_url, $matches)) {
                $videoId = $matches[1];
            }

            $tutorial->videoId = $videoId;

            return $tutorial;
        });

        return view('tutorial', compact('tutorials'));
    }
}
