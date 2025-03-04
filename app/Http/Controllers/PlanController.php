<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\BookPlan;
use App\Models\Subscription;
use App\Models\SubscriptionUser;

class PlanController extends Controller
{
    public function plan()
    {
        $plans = BookPlan::all();
        return view('plan.plan', [
            'plans' => $plans
        ]);
    }

    public function planDetails($id)
    {
        $plans = BookPlan::findOrFail($id);
        return view('plan.plan_details', [
            'plans' => $plans
        ]);
    }

    public function planManagement()
    {
        $plans = BookPlan::all();
        return view('plan.plan_management', [
            'plans' => $plans
        ]);
    }

    public function delete(int $id)
    {
        return view('news.plan_delete', [
            'plans' => BookPlan::findOrFail($id),
        ]);
    }

    public function edit(int $id)
    {
        $plans = BookPlan::findOrFail($id);
        return view('plan.plan_edit', compact('plans'));
    }

    public function create()
    {
        return view('plan.plan_create');
    }

    public function update(Request $request, int $id)
    {
        $request->validate(
            [
                'name' => 'required|min:2',
                'description' => 'required',
                'total_price' => 'required|numeric|min:0.01',
            ],
            [
                'name.required' => 'The title cannot be empty.',
                'name.min' => 'The title must be at least 2 characters.',
                'description.required' => 'The description cannot be empty.',
                'total_price.required' => 'The price cannot be empty.',
                'total_price.numeric' => 'The price must be a valid number.',
                'total_price.min' => 'The price must be greater than 0.',
            ]
        );

        $plans = BookPlan::findOrFail($id);

        $input = $request->except(['_token', '_method']);

        $plans->update($input);

        return redirect()
            ->route('plan.management')
            ->with('feedback.message', 'The plan <b>"' . e($plans->name) . '"</b> was updated successfully');
    }
}
