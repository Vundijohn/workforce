<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return match (true) {
            $user->hasRole(Role::Reviewer->value) => redirect()->route('reviewer.queue'),
            $user->hasRole(Role::Worker->value) => redirect()->route('worker.tasks'),
            default => view('dashboard'),
        };
    }
}
