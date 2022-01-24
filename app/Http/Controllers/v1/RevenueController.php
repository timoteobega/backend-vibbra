<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use App\Models\Revenue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    private function isCustomer($customer_id)
    {
        $customer = Customer::all('id')->where('id','=',$customer_id);
        if ($customer->isEmpty())
        {
            return false;
        }
        return true;
    }

    public function index()
    {
        $revenue = Revenue::all('id','customer_id','invoice_id','description','amount','accrual_date','transaction_date');
        if ($revenue->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($revenue);
    }

    public function store(Request $request,$customer_id)
    {
        try
        {
            if(!$this->isCustomer($customer_id))
            {
                return response()->json(['error' => 'Customer is invalid'],404);
            }

            $revenue = new Revenue;
            $revenue->customer_id = $customer_id;
            $revenue->invoice_id = $request->input('invoice_id');
            $revenue->description = $request->input('description');
            $revenue->amount = $request->input('amount');
            $revenue->accrual_date = $request->input('accrual_date');
            $revenue->transaction_date = $request->input('transaction_date');
            if($revenue->save())
            {
                return response()->json(['revenue_id' => $revenue->id],201);
            }
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            $revenue = Revenue::find($id);
            if (is_null($revenue))
            {
                return response()->json(['error' => 'Not found'],404);
            }
            $revenue->invoice_id = $request->input('invoice_id');
            $revenue->description = $request->input('description');
            $revenue->amount = $request->input('amount');
            $revenue->accrual_date = $request->input('accrual_date');
            $revenue->transaction_date = $request->input('transaction_date');
            $revenue->save();
            return response('',200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function destroy($id)
    {
        $revenue = Revenue::find($id);
        if (is_null($revenue))
        {
            return response()->json(['error' => 'Not found'],404);
        }
        $revenue->delete();
        return response('',204);
    }

    public function totalRevenue(Request $request)
    {
        try
        {
            $fiscal_year = $request->input('fiscal_year');
            if ($fiscal_year < 2000)
            {
                return response()->json(['error' => 'Send a year above 2000'],404);
            }

            $result = DB::table('revenues')->whereYear('accrual_date','=',$fiscal_year)->get(['amount']);
            $max_revenue_amount = $result->max('amount');
            $total_revenue = $result->sum('amount');

            return response()->json([
                'total_revenue' => (double)$total_revenue,
                'max_revenue_amount' => (double)$max_revenue_amount
            ],200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function revenueByMonth(Request $request)
    {
        try
        {
            $fiscal_year = $request->input('fiscal_year');

            if ($fiscal_year < 2000)
            {
                return response()->json(['error' => 'Send a year above 2000'],404);
            }

            $result = DB::table('revenues')
                ->whereYear('accrual_date','=',$fiscal_year)
                ->select( DB::raw('MONTHNAME(accrual_date) as month_name, SUM(amount) month_revenue'))
                ->groupBy('month_name')
                ->get();

            if(empty($result->all()))
            {
                return response()->json(['error' => 'No revenue for this year'],404);
            }

            $response = [
                'revenue' => $result->all(),
                'max_revenue_amount' => (float)$result->max('month_revenue')
            ];

            return response()->json($response,200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function revenueByCustomer(Request $request)
    {
        try
        {
            $fiscal_year = $request->input('fiscal_year');

            if ($fiscal_year < 2000)
            {
                return response()->json(['error' => 'Send a year above 2000'],404);
            }

            $result = DB::table('revenues')
                ->join('customers', 'revenues.customer_id', '=', 'customers.id')
                ->whereYear('accrual_date','=',$fiscal_year)
                ->select( DB::raw('commercial_name as customer_name, SUM(amount) revenue'))
                ->groupBy('commercial_name')
                ->get();

            if(empty($result->all()))
            {
                return response()->json(['error' => 'No revenue for this year'],404);
            }

            $response = [
                'revenue' => $result->all(),
                'max_revenue_amount' => (float)$result->max('revenue')
            ];

            return response()->json($response,200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }
}
