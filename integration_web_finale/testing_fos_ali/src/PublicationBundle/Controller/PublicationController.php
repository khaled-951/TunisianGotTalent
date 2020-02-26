<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Likes;
use PublicationBundle\Entity\Publication;
use PublicationBundle\Entity\Views;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\File;

/**
 * Publication controller.
 *
 */
class PublicationController extends Controller
{
    /**
     * Lists all publication entities.
     *
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('PublicationBundle:Publication')->findBy(array(), array('datePublication'=>'DESC'));
        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findBy(array(), array('dateCommentaire'=>'DESC'));
        $likes = $em->getRepository('PublicationBundle:Likes')->findAll();
        $topthree = $em->getRepository('PublicationBundle:Publication')->findBy(array(), array('viewsPublication'=>'DESC'), 3);

        return $this->render('@Publication/Default/index.html.twig', array(
            'publications' => $publications,
            'commentaires' => $commentaires,
            'user' => $user,
            'likes' => $likes,
            'topthree' => $topthree
        ));
    }

    public function showHashtagAction($hashtag)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('PublicationBundle:Publication')->findHashtag($hashtag);
        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findBy(array(), array('dateCommentaire'=>'DESC'));
        $likes = $em->getRepository('PublicationBundle:Likes')->findAll();
        $topthree = $em->getRepository('PublicationBundle:Publication')->findBy(array(), array('viewsPublication'=>'DESC'), 3);

        return $this->render('@Publication/Default/index.html.twig', array(
            'publications' => $publications,
            'commentaires' => $commentaires,
            'user' => $user,
            'likes' => $likes,
            'topthree' => $topthree
        ));
    }

    public function showOneAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('PublicationBundle:Publication')->find($id);
        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findBy(array('Publication_id'=>$id), array('dateCommentaire'=>'DESC'));
        $likes = $em->getRepository('PublicationBundle:Likes')->findBy(array('Publication_id'=>$id));
        $topthree = $em->getRepository('PublicationBundle:Publication')->findBy(array(), array('viewsPublication'=>'DESC'), 3);

        return $this->render('@Publication/Default/post.html.twig', array(
            'publication' => $publications,
            'commentaires' => $commentaires,
            'user' => $user,
            'likes' => $likes,
            'topthree' => $topthree
        ));
    }

    /**
     * Creates a new publication entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form ->add('src', FileType::class, [
            'label' => 'Content(audio, video, text, image)',
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024M',
                    'mimeTypesMessage' => 'Please upload a valid document',
                ])
            ],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $publication->setUserIdPublication($user);
            $publication->setDatePublication(new \DateTime("now", new \DateTimeZone('+0100')));
            $publication->setLikesPublication(0);
            $publication->setViewsPublication(0);
            $publication->setIsVisiblePublication(1);

            $srcFile = $form->get('src')->getData();

            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $publication->getTypePublication(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $publication->setSrcPublication($newFilename);
            }
            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->redirectToRoute('publication_index');
        /*
        return $this->render('publication/new.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
        ));*/
    }

    public function newtextAction(Request $request)
    {
        $user = $this->getUser();
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form->add('srcPublication');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $publication->setUserIdPublication($user);
            $publication->setDatePublication(new \DateTime("now", new \DateTimeZone('+0100')));
            $publication->setTypePublication("text");
            $publication->setLikesPublication(0);
            $publication->setViewsPublication(0);
            $publication->setIsVisiblePublication(1);

            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('publication_index');
        }
        return $this->redirectToRoute('publication_index');
        /*
        return $this->render('publication/new.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
        ));*/
    }

    /**
     * Finds and displays a publication entity.
     *
     */
    public function showAction(Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);

        return $this->render('publication/show.html.twig', array(
            'publication' => $publication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publication entity.
     *
     */
    public function editAction($id_publication, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $editForm ->add('src', FileType::class, [
            'label' => 'Content(audio, video, text, image)',
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024M',
                    'mimeTypesMessage' => 'Please upload a valid document',
                ])
            ],
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $srcFile = $editForm->get('src')->getData();

            if ($srcFile) {
                $originalFilename = pathinfo($srcFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$srcFile->guessExtension();

                try {
                    $srcFile->move('uploads/' . $publication->getTypePublication(), $newFilename);
                } catch (FileException $e) {
                    print $e->getMessage();
                }
                $publication->setSrcPublication($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->redirectToRoute('publication_index');
        /*
        return $this->render('@Publication/Default/edit.html.twig', array(
            'publication' => $publication,
            'edit_form' => $editForm->createView(),
        ));*/
    }

    public function editTextAction($id_publication, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $editForm->add('srcPublication');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->redirectToRoute('publication_index');
        /*
        return $this->render('@Publication/Default/edit.html.twig', array(
            'publication' => $publication,
            'edit_form' => $editForm->createView(),
        ));*/
    }

    public function makeVisibleAction($id_publication )
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);

        if ($publication) {
            $publication->setIsVisiblePublication(1);
            $this->getDoctrine()->getManager()->flush();

            return new Response("");
        }

        return new Response("");
    }

    public function makeUnVisibleAction($id_publication )
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);

        if ($publication) {
            $publication->setIsVisiblePublication(0);
            $this->getDoctrine()->getManager()->flush();

            return new Response("");
        }

        return new Response("");
    }

    public function upVoteAction($id_publication )
    {
        $user = $this->getUser() ;

        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);
        $like = $em->getRepository('PublicationBundle:Likes')->findOneBy(array('Publication_id'=>$id_publication, 'userId'=>$user->getId()));

        if ($publication && !$like ) {
            $like = new Likes();
            $like->setPublicationId($publication);
            $like->setUserId($user);
            $em->persist($like);
            $em->flush();

            $publication->setLikesPublication($publication->getLikesPublication($id_publication) + 1);
            $em->flush();

            return new Response("");
        }

        return new Response("");
    }

    public function downVoteAction($id_publication )
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);

        if ($publication) {
            $like = $em->getRepository('PublicationBundle:Likes')->findOneBy(array('Publication_id'=>$id_publication, 'userId'=>$user->getId()));
            if($like) {
                $em->remove($like);
                $publication->setLikesPublication($publication->getLikesPublication($id_publication) - 1);
                $em->flush();
            }
            return new Response("");
        }

        return new Response("");
    }

    public function viewUpAction($id_publication )
    {
        $user = $this->getUser() ;

        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);
        $view = $em->getRepository('PublicationBundle:Views')->findOneBy(array('Publication_id'=>$id_publication, 'userId'=>$user->getId()));

        //return new Response($view->getId());
        if ($publication && !$view ) {
            $view = new Views();
            $view->setPublicationId($publication);
            $view->setUserId($user);
            $em->persist($view);

            $publication->setViewsPublication($publication->getViewsPublication($id_publication) + 1);
            $em->flush();

            return new Response("1");
        }

        return new Response("0");
    }

    /**
     * Deletes a publication entity.
     *
     */
    public function deleteAction($id_publication, Request $request )
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('PublicationBundle:Publication')->find($id_publication);

        if ($publication && ($publication->getUserIdPublication()->getId() == $user->getId() || $user->isSuperAdmin() )   ) {
            $em->getRepository('PublicationBundle:Commentaire')->removePublicationCommentaire($id_publication);
            $em->getRepository('PublicationBundle:Views')->removePublicationViews($id_publication);
            $em->getRepository('PublicationBundle:Likes')->removePublicationLikes($id_publication);
            $em->remove($publication);
            $em->flush();
        }

        return new Response("");
    }

    /**
     * Creates a form to delete a publication entity.
     *
     * @param Publication $publication The publication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publication $publication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $publication->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('PublicationBundle:Publication')->findAll();
        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findAll();

        return $this->render('@Publication/Default/admin_view_posts.html.twig', array(
            'publications' => $publications,
            'commentaires' => $commentaires,
        ));
    }
}
