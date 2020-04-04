<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\Admin\CourseResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource(Course::with(['authors', 'topic'])->get());

    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());
        $course->authors()->sync($request->input('authors', []));

        if ($request->input('joined_files', false)) {
            $course->addMedia(storage_path('tmp/uploads/' . $request->input('joined_files')))->toMediaCollection('joined_files');
        }

        if ($request->input('featured_photo', false)) {
            $course->addMedia(storage_path('tmp/uploads/' . $request->input('featured_photo')))->toMediaCollection('featured_photo');
        }

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource($course->load(['authors', 'topic']));

    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());
        $course->authors()->sync($request->input('authors', []));

        if ($request->input('joined_files', false)) {
            if (!$course->joined_files || $request->input('joined_files') !== $course->joined_files->file_name) {
                $course->addMedia(storage_path('tmp/uploads/' . $request->input('joined_files')))->toMediaCollection('joined_files');
            }

        } elseif ($course->joined_files) {
            $course->joined_files->delete();
        }

        if ($request->input('featured_photo', false)) {
            if (!$course->featured_photo || $request->input('featured_photo') !== $course->featured_photo->file_name) {
                $course->addMedia(storage_path('tmp/uploads/' . $request->input('featured_photo')))->toMediaCollection('featured_photo');
            }

        } elseif ($course->featured_photo) {
            $course->featured_photo->delete();
        }

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
