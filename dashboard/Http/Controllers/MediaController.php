<?php

namespace Dashboard\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Загрузка медиа файлов
     *
     * @param Request $request
     * @return array
     */
    public function postMediaUploadFile(Request $request)
    {
        // список доступных форматов для загрузки
        $allowMimeTypes = array_values(Media::$allowMimeTypes);
        // проверка на обьязательные поля
        $this->validate($request, [
            'file' => ['required', 'file', 'mimetypes:'.implode(',', $allowMimeTypes)],
            'model_id' => ['required', 'numeric', 'min:1'],
            'model_type' => ['required'],
            'entity' => ['sometimes', 'nullable'],
            'path' => ['sometimes'],
        ]);
        $modelType = 'App\\Models\\' . ucfirst($request->get('model_type'));
        $entity = $request->get('entity') ?: Media::ENTITY_DEFAULT;
        $items = [];
        $files = $request->file('file');
        if (!is_array($files)) {
            $files = [$files];
        }
        foreach ($files as $index => $file) {
            // ограничение на количество загрузок в 10 файлов
            if ($index >= 10) break;
            $basename = $file->getClientOriginalName();
            $directory = $request->get('path') ?: $request->get('model_type');
            // искать в папке назначения имя файла.
            // если оно уже есть то добавлять уникальных хеш (-s4d6de543)
            if (file_exists('storage'.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$basename)) {
                $pathinfo = pathinfo($basename);
                $basename = $pathinfo['filename'] . '-' . uniqid('') . '.' . $pathinfo['extension'];
            }
            $storedFileName = $file->storeAs($directory, $basename, 'public');
            $media = Media::create([
                'model_id' => $request->get('model_id'),
                'model_type' => $modelType,
                'entity' => $entity,
                'path' => 'storage'.DIRECTORY_SEPARATOR.$storedFileName,
            ]);
            array_push($items, $media->fresh());
        }
        // если режим single file то удалять текущий файл
        // if (!$request->get('multiple')) {
        //     $dropIds = Media::where('model_id', $request->get('model_id'))
        //         ->where('model_type', $modelType)
        //         ->where('entity', $entity)
        //         ->whereNotIn('id', Arr::pluck($items, 'id'))
        //         ->orderBy('order', 'ASC')
        //         ->get('id')
        //         ->pluck('id')
        //         ->toArray();
        //
        //     if ($dropIds) {
        //         $destroyRequest = new Request(['id' => $dropIds]);
        //         $this->deleteMedia($destroyRequest);
        //     }
        // }
        return $this->response([
            MSG => 'Success upload file',
            DATA => [
                'items' => $items[0],
            ]
        ]);
    }

    /**
     * Удаление media обьекта
     *
     * @param Request $request
     * @return array
     */
    public function deleteMedia(Request $request)
    {
        $fileDeleted = (new Media)->deleteMedia($request->all());
        return $this->response([MSG => "Success delete {$fileDeleted} files"]);
    }
}
