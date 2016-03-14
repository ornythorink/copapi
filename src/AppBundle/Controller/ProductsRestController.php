<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;


class ProductsRestController extends FOSRestController
{
    public function getProductAction($username){
        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->findOneByUsername($username);
        if(!is_object($product)){
            throw $this->createNotFoundException();
        }
        return $product;
    }



}
