<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Responder\ResponderFacade as Responder;
use App\Repositories\TypeRepository;
use App\Transformers\TypeTransformer;

use App\Http\Requests\TypeRequest;

class TypeController extends Controller
{

    /**
     * @var TypeRepository
     */
    protected $repository;

    public function __construct(TypeRepository $repository = null)
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
        $types = $this->repository->paginate(env('PER_PAGE'));

        $data = (new TypeTransformer)->transformCollection($types);
        return Responder::respondWithPagination($types, $data);
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
    public function store(TypeRequest $request)
    {
        try {
            $type = $this->repository->create($request->all());
        } catch (Exception $e) {
            return Responder::respondNotFound();
        }

        $data = (new TypeTransformer)->transform($type);
        return Responder::setRespondData($data)
                ->respond();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Responder::respondNotFound();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $type = $this->repository->find($id);
        } catch (Exception $e) {
            return Responder::respondNotFound();
        }

        $data = (new TypeTransformer)->transform($type);
        return Responder::setRespondData($data)
                ->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeRequest $request, $id)
    {
        try {
            $type = $this->repository->update($request->all(), $id);
        } catch (Exception $e) {
            return Responder::respondBadRequest();
        }

        $data = (new TypeTransformer)->transform($type);
        return Responder::respondUpdated($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
        } catch (Exception $e) {
            return Responder::respondNotFound();
        }

        return Responder::respondDeleted();
    }
}
