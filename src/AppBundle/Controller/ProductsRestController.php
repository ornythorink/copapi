<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;


class ProductsRestController extends FOSRestController
{
    public function getProductAction($id){
        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);
        if(!is_object($product)){
            throw $this->createNotFoundException();
        }
        return $product;
    }



}
