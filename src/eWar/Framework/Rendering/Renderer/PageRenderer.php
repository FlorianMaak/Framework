<?php

namespace eWar\Framework\Rendering\Renderer;

use eWar\Framework\Http\RequestHandler;
use eWar\Framework\Rendering\PageControllerInterface;
use eWar\Framework\Rendering\ViewControllerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class PageRenderer
 * @package eWar\Framework\Rendering\Renderer
 */
class PageRenderer implements RendererInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $pageTitle;

    /**
     * @var RequestHandler
     */
    private $requestHandler;


    /**
     * PageRenderer constructor.
     *
     * @param RequestHandler $requestHandler
     * @param string         $appDir
     */
    public function __construct(RequestHandler $requestHandler, string $appDir)
    {
        $twigLoader = new FilesystemLoader($appDir . '/View');
        $this->requestHandler = $requestHandler;
        $this->twig = new Environment($twigLoader, array(
            'cache' => GLOBAL_DIR . '/cache',
        ));
    }


    /**
     * setPageTitle
     *
     * @param string $pageTitle
     */
    public function setPageTitle(string $pageTitle) : void
    {
        $this->pageTitle = $pageTitle;
    }


    /**
     * prepare
     *
     * @param ViewControllerInterface $ctrl
     */
    public function prepare(ViewControllerInterface $ctrl) : void
    {
        /** @var PageControllerInterface $ctrl */
        $this->setPageTitle($ctrl->getPageTitle());
    }


    /**
     * output
     *
     * @param array|null $data
     * @param array      ...$args
     */
    public function output(array $data = null, ...$args) : void
    {
        $data['pagetitle'] = $this->pageTitle;
        try {
            echo $this->twig->render($args[0] . '.twig', $data);
        } catch (\Exception $e) {
            $this->requestHandler->throwError(404);
        }
    }


    /**
     * throwError
     *
     * @param int $statusCode
     */
    public function throwError(int $statusCode) : void
    {
        $this->requestHandler->throwError($statusCode);
    }
}
