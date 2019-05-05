<?php
/**
 * The file contains Templater class
 *
 * PHP version 5
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/ABGEO07/cherry-templater/blob/master/LICENSE MIT
 * @link     https://github.com/ABGEO07/cherry-templater
 */

namespace Cherry\Templating;

use Cherry\HttpUtils\Response;

/**
 * Cherry project templater class
 *
 * @category Library
 * @package  Cherry
 * @author   Temuri Takalandze <takalandzet@gmail.com>
 * @license  https://github.com/ABGEO07/cherry-templater/blob/master/LICENSE MIT
 * @link     https://github.com/ABGEO07/cherry-templater
 */
class Templater
{
    private $_templatesPath;

    private $_cachedTemplatesDir;

    private $_passedVariables = [];

    /**
     * Templater constructor.
     *
     * @param string $templatesPath Path to templates.
     */
    public function __construct($templatesPath)
    {
        $this->_templatesPath = $templatesPath;
        $this->_cachedTemplatesDir = CACHED_TEMPLATES_DIR;
    }

    /**
     * Render given template and return response.
     *
     * @param string $template  Template filename in templates folder.
     * @param array  $variables Arguments for template.
     *
     * @return Response
     */
    public function render($template, $variables = [])
    {
        if (substr($template, -13) !== '.templater.php') {
            $template .= '.templater.php';
        }

        $this->_passedVariables = $variables;

        //Create new Response object
        $response = new Response();

        //Read given template
        $content = $this->_readeTemplate($template);

        return $response->sendResponse($content);
    }

    private function _readeTemplate($template)
    {
        $templatesPath = $this->_templatesPath;

        if (file_exists($templatesPath . '/' . $template)) {
            //Convert array elements into variables
            extract($this->_passedVariables, EXTR_OVERWRITE);

            //Get given template content and hash it
            $templateContent = file_get_contents($templatesPath . '/' . $template);
            $contentHash = md5($templateContent);

            $cachedTemplate = $this->_cachedTemplatesDir . '/' . $contentHash . '.templater.php';

            //Cache template
            if (!file_exists($cachedTemplate)) {
                $this->_cacheTemplate($templateContent);
            }

            //Start Output Buffer session
            ob_start();

            // Include Template File
            include_once "$cachedTemplate";

            //Get Buffer value
            $content = ob_get_contents();

            //Close Buffer session and clear it
            ob_end_clean();
        } else {
            $content = "Template {$template} not found!";
        }

        return $content;
    }

    private function _cacheTemplate($content)
    {
        $contentHash = md5($content);

        file_put_contents($this->_cachedTemplatesDir . '/' . $contentHash . '.templater.php', $content);
    }
}