# Newspack starter template for custom plugins

This template is a pre-configured starting point for custom plugin development on the Newspack platform.
It will give you all of the tools you need to get up and running quickly.

## What does it provide?

1. A pre-configured build process provided by the `@wordpress/scripts` package. This is the standard build process for WordPress. For more information on configuration and options, please see the [official documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/).
2. A PHP CodeSniffer configuration that will check your code against the coding standards that are recommended by the Newspack team.
3. A [Prettier](https://prettier.io/) configuration for WordPress.
4. A [Husky](https://typicode.github.io/husky/) configuration to lint local file changes before they are committed.
5. A GitHub action to lint PHP, JavaScript, and CSS against the configured coding standards.
6. A repository-level GitHub Copilot instructions file to guide Copilot code review toward Newspack, WordPress, security, performance, and deployment concerns.
7. A GitHub action to automatically deploy your changes to the production environment when pushing to the `release` branch.
8. A GitHub action to automatically deploy your changes to the staging environment when pushing to the `alpha` branch.

## How do I use it?

Please refer to [How to set up the Newspack Starter Template for custom plugins](https://help.newspack.com/newspack-developer-hub/how-to-set-up-the-newspack-starter-template-for-custom-plugins/) on help.newspack.com for up-to-date installation and setup instructions.

## Recommended pull request review workflow

When working in a repository created from this template, open custom development changes in a pull request and request a [GitHub Copilot code review](https://docs.github.com/en/copilot/how-tos/use-copilot-agents/request-a-code-review/use-code-review), or confirm your pull request tooling requested one, before merging. Copilot uses `.github/copilot-instructions.md` from the base branch to review against Newspack and WordPress-specific expectations.

Treat Copilot review as an additional safeguard, not a replacement for required human approval or passing status checks. Address relevant Copilot findings before merging or deploying custom development changes.
