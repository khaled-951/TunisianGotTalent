<?php

namespace evenementBundle\Controller;
use evenementBundle\Entity\evenement;
use evenementBundle\Form\evenementType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

/**
 * Evenement controller.
 *
 * @Route("evenement")
 */
class evenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     * @Route("/", name="evenement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $evenements = $em->getRepository('evenementBundle:evenement')->findAll();


        return $this->render('evenement/index.html.twig', array(
            'evenements' => $evenements,
        ));
    }


    /**
     * Creates a new evenement entity.
     *
     * @Route("/new", name="evenement_new")
     * @Method({"GET", "POST"})
     */


    public function newAction(Request $request)
    {

        $evenement = new Evenement();
        $form = $this->createForm(evenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $evenement->upload();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('afficherchasseur');
            //  return $this->redirectToRoute('evenement_show', array('id_evenement' => $evenement->getId_evenement()));
        }



        return $this->render('evenementBundle:evenement:ajouterevenement.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));

    }




    /**
     * Finds and displays a evenement entity.
     *
     * @Route("/{id_evenement}", name="evenement_show")
     * @Method("GET")
     */
    public function showAction(evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);

        return $this->render('evenement/afficherevenement.html.twig', array(
            'evenement' => $evenement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     * @Route("/{id_evenement}/edit", name="evenement_edit")
     * @Method({"GET", "POST"})
     */
    public function modifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository("evenementBundle:evenement")->find($id);
        $form = $this->createForm(evenementType::class, $evenement);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evenement->upload();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('afficher');
        }
        return $this->render("evenementBundle:evenement:modifierevenement.html.twig", array('form' => $form->createView()));
    }

    /**
     * Deletes a evenement entity.
     *
     * @Route("/{id_evenement}", name="evenement_delete")
     * @Method("DELETE")
     */
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository("evenementBundle:evenement")->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('afficher');
    }


    public function supprimerAdminAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository("evenementBundle:evenement")->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('afficherevenementAdmin');
    }


    /**
     * Creates a form to delete a evenement entity.
     *
     * @param evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('id_evenement' => $evenement->getId_evenement())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('evenementBundle:evenement')->findAll();

        /**
         * @var $paginator \Knp\Component\\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $evenement=$paginator ->paginate(
            $evenement, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)

            /*limit per page*/
        );

        return $this->render('evenementBundle:evenement:afficherevenement.html.twig', array(
            'evenement' => $evenement));
    }

    public function afficherevenementAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('evenementBundle:evenement')->findAll();

        return $this->render('evenementBundle:evenement:afficherevenementAdmin.html.twig', array(
            'evenement' => $evenement));
    }

    public function detailuserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('evenementBundle:evenement')->findBy(array('id_evenement' => $id));

        return $this->render('evenementBundle:evenement:detailuser.html.twig', array(
            'evenement' => $evenement));
    }


    public function detailevenementadminAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('evenementBundle:evenement')->findBy(array('id_evenement' => $id));
        return $this->render('evenementBundle:evenement:detailevenementadmin.html.twig', array(
            'evenement' => $evenement));
    }


    public function afficheruserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('evenementBundle:evenement')->findAll();

        /**
         * @var $paginator \Knp\Component\\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $evenement=$paginator ->paginate(
            $evenement, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)

        /*limit per page*/
        );
        foreach ($evenement as $evt) {

            $participations = $em->getRepository('evenementBundle:ticket')->findBy(array('evenement' => $evt->getIdEvenement()));

            if (count($participations) > 0) {
                $evt->setParticipe(true);
            } else {
                $evt->setParticipe(false);
            }


            // $forum->setCountComments(count($comments));

        }

        //var_dump($evenement);

        // $ticket=$em->getRepository('evenementBundle:ticket')->findBy(array('evenement'=>$id));

        return $this->render('evenementBundle:evenement:afficherevenementuser.html.twig', array(
            'evenement' => $evenement));


    }


    public function afficheruser1Action(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('evenementBundle:evenement')->findBy(array('id_evenement' => $id));
        $ticket = $em->getRepository('evenementBundle:ticket')->findBy(array('evenement' => $id));


        //var_dump($ticket);


        return $this->render('evenementBundle:evenement:afficherevenementuser1.html.twig', array(
            'evenement' => $evenement, 'ticket' => $ticket));

    }


    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $evenement = $em->getRepository('evenementBundle:evenement')->findEntitiesByString($requestString);
        if (!$evenement) {
            $result['evenement']['error'] = "evenement Not found :( ";
        } else {
            $result['evenement'] = $this->getRealEntities($evenement);
        }
        return new Response(json_encode($result));
    }

    public function getRealEntities($evenement)
    {
        foreach ($evenement as $evenement) {
            $realEntities[$evenement->getIdEvenement()] = [$evenement->getImage(), $evenement->getTitre()];

        }
        return $realEntities;
    }


    public function pieAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $classes = $em->getRepository('evenementBundle:evenement')->findAll();

        $nbparticipant=0;
        foreach($classes as $evenement) {
            $nbparticipant=$nbparticipant+$evenement->getNbparticipant();
        }
        $data= array();
        $stat=['evenement', 'nbparticipant'];
        $nb=0;
        array_push($data,$stat);
        foreach($classes as $evenement) {
            $stat=array();


            array_push($stat,$evenement->getTypedetalent(),(($evenement->getNbparticipant()) *100)/$nbparticipant);
            $nb=($evenement->getNbparticipant() *100)/$nbparticipant;



            $stat=[$evenement->getTypedetalent(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des places libres dans les evenements
        par type de talent ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('evenementBundle:evenement:pie.html.twig',
            array('piechart' => $pieChart));
    }










}
