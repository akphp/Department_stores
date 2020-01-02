<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth(ADMIN_GUARD)->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'price_month' => 'required|numeric',
            'price_year' => 'required|numeric',
            // 'modules' => 'required|array',
            'modules.*' => 'required|exists:constants,id',
            'currency_id' => 'required|exists:currencies,id',
            'plan_level' => 'required|numeric',
            'no_inventory' => 'required|numeric',
            'no_pos' => 'required|numeric',
            'no_emp' => 'required|numeric',
            'no_item' => 'required|numeric',
            'is_active' => 'required|numeric|in:1,2',
            'is_trial' => 'required',
            'interval_trail' => 'required_if:is_trial,==,1|numeric'
        ];
    }
}
