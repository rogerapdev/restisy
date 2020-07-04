<?php

namespace App\Responder;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response as Res;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class Responder {
    /**
     * @var $statusCode int
     */
    protected $statusCode = null;

    /**
     * @var string
     */
    protected $message = null;

    /**
     * @var array|null
     */
    protected $data = null;

    /**
     * @var array|string|null
     */
    protected $error = null;


    /**
     * @param array $data
     * @return ResponseFactory|Res
     */
    public function respond(array $data = [])
    {
        $default = [
            "status_code" => $this->getStatusCode() ?? Res::HTTP_OK,
            "status"      => "success",
            "message" => "",
        ];

        if (!is_null($this->getMessage()))
            $data['message'] = $this->getMessage();
        else
            $data['message'] = $data['message'] ?? trans("responder.success");

        if (!is_null($this->getRespondData())) {
            if (isset($data['data']) && $data['data'] && is_array($data['data'])) {
                $data['data'] = array_merge($data['data'], $this->getRespondData());
            } else {
                $data['data'] = $this->getRespondData();
            }
        }

        if (!is_null($this->getRespondError()))
            $data['errors'] = $this->getRespondError();

        $data = array_replace($default, $data);

        return \response($data, $data['status_code']);
    }


    /**
     * @param      $message
     * @param null $mode
     *
     * @return Responsible
     */
    public function setMessage($message, $mode = null)
    {
        if (is_null($mode))
            $this->message = $message;
        else
            $this->message = trans("responder.{$mode}", ["attribute" => $message]);
        return $this;
    }


    /**
     * set data for respond ['data' => $data]
     *
     * @param $data
     * @return $this
     */
    public function setRespondData($data)
    {
        $this->data = $data;
        return $this;
    }


    /**
     * appendData
     *
     * @param array $data
     * @return $this
     */
    public function appendRespondData(array $data)
    {
        $this->setRespondData(array_merge((array)$this->getRespondData(), $data));
        return $this;
    }


    /**
     * set data for response ['error' => $error | (string) or (array)]
     *
     * @param $error
     * @return $this
     */
    public function setRespondError($error)
    {
        $this->error = $error;
        return $this;
    }


    /**
     * get data of sending respond
     *
     * @return array|null
     */
    public function getRespondData()
    {
        return $this->data;
    }


    /**
     * get error of sending respond
     *
     * @return array|null
     */
    public function getRespondError()
    {
        return $this->error;
    }


    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    /**
     * @param null $data
     *
     * @return ResponseFactory|Res
     */
    public function respondCreated($data = null)
    {
        return $this->respond([
            "status_code" => Res::HTTP_CREATED,
            "data"        => $data,
        ]);
    }


    /**
     * @param null $data
     *
     * @return ResponseFactory|Res
     */
    public function respondUpdated($data = null)
    {
        return $this->respond([
            "data" => $data,
        ]);
    }


    /**
     * @return ResponseFactory|Res
     */
    public function respondDeleted()
    {
        return $this->respond();
    }


    /**
     * @param array $data
     *
     * @return ResponseFactory|Res
     */
    public function respondBadRequest()
    {
        if (is_null($this->getMessage()))
            $this->setMessage(trans("responder.error"));

        return $this->respond([
            "status"      => "error",
            "status_code" => Res::HTTP_BAD_REQUEST,
        ]);
    }


    /**
     * @return ResponseFactory|Res
     */
    public function respondNotFound()
    {
        if (is_null($this->getMessage()))
            $this->setMessage(trans("responder.notfound"));

        return $this->respond([
            'status'      => 'error',
            'status_code' => Res::HTTP_NOT_FOUND,
        ]);
    }


    /**
     * @return ResponseFactory|Res
     */
    public function respondInternalError()
    {
        if (is_null($this->getMessage()))
            $this->setMessage(trans("responder.internal_error"));

        return $this->respond([
            'status'      => 'error',
            'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
        ]);
    }


    /**
     * @param array $errors
     *
     * @return ResponseFactory|Res
     */
    public function respondValidationError($errors = [])
    {
        if (is_null($this->getMessage()))
            $this->setMessage(trans("responder.validation_error"));

        return $this->respond([
            'status'      => 'error',
            'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
            'errors'      => $errors,
        ]);
    }


    /**
     * @param array $data
     *
     * @return ResponseFactory|Res
     */
    public function respondUnauthorizedError()
    {
        if (is_null($this->getMessage()))
            $this->setMessage(trans("responder.unauthenticated"));

        return $this->respond([
            "status"      => "error",
            "status_code" => Res::HTTP_UNAUTHORIZED,
        ]);
    }


    /**
     * @param array $data
     *
     * @return ResponseFactory|Res
     */
    public function respondForbiddenError()
    {
        if (is_null($this->getMessage()))
            $this->setMessage(trans("responder.forbidden"));

        return $this->respond([
            "status"      => "error",
            "status_code" => Res::HTTP_FORBIDDEN,
        ]);
    }


    

    /**
     * @param Paginator $paginate
     * @param           $data
     *
     * @return ResponseFactory|Res
     */
    public function respondWithPagination(Paginator $paginate, $data)
    {
        return $this->respond([
            'data'      => $data,
            'paginator' => [
                'total_count'  => $paginate->total(),
                'total_pages'  => ceil($paginate->total() / $paginate->perPage()),
                'current_page' => $paginate->currentPage(),
                'limit'        => $paginate->perPage(),
            ],
        ]);
    }
}