<?php

namespace App\Http\Controllers\v1;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Expense;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all(['id','category_id','customer_id','description','amount','accrual_date','transaction_date']);
        if ($expenses->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($expenses);
    }

    private function isCategory($id)
    {
        $category = Category::all('id')->where('id','=',$id);
        if ($category->isEmpty())
        {
            return false;
        }
        return true;
    }

    private function isCustomer($id)
    {
        $category = Customer::all('id')->where('id','=',$id);
        if ($category->isEmpty())
        {
            return false;
        }
        return true;
    }

    public function store(Request $request)
    {
        try
        {
            if(!$this->isCategory($request->input('category_id')))
            {
                return response()->json(['error' => 'Category is invalid'],404);
            }

            if( $request->input('customer_id') !== null && !$this->isCustomer($request->input('customer_id')))
            {
                return response()->json(['error' => 'Customer is invalid'],404);
            }

            $expense = new Expense;
            $expense->category_id = $request->input('category_id');
            $expense->customer_id = $request->input('customer_id');
            $expense->description = $request->input('description');
            $expense->amount = $request->input('amount');
            $expense->accrual_date = $request->input('accrual_date');
            $expense->transaction_date = $request->input('transaction_date');
            if($expense->save())
            {
                return response()->json(['expense_id' => $expense->id],201);
            }
        } catch (Exception $exception)
        {
            dd($exception);
            return response('',400);
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            if(!$this->isCategory($request->input('category_id')))
            {
                return response()->json(['error' => 'Category is invalid'],404);
            }

            if( $request->input('customer_id') !== null && !$this->isCustomer($request->input('customer_id')))
            {
                return response()->json(['error' => 'Customer is invalid'],404);
            }

            $expense = Expense::find($id);
            if (is_null($expense))
            {
                return response()->json(['error' => 'Not found'],404);
            }
            $expense->category_id = $request->input('category_id');
            $expense->customer_id = $request->input('customer_id');
            $expense->description = $request->input('description');
            $expense->amount = $request->input('amount');
            $expense->accrual_date = $request->input('accrual_date');
            $expense->transaction_date = $request->input('transaction_date');
            $expense->save();
            return response('',200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);
        if (is_null($expense))
        {
            return response()->json(['error' => 'Not found'],404);
        }
        $expense->delete();
        return response('',204);
    }
}
