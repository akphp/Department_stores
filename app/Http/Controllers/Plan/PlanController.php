<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanCollection;
use App\Interfaces\PlanInterface;
use App\Models\Plan;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ApiResponser;

    /**
     * model repo.
     *
     * @author Amr
     * @var PlanInterface
     */
    private $planeRepository;

    /**
     * PlanController constructor.
     * @param PlanInterface $planeRepository
     */
    public function __construct(PlanInterface $planeRepository)
    {
        $this->planeRepository = $planeRepository;
    }

    /**
     * show all resources
     *
     * @return mixed
     * @author Amr
     */
    function index()
    {
        $plans =  $this->planeRepository->all();
        return $this->showAll($plans);

    }

    public function show($id)
    {
        $plan = $this->planeRepository->find($id);
        // $this->showOne($plan);
        return response(['data' => $plan, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }

    /**
     * crete new resource
     *
     * @param PlanRequest $request
     * @author Amr
     */
    function store(PlanRequest $request)
    {
        $plan = $this->planeRepository->store($request);
        return response(['data' => $plan, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }


    function changeStatus(Request $request, Plan $plan, $active)
    {
        $plan = $this->planeRepository->changeStatus($request, $plan, $active);
        return response(['data' => $plan, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);

    }

    public function destroy(Plan $plan)
    {
        $plan = $this->planeRepository->delete($plan);
        return response(['data' => $plan, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }
}
