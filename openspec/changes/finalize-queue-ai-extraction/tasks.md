## 1. Job Resilience

- [x] 1.1 Add `$tries`, `$backoff`, `$maxExceptions`, `ShouldBeUnique` with `uniqueId()` and `uniqueFor(60)` to `ExtraireDepensesDuRecu`
- [x] 1.2 Add AI response structure validation before `foreach($response['articles'])`: type-guard articles as array, validate each article's required keys, validate `total_estime` is numeric

## 2. Error Message Infrastructure

- [x] 2.1 Create migration `add_error_message_to_recus_table` adding nullable `text` column `error_message`
- [x] 2.2 Add `error_message` to `Recu` model `$fillable` array

## 3. Error Message Logic

- [x] 3.1 Store human-readable French error message in `error_message` on job failure
- [x] 3.2 Clear `error_message` to `null` on successful extraction (in job)
- [x] 3.3 Clear `error_message` to `null` in `RecuController::retry()` when retrying extraction

## 4. UI

- [x] 4.1 Display `error_message` in a red/orange alert box in `resources/views/recus/show.blade.php`

## 5. Failure Notification

- [x] 5.1 Create `app/Notifications/ExtractionEchouee.php` as a mail notification with French subject/body
- [x] 5.2 Register `Queue::failing()` listener in `AppServiceProvider::boot()` to send notification on permanent failure

## 6. Tests

- [x] 6.1 Update `ExtraireDepensesDuRecuTest` to cover: retry/backoff attributes exist on job, response validation catches malformed articles, error_message is stored on failure, error_message is cleared on success
- [x] 6.2 Add test for `ExtractionEchouee` notification content (subject, body, recipient)
- [x] 6.3 Add test for `Queue::failing()` listener behavior
- [x] 6.4 Run `php artisan test --compact` and confirm all tests pass

## 7. Final Verification

- [x] 7.1 Run `vendor/bin/pint --format agent` to format all PHP files
- [x] 7.2 Run `php artisan test --compact` and confirm all tests pass
