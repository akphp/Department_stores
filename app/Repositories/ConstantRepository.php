<?php

namespace App\Repositories;

use App\Interfaces\ConstantInterface;
use App\Interfaces\UserInterface;
use App\Models\Constant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class ConstantRepository implements ConstantInterface
{
    use ApiResponser;
    /**
     * repo. model
     *
     * @author Amr
     * @var constant
     */
    private $constant;

    /**
     * constantRepository constructor.
     * @param constant $constant
     * @author Amr
     */
    function __construct(Constant $constant)
    {
        $this->constant = $constant;
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
        return $this->constant->get();
        // return $this->showAll(Collection::make($constants));
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
        return $this->constant->findOrFail($id);
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
        // $modules = $request->input('modules');
        $userId = Auth::guard('admin-api')->user()->id;
        $constant = $request->all();
        // unset($constant['modules']);
        $constant['name'] = json_encode($constant['name']);
        $constant['user_id'] = $userId;
        $constant['is_active'] = INACTIVE;

        $constant = constant::create($constant);

        return $constant;
    }

    /**
     * update the resource
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @author Amr
     */
    function update($id, Request $request)
    {
        $constant = Constant::findOrFail($id);
        $userId = Auth::guard('admin-api')->user()->id;
        $data = $request->all();
        // unset($constant['modules']);
        $data['name'] = json_encode($data['name']);
        $data['user_id'] = $userId;
        $data['is_active'] = INACTIVE;

        $constant->update($data);

        return $constant;
    }

    /**
     * delete the resource
     * @param $id
     * @return mixed
     */
    function delete(Constant $constant)
    {

        $constant->delete();
        return $constant;
    }



    /**
     * change the status of constant
     *
     * @param Request $request
     * @param constant $constant
     * @param $active
     * @return bool
     */
    function changeStatus(Request $request, Constant $constant, $active)
    {
        $constant->is_active = $active;
        $constant->update();
        return $constant;
    }
}
