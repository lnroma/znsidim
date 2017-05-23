<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 23.05.17
 * Time: 21:25
 */
namespace App\Http\Controllers\Seo;
use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Seo\Seo;
use Exception;

class IndexController extends Controller
{

    public function save(Request $request)
    {
        try {
            $seo = Seo::where('url', $request->get('url'))->first();
            if(!$seo) {
                $seo = new Seo();
            }
            $seo->url = $request->get('url');
            $seo->title = $request->get('title');
            $seo->description = $request->get('description');
            $seo->keywords = $request->get('keywords');
            $seo->save();

            Messages::addSuccess('Всё круто сохранил!');
        } catch (Exception $error) {
            Messages::addError('Ошибка! ' . $error->getMessage());
        }

        return redirect(url()->previous());
    }

}