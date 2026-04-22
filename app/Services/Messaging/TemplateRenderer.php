<?php

namespace App\Services\Messaging;

class TemplateRenderer
{
    /**
     * Renderiza um template com variáveis
     *
     * @param string $template Template com placeholders no formato {{variavel}}
     * @param array $variables Array de variáveis para substituição
     * @param bool $escape Se deve fazer escape de caracteres especiais
     * @return string Template renderizado
     */
    public function render(string $template, array $variables = [], bool $escape = true): string
    {
        foreach ($variables as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $value = (string) $value;

            // Fazer escape de caracteres especiais se necessário
            if ($escape) {
                $value = $this->escape($value);
            }

            $template = str_replace($placeholder, $value, $template);
        }

        // Remover placeholders não substituídos
        $template = preg_replace('/\{\{[a-zA-Z_][a-zA-Z0-9_]*\}\}/', '', $template);

        return $template;
    }

    /**
     * Renderiza um template para HTML (com escape)
     *
     * @param string $template Template com placeholders
     * @param array $variables Array de variáveis
     * @return string Template renderizado com escape HTML
     */
    public function renderHtml(string $template, array $variables = []): string
    {
        return $this->render($template, $variables, true);
    }

    /**
     * Renderiza um template para texto plano (sem escape)
     *
     * @param string $template Template com placeholders
     * @param array $variables Array de variáveis
     * @return string Template renderizado sem escape
     */
    public function renderPlain(string $template, array $variables = []): string
    {
        return $this->render($template, $variables, false);
    }

    /**
     * Faz escape de caracteres especiais
     *
     * @param string $value Valor a fazer escape
     * @return string Valor com escape
     */
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Valida se um template tem placeholders válidos
     *
     * @param string $template Template a validar
     * @return array Array de placeholders encontrados
     */
    public function extractPlaceholders(string $template): array
    {
        preg_match_all('/\{\{([a-zA-Z_][a-zA-Z0-9_]*)\}\}/', $template, $matches);
        return array_unique($matches[1] ?? []);
    }

    /**
     * Valida se todas as variáveis necessárias foram fornecidas
     *
     * @param string $template Template a validar
     * @param array $variables Variáveis fornecidas
     * @return array Array de variáveis faltantes
     */
    public function validateVariables(string $template, array $variables = []): array
    {
        $required = $this->extractPlaceholders($template);
        $provided = array_keys($variables);

        return array_diff($required, $provided);
    }
}
