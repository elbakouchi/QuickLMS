<?php

namespace App\Http\Requests;

use App\Course;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCourseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title'     => [
                'min:2',
                'required',
                'unique:courses'],
            'slug'      => [
                'min:2',
                'required'],
            'content'   => [
                'required'],
            'price'     => [
                'required'],
            'authors.*' => [
                'integer'],
            'authors'   => [
                'required',
                'array'],
            'topic_id'  => [
                'required',
                'integer'],
        ];

    }
}
