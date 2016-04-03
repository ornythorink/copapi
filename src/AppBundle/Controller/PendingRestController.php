<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Pending;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PendingType;
use Doctrine\Common\Util\Inflector;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;



class PendingRestController extends FOSRestController
{
    public function getPendingAction($id){
        $pending = $this->getDoctrine()->getRepository('AppBundle:Pending')->find($id);

        return $pending;
    }

    public function getPendingsAction(){
        $pending = $this->getDoctrine()->getRepository('AppBundle:Pending')->findAll();

        return $pending;
    }

    public function postPendingAction(Request $request){

            $json = $request->request->all();

            $pending = new Pending();
            $pending->createFromArray($json);
            $form = $this->createForm(PendingType::class, $pending);

            $form->handleRequest($request);
            $form->submit($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($pending);
                $em->flush();
            }
            return $pending;
    }

    /**
     *
     * @Post("/pendings/replace/{source}")
     */
    public function replacePendingAction(Request $request, $source){

        $logger = $this->get('logger');
        $logger->error(\Doctrine\Common\Util\Debug::dump($request->request->all()));
        $form = $this->createForm(PendingType::class, new Pending(), array('method' => 'POST') );

        $form->submit($request->request->all(), 'PATCH' !== 'POST' );
        $logger->error($form->getErrors());
        if ($form->isValid()) {

            $pending = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getRepository('AppBundle:Pending')->createOrReplacePending($pending, $source);
        }
    }


    public function putPendingAction(Request $request, $id){

        $putItems = json_decode($request->getContent() ,true);

        $pending = $this->getDoctrine()->getRepository('AppBundle:Pending')->find($id);

        foreach($putItems as $field=> $value)
        {
            $setter = sprintf('set%s', ucfirst(Inflector::camelize($field)));
            $pending->$setter($value);
        }

        if(!is_object($pending)){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new PendingType(),$pending);

        $form->handleRequest($request);
        $form->submit($request->getContent());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pending);
            $em->flush();
        }

        return $pending;
    }

    public function deletePendingAction($id){

    }
}
