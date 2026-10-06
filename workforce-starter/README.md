# Workforce Platform: Starter Kit (Phases 1 to 3 core)

A Laravel starter for an Outlier-style platform: workers apply to projects, get onboarded, claim tasks, submit work, reviewers approve it, and earnings are recorded. Money handling is intentionally the simple MVP version (manual payouts); the double-entry ledger and M-Pesa come in Phase 4.

> **Status: not yet executed.** This kit was written without PHP or Composer available, so it has not been run or tested. Run `php artisan test` first and fix anything that surfaces. It targets the Laravel 11/12 structure (Breeze + Blade, `bootstrap/app.php` middleware config, `casts()` method).

## Setup

```bash
./setup.sh workforce-platform
```

This runs `composer create-project`, installs `spatie/laravel-permission` and Breeze (Blade), copies `overlay/` on top, migrates, seeds and builds assets. Use MySQL 8 for anything beyond local dev (the claim query uses `FOR UPDATE SKIP LOCKED`, which SQLite ignores).

## What is included

| Area | Files |
|---|---|
| Roles and permissions | `app/Enums/Role.php`, `RolesAndPermissionsSeeder` (worker, client, reviewer, admin, super_admin) |
| Domain model | users (+status/phone/country), worker_profiles, clients, projects, project_applications, tasks, task_submissions, reviews, earnings, audit_logs |
| State machines | `ApplicationStatus` (submitted to engaged, no skipping), task/submission/review enums |
| Business logic | `TaskService::claimNext` (row-locked claiming, 3 open tasks max), `SubmissionService` (submit, review, earning creation in one transaction) |
| Authorization | `TaskPolicy`, `TaskSubmissionPolicy` (no self-review, assignee-only access) |
| UI (Blade) | Worker: projects, my work, task workspace. Reviewer: queue, review form |
| Audit trail | `AuditLogger` called on claims, submissions, reviews, application changes |
| Tests | `tests/Feature/WorkflowTest.php` (permissions, claim rules, full flow, double-review, revisions, transitions) |

## Security decisions already built in

- Self-registered users get only the `worker` role; staff roles are assigned by seeders/admins.
- `users.status` is not mass-assignable.
- Money is stored as integer minor units; one earning per approved submission (unique DB constraint).
- Reviewers cannot review their own work; workers cannot see other workers' tasks.
- Demo data and weak demo passwords only seed in the `local` environment.

## Next steps (maps to your roadmap)

1. **Admin panel (Phase 1/2):** install Filament and add resources for users, projects, tasks, applications. Until then there is no UI to move applications to `engaged`; the demo seeder does it for the demo worker, or use `tinker`: `ProjectApplication::find(1)->transitionTo(ApplicationStatus::Screening)`.
2. **2FA for admin roles** (Fortify or a TOTP package) and a middleware that blocks `users.status = suspended`.
3. **Worker profiles, resume upload** (private disk plus signed URLs), employer/client self-service, job search.
4. **Queues:** switch to Redis + Horizon, then add notifications (email first).
5. **Task import:** CSV/JSON bulk upload of tasks per project.
6. **Phase 4:** replace `earnings` with the double-entry ledger, add Daraja (M-Pesa) behind a provider interface. See the money-flow section of the roadmap.
7. **Quality controls:** second-review sampling and gold-standard tasks before scaling the worker pool.
