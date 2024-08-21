<?php

namespace App\Helpers;

/**
 * This should never be used for local development.
 * This is only a fallback on production where
 * ray() isn't installed.
 */
class Ray
{
    public function ray(...$args): self
    {
        $trace = debug_backtrace();

        foreach ($args as $arg) {
            try {
                $output = count($trace) >= 2
                    ? sprintf('ray() was called in %s from "%s" (line %d) : '.PHP_EOL, $trace[0]['file'], $trace[1]['function'], $trace[0]['line'])
                    : '';

                if (is_object($arg) && method_exists($arg, 'toString')) {
                    $output .= $arg->toString();
                } elseif (is_array($arg)) {
                    $output .= json_encode($arg, JSON_PRETTY_PRINT);
                } elseif (is_numeric($arg)) {
                    $output .= "$arg";
                } elseif (is_bool($arg)) {
                    $output .= $arg ? 'true' : 'false';
                } elseif (is_null($arg)) {
                    $output .= 'null';
                } elseif (is_string($arg)) {
                    $output .= $arg;
                } else {
                    $output = '(empty)';
                }

                \Log::debug($output);
            } catch (\Exception $e) {
                \Log::notice('ray() should not be called in a non-local environment!');
            }
        }

        return $this;
    }

    public function green(): self
    {
        return $this;
    }

    public function orange(): self
    {
        return $this;
    }

    public function red(): self
    {
        return $this;
    }

    public function purple(): self
    {
        return $this;
    }

    public function blue(): self
    {
        return $this;
    }

    public function gray(): self
    {
        return $this;
    }

    public function screenGreen(): self
    {
        return $this;
    }

    public function screenOrange(): self
    {
        return $this;
    }

    public function screenRed(): self
    {
        return $this;
    }

    public function screenPurple(): self
    {
        return $this;
    }

    public function screenBlue(): self
    {
        return $this;
    }

    public function screenGray(): self
    {
        return $this;
    }
}
