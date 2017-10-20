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
        return redirect('/dating?sex=' . $request->get('sex') . '&city_id=' . $request->get('city_id') . '&purpose_id=' . $request->get('purpose_id'));
    }

    public function listAnketa(Request $request)
    {

        $filters = session('filters');

        $ankets = Anketa::orderBy('id', 'desc')
            ->where('is_enable', '1');

        if (is_array($filters) && (!$request->get('sex') || !$request->get('city_id') || !$request->get('purpose_id'))) {
            if (!empty($filters['sex']) && $filters['sex'] >= 0 && !$request->get('sex')) {
                $ankets->where('sex', $filters['sex']);
            }

            if (!empty($filters['city_id']) && $filters['city_id'] >= 0 && !$request->get('city_id')) {
                $ankets->where('city_id', $filters['city_id']);
            }

            if (!empty($filters['purpose_id']) && $filters['purpose_id'] >= 0 && !$request->get('purpose_id')) {
                $ankets->where('purpose_id', $filters['purpose_id']);
            }
        }

        if($request->get('sex') || $request->get('city_id') || $request->get('purpose_id')) {
            if($sex = $request->get('sex')) {
                $ankets->where('sex', $sex);
            }

            if($city_id = $request->get('city_id')) {
                $ankets->where('city_id', $city_id);
            }

            if($purpose_id = $request->get('purpose_id')) {
                $ankets->where('purpose_id', $purpose_id);
            }
            // set params to filter
            session([
                'filters' => [
                    'sex' => $request->get('sex'),
                    'city_id' => $request->get('city_id'),
                    'purpose_id' => $request->get('purpose_id'),
                ]
            ]);
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