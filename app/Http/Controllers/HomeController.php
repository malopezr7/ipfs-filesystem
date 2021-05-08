<?php

namespace App\Http\Controllers;


use App\DocumentElement;
use App\IPFSConnector;
use App\StorageFolder;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mlopez\IPFS\IPFS;
use Mlopez\IPFS\IPFSFacade;

class HomeController extends Controller
{
    /**
     * Rutas de HomeController
     */
    static function routes()
    {
        Route::get('/', 'HomeController@index')->where('any', '.*')->name('dashboard-ecommerce');
    }

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    /**
     * Retornamos la vista de incio
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $pageConfigs = ['showMenu' => false,
            'contentLayout' => "content-right-sidebar",
            'pageClass' => 'file-manager-application'];

        return view('content.fileManager.app-file-manager', ['pageConfigs' => $pageConfigs]);
    }
}
