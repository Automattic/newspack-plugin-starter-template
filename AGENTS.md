# AI agent instructions for Newspack custom plugins

Guidance for coding agents and developers building custom features in a repository created from the Newspack starter template. Human-focused setup and program rules live in the [Newspack custom development guidelines](https://help.newspack.com/newspack-developer-hub/custom-development-guidelines/); this file is the day-to-day guide for writing the code.

## The one rule that governs the rest

This plugin runs on live publisher production sites. Newspack reviews custom code with static analysis but does not run or test it, so nothing here catches a mistake at runtime before a reader does. Weigh security, correctness, and performance on every change, and prefer a core WordPress or Newspack API over a hand-rolled version.

## How the plugin is organized

Each custom feature is a self-contained module under `inc/Modules/<ModuleName>/`:

- `module.php` is the entry point, loaded only when the module is enabled. Keep it lightweight: wire up hooks or call an `init()` method, and never do work in the global scope.
- Classes in the module are autoloaded over Composer PSR-4, so the namespace has to match the file path. A class `Foo_Bar` in `inc/Modules/Sample/Foo_Bar.php` is `PublisherName\Modules\Sample\Foo_Bar`.
- `info.json` holds the `name` and `description` shown on the admin screen.

Modules are enabled or disabled under **Settings → Custom Modules** in wp-admin. A new module does not run until it is enabled there, so after adding one, enable it to test it.

The base namespace is `PublisherName` and the text domain is `publisher-name`. If the repository has been renamed for the publisher, match whatever it already uses, and keep every namespace consistent with its file path.

Front-end source goes in `src/` and is compiled with `@wordpress/scripts` into `build/`. Generated output (`build/`, `vendor/`, `node_modules/`) is gitignored and produced at deploy time, so it should never appear in a commit.

## Security and correctness

These are the rules a reviewer will hold the code to. The repository's [`.github/copilot-instructions.md`](.github/copilot-instructions.md) applies the same bar to a finished diff; the point here is to write code that passes it the first time.

- **Escape at output.** Pass anything echoed through `esc_html()`, `esc_attr()`, `esc_url()`, or `wp_kses_*`. Write `echo esc_html( $value );`, not `echo $value;`.
- **Sanitize and validate on the way in.** Treat request data, options, and REST arguments as untrusted until sanitized and validated.
- **Authorize every state-changing action** at the entry point it uses: a capability check (`current_user_can()`) and a nonce (`check_admin_referer()` or `check_ajax_referer()`) for admin, AJAX, and form handlers, and a non-permissive `permission_callback` for REST routes.
- **Use core APIs for data.** Reach for the WordPress API before direct database access, and run any raw `$wpdb` query through `$wpdb->prepare()`.
- **Keep secrets out of the repository.** No credentials, tokens, private keys, or reader PII in code, fixtures, or logs.
- **Translate user-facing strings** with the plugin text domain.
- **Mind performance on publisher sites.** Cache remote requests and expensive queries, bound every query, and avoid `ORDER BY RAND()` and broadly autoloaded options. The VIP sniffs flag uncached calls as warnings worth heeding, not noise to silence.

## Scalability

Publisher sites serve most traffic from a full-page cache and a CDN, so an anonymous pageview should be answered from cache without ever reaching PHP or the database. Custom code that forces work onto every view defeats that, and a feature that is fine in testing can take a site down under real traffic. Treat the cache as infrastructure to protect, not an obstacle to route around.

- **Do not write to the database on anonymous, high-traffic requests.** A view counter, hit log, or "last seen" write on every pageview turns every cached view into a database write and will not hold up under load. Record this kind of data with an analytics service, or batch and defer the writes to a cron job or an async queue.
- **Do not call the site's own API from the front end on page load.** Each cached pageview that fires a request back to the site becomes an uncached PHP and database hit, so traffic to the page is amplified into traffic the cache cannot absorb (request amplification). Render what the page needs server-side, and reserve front-end requests for genuine user interactions.
- **Do not set cookies or otherwise break the cache on anonymous responses.** Setting a cookie, sending cache-busting headers, or varying the response per request can make the page uncacheable, so every anonymous view falls through to PHP. Keep anonymous responses identical and cacheable; confine cookies and per-user output to logged-in or genuinely personalized paths.

## Coding standards and tooling

PHP follows the standards in `phpcs.xml` (WordPress-Extra, WordPress-Docs, WordPress-VIP-Go, WordPress, and PHPCompatibilityWP). Short array syntax is allowed and Yoda conditions are not required. Write PHP that runs on 7.2 and up, which is what the compatibility sniff checks against.

Run the checks before committing:

- `npm run lint` runs all three linters (PHP, JavaScript, CSS).
- `composer run lint` runs PHPCS on its own; `./vendor/bin/phpcbf --standard=phpcs.xml` auto-fixes what it can.
- `npm run format` applies the WordPress Prettier config to JavaScript and SCSS.

A Husky pre-commit hook lints staged files and blocks the commit on any failure. Fix the finding rather than bypassing the hook; CI re-runs the same linters on every push, so skipping locally does not get unlinted code to a site.

Build commands:

- `npm run build` compiles the front-end once; `npm run start` watches and rebuilds during development.
- `npm run setup` installs dependencies and the commit hook on a fresh checkout.

## Deploying

Deploys run from branches: pushing `alpha` deploys to staging, and pushing `release` deploys to production. CI builds the assets and installs Composer dependencies during the deploy, so the committed source stays clean.

Test every change on staging before it reaches production. The deploy workflow files, `.git-ftp-ignore`, `.git-ftp-include`, branch names, deploy paths, and the SFTP secrets all control where and how code lands on a site, so change them deliberately and review any such change closely.

## Working with Newspack

- **Do not modify Newspack core, other plugins, or the theme.** Extend them through their hooks and filters from inside a module. A direct edit is overwritten on the next update.
- **Do not add code through a snippet plugin.** Snippet plugins are prohibited on Newspack; all custom code belongs in this repository, where it is versioned, linted, and reviewed.
- **Keep each feature in its own module,** with a clear `info.json` description, so what runs on the site and why stays easy to audit.
- **Run a new project idea past Newspack early.** A feature that is broadly useful may belong in Newspack core instead of a custom module, and early input avoids building against the platform.
- **Open a pull request and get it reviewed before merging.** Request a GitHub Copilot review, address its findings, and keep the required human approval; a deploy follows the merge automatically.
