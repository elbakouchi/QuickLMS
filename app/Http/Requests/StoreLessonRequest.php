<?php

namespace App\Http\Requests;

use App\Lesson;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreLessonRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title'     => [
                'min:2',
                'required',
                'unique:lessons'],
            'slug'      => [
                'min:2',
                'required'],
            'content'   => [
                'required'],
            'price'     => [
                'required'],
            'course_id' => [
                'required',
                'integer'],
        ];

    }
}
