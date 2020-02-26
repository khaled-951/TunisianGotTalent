<?php

namespace ReclamationBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ReclamationBundle\Entity\archive;
use ReclamationBundle\Entity\avis;
use ReclamationBundle\Form\avisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class avisController extends Controller
{
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        $avis= new avis();
        $avis->setUser($user);
        $form = $this->createForm(avisType::class, $avis);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            return $this->redirectToRoute('readreclamation');
        }

        return $this->render('@Reclamation/Default/rating.html.twig', array(
            'avis' => $avis,
            'form' => $form->createView(),
        ));
    }
    public function afficherAction()
    {
        $em=$this->getDoctrine()->getRepository(avis::class)->findAll();
        return $this->render('@Reclamation/Dashboard/dashboardavis.html.twig',array('avis'=> $em));
    }
    function deleteAction($id){
        $em=$this->getDoctrine()->getManager();
        $avis=$this->getDoctrine()->getRepository(avis::class)->find($id);
        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('avis');
    }
    function archiverAction($id){
        $em=$this->getDoctrine()->getManager();
        $avis=$this->getDoctrine()->getRepository(avis::class)->find($id);
        $note=$avis->getNote();

        $archive= new archive();
        $archive->setNote($note);
        $am = $this->getDoctrine()->getManager();
        $am->persist($archive);
        $am->flush();

        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('avis');

    }

    public function indexAction(Request $request)
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $notes = $em->getRepository(archive::class)->findAll();

        $note1 = $em->getRepository(archive::class)->findBy(array('note'=>1));
        $note2 = $em->getRepository(archive::class)->findBy(array('note'=>2));
        $note3 = $em->getRepository(archive::class)->findBy(array('note'=>3));
        $note4 = $em->getRepository(archive::class)->findBy(array('note'=>4));
        $note5 = $em->getRepository(archive::class)->findBy(array('note'=>5));

        $total=count($notes);

        $total1=count($note1);
        $total2=count($note2);
        $total3=count($note3);
        $total4=count($note4);
        $total5=count($note5);

        $data= array();
        $stat=['stars', '%'];
        $nb=0;
        array_push($data,$stat);

            $stat=array();
            $nb1=($total1 *100)/$total;
            array_push($stat,'1 stars',($nb1));
            $stat=['1',$nb1];
            array_push($data,$stat);

        $stat=array();
        $nb2=($total2 *100)/$total;
        array_push($stat,'2',($nb2));
        $stat=['2 stars',$nb2];
        array_push($data,$stat);

        $stat=array();
        $nb3=($total3 *100)/$total;
        array_push($stat,'3',($nb3));
        $stat=['3 stars',$nb3];
        array_push($data,$stat);

        $stat=array();
        $nb4=($total4 *100)/$total;
        array_push($stat,'4',($nb4));
        $stat=['4 stars',$nb4];
        array_push($data,$stat);

        $stat=array();
        $nb5=($total5 *100)/$total;
        array_push($stat,'5',($nb5));
        $stat=['5 stars',$nb5];
        array_push($data,$stat);


        $pieChart->getData()->setArrayToDataTable(
            $data
        );



        $pieChart->getOptions()->setTitle('Pourcentages des avis ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('@Reclamation\Dashboard\stat.html.twig', array('piechart' => $pieChart));
    }

}
