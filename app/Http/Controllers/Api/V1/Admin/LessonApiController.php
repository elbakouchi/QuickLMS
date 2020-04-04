<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\Admin\LessonResource;
use App\Lesson;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LessonResource(Lesson::with(['course'])->get());

    }

    public function store(StoreLessonRequest $request)
    {
        $lesson = Lesson::create($request->all());

        if ($request->input('joined_files', false)) {
            $lesson->addMedia(storage_path('tmp/uploads/' . $request->input('joined_files')))->toMediaCollection('joined_files');
        }

        if ($request->input('featured_photo', false)) {
            $lesson->addMedia(storage_path('tmp/uploads/' . $request->input('featured_photo')))->toMediaCollection('featured_photo');
        }

        return (new LessonResource($lesson))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LessonResource($lesson->load(['course']));

    }

    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->all());

        if ($request->input('joined_files', false)) {
            if (!$lesson->joined_files || $request->input('joined_files') !== $lesson->joined_files->file_name) {
                $lesson->addMedia(storage_path('tmp/uploads/' . $request->input('joined_files')))->toMediaCollection('joined_files');
            }

        } elseif ($lesson->joined_files) {
            $lesson->joined_files->delete();
        }

        if ($request->input('featured_photo', false)) {
            if (!$lesson->featured_photo || $request->input('featured_photo') !== $lesson->featured_photo->file_name) {
                $lesson->addMedia(storage_path('tmp/uploads/' . $request->input('featured_photo')))->toMediaCollection('featured_photo');
            }

        } elseif ($lesson->featured_photo) {
            $lesson->featured_photo->delete();
        }

        return (new LessonResource($lesson))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
