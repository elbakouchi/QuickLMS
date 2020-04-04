<?php

namespace App\Http\Requests;

use App\Topic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreTopicRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('topic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title'         => [
                'min:2',
                'required',
                'unique:topics'],
            'slug'          => [
                'min:3',
                'required'],
            'activated'     => [
                'required'],
            'created_by_id' => [
                'required',
                'integer'],
        ];

    }
}
