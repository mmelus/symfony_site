<?php
namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\ContactMeType;
use App\Service\MailerService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Exception;

class MainController extends AbstractController
{
    #[Route(path: '/{_locale}', name: 'main_page', requirements: ['_locale' => 'en|fr', ], methods:['GET','POST'] )]
    public function MainPage(Request $request, ContentRepository $contentRepository): Response
    {
        $bugs = $contentRepository->getBugs($request->getLocale());
        $partitionBugs = $bugs->partition(function($key, $value) {
            return $value->getContentCode() != "INTRO"; 
        });
        $services = $contentRepository->getServices($request->getLocale());
        $partitionServices = $services->partition(function($key, $value) {
            return $value->getContentCode() != "GENERAL"; 
        });

        $contactForm = $this->createForm(ContactMeType::class, null, [
            'action' => $this->generateUrl('contact_me'),
            'method' => 'POST',
        ]);
        $contactForm->handleRequest($request);
        
        return $this->render('mainpage/main.html.twig', [
            'intro' => $partitionBugs[1],
            'bugs' => $partitionBugs[0],
            'general' => $partitionServices[1],
            'services' => $partitionServices[0],
            'form' => $contactForm->createView(),
        ]);
    }

    #[Route(path: '/{_locale}/contact_me', name: 'contact_me', requirements: ['_locale' => 'en|fr', ],methods:['POST'] )]
    public function SendEmail(Request $request,MailerService $mailerService, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ContactMeType::class);
        $form->handleRequest($request);
        try{
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $mailerService->sendEmailToAdmin($data['information'], $data['firstName'], $data['lastName'], $data['subject'], $data['content']);
                $this->addFlash('success',$translator->trans('flash_messages.1'));
                return $this->redirectToRoute('main_page', ['_fragment'=>'contact_me']);
               
            }else{
                return $this->redirectToRoute('main_page', ['request' => $request, '_fragment'=>'contact_me'], 307);
            }
        }catch(Exception $e){
            $this->addFlash('error',$translator->trans('flash_messages.2'));
            return $this->redirectToRoute('main_page', ['request' => $request, '_fragment'=>'contact_me'], 307);
        }
    }

    #[Route(path: '/{_locale}/legal_notice', name: 'legal_notice', requirements: ['_locale' => 'en|fr', ],methods:['GET'] )]
    public function LegalNotice(Request $request,MailerService $mailerService, TranslatorInterface $translator): Response
    {
        return $this->render('legal_notice.html.twig');
    }
}