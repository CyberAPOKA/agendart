<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
        //aplica as validações para a imagem e a mensagem.
        return [
            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,jpg',
                'max:5120',
                function ($attribute, $value, $fail) {
                    if ($value instanceof UploadedFile && !$value->isValid()) {
                        $fail('O arquivo de imagem é inválido.');
                        return;
                    }

                    list($width, $height) = getimagesize($value->getRealPath());
                    if ($width < 200 || $height < 200) {
                        $fail('As dimensões da imagem devem ser no mínimo 200x200px.');
                    }
                },
            ],
            'comment' => ['required', 'max:200']
        ];
    }

    public function messages()
    {
        //traduz as mensagens.
        return [
            'image.required' => 'A imagem é obrigatória.',
            'image.file' => 'Deve ser uma imagem PNG, JPG ou JPEG.',
            'image.mimes' => 'Deve ser uma imagem originalmente criada em .png, .jpg ou .jpeg.',
            'image.image' => 'A imagem deve ser do tipo PNG, JPG ou JPEG.',
            'image.max' => 'O arquivo deve ser menor que 5MB.',
            'comment.required' => 'A mensagem é obrigatória.',
            'comment.max' => 'A mensagem deve ter no máximo 200 caracteres.'
        ];
    }
}
