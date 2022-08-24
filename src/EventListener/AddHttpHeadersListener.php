<?php

/*
 * This file is part of ocubom/html-bundle
 *
 * © Oscar Cubo Medina <https://ocubom.github.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ocubom\HtmlBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddHttpHeadersListener implements EventSubscriberInterface
{
    protected $rules = [];

    public function __construct(...$rules)
    {
        $this->rules = \func_get_args() ?: [];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (empty($this->rules)) {
            return; // ignore if no rules are set
        }
        if (!$event->isMainRequest()) {
            return; // Ignore sub-requests
        }

        $response = $event->getResponse();
        $content = $response->getContent();
        if (false === $content) {
            return; // Ignore special (binary or streamed) responses
        }

        $headers = $response->headers;
        $format = $headers->get('content-type') ?: $event->getRequest()->getRequestFormat('text/html');
        $format = explode(';', $format)[0];

        // Add custom headers and filter content
        foreach ($this->rules as $rule) {
            if (!$rule['enabled']) {
                continue; // Ignore disabled rules
            }

            if (isset($rule['formats']) && !\in_array($format, $rule['formats'], true)) {
                continue; // Ignore header if response format is not supported
            }

            if (isset($rule['pattern'])) {
                $content = preg_replace_callback(
                    $rule['pattern'],
                    function ($match) use ($headers, $rule) {
                        // Set header value
                        $value = vsprintf(isset($rule['value']) ? $rule['value'] : '%s', $match);
                        $headers->set($rule['name'], $value);

                        // Replace matched text
                        return vsprintf(isset($rule['replace']) ? $rule['replace'] : '%s', $match);
                    },
                    $content
                );
            } else {
                // Add value
                $headers->set($rule['name'], isset($rule['value']) ? $rule['value'] : '');
            }
        }

        try {
            $response->setContent($content);
        } catch (\LogicException $err) { // @codeCoverageIgnore
        }
    }

    /** @codeCoverageIgnore */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
