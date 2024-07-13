
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectApprovalRequest extends FormRequest
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
			'iaec_comments' => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:250',
			'iaec_date'     => 'required|date|date_format:Y-m-d',
			'iaec_meeting'  => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:250',
			'decision'      => 'required|numeric|max:1',
		];
				
    }
}
