<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Pending;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PendingType;
use Doctrine\Common\Util\Inflector;

class PendingRestController extends FOSRestController
{
    public function getPendingAction($id){
        $pending = $this->getDoctrine()->getRepository('AppBundle:Pending')->find($id);

        if(!is_object($pending)){
            throw $this->createNotFoundException();
        }

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
