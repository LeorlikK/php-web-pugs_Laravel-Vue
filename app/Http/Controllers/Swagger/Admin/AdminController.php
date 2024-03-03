<?php

namespace App\Http\Controllers\Swagger\Admin;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/admin/users",
 *     summary="Index",
 *     tags={"AdminUsers"},
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="object",
 *                 @OA\Property(property="id", type="integer", example="1"),
 *                 @OA\Property(property="email", type="string", example="email@ya.ru"),
 *                 @OA\Property(property="login", type="string", example="login"),
 *                 @OA\Property(property="role", type="string", example="admin"),
 *                 @OA\Property(property="avatar", type="string", example="default/avatar_default.png"),
 *                 @OA\Property(property="banned", type="boolean", example="0"),
 *             ),
 *         )
 *     ),
 * )
 */
class AdminController extends Controller
{

}
