<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\City;
use App\Dates;

class HomeController extends Controller
{
    public function store(Request $request)
    {
        parse_str($request['data'], $data);
        $company = new Company();
        $company->name = $request['title'];
        $company->code = $request['company_code'];
        $company->city_id = $request['city'];
        $company->address = $request['address'];
        $company->save();


        foreach($data['dates'] as $key => $value){
            $dates = new Dates();
            $dates->company_id = $company->id;
            $dates->date = $value;
            $dates->sum = $data['dates_val'][$key];
            $dates->save();
        }

        return response()->json(['success' => $company->id, 'city' => $company->city->name, 'edit' => route('modify-company', $company->id),
            'delete' => route('delete-company', $company->id)]);
    }

    public function delete(Request $request, $id)
    {
        $company = Company::find($id);
        // if company not found return
        if (!$company) {
            return response()->json(['danger' => 'Įmonė nerasta']);
        }
        Dates::where('company_id', $company->id)->delete();
        $company->delete();
        return response()->json(['success' => 'Įmonė sėkmingai ištrinta']);
    }

    public function edit(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $cities = City::all();
        return view('edit')->with(['company' => $company, 'cities' => $cities]);
    }

    public function modify(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->name = $request['title'];
        $company->code = $request['code'];
        $company->city_id = $request['city'];
        $company->save();

        foreach($company->dates as $key => $data){
            $data->sum = $request['dates'][$key];
            $data->save();
        }

        return redirect(route('home'))->withSuccess('Informacija atnaujinta');
    }
}
