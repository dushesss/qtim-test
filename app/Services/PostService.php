<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;

/**
 * Класс-сервис для управления постами
 *
 * Class PostService
 *
 * @package App\Services
 */
class PostService
{
    /**
     * Метод возвращает все посты
     *
     * @return array
     */
    public static function getAllPosts(): array
    {
        $posts = Post::all();
        $result = [];
        foreach ($posts as $post) {
            $result[] = [
                'name' => $post->name,
                'detail' => $post->detail
            ];
        }

        return $result;
    }

    /**
     * Метод создает пост
     *
     * @param array $data Массив данных, которые требуется сохранить в новом посте
     *
     * @return Post
     */
    public static function createPost(array $data): Post
    {
        $newPost = new Post();

        $newPost->name = $data['name'];
        $newPost->detail = $data['detail'];
        $newPost->save();

        return $newPost;
    }

    /**
     * Метод обновляет пост
     *
     * @param int   $id id поста, который нужно обновить
     * @param array $data Массив данных, которые требуется сохранить в существующем посте
     *
     * @return Post
     */
    public static function updatePost(int $id, array $data): Post
    {
        $post = Post::find($id);

        $post->name = $data['name'];
        $post->detail = $data['detail'];
        $post->save();

        return $post;
    }

    /**
     * Метод удаляет пост
     *
     * @param int $id id поста, который требуется удалить
     *
     * @return bool
     */
    public static function deletePost(int $id): bool
    {
        return (bool) Post::destroy($id);
    }
}
