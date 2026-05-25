<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use App\Models\Institution;
use App\Models\MosqueMessage;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'eventCount' => Event::count(),
            'articleCount' => Article::count(),
            'institutionCount' => Institution::count(),
            'newMessages' => MosqueMessage::where('status', 'baru')->count(),
        ]);
    }
}
