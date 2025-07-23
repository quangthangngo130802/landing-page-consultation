<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = optional($this->route('post'))->id;
        return [
            'title'                  => 'required|unique:posts,title,' . $id,
            'slug'                  => 'nullable|unique:posts,slug,' . $id,
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'           => 'required',
            'address'               => 'nullable|',
            'title_seo'             => 'nullable|max:100',
            'description_seo'       => 'nullable|max:150',
            'keyword_seo'           => 'nullable',
            'status'                => 'required',
            'type'                  => 'required',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'title'            => 'Tiêu đề',
            'slug'             => 'Slug',
            'image'            => 'Hình ảnh',
            'description'      => 'Mô tả',
            'address'          => 'Địa chỉ',
            'title_seo'        => 'Tiêu đề SEO',
            'description_seo'  => 'Mô tả SEO',
            'keywords_seo'     => 'Từ khóa SEO',
            'status'           => 'Trạng thái',
            'type'             => 'Loại bài viết',
        ];
    }
}
