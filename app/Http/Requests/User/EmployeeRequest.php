<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'user.username'      => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'user.first_name'    => ['required', 'string', 'max:255'],
            'user.last_name'     => ['required', 'string', 'max:255'],
            'user.full_name'     => ['nullable', 'string', 'max:255'],
            'user.password'      => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:8', 'confirmed'],
            'user.email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'user.phone'         => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($userId)],
            'user.branch_id'     => ['nullable', 'exists:branches,id'],
            'user.department_id' => ['nullable', 'exists:departments,id'],
            'user.career_id'     => ['nullable', 'exists:careers,id'],
            'user.id_number'     => ['nullable', 'string', 'max:255'],
            'user.address'       => ['nullable', 'string', 'max:255'],
            'user.avatar'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'user.nationality'   => ['nullable', 'string', 'max:255'],
            'user.date_of_birth' => ['nullable', 'date'],

            // Experiences Array
            'experiences'              => ['nullable', 'array'],
            'experiences.*.title'        => ['required_with:experiences', 'string', 'max:255'],
            'experiences.*.organization' => ['required_with:experiences', 'string', 'max:255'],
            'experiences.*.description'  => ['nullable', 'string'],
            'experiences.*.start_date'   => ['nullable', 'date'],
            'experiences.*.end_date'     => ['nullable', 'date', 'after_or_equal:experiences.*.start_date'],
            'experiences.*.type'         => ['nullable', Rule::in(['work', 'education'])],

            // Permissions Array
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }
}
