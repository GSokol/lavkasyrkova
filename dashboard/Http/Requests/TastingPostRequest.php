<?php

namespace Dashboard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class TastingPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'time' => ['required', 'date_format:U'],
            'office_id' => ['required', 'integer', 'exists:offices,id'],
            'active' => ['sometimes', 'nullable', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'time' => Carbon::createFromFormat('d/m/Y', $this->time)->format('U'),
            'active' => in_array($this->active, ['on', 'true', 1, true]),
        ]);
    }
}
