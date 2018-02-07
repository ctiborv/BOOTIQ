<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of ProductController
 *
 * @author ctibor
 */


class ProductController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    
        /**
         * @Route("/product}", name="product_show")
         */
        public function indexAction()
        {    
                
                
                return $this->render('product.html.twig', [
                        'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                ]);
        }                    
    

}
