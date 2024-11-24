<?php

namespace Modules\Event\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class EventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'name' => 'required',
                'venue_id' => 'required|exists:venues,id',
                'ticket_sales_end_date' => 'required|date_format:Y-m-d H:i:s',
            ];
        } else {
            return [
                'name' => 'required',
                'ticket_sales_end_date' => 'sometimes|date_format:Y-m-d H:i:s',
            ];
        }

    }

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
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors): JsonResponse
    {
        return response()->json($errors, 422);
    }
}
