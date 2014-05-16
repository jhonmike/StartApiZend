<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\I18n\Translator\Translator;
use Zend\Validator\AbstractValidator;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->addTranslationFile(
            'phpArray',
            './vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Validate.php'
        );
        AbstractValidator::setDefaultTranslator($translator);
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array($this, 'setLayout'));
    }

    public function setLayout($e)
    {
        $storage = new SessionStorage();
        $auth = new AuthenticationService;
        $auth->setStorage($storage);

        $controller = $e->getTarget();
        $em = $controller->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $matchedController = $controller->getEvent()->getRouteMatch()->getParam('controller');
        $matchedAction = $controller->getEvent()->getRouteMatch()->getParam('action', 'index');

        $acl = $controller->getServiceLocator()->get("Zf2Acl\Permissions\Acl");
        $visit_page = $acl->isAllowed("Visit",$matchedController,$matchedAction);

        //user logado
        $viewModel = $e->getViewModel();
        if ($auth->hasIdentity() AND !$visit_page) {
            $repository = $em->getRepository("Zf2User\Entity\User");
            $user = $repository->findOneById($auth->getIdentity()->getId());
            if ($user->getRole()->getLayout()) {
                $layout = $user->getRole()->getLayout();
                $viewModel->setTemplate($layout);
            }else{
                $viewModel->setTemplate('layout/layout');
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'Version' => function ($hpm) {
                    $serviceLocator = $hpm->getServiceLocator();
                    $viewHelper = new View\Helper\Version();
                    $viewHelper->setServiceLocator($serviceLocator);

                    return $viewHelper;
                }
            ),
        );
    }
}
