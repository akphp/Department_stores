<?php

namespace App\Http\Controllers\Constant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConstantRequest;
use App\Interfaces\ConstantInterface;
use App\Models\Constant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ConstantController extends Controller
{
    use ApiResponser;

    /**
     * model repo.
     *
     * @author Amr
     * @var PlanInterface
     */
    private $constantRepository;

    /**
     * PlanController constructor.
     * @param ConstantInterface $constantRepository
     */
    public function __construct(ConstantInterface $constantRepository)
    {
        $this->constantRepository = $constantRepository;
    }

    /**
     * show all resources
     *
     * @return mixed
     * @author Amr
     */
    function index()
    {
          $constants =  $this->constantRepository->all();
          return $this->showAll($constants);
        // return response(['data' => $plans] , SUCCESS_RESPONSE);

    }

    /**
     * show resource by id
     * @param $id
     * @author Amr
     */
    public function show($id)
    {
        $constant= $this->constantRepository->find($id);
        // dd($this->showOne($plan));
        // $this->showOne($plan);
        return response(['data' => $constant , 'code' => SUCCESS_RESPONSE] , SUCCESS_RESPONSE);
    }

    /**
     * crete new resource
     *
     * @param PlanRequest $request
     * @author Amr
     */
    function store(ConstantRequest $request)
    {
        $constant = $this->constantRepository->store($request);
        return response(['data' => $constant , 'code' => SUCCESS_RESPONSE] , SUCCESS_RESPONSE);

    }
    function update($id , ConstantRequest $request)
    {
        $constant = $this->constantRepository->update($id ,$request);
        return response(['data' => $constant , 'code' => SUCCESS_RESPONSE] , SUCCESS_RESPONSE);

    }

    /**
     * update the status of plan
     *
     * @param Request $request
     * @param Plan $plan
     * @param $active
     * @return mixed
     * @author Amr
     */
    function changeStatus(Request $request, Constant $constant, $active)
    {
        $constant = $this->constantRepository->changeStatus($request, $constant, $active);
        return response(['data' => $constant , 'code' =>SUCCESS_RESPONSE] , SUCCESS_RESPONSE);

        // return response()->api(SUCCESS_RESPONSE, trans('lang.status_updated_successfully', ['attribute' => trans('lang.plan')]), $plan);
    }

    public function destroy(Constant $constant)
    {
        $constant = $this->constantRepository->delete($constant);
        return response(['data' => $constant , 'code' =>SUCCESS_RESPONSE] , SUCCESS_RESPONSE);
        // return response()->api(SUCCESS_RESPONSE, trans('lang.deleted_successfully', ['attribute' => trans('lang.plan')]), $plan);
    }
}
