<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 18.07.17
 * Time: 20:57
 */
namespace App\Http\Controllers\Anketa;

use App\Helpers\User as UserHelper;
use App\Models\Users\Anketa;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function editAnketa($userName)
    {
        /** @var User $user */
        $user = UserHelper::getUserByName($userName);
        /** @var Anketa $ankets */
        $ankets = $user->ankets;

        if (!$ankets) {
            $ankets = new Anketa();
        }

        return view('anketa/edit')
            ->with('ankets', $ankets)
            ->with('user', $user);
    }

    public function saveAnketa($userName, Request $request)
    {
        $user = UserHelper::getUserByName($userName);
        $ankets = $user->ankets;
        if (!$ankets) {
            $ankets = new Anketa();
        }
        $ankets->user_id = $user->id;
        foreach ($request->all() as $_key => $_value) {
            if ($_key == '_token') {
                continue;
            }
            $ankets->{$_key} = $_value;
        }
        $ankets->save();

        return redirect(url()->previous());
    }

    public function saveFilters(Request $request)
    {
        session([
            'filters' => [
                'sex' => $request->get('sex'),
                'city_id' => $request->get('city_id'),
                'purpose_id' => $request->get('purpose_id'),
            ]
        ]);
        return redirect('/dating');
    }

    public function listAnketa()
    {
        $filters = session('filters');

        $ankets = Anketa::orderBy('id', 'desc')
            ->where('is_enable', '1');

        if (is_array($filters)) {
            if (!empty($filters['sex']) && $filters['sex'] >=0) {
                $ankets->where('sex', $filters['sex']);
            }

            if (!empty($filters['city_id']) && $filters['city_id'] >=0 ) {
                $ankets->where('city_id', $filters['city_id']);
            }

            if (!empty($filters['purpose_id']) && $filters['purpose_id'] >= 0) {
                $ankets->where('purpose_id', $filters['purpose_id']);
            }
        }
        $ankets = $ankets->paginate(5);
        return view('anketa/list')->with('ankets', $ankets);
    }

    public function clearFilters()
    {
        session(['filters' => null ]);
        return redirect('/dating');
    }

}