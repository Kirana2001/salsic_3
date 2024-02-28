<?php

namespace App\Http\ViewComposers;

use App\Models\Atlet;
use Illuminate\Contracts\View\View;

class NotifComposer
{

    public function compose(View $view)
    {
        $pendingApproval = 0;
        $atletApproval = Atlet::where('status_id', '!=', 3)->orderBy('id', 'desc')->get()->count();

        $pendingApproval += $atletApproval;

        $view->with(compact('pendingApproval', 'atletApproval'));
    }
}