<?php
namespace App\Traits;
trait ApiJsonResponse
{
    private $response = [
        'success'   => null,
        'data'      => null,
        'message'   => null
    ];

    public function errorResponse($message, $data = []){
        $this->response['success'] = false;
        $this->response['data'] = $data;
        $this->response['message'] = $message;
        return $this->response;
    }

    public function successResponse($message, $data = []){
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = $message;
        return $this->response;
    }
}