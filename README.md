# Newspack starter template for custom plugins

This template is a pre-configured starting point for custom plugin development on the Newspack platform.
It will give you all of the tools you needs to get up and running quickly.

## What does it provide?

1. A pre-configured build process provided by the `@wordpress/scripts` package. This is the standard build process for WordPress. For more information on configuration and options, please see the [official documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/).
2. A PHP CodeSniffer configuration that will check your code against the coding standards that are recommended by the Newspack team.
3. A Prettier configuration for WordPress.
4. Linting tools for CSS, JS and PHP
5. A GitHub action to check that your commits and merges adhere to the correct coding standards
6. A GitHub action to automatically deploy your changes when merged to trunk. (See the Setup section for how to enable this feature)

## How do I use it?

1. Start by clicking the `Use this template` to use this as a starting point for your project.
2. In the Secrets and Variables->Actions under the Settings menu of the new repository. Create new `SFTP_USER` and `SFTP_PASSWORD` secrets and add the credentials provided by NewPack for each.
3. Checkout the repo locally and run `npm run setup` to install everything.
4. Start developing!
