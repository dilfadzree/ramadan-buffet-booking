<?php

namespace App\Http\Controllers;

use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function __construct(private
        AvailabilityService $availabilityService
        )
    {
    }

    /**
     * Display the landing page
     */
    public function index()
    {
        return view('landing');
    }
}
