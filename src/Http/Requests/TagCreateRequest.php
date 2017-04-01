<?php

namespace Easel\Http\Requests;

class TagCreateRequest extends Request
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
            'name' => 'required|unique:tags,name',
            'slug' => 'required|unique:tags,slug',
        ];
  }
}
