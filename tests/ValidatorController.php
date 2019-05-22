<?php

namespace SSDTest;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ValidatorController extends Controller
{
    /**
     * Get form view.
     *
     * @return string
     */
    public function index(): string
    {
        return 'form view';
    }

    /**
     * Store record.
     *
     * @param  \SSDTest\StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        return new JsonResponse;
    }
}