<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Responder\ResponderFacade as Responder;
use App\Repositories\PermissionRepository;
use App\Transformers\PermissionTransformer;

class PermissionController extends BaseController
{

    /**
     * @var PermissionRepository
     */
    protected $repository;

    public function __construct(PermissionRepository $repository = null)
    {

        $this->repository = $repository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->repository->paginate(env('PER_PAGE'));

        $data = (new PermissionTransformer)->transformCollection($permissions);
        return Responder::respondWithPagination($permissions, $data);
    }

}
