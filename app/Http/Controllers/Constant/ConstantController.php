<?php

namespace App\Http\Controllers\Constant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConstantRequest;
use App\Interfaces\ConstantInterface;
use App\Models\Constant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Resources\ConstantResoures;


class ConstantController extends Controller
{
    use ApiResponser;

    private $constantRepository;


    public function __construct(ConstantInterface $constantRepository)
    {
        $this->constantRepository = $constantRepository;
    }


    function index()
    {
        $constants =  $this->constantRepository->all();
        return $this->showAll($constants);
        // return response(['data' => $plans] , SUCCESS_RESPONSE);

    }
    function parents ()
    {
        $constants =  $this->constantRepository->getParents();
        return $this->showAll($constants);
        // return response(['data' => $plans] , SUCCESS_RESPONSE);

    }

    public function show($id)
    {
        $constant =  $this->constantRepository->find($id);
        // return response()->api(SUCCESS_RESPONSE, trans('lang.constant_fetched_successfully'), $constant);
        return response(['data' => $constant, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }


    function store(ConstantRequest $request)
    {
        $constant = $this->constantRepository->store($request);
        return response(['data' => $constant, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }
    function update($id, ConstantRequest $request)
    {
        $constant = $this->constantRepository->update($id, $request);
        return response(['data' => $constant, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }


    function changeStatus(Request $request, Constant $constant, $active)
    {
        $constant = $this->constantRepository->changeStatus($request, $constant, $active);
        return response(['data' => $constant, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);

    }

    public function destroy(Constant $constant)
    {
        $constant = $this->constantRepository->delete($constant);
        return response(['data' => $constant, 'code' => SUCCESS_RESPONSE], SUCCESS_RESPONSE);
    }
}
