<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Topics
    Route::post('topics/media', 'TopicApiController@storeMedia')->name('topics.storeMedia');
    Route::apiResource('topics', 'TopicApiController');

    // Courses
    Route::post('courses/media', 'CourseApiController@storeMedia')->name('courses.storeMedia');
    Route::apiResource('courses', 'CourseApiController');

    // Lessons
    Route::post('lessons/media', 'LessonApiController@storeMedia')->name('lessons.storeMedia');
    Route::apiResource('lessons', 'LessonApiController');

});
