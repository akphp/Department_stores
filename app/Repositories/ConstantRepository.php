<?php

namespace App\Repositories;

use App\Http\Resources\ConstantResoures;
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
        return  $this->constant->where('parent_id' , 0)->with('children')->get();
        // return $this->showAll(Collection::make($constants));
    }

    function getParents(){
        return  $this->constant->where('parent_id' , 0)->with('children')->get();
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
        $userId = Auth::guard('admin-api')->user()->id;
        $constant = $request->all();
        $constant['name'] = $constant['name'];
        $constant['user_id'] = $userId;
        $constant['is_active'] = INACTIVE;

        $constant = constant::create($constant);

        return $constant;
    }

    function update($id, Request $request)
    {
        $constant = Constant::findOrFail($id);
        $userId = Auth::guard('admin-api')->user()->id;
        $data = $request->all();
        // unset($constant['modules']);
        $data['name'] = $data['name'];
        $data['user_id'] = $userId;
        $data['is_active'] = INACTIVE;

        $constant->update($data);

        return $constant;
    }

    function delete(Constant $constant)
    {

        $constant->delete();
        return $constant;
    }

    function changeStatus(Request $request, Constant $constant, $active)
    {
        $constant->is_active = $active;
        $constant->update();
        return $constant;
    }

    function filter(){
        $collection = $this->constant->where('parent_id' , 0)->with('children')->get();
        foreach (request()->query() as $query => $value) {
			if (isset($attribute, $value)) {
				$collection = $collection->where($query, $value);
			}
        
        }
        return  $collection;
    }
}
