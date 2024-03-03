<?php

namespace App\Http\Controllers\Swagger\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/media/photo/{page?}",
 *     summary="Index",
 *     tags={"Photo"},
 *     @OA\Parameter(
 *         description="Page Number",
 *         in="path",
 *         name="page",
 *         required=false,
 *         example="1"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="url", type="string", example="default/photo_default.png"),
 *                 @OA\Property(property="name", type="string", example="Photo Name"),
 *                 @OA\Property(property="size", type="integer", example=32023),
 *                 @OA\Property(property="created_at", type="string", example="2023-06-12 18:54:32"),
 *                 @OA\Property(property="updated_at", type="string", example="2023-06-12 18:54:32"),
 *             )),
 *         )
 *     ),
 * ),
 *
 * @OA\Post(
 *     path="/api/admin/photo/store",
 *     summary="Store",
 *     tags={"Photo"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Photo Name"),
 *                     @OA\Property(property="image", type="file", example="Image File"),
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="url", type="string", example="default/photo_default.png"),
 *                 @OA\Property(property="name", type="string", example="Photo Name"),
 *                 @OA\Property(property="size", type="integer", example=32023),
 *                 @OA\Property(property="created_at", type="string", example="2023-06-12 18:54:32"),
 *                 @OA\Property(property="updated_at", type="string", example="2023-06-12 18:54:32"),
 *             ),
 *         )
 *     ),
 *     @OA\Header(
 *         header="X-XSRF-TOKEN",
 *         description="CSRF token",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 * ),
 */
class PhotoController extends Controller
{
    //
}
