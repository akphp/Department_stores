<?php

namespace App\Repositories;


use App\Interfaces\PlanInterface;
use App\Interfaces\UserInterface;
use App\Models\Plan;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class PlanRepository implements PlanInterface
{
    use ApiResponser;
    private $plan;

    function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }


    function all()
    {
        return $this->plan->get();
        // return $this->showAll(Collection::make($plans));
    }


    function find($id)
    {
        return $this->plan->findOrFail($id);
    }

    function store(Request $request)
    {
        $modules = $request->input('modules');
        $userId = Auth::guard('admin-api')->user()->id;
        $plan = $request->all();
        unset($plan['modules']);
        $plan['user_id'] = $userId;
        $plan = Plan::create($plan);
        foreach ($modules as $value) {
            $plan->modules()->create(['module_id' => $value, 'user_id' => $userId]);
        }
        return $plan;
    }

    function update(Request $request, $id)
    {
        // TODO: Implement update() method.
    }

    function delete($plan)
    {
        if ($plan->store) {
            throw new \Exception('Could not delete plan, because its used by store', USED_PLAN);
        }
        $plan->delete();
        return $plan;
    }
    function changeStatus(Request $request, Plan $plan, $active)
    {
        $plan->is_active = $active;
        $plan->update();
        return $plan;
    }
}
