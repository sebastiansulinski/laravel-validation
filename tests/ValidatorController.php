<?php

namespace SSDTest;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ValidatorController extends Controller
{
    /**
     * Get form view.
     */
    public function index(): string
    {
        return 'form view';
    }

    /**
     * Store record.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        return new JsonResponse;
    }
}
