<?php


namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use App\Entity\Watchdog;
use App\Entity\WatchdogRule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class DefaultController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
        /**
         * Výchozí vykreslovací metoda tohoto kontroleru.
         * @return Response HTTP odpověď
         * @Route("/", name="homepage")
         */
        public function indexAction()
        {

            
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $products = $repository->findAll();

            $repositoryWatchdog = $this->getDoctrine()->getRepository(Watchdog::class);
            $watchdogs = $repositoryWatchdog->findAll();

            $repositoryWatchdogRules = $this->getDoctrine()->getRepository(WatchdogRule::class);
            $watchdogsRules = $repositoryWatchdogRules->findAll();
            
                return $this->render('product.html.twig', [
                        'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                        'products' =>$products,
                        'watchdogs' =>$watchdogs,
                        'watchdogsRules' =>$watchdogsRules,
                    
                ]);
        }

       /**
         * @param integer null|$id     id produktu
         * @param Request     $request HTTP požadavek
         * @return Response HTTP odpověď
         * @Route("/product/{id}", name="product_editor")
         */
        
        public function productAction($id=null , Request $request)
        {
            
            $repository = $this->getDoctrine()->getRepository(Product::class);
            
            if ($id) $product = $repository->find($id);
            else $product = new Product;
            
            
            
            $form = $this->createFormBuilder($product, array('csrf_protection' => false))
                    ->add('name',null,['label'=>'Název'])
                    ->add('price',null,['label'=>'Cena'])
                    ->add('quantity',null,['label'=>'Množství'])
                    ->add('submit', SubmitType::class, ['label' => 'Uložit produkt'])
                        ->getForm();                    
 
            
            if ($product->getWatchdog_activated()==1) {
                $originalProduct = new Product;
                $originalProduct->setPrice($product->getPrice());
                $originalProduct->setQuantity($product->getQuantity());
                $originalProduct->setName($product->getName());
            }
            else $originalProduct = false;
            
            // Zpracování formuláře.
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                    try {
                            if ($originalProduct) {
                                $this->applyWatchdogRules($originalProduct, $product);
                            }
                            $repository->saveProduct($product);
                            $this->addFlash('notice', 'Produkt byl úspěšně uložen.');
                            return $this->redirectToRoute('homepage');
                    } catch (UniqueConstraintViolationException $exception) {
                            $this->addFlash('warning', 'Produkt již existuje s tímto id.');
                    }
            }            
            
                return $this->render('editor.html.twig', [
                        'form' => $form->createView(),
         
                ]);
            
        }
        
         /**
         * @param integer $id     id produktu
         * @param Request     $request HTTP požadavek
         * @return Response HTTP odpověď
         * @Route("/product/wdactivate/{id}", name="watchdog_activate")
         */
        
        public function productWdactivateAction($id , Request $request)
        {
            $repository = $this->getDoctrine()->getRepository(Product::class);
            
            if ($id) {
                $product = $repository->find($id);  
                $product->setWatchdog_activated(1);
                $repository->saveProduct($product);
            }
            $this->addFlash('notice', 'Produkt byl úspěšně uložen.');
            return $this->redirectToRoute('homepage');
        }      
        
        
         /**
         * @param integer $id     id produktu
         * @param Request     $request HTTP požadavek
         * @return Response HTTP odpověď
         * @Route("/product/wddeactivate/{id}", name="watchdog_deactivate")
         */
        
        public function productWddeactivateAction($id , Request $request)
        {
            $repository = $this->getDoctrine()->getRepository(Product::class);
            
            if ($id) {
                $product = $repository->find($id);  
                $product->setWatchdog_activated(0);
                $repository->saveProduct($product);
            }
            return $this->redirectToRoute('homepage');
        }      
        

         /**
         * @param Product $originalProduct - původní stav produktu
         * @param Product $modifiedProduct - nový stav produktu
         * @return integer - 
         */
                
        private function applyWatchdogRules(Product $originalProduct, Product $modifiedProduct) {
            
            $repository = $this->getDoctrine()->getRepository(WatchdogRule::class);
            $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
            $watchdogRules = $repository->findAll();
            foreach ($watchdogRules as $rule) {
                
                $originalValue = $originalProduct->getColumn($rule->getChanged_column_name());
                $modifiedValue = $modifiedProduct->getColumn($rule->getChanged_column_name());

                $writeWatchdog = false;
                switch ($rule->getChanged_column_operation()) :
                    case '<':
                          if ($rule->getChanged_column_value()  && ($modifiedValue < $rule->getChanged_column_value())) $writeWatchdog=true;
                        break;
                    case '>':
                          if ($rule->getChanged_column_value()  && ($modifiedValue > $rule->getChanged_column_value() )) $writeWatchdog=true;
                        break;
                    case '=':
                          if ($rule->getChanged_column_value()  && ($modifiedValue < $rule->getChanged_column_value() )) $writeWatchdog=true;
                        break;
                    case '-':
                          if ($originalValue > $modifiedValue) $writeWatchdog=true;
                        break;
                    case '+':
                          if ($originalValue < $modifiedValue) $writeWatchdog=true;
                        break;
                    case 'Z':
                          if ($originalValue != $modifiedValue) $writeWatchdog=true;
                        break;
                    default:
                        $writeWatchdog =false;
                endswitch;
                
                if ($writeWatchdog) {
                        $watchdog = new Watchdog();
                        $watchdog->setChanged_column_name($rule->getChanged_column_name());
                        $watchdog->setId_product($modifiedProduct->getId());
                        $watchdog->setNew_value($modifiedValue);
                        $watchdog->setOld_value($originalValue);
                        $watchdog->setId_rule($rule->getId());
                        $repositoryWatchdog = $this->getDoctrine()->getRepository(Watchdog::class);
                        $repositoryWatchdog->saveWatchdog($watchdog);
                }
                
            }
            
        }
        
        
}
