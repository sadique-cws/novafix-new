# Copilot Instructions for novafix-new

## Project Overview
- This is a Laravel-based service center management system using Livewire for dynamic UI components.
- Key domains: Service Requests, Staff, Franchise, Reception, Payments, and Service Categories.
- Main business logic is in `app/Livewire/` (subfolders: Admin, Franchise, Frontdesk, Staff, Partials).
- Data models are in `app/Models/`.
- Views are in `resources/views/`, with Livewire components under `resources/views/livewire/`.
- Uses Tailwind CSS and Alpine.js for frontend, with some custom JS for camera/photo capture.

## Key Patterns & Conventions
- Livewire components use attribute-based validation (see `#[Rule(...)]` in component classes).
- Service request creation uses camera/photo capture via browser, with base64 image conversion and Livewire file upload (`ServiceRequestForm`).
- Status and payment flows are tightly coupled: after payment, status controls are hidden and a payment success message is shown (see `ShowTask`).
- Status values are numeric (0=Pending, 25=Processing, 50=In Repair, 75=Testing, 90=Rejected, 100=Completed).
- All user-facing navigation is via named routes (see `routes/web.php`).
- Sidebar and layout logic is in `resources/views/components/layouts/`.

## Developer Workflows
- **Run the app:** Use `php artisan serve` (Laravel default) and `npm run dev` for assets.
- **Testing:** Run `php artisan test` or `vendor/bin/pest` for Pest tests.
- **Database:** Migrations in `database/migrations/`, seeders in `database/seeders/`.
- **File uploads:** Use the `public` disk; images are stored in `storage/app/public/service-requests` and accessed via `asset('storage/...')`.
- **Livewire JS:** If you add custom JS for Livewire, use hooks like `livewire:load` and `message.processed` to ensure event listeners persist after DOM updates.

## Integration Points
- Auth guards: `frontdesk` and `staff` (see usage in Livewire components).
- Payment logic: `app/Models/Payment.php` and related Livewire components.
- Camera/photo capture: see `resources/views/livewire/frontdesk/service-request-form.blade.php` and `ServiceRequestForm.php`.

## Examples
- To add a new status, update both the status array in the relevant Livewire component and the UI dropdown.
- To add a new field to service requests, update the model, migration, Livewire form, and validation rules.

## References
- Main entry: `routes/web.php`, `app/Livewire/`, `resources/views/components/layouts/`, `resources/views/livewire/`
- For custom UI/UX, see Tailwind/Alpine usage in layouts and forms.

---

For more, see the Laravel and Livewire documentation. When in doubt, check for attribute-based validation and Livewire event/JS patterns in this codebase.
