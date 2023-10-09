<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatepermisosRequest extends FormRequest
{
    protected string $tableName = 'permissions';
    protected string $param     = 'permission';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => "required|string|max:50|unique:{$this->tableName},name" . (isset($this->route($this->param)->id) ? ',' . $this->route($this->param)->id : ''),
            'guard_name'  => "required|string",
            'description' => "required|string",
            'module_key'  => "required|string",
/*             'module_key'  => "required|exists:c_modulo,key",
 */        ];
    }
    public function attributes(): array
    {
        return [
            'name'        => "Nombre",
            'description' => "Descripción",
            'module_key'  => "Nombre del módulo",
        ];
    }
}
