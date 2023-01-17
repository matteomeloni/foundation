<?php

namespace Matteomeloni\Foundation\Traits\Controller;

use Illuminate\Support\Str;

trait HasResponse
{
    /**
     * @var string|null
     */
    protected ?string $responseMessage = null;

    /**
     * @var bool
     */
    protected bool $withoutMessage = false;

    /**
     * @param mixed|null $data
     * @return mixed
     */
    public function response($data = null): mixed
    {
        $message = ($this->withoutMessage === false) ? $this->setResponseMessage() : null;
        return response()->success($message, $data);
    }

    /**
     * @param string $message
     * @return $this
     */
    protected function withMessage(string $message): static
    {
        $this->responseMessage = $message;

        return $this;
    }

    protected function withoutMessage(): static
    {
        $this->withoutMessage = true;

        return $this;
    }

    /**
     * @return string
     */
    private function setResponseMessage(): string
    {
        if(!$this->responseMessage) {
            $route = explode('.', request()->route()->getName());

            [$resource, $action] = array_slice($route, -2);

            $resource = Str::singular($resource);

            if (is_null($this->responseMessage)) {
                $this->responseMessage = __("responses.{$resource}.{$action}");
            }
        }

        return $this->responseMessage;
    }
}
