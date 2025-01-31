<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class DocumentationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'info' => [
                'title' => 'Schedule Generator',
                'version' => '1.0.0',
            ],
            'paths' => [
                '/api/register' => [
                    'post' => [
                        'body params' => [
                            'name' => 'string|required',
                            'email' => 'email|required',
                            'password' => 'string|required',
                        ],
                        'summary' => 'Register a new user.',
                        'responses' => [
                            '200' => [
                                'message' => 'User Created.',
                            ],
                        ],
                    ],
                ],
                '/api/login' => [
                    'post' => [
                        'body params' => [
                            'email' => 'email|required',
                            'password' => 'string|required',
                        ],
                        'summary' => 'Register a new user.',
                        'responses' => [
                            '200' => [
                                'status' => 'success',
                                'message' => 'User logged in successfully',
                                'name' => 'username',
                                'token' => 'token',
                            ],
                        ],
                    ],
                ],
                '/api/generate' => [
                    'post' => [
                        'authentication' => 'Bearer token',
                        'body params' => [
                            'recurrence' => 'required|integer',
                            'startTime' => ['required', 'hh:ii:ss'],
                            'endTime' => ['required', 'hh:ii:ss'],
                            'duration' => ['required', 'integer', 'min:1'],
                            'saturdayOff' => ['nullable', 'boolean'],
                            'break' => ['nullable', 'array', 'min:1'],
                            'break.*.startBrake' => ['required_with:break.*.endBrake', 'hh:ii:ss'],
                            'break.*.endBrake' => ['required_with:break.*.startBrake', 'hh:ii:ss'],
                        ],
                        'obs:' => [
                            'recurrence' => [
                                1 => 'day',
                                2 => 'week',
                                3 => 'month',
                            ],
                            'duration' => [
                                'in minutes.'
                            ],
                        ],
                        'summary' => 'Register a new user.',
                        'responses' => [
                            '200' => [
                                'data' => 'Times list'
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
