<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Products;
use AppBundle\Form\ProductsType;

class ProductsRestController extends FOSRestController
{

    public function getProductAction($id){
        $product = $this->getDoctrine()->getRepository('AppBundle:Products')->find($id);
        if(!is_object($product)){
            throw $this->createNotFoundException();
        }
        return $product;
    }

    public function postProductAction(Request $request){
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try{
                $em->persist($product);
                $em->flush();
            } catch ( \Exception $e) {
               \Doctrine\Common\Util\Debug::dump($e->getMessage());
            }
        }
        return $product;
    }
}
