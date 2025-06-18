<?php

namespace App\Http\Controllers;

use App\DataObjects\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function index()
    {
        $resume = Cache::remember('resume_data', now()->addDay(), function () {
            $resume = Storage::disk('resumes')->get('resume.json');
            $resumeDate = json_decode($resume, true);
            return Resume::fromArray($resumeDate);
        });


        return view('resume', ['resume' => $resume,'allowDownload' => true]);
    }

    public function download(Request $request)
    {
        $resume = Cache::remember('resume_data', now()->addDay(), function () {
            $resume = Storage::disk('resumes')->get('resume.json');
            $resumeDate = json_decode($resume, true);
            return Resume::fromArray($resumeDate);
        });

        $pdf = Pdf::loadView('resume', ['resume' => $resume, 'allowDownload' => false]);

        return $pdf->download($resume->basics->name.' Resume.pdf');
    }
}
