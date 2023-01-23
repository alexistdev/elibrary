<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait AdminTrait
{
    protected $users;
    private $title = "E-library";

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users=Auth::user();
            return $next($request);
        });
    }
}
