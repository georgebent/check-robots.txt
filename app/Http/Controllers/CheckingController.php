<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRequest;
use App\Services\CheckingManager;
use Illuminate\Http\Request;

/**
 * Class CheckingController
 * @package App\Http\Controllers
 */
class CheckingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.main');
    }

    /**
     * @param CheckRequest $request
     * @param CheckingManager $checkingManager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function check(CheckRequest $request, CheckingManager $checkingManager)
    {
        $messages = $checkingManager->checkSite($request->site);

        return view('pages.result', compact('messages'));
    }
}
