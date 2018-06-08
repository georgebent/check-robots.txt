<?php

namespace App\Http\Controllers;

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
     * @param Request $request
     * @param CheckingManager $checkingManager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function check(Request $request, CheckingManager $checkingManager)
    {
        $url = $checkingManager->prepareUrl($request->site);
        $data = $checkingManager->checkSite($url);

        return view('pages.result', compact('data'));
    }
}
