<?php

function apiSuccess(
    string $message = 'Sucesso!',
    mixed $data = [],
    ?int $status = 200
) {
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data,
        'status' => $status

    ], $status);
};

function apiError(
    string $message,
    mixed $data = [],
    ?int $status = 400
) {
    return response()->json([
        'success' => false,
        'message' => $message,
        'data' => $data,
        'status' => $status

    ], $status);
};
