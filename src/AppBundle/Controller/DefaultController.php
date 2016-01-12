<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comparison;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newAction(Request $request)
    {
        $file_root = $request->server->get('DOCUMENT_ROOT') . '/integrity/web/files/';
        $comparison = new Comparison();

        $form = $this->createFormBuilder($comparison)
            ->add('first_file', FileType::class)
            ->add('second_file', FileType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($comparison);
            $em->flush();

            if (is_file($file_root . $comparison->getFirstFileName())
                && is_file($file_root . $comparison->getSecondFileName()))
            {
                if (sha1_file($file_root . $comparison->getFirstFileName()) === sha1_file($file_root . $comparison->getSecondFileName()))
                {
                    $comparison->setPercentage('100');
                    $em->persist($comparison);
                    $em->flush();                    
                } else {
                    similar_text(file_get_contents($file_root . $comparison->getFirstFileName()), file_get_contents($file_root . $comparison->getSecondFileName()), $percentage);
                    $comparison->setPercentage($percentage);
                    $em->persist($comparison);
                    $em->flush();              
                }
            }

        }

        return $this->render('default/new.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function listAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Comparison')->findAll();
        // replace this example code with whatever you need
        return $this->render('default/list.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'comparisons' => $repository
        ]);
    }


    /**
     * @Route("/view/{id}", name="view_item")
     */
    public function viewAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Comparison')->find($id);
        var_dump($repository);
        // replace this example code with whatever you need
        return $this->render('default/view.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'comparison' => $repository
        ]);
    }


}
