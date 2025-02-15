<?php
namespace Yiisoft\Mailer;

use Yiisoft\View\View;

/**
 * Composer composes the mail messages via view rendering.
 */
class Composer
{
    /**
     * @var string|bool HTML layout view name.
     * See [[Template::$htmlLayout]] for detailed documentation.
     */
    private $htmlLayout = 'layouts/html';

    /**
     * Sets html layout.
     * @param string $layout
     */
    public function setHtmlLayout(string $layout): void
    {
        $this->htmlLayout = $layout;
    }

    /**
     * @var string|bool text layout view name.
     * See [[Template::$textLayout]] for detailed documentation.
     */
    private $textLayout = 'layouts/text';

    /**
     * Sets text layout.
     * @param string $layout
     */
    public function setTextayout(string $layout): void
    {
        $this->textLayout = $layout;
    }
    /**
     * @var View view instance.
     */
    private $view;

    /**
     * @var string the directory containing view files for composing mail messages.
     */
    private $viewPath;

    /**
     * @return string the directory that contains the view files for composing mail messages.
     */
    public function getViewPath(): string
    {
        return $this->viewPath;
    }

    /**
     * @param string $path the directory that contains the view files for composing mail messages.
     */
    public function setViewPath(string $path): void
    {
        $this->viewPath = $path;
    }

    /**
     * @param View $view view instance or its array configuration that will be used to
     * render message bodies.
     */
    public function setView(View $view): void
    {
        $this->view = $view;
    }

    /**
     * @return View view instance.
     */
    public function getView(): View
    {
        return $this->view;
    }

    /**
     * @param View $view
     * @param string $viewPath
     */
    public function __construct(View $view, string $viewPath)
    {
        $this->view = $view;
        $this->viewPath = $viewPath;
    }

    /**
     * Creates new message view template.
     * The newly created instance will be initialized with the configuration specified by [[templateConfig]].
     * @param string|array $viewName view name for the template.
     * @return Template message template instance.
     */
    protected function createTemplate($viewName): Template
    {
        $template = new Template($this->view, $this->viewPath, $viewName);
        $template->setHtmlLayout($this->htmlLayout);
        $template->setTextLayout($this->textLayout);

        return $template;
    }

    /**
     * @param MessageInterface $message the message to be composed.
     * @param string|array $view the view to be used for rendering the message body. This can be:
     *
     * - a string, which represents the view name for rendering the HTML body of the email.
     *   In this case, the text body will be generated by applying `strip_tags()` to the HTML body.
     * - an array with 'html' and/or 'text' elements. The 'html' element refers to the view name
     *   for rendering the HTML body, while 'text' element is for rendering the text body. For example,
     *   `['html' => 'contact-html', 'text' => 'contact-text']`.
     *
     * @param array $parameters the parameters (name-value pairs) that will be extracted and made available in the view file.
     */
    public function compose(MessageInterface $message, $view, array $parameters = []): void
    {
        $this->createTemplate($view)->compose($message, $parameters);
    }
}
