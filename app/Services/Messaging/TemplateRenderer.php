<?php

namespace App\Services\Messaging;

class TemplateRenderer
{
    public function render(string $template, array $variables = []): string
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{{'.$key.'}}', (string) $value, $template);
        }

        return $template;
    }
}
