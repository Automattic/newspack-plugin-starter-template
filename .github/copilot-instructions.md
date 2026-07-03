# Copilot instructions for Newspack custom plugins

This is a custom WordPress plugin for the Newspack platform. Its code runs on live publisher production sites, so weigh security, correctness, and performance accordingly.

## Codebase context

- Custom features live in self-contained modules under `inc/Modules/<ModuleName>/`, each with a `module.php` entry point. Module bootstrapping stays lightweight and hook-driven.
- PHP under `inc/` is autoloaded via Composer PSR-4; namespaces must match file paths.
- Front-end source lives in `src/` and is compiled with `@wordpress/scripts`. Generated output (`build/`, `vendor/`, `node_modules/`) is gitignored and produced at deploy time, so it should not appear in a diff.
- Deploy model: pushing `alpha` deploys to staging sites, `release` deploys to production.

## What to flag in the diff

Security and correctness:

- Output echoed without escaping. Require `esc_html()`, `esc_attr()`, `esc_url()`, or `wp_kses_*` at the point of output. Example: `echo $user_input;` should be `echo esc_html( $user_input );`.
- Request data, options, or REST arguments used without sanitization or validation.
- State-changing admin, AJAX, REST, or form handlers missing the authorization appropriate to that entry point: a capability check (`current_user_can()`) and nonce (`check_admin_referer()` / `check_ajax_referer()`) for admin, AJAX, and form actions, or a non-permissive `permission_callback` for REST routes.
- Direct database access where a core API would work, and raw `$wpdb` queries not passed through `$wpdb->prepare()`.
- Secrets, SFTP credentials, tokens, private keys, or customer PII committed in code, fixtures, or logs.

WordPress and Newspack conventions:

- User-facing strings not wrapped for translation with the plugin text domain.
- Meaningful side effects at file load instead of inside hook callbacks or an explicit init method.
- Real violations of the standards configured in `phpcs.xml` (`WordPress-Extra`, `WordPress-Docs`, `WordPress-VIP-Go`, `WordPress`, `PHPCompatibilityWP`) that appear in the diff.

Performance on publisher sites:

- Expensive or unbounded queries, uncached remote requests, `ORDER BY RAND()`, or broadly autoloaded options.

JavaScript and CSS:

- Node-only APIs or dependencies that would not run in the browser bundle.
- Committed generated output (`build/`, `vendor/`, `node_modules/`); flag it as likely accidental.

Deploy safety:

- Changes to `.github/workflows`, `.git-ftp-ignore`, `.git-ftp-include`, branch names, deploy paths, or required secrets. Review these carefully and call out anything that could break or reroute a deploy.
