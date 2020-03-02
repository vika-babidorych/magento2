<?php
declare(strict_types=1);

namespace Vika\HelloWorldPlugin\Plugin;

use Vika\HelloWorldStorefrontUi\Block\Index;

/**
 * Modify string with prefix, suffix and tags via plugins
 */
class HelloWorldPlugin
{
    /**
     * Modify string with suffix
     *
     * @param Index $subject
     * @param string $result
     * @return string
     */
    public function afterGetHello(Index $subject, $result)
    {
        return  $subject->escapeHtml($result) . ' after suffix.';
    }

    /**
     * Modify string with prefix and tags
     *
     * @param Index $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundGetHello(Index $subject, callable $proceed)
    {
        $result = $proceed();

        return "Before prefix " . "<h1>" . $subject->escapeHtml($result) . "</h1>";
    }
}
