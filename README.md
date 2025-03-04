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

### Creating a new repository from this template

Click the `Use this template` button to create a new repository in your own GitHub account from this template.

### Setting up the repository secrets

Go to the Secrets and Variables->Actions sections under the Settings menu of the new repository.
Under the Repository secrets sections, create new the secrets outlined in the table below.

### Secrets

| Secret                | Description                                 |
| --------------------- | ------------------------------------------- |
| PROD_SFTP_USER        | The username for the Production SFTP server |
| PROD_SFTP_PASSWORD    | The password for the Production SFTP server |
| STAGING_SFTP_USER     | The username for the Staging SFTP server    |
| STAGING_SFTP_PASSWORD | The password for the Staging SFTP server    |

### Adding some branch protection rules

1. Navigate to Settings > Branches.
2. Click on **Add classic branch protection rule**
3. Enter `trunk` into the Branch name pattern field.
4. Check **Require a pull request before merging**.
5. Check **Require approvals**. You can leave the number of required approval set at 1.
6. Click on **Create**.
7. Check Require status checks to pass before merging
8. In the search box, searching for “Linting” and add each status check that appears. There should be 3 in total.

## Adding collaborators

In Settings->Collaborators and teams section of the new repository, add the Newspack team as a collaborators with write access.
You may need to add them individually and you can get their usernames from the Newspack team.

### Checking out the repo locally

Checkout the repo locally and run `npm run setup` to install everything.

```bash
git clone <your-repo-url>

cd <your-repo-name>

npm run setup
```

### Create the staging branch

In it doesn't already exist, create and `staging` branch and push it to the remote repository.

```bash
git checkout -b staging

git push origin staging
```
