<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="session_info")
     *
     * displays session data
     */
    #[Route("/session", name: "session_info")]
    public function showSession(Request $request): Response
    {

        $currentYear = date('Y');

        $sessionData = $request->getSession()->all();
        dump($sessionData); // Dump the session data to check its content

        return $this->render('session.html.twig', [
            'sessionData' => $sessionData,
            'currentYear' => $currentYear,
        ]);
    }

    /**
     * @Route("/session/delete", name="delete_session_contents")
     *
     * deletes session data
     */
    #[Route("/session/delete", name: "delete_session_contents")]
    public function deleteSessionContents(SessionInterface $session): Response
    {

        $session->clear(); // Clears all session data

        // a flash message to notify the user
        $this->addFlash('success', 'Session contents have been deleted.');

        // Redirect to session info
        return $this->redirectToRoute('session_info');
    }
}
