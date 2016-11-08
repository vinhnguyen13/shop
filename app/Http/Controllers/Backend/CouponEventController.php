<?php

namespace App\Http\Controllers\Backend;


use App\Helpers\Grid;
use App\Models\Backend\CpEvent;
use Illuminate\Http\Request;
use DB;
use Image;
use Input;
use Redirect;
use Response;
use Storage;
use Validator;

class CouponEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $grid = new Grid( DB::table('cp_event'),
            [
                'id',
                'name' => [
                    'filter' => 'like',
                ],
                'description' => [
                    'filter' => 'like',
                ],
                'start_date' => [
                    'filter' => false,
                    'format' => function($item){
                        return date('d-m-Y', $item->start_date);
                    }
                ],
                'end_date' => [
                    'filter' => false,
                    'format' => function($item){
                        return date('d-m-Y', $item->end_date);
                    }
                ]
            ]);

        if ($request->ajax()) {
            return $grid->table();
        }
        return view('coupon-event.index', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cpevent = new CpEvent();
        $isNewRecord = true;
        return view('coupon-event.form', compact('cpevent', 'isNewRecord')); // folder_name.blade_name
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        if(count($input) > 0) {
            $validation = Validator::make($input, CpEvent::$rules);
            if ($validation->passes()) {
                $user = \Auth::user();
                $time = time();
                if (empty($input['start_date']))
                    $input['start_date'] = $time;
                else
                    $input['start_date'] = strtotime($input['start_date']);

                if (empty($input['end_date']))
                    $input['end_date'] = $time;
                else
                    $input['end_date'] = strtotime($input['end_date']. " 23:59");

                $input['created_at'] = $time;
                $input['created_by'] = $user->id;
                $cpevent = CpEvent::create($input);
                return Redirect::route('cpevent.show', ['id' => $cpevent->id]);
            }

            if ($validation->fails()) {
                return Redirect::route('cpevent.create')
                    ->withErrors($validation)
                    ->withInput();
            }
        } else
            return abort('404', 'Input Not Found');

        return Redirect::route('cpevent.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $cpevent = DB::table('cp_event')->where('id', $id)->get()->first();
        if(count($cpevent) > 0)
            return view('coupon-event.view', compact('cpevent'));
        else
            return abort('404', 'Coupon Event Not Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $isNewRecord = false;
        $cpevent = CpEvent::find($id);
        if(count($cpevent) > 0) {
            return view('coupon-event.form', compact('cpevent', 'isNewRecord'));
        } else {
            return abort('404', 'Coupon Event Not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $cpevent = CpEvent::find($id);
        if(count($cpevent) > 0) {
            $input = Input::all();
            if(count($input) > 0) {
                $user = \Auth::user();
                $validator = Validator::make($input, ['end_date' => 'required|after:start_date']);
                if ($validator->passes()) {
                    $time = time();
                    if (empty($input['start_date']))
                        $input['start_date'] = $time;
                    else
                        $input['start_date'] = strtotime($input['start_date']);

                    if (empty($input['end_date']))
                        $input['end_date'] = $time;
                    else
                        $input['end_date'] = strtotime($input['end_date']. " 23:59");

                    $input['created_at'] = $time;
                    $input['created_by'] = $user->id;
                    if ($cpevent->update($input)) {
                        return Redirect::route('cpevent.show', ['id' => $cpevent->id]);
                    }
                } else {
                    return Redirect::route('cpevent.edit', ['id' => $cpevent->id])
                        ->withErrors($validator)
                        ->withInput();
                }

            } else
                return abort('404', 'Input Not Found');

        } else {
            return abort('404', 'Coupon Event Not Found');
        }
        return Redirect::route('cpevent.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
//        $cpevent = CpEvent::find($id);
//        if($cpevent) {
//            $cpevent->delete();
//        }

        return Redirect::route('cpevent.index');
    }
}
