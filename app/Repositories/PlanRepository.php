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
    /**
     * repo. model
     *
     * @author Amr
     * @var Plan
     */
    private $plan;

    /**
     * PlanRepository constructor.
     * @param Plan $plan
     * @author Amr
     */
    function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * get resources' columns
     *
     * @param $columns
     * @return mixed
     * @author Amr
     */
    // function get($columns = ['*'])
    // {
    //     // TODO: Implement get() method.
    // }

    /**
     * show all resources
     *
     * @return mixed
     * @author Amr
     */
    function all()
    {
        return $this->plan->get();
        // return $this->showAll(Collection::make($plans));
    }

    /**
     * get the resource by id
     *
     * @param $id
     * @return mixed
     * @author Amr
     */
    function find($id)
    {
        return $this->plan->findOrFail($id);
    }

    /**
     * store the resource
     *
     * @param Request $request
     * @return mixed
     * @author Amr
     */
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

    /**
     * update the resource
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @author Amr
     */
    function update(Request $request, $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * delete the resource
     * @param $id
     * @return mixed
     */
    function delete($plan)
    {
        if ($plan->store) {
            throw new \Exception('Could not delete plan, because its used by store', USED_PLAN);
        }
        $plan->delete();
        return $plan;
    }

    /**
     * filter the resource accordin' to
     * the given params
     *
     * @param $where
     * @return mixed
     * @author Amr
     */
    function filter($where)
    {
        $plan = filter($where, $this->plan);
        return $plan;
    }

    /**
     * complete form registration
     *
     * @param Request $request
     * @return mixed
     * @author Amr
     */
    function complete(Request $request)
    {
        // TODO: Implement complete() method.
    }

    /**
     * change the status of plan
     *
     * @param Request $request
     * @param Plan $plan
     * @param $active
     * @return bool
     */
    function changeStatus(Request $request, Plan $plan, $active)
    {
        $plan->is_active = $active;
        $plan->update();
        return $plan;
    }


}

