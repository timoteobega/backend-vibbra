<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all('id','cnpj','commercial_name','legal_name');
        if ($customers->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        try
        {
            $customer = Customer::all('id')->where('cnpj','=',$request->input('cnpj'));
            if (!$customer->isEmpty())
            {
                return response()->json(['error' => 'CNPJ already registered'],404);
            }

            $customer = new Customer;
            $customer->cnpj = $request->input('cnpj');
            $customer->commercial_name = $request->input('commercial_name');
            $customer->legal_name = $request->input('legal_name');
            if($customer->save())
            {
                return response()->json(['customer_id' => $customer->id],201);
            }
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function show($id)
    {
        $customer = Customer::all('id','cnpj','commercial_name','legal_name')->where('id','=',$id);
        if ($customer->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($customer->first());
    }

    public function update(Request $request, $id)
    {
        try
        {
            $customer = Customer::find($id);
            if (is_null($customer))
            {
                return response()->json(['error' => 'Not found'],404);
            }

            $customer = Customer::all('id','cnpj')->where('cnpj','=',$request->input('cnpj'))->first();
            if (!is_null($customer) && $customer->cnpj != $request->input('cnpj'))
            {
                return response()->json(['error' => 'CNPJ already registered'],404);
            }

            $customer->cnpj = is_null($request->input('cnpj')) ? $customer->cnpj : $request->input('cnpj');
            $customer->commercial_name = is_null($request->input('commercial_name')) ? $customer->commercial_name : $request->input('commercial_name');
            $customer->legal_name = is_null($request->input('legal_name')) ? $customer->legal_name : $request->input('legal_name');
            $customer->save();
            return response('',200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer))
        {
            return response()->json(['error' => 'Not found'],404);
        }
        $customer->delete();
        return response('',204);
    }

    public function search($key,$value)
    {
        try {
            $customers = Customer::query()->where($key, 'like', "%{$value}%")->get(['id','cnpj','commercial_name','legal_name']);
            if ($customers->isEmpty())
            {
                return response()->json(['error' => 'Not found'],404);
            }
            return response()->json([
                "count" => $customers->count(),
                "customers" => $customers->all()
            ]);
        } catch (Exception $customers)
        {
            return response('',400);
        }
    }
}
