<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BlackListCategories;
use AppBundle\Form\BlackListCategoriesType;
use Doctrine\Common\Util\Inflector;


class BlackListCategoriesRestController extends FOSRestController
{
    /**
     *
     * @Get("/blacklistcategories/{id}")
     */
    public function getBlackListCategoriesAction($id){
        $blacklist = $this->getDoctrine()->getRepository('AppBundle:BlackListCategories')->find($id);

        if(!is_object($blacklist)){
            throw $this->createNotFoundException();
        }

        return $blacklist;
    }

    /**
     *
     * @Get("/blacklistcategories")
     */
    public function getAllBlackListCategoriesAction(){
        $blacklist = $this->getDoctrine()->getRepository('AppBundle:BlackListCategories')->findAll();

        if(!is_object($blacklist)){
            throw $this->createNotFoundException();
        }

        return $blacklist;
    }


    /**
     *
     * @Post("/blacklistcategories")
     */
    public function postBlackListCategoriesAction(Request $request){
        $json = $request->request->all();

        $blacklist = new BlackListCategories();

        $form = $this->createForm(BlackListCategoriesType::class, $blacklist);

        $form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {
            foreach($json as $field=> $value)
            {
                $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
                if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                    $value = new \DateTime($value);
                }
                $blacklist->$setter($value);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($blacklist);
            $em->flush();
        }
        return $blacklist;
    }

    /**
     *
     * @Put("/blacklistcategories/{id}")
     */
    public function putBlackListCategoriesAction(Request $request, $id){
        $putItems = json_decode($request->getContent() ,true);

        $blacklist = $this->getDoctrine()->getRepository('AppBundle:BlackListCategories')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                $value = new \DateTime($value);
            }
            $blacklist->$setter($value);
        }

        if(!is_object($blacklist)){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new BlackListCategoriesType(),$blacklist);

        $form->handleRequest($request);
        $form->submit($request->getContent());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blacklist);
            $em->flush();
        }

        return $blacklist;
    }

    /**
     *
     * @Delete("/blacklistcategories/{id}")
     */
    public function deleteBlackListCategoriesAction($id){

    }
}