# Main methods

## url(?string $value): self

Sets the link to your input image.

## parameter(string $name, $value): self

Sets the value of the parameter by its name.

You can find all existing parameter names in `Parameter` enum situated in `Coderello\Proximage\Enums` namespace.

> More handy way is to use methods for image manipulations which can be found in the section below.

## shouldProxy(Closure $shouldProxy): self

Sets callback which detects if given image should be proxied. Callback receives `$url` as the first argument and should return `true` or `false`.

## template($template): self

Applies template to the current `ImageProxy` instance.

**Accepts:**

- `string` (template class name)
- `object` (template instance)

**Out-of-the-box templates (you can find them in `Coderello\Proximage\Templates` namespace):**

- `AvatarTemplate`
- `DisableProxyingForLocalEnvironmentTemplate`

> Of course, you are not limited to these ones. You can create your own templates. Each one must implement `Template` contract situated in the `Coderello\Proximage\Contracts` namespace.

## get(): ?string

Returns URL of proxied image.
