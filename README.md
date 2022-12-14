<div align="center">

Ocubom HTML Bundle
==================

A Symfony bundle to integrate several custom utilities for HTML manipulation

[![Contributors][contributors-img]][contributors-url]
[![Forks][forks-img]][forks-url]
[![Stargazers][stars-img]][stars-url]
[![Issues][issues-img]][issues-url]
[![License][license-img]][license-url]

[![Version][packagist-img]][packagist-url]
[![CI][workflow-ci-img]][workflow-ci-url]
[![Code Quality][quality-img]][quality-url]
[![Coverage][coverage-img]][coverage-url]

[**Explore the docs »**](https://github.com/ocubom/html-bundle)

[Report Bug](https://github.com/ocubom/html-bundle/issues)
·
[Request Feature](https://github.com/ocubom/html-bundle/issues)

</div>

<details>
  <summary>Contents</summary>

* [About HTML Bundle](#about-html-bundle)
* [Getting Started](#getting-started)
    * [Installation](#installation)
    * [Usage](#usage)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [Authorship](#authorship)
* [License](#license)

</details>

## About HTML Bundle

[Ocubom HTML Bundle](https://github.com/ocubom/html-bundle) is a [Symfony Bundle][] that integrates several utilities for HTML manipulation.

This suite started as an internal class based on [nochso/html-compress-twig][] to allow the use of [wyrihaximus/html-compress][] with Twig 3.0.
This class used to be embedded into several projects.
Over time, each project adapted its version slightly, leading to fragmented development and difficult maintenance.
Therefore, the development is unified in this extension which is made public in case it is useful for other projects.

## Getting Started

### Installation

Make sure Composer is installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

#### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require ocubom/html-bundle
```

#### Applications that don't use Symfony Flex

##### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require ocubom/html-bundle
```

##### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Ocubom\HtmlBundle\OcubomHtmlBundle::class => ['all' => true],
];
```

### Usage

Just create the file `config/packages/ocubom_html.yaml` using the configuration reference:

```console
bin/console config:dump-reference ocubom_html
```

You can use the [example configuration][] provided.

```yaml
ocubom_html:

    # Register Ocubom/TwigHtmlExtension to minify the HTML (defaults)
    compress:
        force: false
        level: smallest
        
    # Headers extract
    # The listener is only registered if some header is registered
    #headers:
    #    # Duplicate robots meta as X-Robots-Tag
    #    # @see https://developers.google.com/search/docs/advanced/robots/robots_meta_tag#xrobotstag
    #    -   name:    'X-Robots-Tag'
    #        pattern: '@[\p{Zs}]*<meta\s+(?:name="robots"\s+content="([^"]+)"|content="([^"]+)"\s+name="robots")\s*/?\s*>\p{Zs}*\n?@i'
    #        value:   '%2$s'
    #        replace: '%1$s'
    #        formats:
    #            - 'text/html'
    #
    #    # Disable Metro Interface
    #    # @see https://github.com/h5bp/html5-boilerplate/blob/5.3.0/dist/doc/extend.md#prompt-users-to-switch-to-desktop-mode-in-ie10-metro
    #    -   name:    'X-UA-Compatible'
    #        enabled: true
    #        pattern: '@[\p{Zs}]*<meta\s+(?:http-equiv="X-UA-Compatible"\s+content="([^"]+)"|content="([^"]+)"\s+http-equiv="X-UA-Compatible")\s*>\p{Zs}*\n?@i'
    #        value:   '%2$s'
    #        replace: '' # Delete the meta tag as is not standard
    #        formats:
    #            - 'text/html'
```

> **Note**
> This configuration will be installed if your project uses [endroid/installer][]

_For more examples, please refer to the [Documentation](https://github.com/ocubom/html-bundle)._

## Roadmap

See the [open issues](https://github.com/ocubom/html-bundle/issues) for a full list of proposed features (and known issues).

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create.
Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request.
You can also simply open an issue with the tag "enhancement".

1. Fork the Project.
2. Create your Feature Branch (`git checkout -b feature/your-feature`).
3. Commit your Changes (`git commit -m 'Add your-feature'`).
4. Push to the Branch (`git push origin feature/your-feature`).
5. Open a Pull Request.

## Authorship

* Oscar Cubo Medina — [@ocubom](https://twitter.com/ocubom) — https://ocubom.page <div align="center">

See also the list of [contributors][contributors-url] who participated in this project.

## License

Distributed under the MIT License.
See [LICENSE][] for more information.


[LICENSE]: https://github.com/ocubom/html-bundle/blob/master/LICENSE
[example configuration]: https://github.com/ocubom/html-bundle/blob/main/.install/symfony/config/packages/ocubom_html.yaml

<!-- Links -->
[composer]: https://getcomposer.org/
[endroid/installer]: https://packagist.org/packages/endroid/installer
[Symfony]: https://symfony.com/
[Symfony Bundle]: https://symfony.com/doc/current/bundles.html

<!-- Packagist links -->
[nochso/html-compress-twig]: https://packagist.org/packages/nochso/html-compress-twig
[wyrihaximus/html-compress]: https://packagist.org/packages/wyrihaximus/html-compress

<!-- Project Badges -->
[contributors-img]: https://img.shields.io/github/contributors/ocubom/html-bundle.svg?style=for-the-badge
[contributors-url]: https://github.com/ocubom/html-bundle/graphs/contributors
[forks-img]:        https://img.shields.io/github/forks/ocubom/html-bundle.svg?style=for-the-badge
[forks-url]:        https://github.com/ocubom/html-bundle/network/members
[stars-img]:        https://img.shields.io/github/stars/ocubom/html-bundle.svg?style=for-the-badge
[stars-url]:        https://github.com/ocubom/html-bundle/stargazers
[issues-img]:       https://img.shields.io/github/issues/ocubom/html-bundle.svg?style=for-the-badge
[issues-url]:       https://github.com/ocubom/html-bundle/issues
[license-img]:      https://img.shields.io/github/license/ocubom/html-bundle.svg?style=for-the-badge
[license-url]:      https://github.com/ocubom/html-bundle/blob/master/LICENSE
[workflow-ci-img]:  https://img.shields.io/github/actions/workflow/status/ocubom/html-bundle/test.yml?branch=main&label=CI&logo=github&style=for-the-badge
[workflow-ci-url]:  https://github.com/ocubom/html-bundle/actions/
[packagist-img]:    https://img.shields.io/packagist/v/ocubom/html-bundle.svg?logo=packagist&logoColor=%23fefefe&style=for-the-badge
[packagist-url]:    https://packagist.org/packages/ocubom/html-bundle
[coverage-img]:     https://img.shields.io/scrutinizer/coverage/g/ocubom/html-bundle.svg?logo=scrutinizer&logoColor=fff&style=for-the-badge
[coverage-url]:     https://scrutinizer-ci.com/g/ocubom/html-bundle/code-structure/main/code-coverage
[quality-img]:      https://img.shields.io/scrutinizer/quality/g/ocubom/html-bundle.svg?logo=scrutinizer&logoColor=fff&style=for-the-badge
[quality-url]:      https://scrutinizer-ci.com/g/ocubom/html-bundle/
