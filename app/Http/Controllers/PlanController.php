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
        return view('plan.plan_delete', [
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

    public function store(Request $request)
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

        $input = $request->all();

        $input['month'] = now()->format('Y-m-d');
        $input['created_at'] = now();
        $input['updated_at'] = now();

        BookPlan::create($input);

        return redirect()
            ->route('plan.management')
            ->with('feedback.message', 'The Plan <b>"' . e($input['name']) . '"</b> was uploaded successfully');
    }

    public function destroy(int $id)
    {
        $plans = BookPlan::findOrFail($id);

        // Verifica si existen suscripciones activas asociadas al plan
        if ($plans->subscriptions()->exists()) {
            return redirect()
                ->route('plan.management')
                ->with('feedback.message', 'The Plan <b>"' . e($plans->name) . '"</b> cannot be deleted because there is an active subscription.');
        } else {
            $plans->delete($id);

            return redirect()
                ->route('plan.management')
                ->with('feedback.message', 'The Plan <b>"' . e($plans['name']) . '"</b> was deleted successfully');
        }
    }
}
