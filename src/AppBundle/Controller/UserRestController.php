<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserRestController extends FOSRestController
{
    public function getUserAction($username){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByUsername($username);
        if(!is_object($user)){
            throw $this->createNotFoundException();
        }
        return $user;
    }
}
