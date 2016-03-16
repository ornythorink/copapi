<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Products;
use AppBundle\Form\ProductsType;

class ProductsRestController extends FOSRestController
{

    public function getProductAction(Request $request, $id){

        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);
        if(!is_object($product)){
            throw $this->createNotFoundException();
        }
        return $product;
    }

    public function postProductAction(Request $request){
        $json = $request->request->all();

        $product = new Products();

        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {
            $product->createFromArray($json);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }
        return $product;
    }
}
