<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Контроллер для управления постом
 *
 * Class PostControler
 *
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    /**
     * Экшен возвращает все посты
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        try {
            $posts = PostService::getAllPosts();
            return ResponseHelper::sendSuccess($posts);
        } catch (\Throwable $e) {
            return ResponseHelper::sendError('Ошибка при входе', $e->getMessage());
        }
    }

    /**
     * Экшен создает один пост
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request): Response
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|string',
                'detail' => 'required|max:255|string'
            ]);

            if ($validator->fails()) {
                return ResponseHelper::sendError('Ошибка при вводе данных');
            }

            $data = $validator->validated();

            $posts = PostService::createPost($data);
            return ResponseHelper::sendSuccess($posts);
        } catch (\Throwable $e) {
            return ResponseHelper::sendError('Ошибка при входе', $e->getMessage());
        }
    }

    /**
     * Экшен обновляет пост
     *
     * @param Request $request
     * @param int     $postId id поста, который требуется обновить
     *
     * @return Response
     */
    public function update(Request $request, int $postId): Response
    {
        try {
            $validator = Validator::make($request->all(), [
                'postId' => 'required|numeric',
                'name' => 'required|max:255|string',
                'detail' => 'required|max:255|string'
            ]);

            if ($validator->fails()) {
                return ResponseHelper::sendError('Ошибка при вводе данных');
            }

            $data = $validator->validated();

            $post = PostService::updatePost($postId, $data);
            return ResponseHelper::sendSuccess($post);
        } catch (\Throwable $e) {
            return ResponseHelper::sendError('Ошибка при обновлении поста', $e->getMessage());
        }
    }

    /**
     * Экшен для удаления одного поста
     *
     * @param Request $request
     * @param int     $postId id поста, который нужно удалить
     *
     * @return Response
     */
    public function delete(Request $request, int $postId): Response
    {
        try {
            $deleted = PostService::deletePost($postId);
            return ResponseHelper::sendSuccess($deleted, 'Пост удален успешно');
        } catch (\Throwable $e) {
            return ResponseHelper::sendError('Ошибка при удалении поста', $e->getMessage());
        }
    }
}
