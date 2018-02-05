<?php

namespace Rest\Controller;

use Rest\Request;


class AbstractRestfulController extends AbstractController {

     /**
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request, $action = 'index')
    {

        switch (strtolower($request->getRequestType())) {
            case 'get':
                $id = $this->getIdentifier($request);
                if ($id) {
                    $view = $this->get($id);
                } else {
                    $view = $this->getList();
                }
                break;
            case 'delete':
                $id = $this->getIdentifier($request);

                if ($id) {
                    $view = $this->delete($id, $request->getData());
                } else {
                    return $this->getResponse()->setStatusCode(501);
                }
                break;

            case 'post':
                $data = $request->getData();
                $view = $this->create($data);
                break;
                
            default:
                return $this->getResponse()->setStatusCode(501);
        }

        return $view;
    }

}