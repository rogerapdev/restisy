<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Responder\ResponderFacade as Responder;
use App\Repositories\RoleRepository;
use App\Transformers\RoleTransformer;

class RoleController extends BaseController
{

    /**
     * @var RoleRepository
     */
    protected $repository;

    public function __construct(RoleRepository $repository = null)
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
        $roles = $this->repository->paginate(env('PER_PAGE'));

        $data = (new RoleTransformer)->transformCollection($roles);
        return Responder::respondWithPagination($roles, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Responder::respondNotFound();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $role = $this->repository->with(['permissions'])->find($id);
        } catch (Exception $e) {
            return Responder::respondNotFound();
        }

        return Responder::setRespondData($role)
                ->respond();
                
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return Responder::respondNotFound();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
