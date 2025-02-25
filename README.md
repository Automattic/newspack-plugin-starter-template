# Newspack starter template for custom plugins

This template is a pre-configured starting point for custom plugin development on the Newspack platform.
It will give you all of the tools you needs to get up and running quickly.

## What does it provide?

1. A pre-configured build process provided by the `@wordpress/scripts` package. This is the standard build process for WordPress. For more information on configuration and options, please see the [official documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/).
2. A PHP CodeSniffer configuration that will check your code against the coding standards that are recommended by the Newspack team.
3. A [Prettier](https://prettier.io/) configuration for WordPress.
4. A [Husky](https://typicode.github.io/husky/) configuration to lint local files changes before they are committed.
5. A GitHub action to check that your commits and merges adhere to the correct coding standards
6. A GitHub action to automatically deploy your changes to the production environment when merged to trunk.
7. A GitHub action to automatically deploy your changes to the staging environment when pushing to the `staging` branch.

## How do I use it?

1. Start by clicking the `Use this template` button to create a new repository in your own GitHub account from this template.
2. In the Secrets and Variables->Actions sections under the Settings menu of the new repository. Create new the secrets outlined in the table below.
3. In the Settings->Branches section of the new repository, set the branch protection rules to require a pull request to trunk, an approved review, and status checks to pass before merging.
4. In Settings->Collaborators and teams section of the new repository, add the Newspack team as a collaborators with write access. You may need to add them individually and you can get their usernames from the Newspack team.
5. Do a search and replace for `PublisherName` with a camel case slug of your publication.
6. Checkout the repo locally and run `npm run setup` to install everything.
7. In it doesn't already exist, create and `staging` branch and push it to the remote repository.
8. Start developing!

### Secrets

| Secret                | Description                                 |
| --------------------- | ------------------------------------------- |
| PROD_SFTP_USER        | The username for the Production SFTP server |
| PROD_SFTP_PASSWORD    | The password for the Production SFTP server |
| STAGING_SFTP_USER     | The username for the Staging SFTP server    |
| STAGING_SFTP_PASSWORD | The password for the Staging SFTP server    |
