<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
        return $rules = [
            'title' => [
                'string',
                'required',
                'max:255',
                # TITLE/AUTHOR PAIR MUST BE UNIQUE FOR EACH USER
                Rule::unique('books')->where('author', '"'.$this->get('author').'"')->where('user_id', $this->user()->id)->ignore($this->book->id ?? null)
            ],
            'author' => [
                'string',
                'required',
                'max:255',
                'regex:/.+, .+/' # AUTHORS MUST BE IN THE FORM LAST, FIRST
            ],
            'publication_date' => [
                'nullable',
                'date'
            ],
            'isbn13' => [
                'nullable',
                'size:13',
                'regex:/^\d*$/',
                Rule::unique('books')->where('user_id', $this->user()->id)->ignore($this->book->id ?? null)
            ],
            'cover' => [
                'image',
                'mimetypes:image/gif,image/jpeg,image/png',
                'max:5000'
            ]
        ];
    }
}
