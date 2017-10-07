<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 23.05.17
 * Time: 21:25
 */
namespace App\Http\Controllers\Videos;
use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Seo\Seo;
use Exception;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        var_dump($request);die;
    }
}