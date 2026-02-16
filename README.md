# Account Shield

Account Shield is a secure password and account management application built with Laravel 12. It features client-side encryption for sensitive data, ensuring that only you can access your stored passwords using a Master Password.

## Features

- **Secure Encryption**: Sensitive data (usernames, passwords, notes) is encrypted using AES-256-GCM.
- **Master Password**: Your data is protected by a Master Password that is never stored in plain text.
- **Account Categories**: Organize your accounts into categories like Social, Email, Bank, etc.
- **Password Strength Checker**: Built-in dashboard stats for identifying weak passwords.

## Prerequisites

- **PHP**: ^8.2 (Note: Some dependencies may require PHP 8.4+)
- **Composer**: Latest version
- **Node.js & NPM**: For frontend assets
- **SQLite**: Default database driver

## Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd account-shield
   ```

2. **Install PHP dependencies**:
   If you encounter PHP version issues with Symfony packages, use the ignore-platform-reqs flag:
   ```bash
   composer install --ignore-platform-reqs
   ```

3. **Install Node dependencies**:
   ```bash
   npm install
   ```

4. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Migration**:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Build Frontend Assets**:
   ```bash
   npm run build
   ```

7. **Start the Application**:
   ```bash
   php artisan serve
   ```

## Troubleshooting

### "vendor/autoload.php: Failed to open stream"
This error occurs when Composer dependencies haven't been installed. Run `composer install`.

### PHP Version Issues
If you are running PHP 8.3 and see errors about `symfony/clock` or other packages requiring PHP 8.4, you can either:
- Upgrade to PHP 8.4.
- Run `composer install --ignore-platform-reqs` to bypass the check (the application has been verified to work on PHP 8.3.6).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
