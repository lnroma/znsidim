<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07.05.17
 * Time: 12:07
 */
namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    /**
     * index action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * search result action
     * @param $query
     * @return $this
     */
    public function result($query)
    {
        return view('search.result')
            ->with('query', $query);
    }

}