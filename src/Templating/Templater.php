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

    /**
     * Templater constructor.
     *
     * @param string $templatesPath Path to templates.
     */
    public function __construct($templatesPath)
    {
        $this->_templatesPath = $templatesPath;
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

        $templatesPath = $this->_templatesPath;

        if (file_exists($templatesPath . '/' . $template)) {
            //Convert array elements into variables
            extract($variables, EXTR_OVERWRITE);

            //Start Output Buffer session
            ob_start();

            // Include Template File
            include_once "{$templatesPath}/{$template}";

            //Get Buffer value
            $content = ob_get_contents();

            //Close Buffer session and clear it
            ob_end_clean();
        } else {
            $content = "Template {$template} not found!";
        }

        //Create new Response object
        $response = new Response();

        return $response->sendResponse($content);
    }
}