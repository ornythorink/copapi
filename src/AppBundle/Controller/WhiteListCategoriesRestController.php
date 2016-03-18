<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\WhiteListCategories;
use AppBundle\Form\WhiteListCategoriesType;
use Doctrine\Common\Util\Inflector;

class WhiteListCategoriesRestController extends FOSRestController
{
    /**
     *
     * @Get("/whitelistcategories/{id}")
     */
    public function getWhiteListCategoriesAction($id){
        $whitelist = $this->getDoctrine()->getRepository('AppBundle:WhiteListCategories')->find($id);

        if(!is_object($whitelist)){
            throw $this->createNotFoundException();
        }

        return $whitelist;
    }

    /**
     *
     * @Get("/whitelistcategories")
     */
    public function getAllWhiteListCategoriesAction(){
        $whitelist = $this->getDoctrine()->getRepository('AppBundle:WhiteListCategories')->findAll();

        if(count($whitelist) == 0){
            throw $this->createNotFoundException();
        }

        return $whitelist;
    }


    /**
     *
     * @Post("/whitelistcategories")
     */
    public function postWhiteListCategoriesAction(Request $request){
        $json = $request->request->all();

        $whitelist = new WhiteListCategories();

        $form = $this->createForm(WhiteListCategoriesType::class, $whitelist);

        $form->handleRequest($request);
        $form->submit($request);

        if ($form->isValid()) {
            foreach($json as $field=> $value)
            {
                $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
                if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                    $value = new \DateTime($value);
                }
                $whitelist->$setter($value);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($whitelist);
            $em->flush();
        }
        return $whitelist;
    }

    /**
     *
     * @Put("/whitelistcategories/{id}")
     */
    public function putWhiteListCategoriesAction(Request $request, $id){
        $putItems = json_decode($request->getContent() ,true);

        $whitelist = $this->getDoctrine()->getRepository('AppBundle:WhiteListCategories')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            if(preg_match('/\d{4}-\d{2}-\d{2}/',$value)){
                $value = new \DateTime($value);
            }
            $whitelist->$setter($value);
        }

        if(!is_object($whitelist)){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new WhiteListCategoriesType(),$whitelist);

        $form->handleRequest($request);
        $form->submit($request->getContent());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($whitelist);
            $em->flush();
        }

        return $whitelist;
    }

    /**
     *
     * @Delete("/whitelistcategories/{id}")
     */
    public function deleteWhiteListCategoriesAction($id){

    }
}
