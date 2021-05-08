<?php

namespace App\Http\Controllers;

use App\DocumentElement;
use App\IPFSConnector;
use App\StorageFile;
use App\StorageFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class StorageController extends Controller
{

    /**
     * @var ipfs
     */
    private $ipfs;

    /**
     * StorageController constructor.
     */
    public function __construct()
    {
        $this->ipfs = new IPFSConnector();
    }

    /**
     * Devuelve las rutas que usa el controlador
     *
     * @return void
     */
    static function routes()
    {
        Route::get('get-tree', 'StorageController@getTree')->name('get-tree');
        Route::post('get-share-link', 'StorageController@getShareLink')->name('get-share-link');
        Route::post('get-info', 'StorageController@getInfo')->name('get-info');
        Route::post('delete', 'StorageController@deleteElement')->name('delete');
        Route::group(['prefix' => 'folders'], function () {
            Route::get('store-folder', 'StorageController@storeFolder')->name('folders.store-folder');
        });
        Route::group(['prefix' => 'files'], function () {
            Route::get('{id}', 'StorageController@getFile')->name('files.get-file');
            Route::post('store-file', 'StorageController@storeFile')->name('files.store-file');
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getTree(Request $request)
    {
        $parent = DocumentElement::find($request->parent);
        $bread_crumb = null;
        if (!is_null($parent)){
            $tree = DocumentElement::whereHas('element', function ($element){
                $element->where('id_user_uploaded', Auth::user()->id);
            })->where('parent_id',$parent->id)
                ->with('children')
                ->orderBy('created_at','asc')
                ->get();

            $current_parent = $parent;
            $bread_crumb = new Collection();
            while (!is_null($parent->parent)){
                $element = new Collection();
                $element->put('id',$parent->parent->id);
                $element->put('name',$parent->parent->element->name);
                $bread_crumb->push($element);
                $parent = $parent->parent;
            }
            $bread_crumb = $bread_crumb->reverse();
            $parent = $current_parent;

        }else{
            $tree = Auth::user()->tree();
        }

        return view('content.fileManager.partials.items-container',['tree'=>$tree,'parent'=>$parent, 'bread_crumb'=>$bread_crumb]);
    }

    /**
     * Crea un fichero
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeFile(Request $request)
    {
        $hash = '';
        DB::beginTransaction();
        try {
            $file = $request->file;
            $parent = DocumentElement::find($request->id_parent);
            $name = $file->getClientOriginalName();
            $url = $name;
            if (!is_null($parent)) {
                $url = $parent->full_url() . '/' . $url;
            }
            $response = $this->ipfs->upload($file, $url);
            $hash = $response;
            $file = StorageFile::create([
                'name' => $name,
                'url' => $url,
                'content_type' => $file->getMimeType(),
                'id_user_uploaded' => Auth::user()->id,
                'hash' => $response
            ]);

            $document_element = $file->element()->create([
                'parent_id' => $parent != null ? $parent->id : null,
            ]);

            DB::commit();
            return response()->json([
                'success' => 'true',
                'message' => 'File Uploaded',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            /**
             * pendiente hacer rm en caso de error.
             */
            return response()->json([
                'success' => false,
                'message' => 'Error on upload file: ' . $e->getMessage(),
            ], 401);
        }
    }

    /**
     * retornamos el fichero para visualizarlo en el navegador
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function getFile($id)
    {
        $element = DocumentElement::whereHas('element', function ($element) {
            $element->where('id_user_uploaded', Auth::user()->id);
        })->where('id', $id)->first();

        if (is_null($element))
            return \response()->json([
                'success' => false,
                'message' => 'No puedes acceder a este elemento'
            ], 404);

        if ($element->element_type != 'App\StorageFile')
            return \response()->json([
                'success' => false,
                'message' => 'No puedes acceder a este elemento'
            ], 404);

        /** @var StorageFile $file */
        $file = $element->element;
        $content = $this->ipfs->cat($file->hash);

        $response = Response::make($content, 200);
        $response->header("Content-Type", $file->content_type);

        ob_get_clean();

        return $response;
    }

    /**
     * retorno el link de ipfs publico.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShareLink(Request $request)
    {
        $element = DocumentElement::whereHas('element', function ($element) {
            $element->where('id_user_uploaded', Auth::user()->id);
        })->where('id', $request->id)->first();

        if (is_null($element))
            return \response()->json([
                'success' => false,
                'message' => 'No puedes acceder a este elemento'
            ]);

        return \response()->json([
            'success' => true,
            'link' => 'https://ipfs.io/ipfs/' . $element->element->hash
        ]);
    }

    /**
     * retorno el contenido de la info del elemento
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        try {
            $element = DocumentElement::whereHas('element', function ($element) {
                $element->where('id_user_uploaded', Auth::user()->id);
            })->where('id', $request->id)->first();

            if (is_null($element))
                return \response()->json([
                    'success' => false,
                    'message' => 'No puedes acceder a este elemento'
                ], 401);

            $element->size = $this->ipfs->loadSize($element);
            $element->type = $element->element_type != 'App\StorageFolder' ? explode('/', $element->element->content_type)[1] : 'folder';

            $content = view('content.fileManager.partials.info-item', compact('element'))->render();

            return \response()->json([
                'success' => true,
                'content' => $content
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error on create folder: ' . $th->getMessage(),
            ], 401);
        }
    }


    /**
     * Crea una carpeta
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeFolder(Request $request)
    {
        DB::beginTransaction();
        try {
            $parent = DocumentElement::find($request->id_parent);
            $name = $request->name;
            $url = $name;
            if (!is_null($parent)) {
                $url = $parent->full_url() . '/' . $url;
            }
            $hash = $this->ipfs->mkdir($url);
            $folder = StorageFolder::create([
                'name' => $name,
                'id_user_uploaded' => Auth::user()->id,
                'hash' => $hash
            ]);

            $document_element = $folder->element()->create([
                'parent_id' => $parent != null ? $parent->id : null,
            ]);

            DB::commit();
            return response()->json([
                'success' => 'true',
                'message' => 'Folder created',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error on create folder: ' . $e->getMessage(),
            ], 401);
        }
    }


    /**
     * Elimina cualquier elemento
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function deleteElement(Request $request)
    {
        DB::beginTransaction();
        try {
            $element = DocumentElement::find($request->id);
            $deleted = $this->ipfs->rm($element->element->name);
            if (!$deleted)
                throw new \Exception('Error al borrar elemento');

            $element->element->delete();
            $element->delete();
            DB::commit();
            return response()->json([
                'success' => 'true',
                'message' => 'Folder deleted',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error on delete folder: ' . $e->getMessage(),
            ], 401);
        }
    }

}
