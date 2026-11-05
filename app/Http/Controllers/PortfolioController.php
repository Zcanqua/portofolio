<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Certificate;
use App\Repositories\ProjectRepository;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __invoke(ProjectRepository $projects): View
    {
        $profileImage = User::query()
            ->where('is_admin', true)
            ->orderBy('id')
            ->value('profile_image');

        return view('portfolio', [
            'projects' => $projects->all(),
            'certificates' => Certificate::query()->orderByDesc('year')->orderBy('title')->get(),
            'profileImage' => $profileImage ?: 'images/profile.jpg',
        ]);
    }
}
