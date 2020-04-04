@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.topic.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.topics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.topic.fields.id') }}
                        </th>
                        <td>
                            {{ $topic->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topic.fields.title') }}
                        </th>
                        <td>
                            {{ $topic->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topic.fields.slug') }}
                        </th>
                        <td>
                            {{ $topic->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topic.fields.description') }}
                        </th>
                        <td>
                            {!! $topic->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topic.fields.activated') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $topic->activated ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topic.fields.created_by') }}
                        </th>
                        <td>
                            {{ $topic->created_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.topics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#topic_courses" role="tab" data-toggle="tab">
                {{ trans('cruds.course.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="topic_courses">
            @includeIf('admin.topics.relationships.topicCourses', ['courses' => $topic->topicCourses])
        </div>
    </div>
</div>

@endsection